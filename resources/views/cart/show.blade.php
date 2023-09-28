@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Shopping Cart</h1>

        @if(count($cartItems) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price $</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $cartItem)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <img src="{{ Storage::url($cartItem->product->photo) }}" alt="product Photo" style="width: 100px; margin-right: 10px;">
                                <div>
                                    <p style="margin: 0;">{{ $cartItem->product->name }}</p>
                                    <p style="margin: 0;">{{ $cartItem->product->description }}</p>
                                </div>
                            </div>
                            </td>
                        
                            <td>{{ $cartItem->product->price }} $</td>

                        <td>
                            <form method="POST" action="{{ route('cart.updateQuantityProduct') }}">
                                @csrf
                                <input type="hidden" name="cartItemId" value="{{ $cartItem->id }}">
                                
                                <div class="input-group mb-3">
                                    <input type="number" name="quantity" value="{{ $cartItem->quantity }}" min="1" class="form-control rounded-pill">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary ">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            </form> 
                        </td>

                        <td>{{ $cartItem->product->price * $cartItem->quantity }} $</td>
                        <td>
                            
                            <form id="remove-form-{{ $cartItem->id }}" action="{{ route('cart.remove', $cartItem->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                            <button type="button" class="btn  btn-danger" onclick="confirmRemove({{ $cartItem->id }})">Remove</button>
                        </td>
                        <script>
                            function confirmRemove(cartItemId) {
                                if (confirm('Are you sure you want to remove this item from your cart?')) {
                                    document.getElementById('remove-form-' + cartItemId).submit();
                                }
                            }
                            </script>
                        
                    </tr>
                    @endforeach
                    <a href="{{ route('cart.removeAll', Auth::id()) }}" class="btn btn-danger">Remove All Items</a>

      
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                <div>
                    <h4>Total: {{ $total }}$</h4>
                    <form method="POST" action="{{ route('orders.showOrderForm')}}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </form>
                </div>
            </div>

        @else
            <p>Your cart is empty.</p>
        @endif
    </div>
    

@endsection
