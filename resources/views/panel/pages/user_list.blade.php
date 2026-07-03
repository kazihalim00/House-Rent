@extends('panel.layout')

@section('content')
    <div class="container mx-auto px-4 py-6">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-white">User Lists</h2>

            <a href="{{ url('/add-user') }}"
                class="text-white font-semibold py-2 px-5 rounded-full shadow transition duration-300 flex items-center gap-2"
                style="background-color: #e53935;" onmouseover="this.style.backgroundColor='#c62828'"
                onmouseout="this.style.backgroundColor='#e53935'">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                </svg>
                Add User
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">

                    <thead>
                        <tr class="bg-gray-900 text-white text-sm uppercase tracking-wider">
                            <th class="px-6 py-4 font-semibold">#</th>
                            <th class="px-6 py-4 font-semibold">Name</th>
                            <th class="px-6 py-4 font-semibold">Email</th>
                            <th class="px-6 py-4 font-semibold">Role</th>
                            <th class="px-6 py-4 font-semibold text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 text-gray-700">
                        @foreach ($users as $user)
                            <tr class="hover:bg-blue-50 transition-colors duration-200">

                                <td class="px-6 py-4 font-medium">{{ $user->id }}</td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        @if($user->user_image)
                                            <img src="{{ asset('upload/img/' . $user->user_image) }}"
                                                class="w-11 h-11 rounded-full object-cover shadow-sm">
                                        @else
                                            <img src="{{ asset('assets/img/avatar.png') }}"
                                                class="w-11 h-11 rounded-full object-cover shadow-sm">
                                        @endif
                                        <div>
                                            <h6 class="text-base font-bold text-gray-900 m-0">{{ $user->name }}</h6>
                                            <p class="text-xs text-gray-500 m-0">Joined {{ $user->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">{{ $user->email }}</td>

                                <td class="px-6 py-4">
                                    @if ($user->role == "Admin")
                                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1.5 rounded-full">
                                            {{ $user->role }}
                                        </span>
                                    @elseif($user->role == "User")
                                        <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1.5 rounded-full">
                                            {{ $user->role }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 flex justify-center gap-3">
                                    <a href="{{ url('/edit-user/' . $user->id) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg shadow transition duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                        </svg>
                                    </a>

                                    <a href="{{ url('/delete-user/' . $user->id) }}"
                                        onclick="return confirm('Are you sure to delete?')"
                                        class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg shadow transition duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                            <path fill-rule="evenodd"
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                        </svg>
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>
@endsection