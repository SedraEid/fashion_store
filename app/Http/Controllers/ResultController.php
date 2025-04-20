<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Customer;

class ResultController extends Controller
{
    public function storeOrUpdateResult(Request $request)
{
    $user = auth()->user(); 

    $customer = Customer::where('user_id', $user->id)->first();

    if (!$customer) {
        return response()->json(['message' => 'هذا المستخدم ليس عميلًا'], 404);
    }

    $request->validate([
        'result_value' => 'required|string|max:255',
    ]);

    $result = $customer->result;

    if ($result) {
        $result->update(['result_value' => $request->result_value]);
//
        if (!$customer->results_id) {
            $customer->results_id = $result->id;
            $customer->save();
        }

    } else {
        $result = $customer->result()->create([
            'result_value' => $request->result_value
        ]);
//
        $customer->results_id = $result->id;
        $customer->save();
    }

    return response()->json([
        'message' => 'تم حفظ النتيجة بنجاح',
        'result' => $result
    ], 200);
}

}
