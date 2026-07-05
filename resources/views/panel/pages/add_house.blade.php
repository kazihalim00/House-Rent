@extends('panel.layout')

@section('content')
    <div class="container mx-auto px-4 py-10 max-w-3xl">

        <div class="text-center border-b border-gray-700/60 pb-8 mb-8 relative">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-3 tracking-tight drop-shadow-md">
                Add House
            </h2>
            <p class="text-gray-400 text-sm md:text-base max-w-lg mx-auto font-medium">
                Please provide your house details below. Fields marked with
                <span class="text-red-400 font-bold">*</span> are required.
            </p>
        </div>

        @if (session('success'))
            <div
                class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-md rounded-r-lg flex justify-between items-center">
                <span>{{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.style.display='none'" class="text-green-700 font-bold">
                    &times;
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-md rounded-r-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/add-house') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="house_name" class="block text-sm font-medium text-gray-300 mb-2">House Name *</label>
                    <input type="text" name="house_name" id="house_name"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500"
                        placeholder="Enter house name" required />
                </div>
                <input type="hidden" name="owner_name" value="{{ Auth::user()->name }}">
                <input type="hidden" name="email" value="{{ Auth::user()->email }}">

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Phone Number *</label>
                    <input type="tel" name="phone" id="phone"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500"
                        placeholder="Enter phone number" required />
                </div>

                <div>
                    <label for="division" class="block text-sm font-medium text-gray-300 mb-2">Division *</label>
                    <select name="division" id="division"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none cursor-pointer"
                        required>
                        <option value="">Select Division</option>
                        <option value="Sylhet">Sylhet</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Chattogram">Chattogram</option>
                        <option value="Khulna">Khulna</option>
                        <option value="Rajshahi">Rajshahi</option>
                    </select>
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-gray-300 mb-2">City / Town *</label>
                    <input type="text" name="city" id="city"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500"
                        placeholder="City or Town" required />
                </div>

                <div>
                    <label for="home_price" class="block text-sm font-medium text-gray-300 mb-2">Rental Price (TK) *</label>
                    <input type="text" name="home_price" id="home_price"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500"
                        placeholder="e.g. 15000" required />
                </div>

                <div>
                    <label for="bed" class="block text-sm font-medium text-gray-300 mb-2">
                        Number of Beds *
                    </label>

                    <select name="bed" id="bed"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">Select Number of Beds</option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }} Bed{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label for="bath" class="block text-sm font-medium text-gray-300 mb-2">
                        Number of Baths *
                    </label>

                    <select name="bath" id="bath"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">Select Number of Baths</option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }} Bath{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-300 mb-2">Street Address *</label>
                <input type="text" name="address" id="address"
                    class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500"
                    placeholder="House No., Road Name, etc." required />
            </div>

            <div>
                <label for="about" class="block text-sm font-medium text-gray-300 mb-2">About House *</label>
                <textarea name="about" id="about" rows="3"
                    class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500"
                    placeholder="Write a short description about the house..." required></textarea>
            </div>

            <div>
                <label for="booking_date" class="block text-sm font-medium text-gray-300 mb-2">Booking Date *</label>
                <input type="date" name="booking_date" id="booking_date"
                    class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    min="{{ date('Y-m-d') }}" required />
            </div>

            <div>
                <label for="home_image" class="block text-sm font-medium text-gray-300 mb-2">Upload House Images (Multiple
                    allowed) *</label>
                <input type="file" name="home_image[]" id="home_image"
                    class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-xl file:mr-4 file:py-3 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-700 file:text-gray-300 hover:file:bg-gray-600 cursor-pointer"
                    multiple required />
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg transition duration-300 flex justify-center items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                    </svg>
                    Submit
                </button>
            </div>

        </form>
    </div>
@endsection