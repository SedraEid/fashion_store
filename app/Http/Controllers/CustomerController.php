<?php

namespace App\Http\Controllers;
use App\Models\Customer;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function store(Request $request)
{
    $user = auth()->user();

    $customer = Customer::create([
        'user_id' => $user->id,
        'results_id' => $request->results_id,
        'image_analysis_id' => $request->image_analysis_id,
    ]);

    return response()->json($customer);
}



public function getProfile(Request $request)
    {
        $user = $request->user(); 

        $customer = $user->customer;

        if (!$customer) {
            return response()->json(['message' => 'العميل غير موجود'], 404);
        }

        $profile = $user->profile;

        return response()->json([
            'customer' => $customer,
            'user'=>$user,
        ]);
    }
}






