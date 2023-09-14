@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Phone</h1>
    
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('admin.phones.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="photo">Photo:</label>
                    <input type="file" name="photo" id="photo" class="form-control" onchange="previewPhoto(event)">
                   
                </div>
                   
                    <div class="form-group">
                        <label for="brand">Brand:</label>
                        <input type="text" name="brand" id="brand" class="form-control">
                    </div>
        
                    <div class="form-group">
                        <label for="model">Model:</label>
                        <input type="text" name="model" id="model" class="form-control">
                    </div>
        
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" name="price" id="price" class="form-control">
                    </div>
        
                    <div class="form-group">
                        <label for="color">Color:</label>
                        <select name="color" id="color" class="form-control">
                            <option value="silver">Silver</option>
                            <option value="gold">Gold</option>
                            <option value="space_gray">Space Gray</option>
                            <option value="rose_gold">Rose Gold</option>
                            <option value="midnight_green">Midnight Green</option>
                            <option value="pacific_blue">Pacific Blue</option>
                            <option value="product_red">Product(RED)</option>
                            <option value="black">Black</option>
                            <option value="white">White</option>
                            <option value="blue">Blue</option>
                            <option value="green">Green</option>
                            <option value="yellow">Yellow</option>
                            <option value="purple">Purple</option>
                            <option value="coral">Coral</option>
                            <option value="orange">Orange</option>
                           
                        </select>
                    </div>
                    
        
                    <div class="form-group">
                        <label for="storage">Storage:</label>
                        <select name="storage" id="storage" class="form-control">
                            <option value="16GB">16GB</option>
                            <option value="32GB">32GB</option>
                            <option value="64GB">64GB</option>
                            <option value="128GB">128GB</option>
                            <option value="256GB">256GB</option>
                            <option value="512GB">512GB</option>
                            <option value="1TB">1TB</option>
                          
                        </select>
                    </div>
        
                    <div class="form-group">
                        <label for="screen_size">Screen Size:</label>
                        <input type="text" name="screen_size" id="screen_size" class="form-control">
                    </div>
        
                    <div class="form-group">
                        <label for="ram">RAM:</label>
                        <select name="ram" id="ram" class="form-control">
                            <option value="2GB">2GB</option>
                            <option value="4GB">4GB</option>
                            <option value="8GB">8GB</option>
                            <option value="16GB">16GB</option>
                            <option value="32GB">32GB</option>
                            
                        </select>
                    </div>
        
                    <button type="submit" class="btn btn-primary">Add Phone</button>
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
