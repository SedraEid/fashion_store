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
            'profile' => $profile,
            'customer' => $customer,
        ]);
    }



    public function update(Request $request)
    {
        $profile = Profile::where('user_id', Auth::id())->first();

        if (!$profile) {
            return response()->json(['message' => 'البروفايل غير موجود'], 404);
        }

        $profile->update($request->only(['profile_picture', 'gender', 'birthdate', 'city']));

        return response()->json([
            'message' => 'تم تحديث البروفايل بنجاح',
            'profile' => $profile,
        ]);
    }
}
