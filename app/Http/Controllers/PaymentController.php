<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        $payment = new Payment();
        $payment->payment_type = $request->input('payment_type');
        $payment->save();
        return response()->json(['payment'=>$payment,'msg'=>'payment created successfully!!']);
    }
}
