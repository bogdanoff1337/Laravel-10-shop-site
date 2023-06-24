@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Phone</h1>
    
    <div class="row">
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('admin.phones.update', $phone) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                   
                    <div class="form-group">
                        <label for="brand">Brand:</label>
                        <input type="text" name="brand" id="brand" class="form-control" value="{{ $phone->brand }}">
                    </div>
        
                    <div class="form-group">
                        <label for="model">Model:</label>
                        <input type="text" name="model" id="model" class="form-control" value="{{ $phone->model }}">
                    </div>
        
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" name="price" id="price" class="form-control" value="{{ $phone->price }}">
                    </div>
        
                    <div class="form-group">
                        <label for="color">Color:</label>
                        <select name="color" id="color" class="form-control">
                            <option value="silver" {{ $phone->color === 'silver' ? 'selected' : '' }}>Silver</option>
                            <option value="gold" {{ $phone->color === 'gold' ? 'selected' : '' }}>Gold</option>
                            <option value="space_gray" {{ $phone->color === 'space_gray' ? 'selected' : '' }}>Space Gray</option>
                            <option value="rose_gold" {{ $phone->color === 'rose_gold' ? 'selected' : '' }}>Rose Gold</option>
                            <option value="midnight_green" {{ $phone->color === 'midnight_green' ? 'selected' : '' }}>Midnight Green</option>
                            <option value="pacific_blue" {{ $phone->color === 'pacific_blue' ? 'selected' : '' }}>Pacific Blue</option>
                            <option value="product_red" {{ $phone->color === 'product_red' ? 'selected' : '' }}>Product(RED)</option>
                            <option value="black" {{ $phone->color === 'black' ? 'selected' : '' }}>Black</option>
                            <option value="white" {{ $phone->color === 'white' ? 'selected' : '' }}>White</option>
                            <option value="blue" {{ $phone->color === 'blue' ? 'selected' : '' }}>Blue</option>
                            <option value="green" {{ $phone->color === 'green' ? 'selected' : '' }}>Green</option>
                            <option value="yellow" {{ $phone->color === 'yellow' ? 'selected' : '' }}>Yellow</option>
                            <option value="purple" {{ $phone->color === 'purple' ? 'selected' : '' }}>Purple</option>
                            <option value="coral" {{ $phone->color === 'coral' ? 'selected' : '' }}>Coral</option>
                            <option value="orange" {{ $phone->color === 'orange' ? 'selected' : '' }}>Orange</option>
                            
                        </select>
                    </div>
                    
        
                    <div class="form-group">
                        <label for="storage">Storage:</label>
                        <select name="storage" id="storage" class="form-control">
                            <option value="16GB" {{ $phone->storage === '16GB' ? 'selected' : '' }}>16GB</option>
                            <option value="32GB" {{ $phone->storage === '32GB' ? 'selected' : '' }}>32GB</option>
                            <option value="64GB" {{ $phone->storage === '64GB' ? 'selected' : '' }}>64GB</option>
                            <option value="128GB" {{ $phone->storage === '128GB' ? 'selected' : '' }}>128GB</option>
                            <option value="256GB" {{ $phone->storage === '256GB' ? 'selected' : '' }}>256GB</option>
                            <option value="512GB" {{ $phone->storage === '512GB' ? 'selected' : '' }}>512GB</option>
                            <option value="1TB" {{ $phone->storage === '1TB' ? 'selected' : '' }}>1TB</option>
                            <!-- Додайте більше варіантів об'єму пам'яті, якщо потрібно -->
                        </select>
                    </div>
        
                    <div class="form-group">
                        <label for="screen_size">Screen Size:</label>
                        <input type="text" name="screen_size" id="screen_size" class="form-control" value="{{ $phone->screen_size }}">
                    </div>
        
                    <div class="form-group">
                        <label for="ram">RAM:</label>
                        <select name="ram" id="ram" class="form-control">
                            <option value="2GB" {{ $phone->ram === '2GB' ? 'selected' : '' }}>2GB</option>
                            <option value="4GB" {{ $phone->ram === '4GB' ? 'selected' : '' }}>4GB</option>
                            <option value="8GB" {{ $phone->ram === '8GB' ? 'selected' : '' }}>8GB</option>
                            <option value="16GB" {{ $phone->ram === '16GB' ? 'selected' : '' }}>16GB</option>
                            <option value="32GB" {{ $phone->ram === '32GB' ? 'selected' : '' }}>32GB</option>
                            <!-- Додайте більше варіантів об'єму оперативної пам'яті, якщо потрібно -->
                        </select>
                    </div>
        
                    <button type="submit" class="btn btn-primary">Update Phone</button>
                </form>
            </div>
            
        </div>

    </div>
</div>
@endsection
