@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My Orders</h1>
        @if ($orders->isEmpty())
        <p>You have no orders.</p>
    @else
        @foreach ($orders as $order)
            <h2>Order Number: {{ $order->order_number }}</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Data</th>
                        <th>Quantity</th>
                        <th>Your Name</th>
                        <th>Payment Method</th>
                        <th>Delivery City</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>
                                @if ($item->product)
                                    <div style="display: flex; align-items: center;">
                                        <img src="{{ Storage::url($item->product->photo) }}" alt="product Photo" style="width: 100px; margin-right: 10px;">
                                        <div>
                                            <p style="margin: 0;">{{ $item->product->name }}</p>
                                            <p style="margin: 0;">{{ $item->product->description }}</p>
                                        </div>
                                    </div>
                                @else
                                    No product available
                                @endif
                            </td>
                            <td>
                                @if ($item->product)
                                    {{ $item->product->price }}$
                                @else
                                    No price available
                                @endif
                            </td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                            <td>{{ $order->payment_method }}</td>
                            <td>{{ $order->delivery_city }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5"></td>
                        <td colspan="3">
                            <strong>Total:</strong> {{ $order->items->sum(function ($item) {
                                return $item->product ? $item->product->price * $item->quantity : 0;
                            }) }}$
                            <br>
                            <strong>Status:</strong>{{ $order->statusOrder ? $order->statusOrder->status : '' }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        @endforeach
    @endif
    </div>
@endsection
