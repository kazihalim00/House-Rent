@extends('panel.layout')

@section('content')

    <div class="container mx-auto px-4 py-8">
        <div class="text-end">
            <a href="{{ url('/add-house') }}" class="btn btn-success">
                Add House
            </a>
        </div>
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Available Houses for Rent</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Find your dream house from our premium collection. We offer the best facilities at an affordable price.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center">
            @foreach ($houses as $house)
                <div
                    class="max-w-sm w-full bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden border border-gray-100">

                    <div class="relative">
                        <img class="w-full h-56 object-cover" src="{{ asset('/upload/img/' . $house->home_image) }}"
                            alt="House Image" />
                        <div
                            class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase">
                            For Rent
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $house->house_name }}</h3>

                        <p class="text-gray-500 text-sm mb-4">
                            <i class="fas fa-map-marker-alt text-red-500 mr-1"></i> {{  $house->address }}
                        </p>

                        <p class="text-gray-700 text-base mb-6 line-clamp-2">
                            {{ $house->about }}
                        </p>

                        <button
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition-colors duration-300">
                            View Details
                        </button>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex justify-between text-center border-t border-gray-100">

                        <div class="w-1/3 border-r border-gray-200">
                            <span class="block font-bold text-lg text-gray-800" style="color:green">{{ $house->home_price }}
                                TK</span>
                            <span class="text-xs text-gray-500 uppercase font-semibold">Monthly</span>
                        </div>

                        <div class="w-1/3 border-r border-gray-200">
                            <span class="block font-bold text-lg text-gray-800">{{ $house->bed }}</span>
                            <span class="text-xs text-gray-500 uppercase font-semibold">Beds</span>
                        </div>

                        <div class="w-1/3">
                            <span class="block font-bold text-lg text-gray-800">{{ $house->bath }}</span>
                            <span class="text-xs text-gray-500 uppercase font-semibold">Baths</span>
                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    </div>
@endsection