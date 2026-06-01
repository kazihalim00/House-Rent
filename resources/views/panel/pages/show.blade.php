@extends('panel.layout')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl">

        <div class="mb-6">
            <a href="{{ route('house-detail') }}"
                class="inline-flex items-center text-gray-600 hover:text-blue-600 font-semibold transition-colors duration-300 bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200 hover:shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> Back to Houses
            </a>
        </div>

        <div class="relative w-full h-[40vh] md:h-[55vh] rounded-3xl overflow-hidden shadow-2xl mb-10 group">
            <img src="{{ asset('upload/img/' . $home->home_image) }}"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                alt="House Image">

            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

            <div class="absolute bottom-6 left-6 md:bottom-12 md:left-12 text-white z-10">
                <span
                    class="bg-blue-600 text-white px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-4 inline-block shadow-lg">For
                    Rent</span>
                <h1 class="text-3xl md:text-5xl font-extrabold drop-shadow-lg mb-2">{{ $home->house_name }}</h1>
                <p class="text-gray-200 mt-2 text-lg md:text-xl font-medium drop-shadow-md flex items-center">
                    <i class="fas fa-map-marker-alt text-red-500 mr-3 text-2xl"></i> {{ $home->address }}, {{ $home->city }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">

            <div class="lg:col-span-2 space-y-8">

                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b border-gray-100 pb-4">Property Overview</h3>
                    <div class="grid grid-cols-3 gap-4 md:gap-8 text-center">
                        <div
                            class="bg-blue-50/50 p-6 rounded-2xl border border-blue-50 hover:bg-blue-50 transition duration-300">
                            <i class="fas fa-bed text-blue-500 text-4xl mb-3"></i>
                            <p class="font-black text-gray-800 text-2xl">{{ $home->bed }}</p>
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wide mt-1">Bedrooms</p>
                        </div>
                        <div
                            class="bg-orange-50/50 p-6 rounded-2xl border border-orange-50 hover:bg-orange-50 transition duration-300">
                            <i class="fas fa-bath text-orange-500 text-4xl mb-3"></i>
                            <p class="font-black text-gray-800 text-2xl">{{ $home->bath }}</p>
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wide mt-1">Bathrooms</p>
                        </div>
                        <div
                            class="bg-green-50/50 p-6 rounded-2xl border border-green-50 hover:bg-green-50 transition duration-300">
                            <i class="fas fa-calendar-alt text-green-500 text-4xl mb-3"></i>
                            <p class="font-black text-gray-800 text-xl mt-2">
                                {{ \Carbon\Carbon::parse($home->booking_date)->format('d M') }}</p>
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wide mt-1">Available</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b border-gray-100 pb-4">About This Property</h3>
                    <p class="text-gray-600 leading-relaxed text-lg text-justify">
                        {{ $home->about }}
                    </p>
                </div>

            </div>

            <div class="lg:col-span-1 sticky top-8 space-y-6">

                <div class="bg-white rounded-2xl p-8 shadow-xl border border-gray-100 relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-50 rounded-full blur-2xl -z-10"></div>

                    <p class="text-gray-500 font-semibold mb-2 uppercase tracking-wider text-sm">Monthly Rent</p>
                    <div class="text-5xl font-black text-gray-900 mb-8">
                        ৳ {{ $home->home_price }} <span class="text-base text-gray-500 font-medium">/ month</span>
                    </div>

                    <a href="{{ route('book.house', $home->id) }}"
                        class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold text-xl py-4 rounded-xl shadow-lg hover:shadow-blue-600/40 transition-all duration-300 transform hover:-translate-y-1">
                        <i class="fas fa-bolt mr-2 text-yellow-300"></i> Book Property
                    </a>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-gray-800 font-bold mb-5 pb-3 border-b border-gray-100">Listed By</p>
                    <div class="flex items-center">
                        <div
                            class="h-16 w-16 rounded-full bg-gradient-to-tr from-blue-600 to-purple-600 flex items-center justify-center text-white mr-5 shadow-md border-4 border-white ring-2 ring-gray-100">
                            <span class="text-2xl font-bold">{{ substr($home->owner_name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-gray-900">{{ $home->owner_name }}</p>
                            <p class="text-sm text-blue-600 font-bold mt-1 bg-blue-50 inline-block px-2 py-0.5 rounded">
                                <i class="fas fa-check-circle mr-1"></i> Verified Owner
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection