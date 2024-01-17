@extends('layouts.app')

@section('content')
    <div class="product-container">
        @foreach ($products as $product)
            <div class="col-md-2 mb-3">
                <div class="card product-card">

                    <img src="{{ Storage::url($product->photo) }}" alt="{{ $product->name }}"
                        class="card-img-top img-same-size product-image">

                    <div class="card-body-product product-description">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text product-description">{{ $product->description }}...</p>
                        <p class="card-text">Stock quantity: {{ $product->stock_quantity }}</p>
                        <p class="card-text">Price: ${{ $product->price }}</p>

                        <div class="product-features d-flex justify-content-between">
                            <form action="{{ route('cart.store', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn material-symbols-outlined">
                                    add_shopping_cart
                                </button>
                            </form>
                            <span ><a  class="btn" href="{{ route('cart.show', $product->id) }}">Details...</a></span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
