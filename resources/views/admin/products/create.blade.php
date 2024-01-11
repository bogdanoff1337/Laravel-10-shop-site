@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Product</h1>
    
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="photo">Photo:</label>
                    <input type="file" name="photo" id="photo" class="form-control" onchange="previewPhoto(event)">
                   
                </div>
                   
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
        
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input type="textarea" name="description" id="description" class="form-control">
                    </div>
        
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" name="price" id="price" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="stock_quantity">Stock quantity:</label>
                        <input type="number" name="stock_quantity" id="stock_quantity" class="form-control">
                    </div>
        
                    <button type="submit" class="btn btn-primary mt-3">Add Product</button>
                </form>
            </div>
            <div class="col-md-6">
                <form enctype="multipart/form-data">
                    <div class="form-group">
                        <img id="photoPreview"   onchange="previewPhoto(event)" style="card-img" class="card-img-top zoom-effect">
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function previewPhoto(event) {
            var input = event.target;
            var reader = new FileReader();
            
            reader.onload = function(){
                var preview = document.getElementById('photoPreview');
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
