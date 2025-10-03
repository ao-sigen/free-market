<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Charge;

class PurchaseController extends Controller
{
    // 商品購入画面
    public function show(Product $product, Request $request)
    {
        $user = auth()->user();
        $selectedMethod = $request->input('payment_method', 'card'); // デフォルトはカード

        return view('purchase.show', [
            'product' => $product,
            'user' => $user,
            'selectedMethod' => $selectedMethod
        ]);
    }

    // クレジットカード入力画面
    public function checkout(Product $product, Request $request)
    {
        $method = $request->input('payment_method', 'card');

        if ($method !== 'card') {
            return redirect()->route('purchase.show', $product->id)
                ->with('error', 'クレジットカード以外はここから決済できません。');
        }

        return view('checkout', [
            'product' => $product,
            'paymentMethod' => $method,
        ]);
    }

    // カード決済処理
    public function charge(Request $request, Product $product)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $token = $request->input('stripeToken');

        // Stripe決済
        $charge = Charge::create([
            'amount' => $product->price,
            'currency' => 'jpy',
            'description' => $product->name,
            'source' => $token,
        ]);

        // 購入履歴を保存
        $purchase = Purchase::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'amount' => $product->price,
            'status' => 'paid',
        ]);

        return redirect()->route('purchase.thanks', $purchase->id)
            ->with('paymentMethod', 'card');
    }

    // 購入リクエストを受け取る
    public function store(Request $request, Product $product)
    {
        $method = $request->input('payment_method'); // card or konbini

        if ($method === 'card') {
            // カードなら checkout ページへリダイレクト
            return redirect()->route('purchase.checkout', ['product' => $product->id, 'payment_method' => 'card']);
        }

        if ($method === 'konbini') {
            Stripe::setApiKey(config('services.stripe.secret'));

            // Stripe コンビニ支払い用 PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => $product->price,
                'currency' => 'jpy',
                'payment_method_types' => ['konbini'],
                'payment_method_options' => [
                    'konbini' => [
                        'product_description' => $product->name,
                        'expires_after_days' => 3,
                    ]
                ]
            ]);

            // 購入履歴
            $purchase = Purchase::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'amount' => $product->price,
                'status' => 'pending',
                'payment_id' => $paymentIntent->id,
            ]);

            session(['paymentMethod' => 'konbini']);

            return redirect()->route('purchase.thanks', $purchase->id)
                ->with('paymentMethod', 'konbini');
        }

        return back()->withErrors('支払い方法が選択されていません');
    }

    // 購入完了画面
    public function thanks($purchase_id)
    {
        $purchase = Purchase::findOrFail($purchase_id);
        $product = $purchase->product;
        $user = auth()->user();
        $paymentMethod = session('paymentMethod', null);

        return view('purchase.thanks', compact('purchase', 'product', 'user', 'paymentMethod'));
    }

    // 住所編集
    public function editAddress($product_id)
    {
        $purchase = Purchase::where('product_id', $product_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $user = auth()->user();

        return view('purchase.edit', compact('purchase', 'user'));
    }

    public function updateAddress(Request $request, $product_id)
    {
        $purchase = Purchase::where('product_id', $product_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $purchase->update($request->only(['postcode', 'address', 'building']));

        return redirect()->route('purchase.show', $product_id)
            ->with('success', '配送先を更新しました。');
    }
}
