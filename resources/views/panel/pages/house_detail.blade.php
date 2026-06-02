@extends('panel.layout')

@section('content')
    <div class="container mx-auto px-4 py-8">

        @if (session('success'))
            <div
                class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-md rounded-r-lg flex justify-between items-center">
                <span>{{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.style.display='none'"
                    class="text-green-700 font-bold">&times;</button>
            </div>
        @endif

        <div class="text-end mb-4">
            <a href="{{ url('/add-house') }}" class="btn btn-success">Add House</a>
        </div>

        @if ($houses->isEmpty())
            <div class="mb-6 p-6 bg-gray-100 text-gray-700 rounded-xl shadow-sm text-center">
                No houses found for this date filter. Please choose another available date or range.
            </div>
        @endif

        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-white-800 mb-4">Available Houses for Rent</h2>
            <p class="text-white-600 max-w-2xl mx-auto">
                Find your dream house from our premium collection. We offer the best facilities at an affordable price.
            </p>
        </div>
        @if(request()->hasAny(['location', 'min_price', 'max_price', 'rooms', 'date', 'search']))
            <div class="mb-8 flex flex-wrap items-center gap-3 bg-blue-50/50 p-4 rounded-xl border border-blue-100 shadow-sm">
                <span class="text-sm font-bold text-gray-700"><i class="fas fa-filter text-blue-500 mr-2"></i>Active
                    Filters:</span>

                @if(request('location'))
                    <span
                        class="px-3 py-1.5 bg-white text-blue-700 text-xs font-bold rounded-full shadow-sm border border-blue-200">{{ request('location') }}</span>
                @endif
                @if(request('min_price'))
                    <span
                        class="px-3 py-1.5 bg-white text-blue-700 text-xs font-bold rounded-full shadow-sm border border-blue-200">Min
                        ৳{{ request('min_price') }}</span>
                @endif
                @if(request('max_price'))
                    <span
                        class="px-3 py-1.5 bg-white text-blue-700 text-xs font-bold rounded-full shadow-sm border border-blue-200">Max
                        ৳{{ request('max_price') }}</span>
                @endif
                @if(request('rooms'))
                    <span
                        class="px-3 py-1.5 bg-white text-blue-700 text-xs font-bold rounded-full shadow-sm border border-blue-200">{{ request('rooms') }}+
                        Beds</span>
                @endif
                @if(request('date'))
                    <span
                        class="px-3 py-1.5 bg-white text-blue-700 text-xs font-bold rounded-full shadow-sm border border-blue-200">From:
                        {{ request('date') }}</span>
                @endif

                <a href="{{ route('house-detail') }}"
                    class="ml-auto px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-bold rounded-lg shadow-sm transition transform hover:-translate-y-0.5">
                    <i class="fas fa-times mr-1"></i> Clear All
                </a>
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center">
            @foreach ($houses as $house)
                <div
                    class="max-w-sm w-full bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden border border-gray-100">

                    <div class="relative">
                        <img class="w-full h-56 object-cover" src="{{ asset('/upload/img/' . $house->home_image) }}"
                            alt="House Image" />
                        <div
                            class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase shadow">
                            For Rent
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $house->house_name }}</h3>

                        <p class="text-gray-500 text-sm mb-4">
                            <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>{{ $house->address }}
                        </p>

                        <p class="text-gray-700 text-base mb-6 line-clamp-2">{{ $house->about }}</p>

                        <div class="flex items-center bg-blue-50 rounded-lg p-3 mb-6 border border-blue-100">
                            <div
                                class="h-10 w-10 rounded-full bg-blue-200 flex items-center justify-center text-blue-700 mr-3 shadow-sm">
                                <i class="fas fa-user-tie text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs text-blue-500 uppercase font-bold tracking-wider mb-0.5">Property Owner</p>
                                <p class="text-sm font-bold text-gray-800">{{ $house->owner_name }}</p>
                            </div>
                        </div>
                        <a href="{{ route('panel.pages.show', $house->id) }}"
                            class="w-full block text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors duration-300 shadow-md hover:shadow-lg">
                            View Details
                        </a>
                    </div>

                    <div class="bg-gray-50 px-4 py-4 flex justify-between text-center border-t border-gray-100">
                        <div class="w-1/2 border-r border-gray-200 px-2">
                            <span class="block font-bold text-lg text-green-700">{{ $house->home_price }} ৳</span>
                            <span class="text-[10px] text-gray-500 uppercase font-bold tracking-wide">Monthly</span>
                        </div>
                        <div class="w-1/4 border-r border-gray-200 px-2">
                            <span class="block font-bold text-lg text-blue-700">{{ $house->bed }}</span>
                            <span class="text-[10px] text-gray-500 uppercase font-bold tracking-wide">Beds</span>
                        </div>
                        <div class="w-1/4 border-r border-gray-200 px-2">
                            <span class="block font-bold text-lg text-orange-600">{{ $house->bath }}</span>
                            <span class="text-[10px] text-gray-500 uppercase font-bold tracking-wide">Baths</span>
                        </div>
                        <div class="w-1/2 px-2">
                            <span
                                class="block font-bold text-lg {{ $house->bookings_count > 0 ? 'text-gray-500' : 'text-red-600' }}">{{ \Carbon\Carbon::parse($house->booking_date)->format('d M') }}</span>
                            <span
                                class="text-[10px] uppercase font-bold tracking-wide {{ $house->bookings_count > 0 ? 'text-red-600' : 'text-gray-500' }}">
                                {{ $house->bookings_count > 0 ? 'Booked' : 'Available' }}
                            </span>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
@endsection