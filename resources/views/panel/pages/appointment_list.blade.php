@extends('panel.layout')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    
    <!-- Success and Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm rounded flex justify-between">
            <div><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</div>
            <button onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm rounded flex justify-between">
            <div><i class="fas fa-times-circle mr-2"></i>{{ session('error') }}</div>
            <button onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    @endif

    <h2 class="text-3xl font-bold mb-6 text-gray-800 border-b pb-3"><i class="fas fa-calendar-check mr-2 text-blue-600"></i> Appointment Requests</h2>

    @if($appointments->isEmpty())
        <div class="bg-white p-8 text-center rounded-lg shadow-sm border border-gray-100">
            <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
            <p class="text-gray-500 text-lg">No appointment requests found yet.</p>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Property</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Visitor Details</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Schedule</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Message</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($appointments as $appointment)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $appointment->house?->house_name ?? 'House Deleted' }}</div>
                                <div class="text-xs text-gray-500"><i class="fas fa-map-marker-alt text-red-400 mr-1"></i>{{ $appointment->house?->city ?? 'N/A' }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $appointment->user?->name ?? 'Unknown User' }}</div>
                                <div class="text-xs text-gray-500">{{ $appointment->user?->email ?? 'N/A' }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-blue-600">{{ \Carbon\Carbon::parse($appointment->visit_date)->format('d M, Y') }}</div>
                                <div class="text-xs text-gray-600 mt-1"><i class="far fa-clock mr-1"></i>{{ $appointment->visit_time }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600 italic line-clamp-2" title="{{ $appointment->message }}">
                                    {{ $appointment->message ?? 'No message provided' }}
                                </p>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($appointment->status == 'pending')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 mb-2">
                                        Pending
                                    </span>
                                    
                                    <!-- এই ফর্মগুলোর কারণেই এখন বাটন কাজ করবে -->
                                    <div class="flex justify-center gap-2 mt-1">
                                        <!-- Approve Form -->
                                        <form action="{{ route('appointment.approve', $appointment->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-green-500 text-white p-1.5 rounded hover:bg-green-600 transition shadow-sm" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>

                                        <!-- Reject Form -->
                                        <form action="{{ route('appointment.reject', $appointment->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Are you sure you want to reject this request?')" class="bg-red-500 text-white p-1.5 rounded hover:bg-red-600 transition shadow-sm" title="Reject">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>

                                @elseif($appointment->status == 'approved')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Approved
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Rejected
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection