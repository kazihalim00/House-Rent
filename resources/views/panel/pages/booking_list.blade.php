@extends('panel.layout')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <h2 class="text-3xl font-bold mb-6 text-gray-800 border-b pb-3">Booking List</h2>

        @if($bookings->isEmpty())
            <div class="bg-white p-8 text-center rounded-lg shadow-sm border border-gray-100">
                <i class="fas fa-calendar-alt text-gray-400 text-4xl mb-3"></i>
                <p class="text-gray-500 text-lg">No bookings yet.</p>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Guest Name</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Phone</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">House Name</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Owner Name</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Check-in Date</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Duration (Months)</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Booking Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($bookings as $booking)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $booking->guest_name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $booking->guest_email }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $booking->guest_phone }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $booking->house->house_name }}</div>
                                        <div class="text-sm text-gray-500"><i class="fas fa-map-marker-alt text-red-400 mr-1"></i>{{ $booking->house->address }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-700">
                                        {{ $booking->house->owner_name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-700">
                                        {{ $booking->booking_duration }} {{ $booking->booking_duration == 1 ? 'Month' : 'Months' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $booking->created_at->format('d M, Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
