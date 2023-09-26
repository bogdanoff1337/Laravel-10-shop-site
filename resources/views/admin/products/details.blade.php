@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-5">
            <img src="{{ Storage::url($product->photo) }}" alt="{{ $product->name }}" class="img-fluid rounded product-image">
        </div>
             <div class="col-lg-7">
            <h1 class="display-4">{{ $product->name }}</h1>
            <p class="lead">{{ $product->description }}</p>
            
            <p class="font-weight-bold  ">Price: ${{ $product->price }}</p>
            
            <div class="btn-group">

                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-primary btn-lg">Add to Cart</button>
            </form>

            <form action="" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <a class="btn btn-light btn-lg mx-2" >
                    <i class="bi bi-bookmark">Save</i>
                </a>
             </form>
            </div>   
        </div>
    </div>
</div>
@endsection
