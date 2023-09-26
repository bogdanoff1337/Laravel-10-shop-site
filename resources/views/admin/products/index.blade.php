@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card product-card">
                    
                    <img src="{{ Storage::url($product->photo) }}" alt="{{ $product->name }}" class="card-img-top img-same-size product-image">
                    
                    <div class="card-body product-description">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text product-description">{{ $product->description }}...</p>
                        <p class="card-text">Stock quantity: {{ $product->stock_quantity }}</p>
                        <p class="card-text">Price: ${{ $product->price }}</p>
                        
                        <div class="product-features d-flex justify-content-between">
                            <form  action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-outline-primary">
                                    Add to cart <i class="bi bi-cart-plus-fill"></i>
                                </button>
                            </form>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Details...</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
          
        </div>
    </div> 
    
@endsection
