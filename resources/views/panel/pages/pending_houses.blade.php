@extends('panel.layout')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <h2 class="text-3xl font-bold mb-6 text-gray-800 border-b pb-3">Pending Houses for Approval</h2>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($houses->isEmpty())
            <div class="bg-white p-8 text-center rounded-lg shadow-sm border border-gray-100">
                <i class="fas fa-check-circle text-green-500 text-4xl mb-3"></i>
                <p class="text-gray-500 text-lg">All caught up! No pending houses at the moment.</p>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">House Info
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Owner</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($houses as $house)
                            <tr class="hover:bg-gray-50 transition duration-150">

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="{{ asset('upload/img/' . $house->home_image) }}" alt="House"
                                        class="h-16 w-16 object-cover rounded shadow-sm">
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $house->house_name }}</div>
                                    <div class="text-sm text-gray-500"><i class="fas fa-map-marker-alt text-red-400 mr-1"></i>
                                        {{ $house->city }}</div>
                                    <div class="text-sm font-bold text-green-600 mt-1">৳ {{ $house->home_price }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $house->owner_name }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex justify-center gap-3">

                                        <form action="{{ route('admin.approve_house', $house->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow transition transform hover:-translate-y-0.5">
                                                <i class="fas fa-check mr-1"></i> Approve
                                            </button>
                                        </form>


                                        <form action="{{ route('admin.reject_house', $house->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow transition transform hover:-translate-y-0.5"
                                                onclick="return confirm('Are you sure you want to reject this house listing?')">
                                                <i class="fas fa-times mr-1"></i> Reject
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection