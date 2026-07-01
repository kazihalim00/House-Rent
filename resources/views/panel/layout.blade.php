<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>House Rent</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <style>
        body.panel-bg,
        html.panel-bg {
            background-color: #16213e !important;
        }

        .content,
        .container-fluid.pt-4.px-4.flex-grow-1,
        .footer-bg {
            background-color: #16213e !important;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="panel-bg">
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->
        <div class="content d-flex flex-column min-vh-100">

            <!-- Sidebar Start -->
            @include('panel.includes.sidebar')
            <!-- Sidebar End -->
            <!-- Navbar Start -->
            @include('panel.includes.header')
            <!-- Navbar End -->

            <!-- Main Content -->
            <div class="container-fluid pt-4 px-4 flex-grow-1">
                @yield('content')
            </div>

            <!-- Footer Start -->
            @include('panel.includes.footer')
            <!-- Footer End -->

        </div>
        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @yield('scripts')
    <!-- Advanced Filter Modal (সম্পূর্ণ কোড) -->
    <div id="globalFilterModal"
        class="fixed inset-0 z-[9999] hidden bg-black/60 backdrop-blur-sm flex justify-center items-center px-4 transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl overflow-hidden transform scale-95 transition-transform duration-300"
            id="filterModalContent">

            <div class="bg-gray-900 px-6 py-4 flex justify-between items-center">
                <h3 class="text-white text-xl font-bold"><i class="fas fa-filter text-red-500 mr-2" style="color: #e53935;"></i> Advanced
                    Search
                </h3>
                <button onclick="closeFilterModal()"
                    class="text-gray-400 hover:text-white text-2xl font-bold leading-none">&times;</button>
            </div>

            <form action="{{ route('house-detail') }}" method="GET" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label
                            class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Location</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i
                                    class="fas fa-map-marker-alt"></i></span>
                            <input type="text" name="location" value="{{ request('location') }}"
                                placeholder="City or area..."
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-700">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Min Price
                            (৳)</label>
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="e.g. 5000"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-700">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Max Price
                            (৳)</label>
                        <input type="number" name="max_price" value="{{ request('max_price') }}"
                            placeholder="e.g. 20000"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-700">
                    </div>

                    <div>
                        <label
                            class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Bedrooms</label>
                        <select name="rooms"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-700">
                            <option value="">Any Rooms</option>
                            <option value="1" {{ request('rooms') == '1' ? 'selected' : '' }}>1+ Bed</option>
                            <option value="2" {{ request('rooms') == '2' ? 'selected' : '' }}>2+ Beds</option>
                            <option value="3" {{ request('rooms') == '3' ? 'selected' : '' }}>3+ Beds</option>
                            <option value="4" {{ request('rooms') == '4' ? 'selected' : '' }}>4+ Beds</option>
                        </select>
                    </div>

                    <div>
                        <label
                            class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Availability</label>
                        <input type="date" name="date" value="{{ request('date') }}"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-700">
                    </div>
                </div>

                <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-100">
                    <button type="button" onclick="window.location.href='{{ route('house-detail') }}'"
                        class="text-sm text-red-500 hover:text-red-700 font-bold flex items-center">
                        <i class="fas fa-times mr-1"></i> Clear Filters
                    </button>
                    <div class="flex gap-3">
                        <button type="button" onclick="closeFilterModal()"
                            class="px-6 py-2.5 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition">Cancel</button>
                        <button type="submit"
                            class="px-6 py-2.5 text-white font-bold rounded-lg shadow-md transition" style="background-color: #e53935;" onmouseover="this.style.backgroundColor='#c62828'" onmouseout="this.style.backgroundColor='#e53935'">Apply
                            Filters</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Script -->
    <script>
        function openFilterModal() {
            const modal = document.getElementById('globalFilterModal');
            const modalContent = document.getElementById('filterModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function closeFilterModal() {
            const modal = document.getElementById('globalFilterModal');
            const modalContent = document.getElementById('filterModalContent');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
</body>
</body>


</html>