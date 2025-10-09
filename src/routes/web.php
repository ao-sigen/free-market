<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\RegisterController;

// 🔹 認証関連
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth')->group(function () {
    // プロフィール作成
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');

    // マイページ
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// 🔹 商品一覧・検索
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');

// 🔹 商品詳細・出品
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/sell', [ProductController::class, 'create'])->name('products.create');
Route::post('/sell', [ProductController::class, 'store'])->name('products.store');

// 🔹 サンクスページ
Route::get('/thank/{id}', [ProductController::class, 'thank'])->name('thank');

// 🔹 お気に入り・コメント
Route::post('/products/{id}/favorite', [ProductController::class, 'favorite'])->name('products.favorite');
Route::post('/products/{id}/comment', [ProductController::class, 'comment'])
    ->name('products.comment')
    ->middleware('auth');

// 🔹 購入関連（認証必須）
Route::middleware('auth')->group(function () {
    // 購入確認ページ
    Route::get('/purchase/{product}', [PurchaseController::class, 'show'])->name('purchase.show');

    // 購入処理（POSTのみ）
    Route::post('/purchase/{product}/store', [PurchaseController::class, 'store'])->name('purchase.store');

    // 配送先編集
    Route::get('/purchase/{product}/edit', [PurchaseController::class, 'editAddress'])->name('purchase.edit');
    Route::patch('/purchase/{product}/edit', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');

    // 購入完了ページ
    Route::get('/purchase/thanks/{purchase_id}', [PurchaseController::class, 'thanks'])->name('purchase.thanks');
});
// クレジットカード決済用のチェックアウト画面
// 購入処理共通（最初の入口）
Route::post('/purchase/{product}', [PurchaseController::class, 'store'])->name('purchase.store');

// クレジットカード入力ページ
Route::get('/purchase/{product}/checkout', [PurchaseController::class, 'checkout'])->name('purchase.checkout');

// クレジットカード決済実行
Route::post('/purchase/{product}/charge', [PurchaseController::class, 'charge'])->name('purchase.charge');

// 購入完了ページ
Route::get('/purchase/thanks/{purchase}', [PurchaseController::class, 'thanks'])->name('purchase.thanks');
