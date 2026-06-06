@extends('panel.layout')
@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl">

        @if(session('success'))
            <div
                class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm rounded flex justify-between items-center">
                <div><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</div>
                <button onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif

        <div class="flex items-center justify-between border-b pb-4 mb-8">
            <h2 class="text-3xl font-bold text-gray-800"><i class="fas fa-star text-yellow-400 mr-2"></i> Platform Reviews
            </h2>
        </div>

        @if(Auth::user()->role !== 'Admin')
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-10 max-w-2xl mx-auto">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Write a Review</h3>
                <form action="{{ route('review.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Rating</label>
                        <select name="rating" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            <option value="5">⭐⭐⭐⭐⭐ (5/5) - Excellent</option>
                            <option value="4">⭐⭐⭐⭐ (4/5) - Very Good</option>
                            <option value="3">⭐⭐⭐ (3/5) - Good</option>
                            <option value="2">⭐⭐ (2/5) - Fair</option>
                            <option value="1">⭐ (1/5) - Poor</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Your
                            Experience</label>
                        <textarea name="comment" rows="4" required placeholder="Share your experience with our platform..."
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"></textarea>
                    </div>

                    <div class="text-right">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition">
                            Submit Review
                        </button>
                    </div>
                </form>
            </div>
        @endif

        @if($reviews->isEmpty())
            <div class="bg-white p-8 text-center rounded-2xl shadow-sm border border-gray-100">
                <i class="far fa-comment-dots text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500 text-lg">No reviews have been posted yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($reviews as $review)
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative hover:shadow-md transition">

                        @if(Auth::user()->role === 'Admin')
                            <div class="absolute top-4 right-4">
                                <form action="{{ route('review.delete', $review->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this review?')"
                                        class="text-red-400 hover:text-red-600 transition" title="Delete Review">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        @endif

                        <div class="flex items-center mb-4">
                            <img src="{{ asset('upload/img/' . ($review->user->user_image ?? 'default.jpg')) }}" alt="User"
                                class="w-12 h-12 rounded-full object-cover mr-4 border-2 border-blue-50">
                            <div>
                                <h4 class="text-sm font-bold text-gray-800">{{ $review->user->name ?? 'Unknown User' }}</h4>
                                <p class="text-xs text-gray-400">{{ $review->created_at->format('d M, Y - h:i A') }}</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star text-yellow-400 text-sm"></i>
                                @else
                                    <i class="far fa-star text-gray-300 text-sm"></i>
                                @endif
                            @endfor
                        </div>

                        <p class="text-gray-600 text-sm italic line-clamp-4">"{{ $review->comment }}"</p>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection