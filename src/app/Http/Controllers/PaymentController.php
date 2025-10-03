<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        if ($request->payment_method === 'konbini') {
            $paymentIntent = PaymentIntent::create([
                'amount' => $product->price,
                'currency' => 'jpy',
                'payment_method_types' => ['konbini'],
                'confirm' => true,
            ]);

            // PaymentIntent には支払い用の情報が入るので、一旦ビューに渡して表示する
            return view('purchase.konbini', [
                'product' => $product,
                'voucher_url' => $paymentIntent->next_action->konbini_display_details->hosted_voucher_url ?? null,
                'voucher_expires' => $paymentIntent->next_action->konbini_display_details->expires_after ?? null
            ]);
        }
    }
}
