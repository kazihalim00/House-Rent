@extends('panel.layout')

@section('content')
    <div class="container mx-auto px-4 py-10 max-w-2xl">

        <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl p-8">

            <h2 class="text-3xl font-bold text-white mb-8 text-center border-b border-gray-800 pb-4">Add New User</h2>

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
                <div
                    class="bg-green-500/10 border border-green-500/50 text-green-400 px-5 py-4 rounded-xl mb-6 flex justify-between items-center">
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ url('/add-user') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Name</label>
                    <input type="text" name="name" id="name"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 placeholder-gray-500"
                        placeholder="Enter full name">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                    <input type="email" name="email" id="email"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 placeholder-gray-500"
                        placeholder="Enter email address">
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-300 mb-2">Choose Role</label>
                    <select name="role" id="role"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 appearance-none cursor-pointer">
                        <option value="" class="text-gray-400">Select Role</option>
                        <option value="Admin">Admin</option>
                        <option value="User">User</option>
                    </select>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 placeholder-gray-500"
                        placeholder="••••••••">
                </div>

                <div>
                    <label for="user_image" class="block text-sm font-medium text-gray-300 mb-2">Upload your photo</label>
                    <input type="file" name="user_image" id="user_image"
                        class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-xl file:mr-4 file:py-3 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-700 file:text-gray-300 hover:file:bg-gray-600 transition duration-200 cursor-pointer">
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg transition duration-300 flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path
                                d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                        </svg>
                        Submit Details
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection