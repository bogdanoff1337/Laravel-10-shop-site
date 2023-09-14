@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ Storage::url($phone->photo) }}" alt="Phone Photo" class="card-img-top zoom-effect">
                    <div class="card-body">
                        <h5 class="card-title">{{ $phone->model }}</h5>
                        <p class="card-text">Price: ${{ $phone->price }}</p>
                       
                        
                        <div class="phone-features" style="display: none;">
                            <p>Color: {{ $phone->color }}</p>
                            <p>RAM: {{ $phone->ram }}</p>
                            <p>Storage: {{ $phone->storage }}</p>
                            <form  action="{{ route('cart.add', $phone->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $phone->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-secondary ">
                                    <i class="bi bi-cart-fill"></i>
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
                    $(this).find('.phone-features').slideDown(); // Відображення характеристик при наведенні
                },
                function() {
                    $(this).find('.phone-features').slideUp(); // Приховування характеристик при знятті наведення
                }
            );
        });
    </script>
    
@endsection
