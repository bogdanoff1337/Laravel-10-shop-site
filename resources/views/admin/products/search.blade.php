@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Search Results</h1>

        @if ($products->count() > 0)
            <ul>
                @foreach ($products as $product)
                    <li>{{ $product->name }}</li>
                @endforeach
            </ul>
        @else
            <p>No results found.</p>
        @endif
    </div>
@endsection
