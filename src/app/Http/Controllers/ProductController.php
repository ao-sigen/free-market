<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Comment;



class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all(); // すべて取得
        return view('index', compact('products'));

        $query = Product::query();

        // キーワード検索
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where('name', 'like', "%{$keyword}%");
        }

        $products = $query->paginate(6);

        return view('products.index', compact('products'));
    }


    public function show($id)
    {
        $product = Product::with(['images', 'condition', 'categories', 'favorites'])->findOrFail($id);

        $comments = DB::table('comments')->where('product_id', $id)->get();
        $user = auth()->user();

        return view('products.show', compact('product', 'comments', 'user'));
    }


    public function create()
    {
        $categories = Category::all(); // カテゴリ一覧を取得
        $conditions = Condition::all(); // 状態一覧を取得

        return view('products.create', compact('categories', 'conditions'));
    }


    public function store(StoreProductRequest $request)
    {
        $validate = $request->validate();

        $product = Product::create([
            'user_id'      => auth()->id(),
            'condition_id' => $validated['condition_id'],
            'name'         => $validated['name'],
            'brand'        => $validated['brand'],
            'description'  => $validated['description'],
            'price'        => $validated['price'],
        ]);
        

        // カテゴリの紐付け
        $product->categories()->attach($validated['categories']);

        // 画像アップロード
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('thank', ['id' => $product->id]);
    }

    public function thank($id)
    {
        $product = Product::findOrFail($id);
        return view('products.thank', compact('product'));
    }

    public function favorite($id)
    {
        $product = Product::findOrFail($id);
        $user = auth()->user();

        // すでにお気に入り登録済みか確認
        if ($user->favorites()->where('product_id', $product->id)->exists()) {
            // 解除
            $user->favorites()->detach($product->id);
        } else {
            // 登録
            $user->favorites()->attach($product->id);
        }

        return back();
    }

    public function comment(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string|max:500',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'product_id' => $id,
            'text' => $request->text,
        ]);

        return back();
    }

    public function search(Request $request)
    {
        $query = $request->input('q'); // 検索ワード
        $products = \App\Models\Product::query()
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->get();

        // Ajaxの場合は部分テンプレート返却
        if ($request->ajax()) {
            return view('products._search_results', compact('products'));
        }

        // 通常アクセスの場合は検索結果ページへ
        return view('index', compact('products'));
    }
}
