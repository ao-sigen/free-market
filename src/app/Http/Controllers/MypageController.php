<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Comment;
use App\Models\Review;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page', 'favorite'); // デフォルトはお気に入り
        $order = $request->query('order', 'latest'); // 並び替え

        // 出品商品
        $sales = Product::where('user_id', $user->id)
            ->when($order === 'price_asc', fn($q) => $q->orderBy('price', 'asc'))
            ->when($order === 'price_desc', fn($q) => $q->orderBy('price', 'desc'))
            ->latest()
            ->paginate(4)
            ->appends(['page' => 'sell', 'order' => $order]);

        // 購入商品
        $purchases = Purchase::where('user_id', $user->id)
            ->with('product.images')
            ->when($order === 'price_asc', fn($q) => $q->join('products', 'products.id', '=', 'purchases.product_id')
                ->orderBy('products.price', 'asc'))
            ->when($order === 'price_desc', fn($q) => $q->join('products', 'products.id', '=', 'purchases.product_id')
                ->orderBy('products.price', 'desc'))
            ->latest('purchases.created_at')
            ->paginate(4)
            ->appends(['page' => 'buy', 'order' => $order]);

        // お気に入り商品
        $favorites = $user->favorites()
            ->with('images') // Product モデルに images リレーションがあればOK
            ->paginate(4)
            ->appends(['page' => 'favorite', 'order' => $order]);

        return view('profile.mypage', compact('user', 'page', 'purchases', 'sales', 'favorites', 'order'));
    }


    // 購入履歴（購入者側）
    public function purchases()
    {
        $purchases = Auth::user()->purchases()->with('product')->get();
        return view('mypage.purchases', compact('purchases'));
    }

    // 売却済み一覧（出品者側）
    public function sales()
    {
        $sales = Auth::user()->sales()->where('sold', true)->with('purchases')->get();
        return view('mypage.sales', compact('sales'));
    }
}
