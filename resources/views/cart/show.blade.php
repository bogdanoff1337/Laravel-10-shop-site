@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Shopping Cart</h1>

        @if(count($cartItems) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Phone</th>
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
                                <img src="{{ Storage::url($cartItem->phone->photo) }}" alt="Phone Photo" style="width: 100px; margin-right: 10px;">
                                <div>
                                    <p style="margin: 0;">{{ $cartItem->phone->brand }}</p>
                                    <p style="margin: 0;">{{ $cartItem->phone->model }}</p>
                                </div>
                            </div>
                            </td>
                        
                            <td>{{ $cartItem->phone->price }} $</td>

                        <td>
                            <div class="d-flex align-items-center">
                                <form action="{{ route('cart.decrement', $cartItem->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">-</button>
                                </form>
                                <span class="mx-2">{{ $cartItem->quantity }}</span>
                                <form action="{{ route('cart.increment', $cartItem->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">+</button>
                                </form>
                            </div>
                        </td>
                        <td>{{ $cartItem->phone->price * $cartItem->quantity }} $</td>
                        <td>
                            
                            <form id="remove-form-{{ $cartItem->id }}" action="{{ route('cart.remove', $cartItem->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmRemove({{ $cartItem->id }})">Remove</button>
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
