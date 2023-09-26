@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Product</h1>
    
    <div class="row">
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                   
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}">
                    </div>
        
                    <div class="form-group">
                        <label for="description">description:</label>
                        <input type="text" name="description" id="description" class="form-control" value="{{ $product->description }}">
                    </div>
        
                    <div class="form-group">
                        <label for="stock_quantity">Stock quantity:</label>
                        <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" value="{{ $product->stock_quantity }}">
                    </div>

                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}">
                    </div>
        
                    <button type="submit" class="btn btn-primary mt-2">Update product</button>
                </form>
            </div>
            
        </div>

    </div>
</div>
@endsection
