@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>Order</h1>
                @foreach ($cartItems as $cartItem)
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ Storage::url($cartItem->product->photo) }}" alt="product Photo" class="mr-3" style="width: 100px;">
                        <div>
                            <p  style="margin: 0;">{{ $cartItem->product->name }}</p>
                            <p  style="margin: 0;">{{ $cartItem->product->description }}</p>
                            <p  style="margin: 0;">Кількість: {{ $cartItem->quantity }}</p>
                            <p  style="margin: 0;">Price: {{ $cartItem->product->price }} $</p>
                        </div>
                    </div>
                @endforeach
                <p><h4>Total: {{ $total }}$</h4></p>
            </div>
            <div class="col-md-6">
                <h1>Order Form</h1>
                <form method="POST" action="{{ route('orders.placeOrder') }}">
                    @csrf
                    <div class="form-group">
                        <label for="first_name">Ім'я</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" required>
                    </div>
            
                    <div class="form-group">
                        <label for="last_name">Прізвище</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" required>
                    </div>
            
                    <div class="form-group">
                        <label for="payment_method">Спосіб оплати</label>
                        <select name="payment_method" id="payment_method" class="form-control" required>
                            <option value="cash">Готівка</option>
                            <option value="card">Кредитна карта</option>
                        </select>
                    </div>
            
                    <div class="form-group">
                        <label for="delivery_city">Місто доставки</label>
                        <input type="text" name="delivery_city" id="delivery_city" class="form-control" required>
                    </div>
            
                    <button type="submit" class="btn btn-primary mt-3">Оформити замовлення</button>
                </form>
            </div>
        </div>
    </div>
@endsection
