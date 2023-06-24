@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My Orders</h1>
        @foreach ($orders as $order)
            <h2>Order Number: {{ $order->order_number }}</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Phone</th>
                        <th>Price</th>
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
                                @if ($item->phone)
                                    <div style="display: flex; align-items: center;">
                                        <img src="{{ Storage::url($item->phone->photo) }}" alt="Phone Photo" style="width: 100px; margin-right: 10px;">
                                        <div>
                                            <p style="margin: 0;">{{ $item->phone->brand }}</p>
                                            <p style="margin: 0;">{{ $item->phone->model }}</p>
                                        </div>
                                    </div>
                                @else
                                    No Phone available
                                @endif
                            </td>
                            <td>
                                @if ($item->phone)
                                    {{ $item->phone->price }}$
                                @else
                                    No price available
                                @endif
                            </td>
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
                                return $item->phone ? $item->phone->price * $item->quantity : 0;
                            }) }}$
                            <br>
                            <strong>Status:</strong>{{ $order->statusOrder ? $order->statusOrder->status : '' }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        @endforeach
    </div>
@endsection
