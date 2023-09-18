<!-- resources/views/admin/index.blade.php -->

@include('partials.flash-message')

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dashboard</h1>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="users-tab" data-toggle="tab" href="#users">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="products-tab" data-toggle="tab" href="#products">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders">Orders</a>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="users">
                <h2>Users</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <form action="{{ route('admin.delete', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="products">
                <h2>Products</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>description</th>
                            <th>stock_quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->stock_quantity }}</td>
                                <td>{{ $product->price }}</td>
                                <td>
                                    <form action="{{ route('admin.products.delete', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="orders">
                <h2>Orders</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order Number</th>
                            <th>User</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedOrders as $orderNumber => $orders)
                            <tr>
                                <td rowspan="{{ count($orders) }}">{{ $orderNumber }}</td>
                                @foreach ($orders as $index => $order)
                                    @if ($index > 0)
                                        </tr><tr>
                                    @endif
                                    <td>{{ $order->user->name }}</td>
                                    <td>
                                        @foreach ($order->items as $itemIndex => $item)
                                            @if ($itemIndex > 0)
                                                <br>
                                            @endif
                                            @if ($item->product)
                                                {{ $item->product->name }} - {{ $item->product->description }}
                                            @else
                                                No product available
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($order->items as $itemIndex => $item)
                                            @if ($itemIndex > 0)
                                                <br>
                                            @endif
                                            @if ($item->product)
                                                {{ $item->product->price }}$
                                            @else
                                                No price available
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($order->items as $itemIndex => $item)
                                            @if ($itemIndex > 0)
                                                <br>
                                            @endif
                                            {{ $item->quantity }}
                                        @endforeach
                                    </td>
                                    <td>
                                    
                                        <form action="{{ route('admin.updateOrderStatus', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" onchange="this.form.submit()">
                                                <option value="pending" {{ $order->statusOrder && $order->statusOrder->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="completed" {{ $order->statusOrder && $order->statusOrder->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ $order->statusOrder && $order->statusOrder->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                    
                                    <td>
                                        <form action="{{ route('admin.deleteOrder', $order->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.nav-link');

            tabs.forEach(function (tab) {
                tab.addEventListener('click', function (event) {
                    event.preventDefault();
                    document.querySelector('.nav-link.active').classList.remove('active');
                    document.querySelector('.tab-pane.fade.show.active').classList.remove('show', 'active');
                    this.classList.add('active');
                    document.querySelector(this.getAttribute('href')).classList.add('show', 'active');
                });
            });
        });
    </script>
@endsection
