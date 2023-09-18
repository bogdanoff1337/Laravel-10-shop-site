@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ Storage::url($product->photo) }}" alt="Product Photo" class="card-img-top zoom-effect img-fluid">
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Price: ${{ $product->price }}</p>
                       
                        
                        <div class="product-features" style="display: none;">
                            <p>Description: {{ $product->description }}</p>
                            <p>Stock quantity: {{ $product->stock_quantity }}</p>
                            
                            <form  action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-secondary ">
                                    Add to cart <i class="bi bi-cart-plus"></i>
                                </button>
                            </form>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.card').hover(
                function() {
                    $(this).find('.product-features').slideDown(); // Відображення характеристик при наведенні
                },
                function() {
                    $(this).find('.product-features').slideUp(); // Приховування характеристик при знятті наведення
                }
            );
        });
    </script>
    
@endsection
