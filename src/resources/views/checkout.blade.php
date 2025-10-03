@extends('layout.app')

@section('content')
<div class="checkout-container">
    <h2>{{ $product->name }} を購入する</h2>
    <p>金額: ¥{{ number_format($product->price) }}</p>

    <form action="{{ route('purchase.charge', $product->id) }}" method="POST" id="payment-form">
        @csrf
        <div id="card-element"><!-- Stripe Elements --></div>
        <button type="submit">決済する</button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ config('services.stripe.key') }}");
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const {
            token,
            error
        } = await stripe.createToken(card);
        if (error) {
            alert(error.message);
        } else {
            let hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'stripeToken';
            hidden.value = token.id;
            form.appendChild(hidden);
            form.submit();
        }
    });
</script>
@endsection