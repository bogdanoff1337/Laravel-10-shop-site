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
                        <input type="text" name="name" id="name" class="form-control" value="{{ $product->brand }}">
                    </div>
        
                    <div class="form-group">
                        <label for="descreaption">Descreaption:</label>
                        <input type="text" name="descreaption" id="descreaption" class="form-control" value="{{ $product->model }}">
                    </div>
        
                    <div class="form-group">
                        <label for="stock_quantity">Stock quantity:</label>
                        <input type="number" name="stock_quantity" id="stock_quantity" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}">
                    </div>
        
                    <button type="submit" class="btn btn-primary">Update product</button>
                </form>
            </div>
            
        </div>

    </div>
</div>
@endsection
