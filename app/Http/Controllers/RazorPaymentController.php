<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;


class RazorPaymentController extends Controller
{
    public function handleCallback(Request $request)
    {
        $paymentId = $request->input('payment_id');
        $razorpayPaymentId = $request->input('razorpay_payment_id');
        $razorpaySignature = $request->input('razorpay_signature');

        // Verify payment and update your database accordingly
        // Example: $payment = Payment::where('payment_id', $paymentId)->first();
        //          $payment->status = 'success';
        //          $payment->save();

        // Send response back to RazerPay
        return response()->json(['success' => true]);
    }
}
