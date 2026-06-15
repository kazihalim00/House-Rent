@extends('panel.layout')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        @if(session('success'))
            <div
                class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm rounded flex justify-between">
                <div><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</div>
                <button onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif
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
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Guest
                                    Name</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Email
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Phone
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">House
                                    Name</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    Check-in Date</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    Duration (Months)</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Booking
                                    Date</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($bookings as $booking)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
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
                                        <div class="text-sm font-bold text-gray-900">
                                            {{ $booking->house?->house_name ?? 'House Deleted' }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <i
                                                class="fas fa-map-marker-alt text-red-400 mr-1"></i>{{ $booking->house?->address ?? 'N/A' }}
                                        </div>
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
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($booking->status == 'pending')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif ($booking->status == 'approved')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Approved
                                            </span>
                                        @else {{-- rejected --}}
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex items-center space-x-2">
                                            {{-- Show Approve/Reject buttons if the current user is the house owner or an Admin, and the booking is pending --}}
                                            @if ($booking->status == 'pending' && (Auth::user()->role == 'Admin' || Auth::id() == $booking->house?->user_id))
                                                <form action="{{ route('booking.approve', $booking->id) }}" method="POST"
                                                    class="inline-block">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-green-50 text-green-500 hover:bg-green-100 p-2 rounded-lg transition"
                                                        title="Approve Booking">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('booking.reject', $booking->id) }}" method="POST"
                                                    class="inline-block">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-red-50 text-red-500 hover:bg-red-100 p-2 rounded-lg transition"
                                                        title="Reject Booking">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            {{-- Existing delete button (can be used by guests for their own bookings, or owners/admins for any booking) --}}
                                            <form action="{{ route('booking.delete', $booking->id) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this booking history?')"
                                                    class="bg-red-50 text-red-500 hover:bg-red-100 p-2 rounded-lg transition"
                                                    title="Delete Booking">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
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