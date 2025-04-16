<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'gender' => 'string',
            'birthdate' => 'date',
            'city' => 'string',
        ]);
    
        $profile = Profile::create([
            'user_id' => Auth::id(),
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'city' => $request->city,
        ]);
    
        return response()->json([
            'message' => 'تم إنشاء البروفايل بنجاح',
            'profile' => $profile,
        ]);
    }
    


    public function show(Request $request)
    {
        $user = $request->user(); 
        $profile = $user->profile; 
    
        if (!$profile) {
            return response()->json(['message' => 'البروفايل غير موجود'], 404);
        }
    
        $customer = $user->customer;
    
        return response()->json([
            'user' => $user,
        ]);
    }



    public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'gender' => 'required|string|in:male,female',
        'birthdate' => 'nullable|date',
        'city' => 'nullable|string|max:255',
    ]);

    $user = Auth::user();

    if (!$user) {
        return response()->json(['message' => 'المستخدم غير موجود'], 401);
    }

    $user->update($request->only(['name', 'email', 'phone', 'address']));

    $profile = $user->profile;

    if ($profile) {
        $profile->update($request->only(['gender', 'birthdate', 'city']));
    } else {
        $profile = Profile::create([
            'user_id' => $user->id,
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'city' => $request->city,
        ]);
    }

    return response()->json([
        'message' => 'تم تحديث بيانات المستخدم والبروفايل بنجاح',
        'user' => $user,
        'profile' => $profile,
    ]);
}

}
