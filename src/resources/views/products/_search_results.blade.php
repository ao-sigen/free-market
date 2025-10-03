<div class="product-list">
    @forelse($products as $product)
    <div class="product-card">
        <div class="product-card-link">
            <a href="{{ route('products.show', $product->id) }}">
                <img class="product-card__img"
                    src="{{ $product->images->isNotEmpty() 
                               ? asset('storage/' . $product->images->first()->path) 
                               : asset('images/noimage.jpg') }}"
                    alt="{{ $product->name }}">
                <p>{{ $product->name }}</p>
            </a>
        </div>
    </div>
    @empty
    <p>該当する商品はありません</p>
    @endforelse
</div>