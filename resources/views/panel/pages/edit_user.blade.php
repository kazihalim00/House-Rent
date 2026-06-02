@extends('panel.layout')

@section('content')
    <div class="container mx-auto px-4 py-10 max-w-2xl">

        <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl p-8">

            <h2 class="text-3xl font-bold text-white mb-8 text-center border-b border-gray-800 pb-4">Edit User</h2>

            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500/50 text-red-400 px-5 py-4 rounded-xl mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/50 text-green-400 px-5 py-4 rounded-xl mb-6 flex justify-between items-center">
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ url('/edit-user/' . $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 placeholder-gray-500"
                        placeholder="Enter full name">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 placeholder-gray-500"
                        placeholder="Enter email address">
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-300 mb-2">Choose Role</label>
                    <select name="role" id="role"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 appearance-none cursor-pointer">
                        <option value="" class="text-gray-400">Select Role</option>
                        <option value="Admin" {{ old('role', $user->role) === 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="User" {{ old('role', $user->role) === 'User' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 placeholder-gray-500"
                        placeholder="Leave blank to keep current password">
                </div>

                <div>
                    <label for="user_image" class="block text-sm font-medium text-gray-300 mb-2">Upload photo</label>
                    <input type="file" name="user_image" id="user_image"
                        class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-xl file:mr-4 file:py-3 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-700 file:text-gray-300 hover:file:bg-gray-600 transition duration-200 cursor-pointer">
                </div>

                @if ($user->user_image)
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('upload/img/' . $user->user_image) }}" alt="Current user image" class="w-20 h-20 rounded-full object-cover shadow-sm">
                        <p class="text-sm text-gray-400">Current image</p>
                    </div>
                @endif

                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg transition duration-300 flex justify-center items-center gap-2">
                        Update User
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
