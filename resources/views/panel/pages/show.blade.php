@extends('panel.layout')

@section('content')

    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
        }

        .container {
            width: 70%;
            margin: auto;
            background: white;
            padding: 20px;
            margin-top: 40px;
            border-radius: 10px;
            display: flex;
            gap: 20px;
        }

        .image-box img {
            width: 300px;
            border-radius: 10px;
        }

        .details {
            flex: 1;
        }

        .price {
            color: green;
            font-size: 22px;
            font-weight: bold;
        }

        .btn {
            padding: 10px 15px;
            background: blue;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn:hover {
            background: darkblue;
        }
    </style>

<div class="container">

    <div class="image-box">
        <img src="{{ asset('upload/img/' . $home->home_image) }}" alt="House Image">
    </div>

    <div class="details">
        <h2>{{ $home->house_name }}</h2>

        <p class="price">৳ {{ $home->home_price }}</p>

        <p><strong>Location:</strong> {{ $home->address }}, {{ $home->city }}</p>
        <p><strong>Beds:</strong> {{ $home->bed }} | <strong>Baths:</strong> {{ $home->bath }}</p>
        
        <hr>
        <p>{{ $home->about }}</p>

        <a href="{{ route('book.house', $home->id) }}" class="btn" style="text-decoration: none; display: inline-block;">Book Now</a>

        <p id="msg"></p>
    </div>
</div>

@endsection