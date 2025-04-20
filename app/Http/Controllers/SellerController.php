<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Dotenv\Validator as DotenvValidator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SellerController extends Controller
{

    public function registerSeller(Request $req)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'store_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'birthdate' => 'required|date',
            'city' => 'nullable|string|max:255',
        ];
    
        $validator = Validator::make($req->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'phone' => $req->phone,
            'address' => $req->address,
            'user_type' => 1, 
        ]);
    
        $user->seller()->create([
            'store_name' => $req->store_name,
        ]);
    
        $user->profile()->create([
            'gender' => $req->gender,
            'birthdate' => $req->birthdate,
            'city' => $req->city,
        ]);
    
        $token = $user->createToken('seller_token')->plainTextToken;
    
        return response()->json([
            'message' => 'تم تسجيل البائع بنجاح',
            'user' => $user,
            'token' => $token,
            'redirect_url' => route('seller.dashboard'),
        ], 201);
        
        
    }



    public function loginSeller(Request $req)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    
        $req->validate($rules);
    
        $user = User::where('email', $req->email)->first();
    
        if ($user && Hash::check($req->password, $user->password)) {
            if ($user->user_type != 1) {
                return response()->json(['message' => 'هذا الحساب ليس لبائع'], 403);
            }
    
            $token = $user->createToken('seller_token')->plainTextToken;
    
            return response()->json([
                'user' => $user,
                'token' => $token
            ], 200);
        }
    
        return response()->json([
            'message' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة'
        ], 400);
    }
    

    public function show()
    {
        $user = Auth::user();

        if ($user->user_type != 1) {
            return response()->json(['message' => 'المستخدم ليس بائعًا'], 403);
        }

        $seller = $user->seller;

        if (!$seller) {
            return response()->json(['message' => 'بيانات البائع غير موجودة'], 404);
        }

        return response()->json([
            'user' => $user,
            'seller' => $seller,
        ]);
    }



    public function updateSellerData(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return response()->json(['message' => 'المستخدم غير مسجل الدخول'], 401);
    }

    if ($user->user_type != 1) {
        return response()->json(['message' => 'المستخدم ليس بائعًا'], 403);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',

        'store_name' => 'required|string|max:255',

        'gender' => 'nullable|in:male,female',
        'birthdate' => 'nullable|date',
        'city' => 'nullable|string|max:255',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
    ]);

    $seller = $user->seller;
    if ($seller) {
        $seller->update([
            'store_name' => $request->store_name,
        ]);
    }

    $profile = $user->profile;
    if ($profile) {
        $profile->update([
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'city' => $request->city,
        ]);
    }

    $user = User::with('seller', 'profile')->find($user->id);

    return response()->json([
        'message' => 'تم تحديث بيانات البائع بنجاح',
        'user' => $user
    ]);
}

    
    
}
