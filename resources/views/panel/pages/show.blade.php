@extends('panel.layout')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        @if (session('success'))
            <div
                class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-md rounded-r-lg flex justify-between items-center transition-all">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.style.display='none'"
                    class="text-green-700 hover:text-green-900 font-bold text-xl">&times;</button>
            </div>
        @endif
        
        @if (session('error'))
            <div
                class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-md rounded-r-lg flex justify-between items-center transition-all">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                    <span class="font-semibold">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.style.display='none'"
                    class="text-red-700 hover:text-red-900 font-bold text-xl">&times;</button>
            </div>
        @endif
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
                                {{ \Carbon\Carbon::parse($home->booking_date)->format('d M') }}
                            </p>
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

                    <div class="space-y-4">
                        @if (Auth::check() && Auth::id() === $home->user_id && Auth::user()->role !== 'Admin')
                            <div class="block w-full text-center bg-gray-400 text-white font-bold text-xl py-4 rounded-xl shadow-lg cursor-not-allowed opacity-60">
                                <i class="fas fa-ban mr-2"></i> You cannot book your own house
                            </div>
                        @else
                            <a href="{{ route('book.house', $home->id) }}"
                                class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold text-xl py-4 rounded-xl shadow-lg hover:shadow-blue-600/40 transition-all duration-300 transform hover:-translate-y-1">
                                <i class="fas fa-bolt mr-2 text-yellow-300"></i> Book Property
                            </a>
                        @endif

                        <button onclick="openAppointmentModal()"
                            class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-bold text-lg py-3 rounded-xl shadow-sm transition-all duration-300 transform hover:-translate-y-1">
                            <i class="fas fa-calendar-alt mr-2"></i> Schedule a Visit
                        </button>
                    </div>
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
    <div id="appointmentModal"
        class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex justify-center items-center px-4 transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300"
            id="modalContent">

            <div class="bg-blue-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-white text-xl font-bold"><i class="fas fa-clock mr-2"></i> Schedule a House Visit</h3>
                <button onclick="closeAppointmentModal()"
                    class="text-white hover:text-gray-200 text-2xl font-bold leading-none">&times;</button>
            </div>

            <form action="{{ route('book.appointment', $home->id) }}" method="POST" class="p-6">
                @csrf

                <div class="mb-5">
                    <label class="block text-gray-700 font-bold mb-2 text-sm">Select Visit Date *</label>
                    <input type="date" name="visit_date" required min="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-gray-700">
                </div>

                <div class="mb-5">
                    <label class="block text-gray-700 font-bold mb-2 text-sm">Select Preferred Time *</label>
                    <select name="visit_time" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-gray-700">
                        <option value="" disabled selected>Choose a time slot</option>
                        <option value="Morning (9:00 AM - 12:00 PM)">Morning (9:00 AM - 12:00 PM)</option>
                        <option value="Afternoon (1:00 PM - 4:00 PM)">Afternoon (1:00 PM - 4:00 PM)</option>
                        <option value="Evening (5:00 PM - 8:00 PM)">Evening (5:00 PM - 8:00 PM)</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2 text-sm">Message (Optional)</label>
                    <textarea name="message" rows="3" placeholder="Any specific questions for the owner?"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-gray-700 resize-none"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeAppointmentModal()"
                        class="px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200 transition">Cancel</button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-md transition">Submit
                        Request</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAppointmentModal() {
            const modal = document.getElementById('appointmentModal');
            const modalContent = document.getElementById('modalContent');
            modal.classList.remove('hidden');
            // হাল্কা এনিমেশনের জন্য
            setTimeout(() => {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function closeAppointmentModal() {
            const modal = document.getElementById('appointmentModal');
            const modalContent = document.getElementById('modalContent');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
@endsection