@extends('panel.layout')

@section('content')
    <div class="max-w-4xl mx-auto bg-gray-900 border border-gray-800 rounded-2xl shadow-xl p-8">

        <!-- Header -->
        <div class="mb-8 text-center border-b border-gray-800 pb-6">
            <h2 class="text-3xl font-bold text-white">Add Team Member</h2>
            <p class="text-gray-400 text-sm mt-2">Manage your development team</p>
        </div>

        <form action="{{ url('/add-team-member') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-md rounded-r-lg flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                    <button type="button" onclick="this.parentElement.style.display='none'" class="text-green-700 font-bold">
                        &times;
                    </button>
                </div>
            @endif
            <!-- Row 1 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-gray-300 text-sm font-medium">Full Name *</label>
                    <input type="text"
                        class="w-full mt-2 bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Enter full name" name="name">
                </div>

                <div>
                    <label class="text-gray-300 text-sm font-medium">Designation *</label>
                    <select
                        class="w-full mt-2 bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none"
                        name="role">
                        <option value="">Select Role</option>
                        <option>Frontend Developer</option>
                        <option>Backend Developer</option>
                        <option>Full Stack Developer</option>
                        <option>UI/UX Designer</option>
                        <option>Project Manager</option>
                    </select>
                </div>
            </div>

            <!-- Row 2 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-gray-300 text-sm font-medium">GitHub</label>
                    <input type="url"
                        class="w-full mt-2 bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="https://github.com/username" name="github">
                </div>

                <div>
                    <label class="text-gray-300 text-sm font-medium">LinkedIn</label>
                    <input type="url"
                        class="w-full mt-2 bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="https://linkedin.com/in/username" name="linkedin">
                </div>
            </div>

            <!-- Portfolio -->
            <div>
                <label class="text-gray-300 text-sm font-medium">Portfolio Website</label>
                <input type="url"
                    class="w-full mt-2 bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none"
                    placeholder="https://yourportfolio.com" name="portfolio">
            </div>

            <!-- Image Upload -->
            <div>
                <label class="text-gray-300 text-sm font-medium">Profile Image *</label>

                <div
                    class="mt-2 flex flex-col items-center justify-center border-2 border-dashed border-gray-700 rounded-xl p-6 bg-gray-800 hover:border-blue-500 transition">
                    <input type="file" class="text-gray-300" name="image">
                    <p class="text-gray-400 text-sm mt-2">Click or drag image here</p>
                </div>
            </div>

            <!-- Bio -->
            <div>
                <label class="text-gray-300 text-sm font-medium">Short Bio *</label>
                <textarea rows="4"
                    class="w-full mt-2 bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none"
                    placeholder="Write a short introduction..." name="short_bio"></textarea>
            </div>

            <!-- Row 3 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-gray-300 text-sm font-medium">Display Order</label>
                    <input type="number"
                        class="w-full mt-2 bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="1" name="order">
                </div>

                <div>
                    <label class="text-gray-300 text-sm font-medium">Status</label>
                    <select
                        class="w-full mt-2 bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none"
                        name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg transition flex items-center justify-center gap-2"
                    name="submit">
                    ➕ Add Team Member
                </button>
            </div>

        </form>
    </div>
@endsection