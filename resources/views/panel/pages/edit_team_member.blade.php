@extends('panel.layout')

@section('content')

    <div class="max-w-4xl mx-auto bg-gray-900 border border-gray-800 rounded-2xl shadow-xl p-8">

        <div class="text-center mb-8 border-b border-gray-800 pb-6">
            <h2 class="text-3xl font-bold text-white">Update Team Member</h2>
            <p class="text-gray-400 text-sm mt-2">Manage your development team</p>
        </div>

        <form action="{{ url('/edit-team-member/' . $member->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-md rounded-r-lg flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                    <button type="button" onclick="this.parentElement.style.display='none'"
                        class="text-green-700 font-bold">&times;</button>
                </div>
            @endif

            <!-- Name -->
            <input type="text" name="name" value="{{ $member->name }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white"
                placeholder="Enter full name">

            <!-- Role -->
            <select name="role" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white">

                <option disabled>Select Role</option>

                <option value="Frontend Developer" {{ $member->role == 'Frontend Developer' ? 'selected' : '' }}>
                    Frontend Developer
                </option>

                <option value="Backend Developer" {{ $member->role == 'Backend Developer' ? 'selected' : '' }}>
                    Backend Developer
                </option>

                <option value="Full Stack Developer" {{ $member->role == 'Full Stack Developer' ? 'selected' : '' }}>
                    Full Stack Developer
                </option>

                <option value="UI/UX Designer" {{ $member->role == 'UI/UX Designer' ? 'selected' : '' }}>
                    UI/UX Designer
                </option>

                <option value="Project Manager" {{ $member->role == 'Project Manager' ? 'selected' : '' }}>
                    Project Manager
                </option>

            </select>

            <!-- GitHub -->
            <input type="url" name="github" value="{{ $member->github }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white" placeholder="GitHub URL">

            <!-- LinkedIn -->
            <input type="url" name="linkedin" value="{{ $member->linkedin }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white"
                placeholder="LinkedIn URL">

            <!-- Portfolio -->
            <input type="url" name="portfolio" value="{{ $member->portfolio }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white"
                placeholder="Portfolio URL">

            <!-- image -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-5">

                <!-- Label -->
                <label class="text-gray-300 text-sm font-medium block mb-3">
                    Profile Image
                </label>

                <!-- Current Image Preview -->
                <div class="flex items-center gap-4 mb-4">

                    <img src="{{ asset('upload/team/' . $member->image) }}"
                        class="w-16 h-16 rounded-full object-cover border-2 border-gray-600 shadow" alt="Current Image">

                    <div>
                        <p class="text-sm text-gray-400">Current Image</p>
                        <p class="text-xs text-gray-500">Upload new image to replace</p>
                    </div>

                </div>

                <!-- File Input -->
                <input type="file" name="image" class="block w-full text-sm text-gray-300
                                       file:mr-4 file:py-2 file:px-4
                                       file:rounded-lg file:border-0
                                       file:text-sm file:font-semibold
                                       file:bg-blue-600 file:text-white
                                       hover:file:bg-blue-700
                                       cursor-pointer">

            </div>

            <!-- Bio -->
            <textarea name="short_bio" rows="4"
                class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white"
                placeholder="Short bio">{{ $member->short_bio }}</textarea>

            <!-- Order -->
            <input type="number" name="order" value="{{ $member->order }}"
                class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white"
                placeholder="Display order">

            <!-- Status -->
            <select name="status" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white">

                <option value="active" {{ $member->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $member->status == 'inactive' ? 'selected' : '' }}>Inactive</option>

            </select>

            <!-- Submit -->
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl">
                Update Team Member
            </button>

        </form>
    </div>

@endsection