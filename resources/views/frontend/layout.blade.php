<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="House Rent" />
    <link rel="shortcut icon" href="{{ asset('frontend/favicon.png') }}" />
    <meta name="description" content="Find your dream home with House Rent" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('frontend/fonts/icomoon/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/fonts/flaticon/font/flaticon.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/tiny-slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/aos.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" />

    <style>
        :root {
            --dark-bg: #1a1a2e;
            --dark-surface: #16213e;
            --dark-card: #1e2a45;
            --dark-border: #2a3a5c;
            --accent-red: #e53935;
            --accent-red-hover: #c62828;
            --text-primary: #f0f4ff;
            --text-muted: #8892a4;
            --text-secondary: #b0bec5;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: var(--dark-bg) !important;
            color: var(--text-primary) !important;
            font-family: 'Inter', sans-serif !important;
        }

        /* ── Navbar ── */
        .site-navbar {
            background-color: var(--dark-surface) !important;
            border-bottom: 1px solid var(--dark-border);
            padding: 14px 0;
        }

        .site-navbar .site-logo a {
            color: var(--text-primary) !important;
            font-weight: 700;
            font-size: 20px;
        }

        .site-navbar .site-logo a span {
            color: var(--accent-red);
        }

        .site-navbar .site-navigation .site-menu a {
            color: var(--text-secondary) !important;
            font-weight: 500;
            transition: color 0.2s;
        }

        .site-navbar .site-navigation .site-menu a:hover {
            color: var(--accent-red) !important;
        }

        .site-navbar .site-navigation .site-menu .active>a {
            color: var(--accent-red) !important;
        }

        /* ── Buttons ── */
        .btn-primary {
            background-color: var(--accent-red) !important;
            border-color: var(--accent-red) !important;
            color: #fff !important;
            font-weight: 600;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background-color: var(--accent-red-hover) !important;
            border-color: var(--accent-red-hover) !important;
        }

        .btn-secondary {
            background-color: var(--accent-red) !important;
            border-color: var(--accent-red) !important;
            color: #fff !important;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-secondary:hover {
            background-color: var(--accent-red-hover) !important;
            border-color: var(--accent-red-hover) !important;
        }

        /* ── Property card image fix ── */
        .property-item {
            overflow: hidden !important;
        }

        .property-item .img,
        .property-item a.img {
            display: block !important;
            width: 100% !important;
            overflow: hidden !important;
            margin: 0 !important;
            padding: 0 !important;
            line-height: 0;
        }

        .property-item .img img,
        .property-item a.img img {
            width: 100% !important;
            max-width: 100% !important;
            height: 220px !important;
            object-fit: cover !important;
            object-position: center !important;
            display: block !important;
            border-radius: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .property-item a.img img[style],
        .property-item .img img[style] {
            width: 100% !important;
            max-width: 100% !important;
            height: 220px !important;
            object-fit: cover !important;
            object-position: center !important;
            display: block !important;
            border-radius: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* ── Equal height property cards ── */
        .property-slider {
            display: flex;
            align-items: stretch;
        }

        .tns-inner .tns-slider {
            display: flex !important;
            align-items: stretch !important;
        }

        .property-item {
            display: flex !important;
            flex-direction: column !important;
            height: 100% !important;
            overflow: hidden !important;
        }

        .property-content {
            display: flex !important;
            flex-direction: column !important;
            flex: 1 !important;
            padding: 20px !important;
            background: var(--dark-card) !important;
        }

        .property-content>div:last-child {
            margin-top: auto !important;
        }

        .property-slider .property-item {
            margin: 0 8px;
        }

        .tns-inner {
            margin: 0 !important;
        }

        /* Force remove any padding around image inside card */
        .property-item {
            padding: 0 !important;
        }

        .property-item>a.img,
        .property-item>.img {
            display: block !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            line-height: 0 !important;
            font-size: 0 !important;
        }

        /* ── Property card content & button ── */
        .property-content {
            padding: 20px !important;
            background: var(--dark-card) !important;
        }

        .property-content a.btn,
        .property-content a.btn-primary,
        .property-content a.btn-secondary {
            background-color: var(--accent-red) !important;
            border-color: var(--accent-red) !important;
            color: #fff !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            padding: 11px 0 !important;
            display: block !important;
            width: 100% !important;
            text-align: center !important;
            transition: background 0.2s !important;
            margin-top: 4px !important;
        }

        .property-content a.btn:hover,
        .property-content a.btn-primary:hover,
        .property-content a.btn-secondary:hover {
            background-color: var(--accent-red-hover) !important;
            border-color: var(--accent-red-hover) !important;
        }

        /* ── Hero ── */
        .hero {
            position: relative;
        }

        .hero .overlay::after {
            background: linear-gradient(to bottom, rgba(22, 33, 62, 0.7) 0%, rgba(26, 26, 46, 0.92) 100%) !important;
        }

        .hero .heading {
            color: #fff !important;
        }

        .hero .form-search .form-control {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid var(--dark-border) !important;
            color: var(--text-primary) !important;
            border-radius: 8px 0 0 8px;
        }

        .hero .form-search .form-control::placeholder {
            color: var(--text-muted);
        }

        .hero .form-search .btn {
            border-radius: 0 8px 8px 0;
        }

        /* ── Sections ── */
        .section {
            background-color: var(--dark-bg) !important;
            padding: 4rem 0;
        }

        .section.bg-light,
        .section-4.bg-light {
            background-color: var(--dark-surface) !important;
        }

        /* ── Section headings ── */
        h2.heading,
        h2.font-weight-bold {
            color: var(--text-primary) !important;
        }

        h2.text-primary {
            color: var(--accent-red) !important;
        }

        /* ── Property Cards ── */
        .property-item {
            background: var(--dark-card) !important;
            border: 1px solid var(--dark-border) !important;
            border-radius: 12px !important;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .property-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 32px rgba(229, 57, 53, 0.15) !important;
        }

        .property-content {
            padding: 16px !important;
        }

        .property-content .price span {
            color: var(--accent-red) !important;
            font-size: 20px;
            font-weight: 700;
        }

        .property-content .city,
        .property-content .text-black-50 {
            color: var(--text-muted) !important;
        }

        .property-content .caption {
            color: var(--text-secondary) !important;
        }

        /* ── Features section ── */
        .features-1 {
            background: var(--dark-surface) !important;
            padding: 4rem 0;
        }

        .box-feature {
            background: var(--dark-card) !important;
            border: 1px solid var(--dark-border) !important;
            border-radius: 12px;
            padding: 2rem 1.5rem;
            transition: border-color 0.2s;
        }

        .box-feature:hover {
            border-color: var(--accent-red) !important;
        }

        .box-feature [class^="flaticon-"],
        .box-feature [class*=" flaticon-"] {
            color: var(--accent-red) !important;
            font-size: 2.5rem !important;
        }

        .box-feature h3 {
            color: var(--text-primary) !important;
            font-size: 1rem;
            font-weight: 600;
        }

        .box-feature p {
            color: var(--text-muted) !important;
            font-size: 14px;
        }

        .box-feature .learn-more {
            color: var(--accent-red) !important;
            font-weight: 600;
        }

        /* ── Testimonials ── */
        .sec-testimonials {
            background: var(--dark-bg) !important;
        }

        .testimonial .h5 {
            color: var(--accent-red) !important;
        }

        .testimonial .text-dark {
            color: var(--text-secondary) !important;
        }

        .testimonial .text-black-50 {
            color: var(--text-muted) !important;
        }

        .testimonial .icon-star.text-warning {
            color: #fbbf24 !important;
        }

        .testimonial .icon-star.text-muted {
            color: var(--dark-border) !important;
        }

        .btn-light {
            background: var(--dark-card) !important;
            border-color: var(--dark-border) !important;
            color: var(--text-primary) !important;
        }

        .btn-light:hover {
            border-color: var(--accent-red) !important;
            color: var(--accent-red) !important;
        }

        /* ── About section ── */
        .section-4 .text-black-50 {
            color: var(--text-muted) !important;
        }

        .wrap-icon {
            background: var(--accent-red) !important;
        }

        .feature-text h3 {
            color: var(--text-primary) !important;
        }

        .feature-text p {
            color: var(--text-muted) !important;
        }

        /* ── Counters ── */
        .section-counter {
            border-top: 1px solid var(--dark-border) !important;
        }

        .counter-wrap .number {
            color: var(--text-primary) !important;
            font-size: 2rem;
            font-weight: 700;
        }

        .countup {
            color: var(--accent-red) !important;
        }

        .counter-wrap .caption {
            color: var(--text-muted) !important;
        }

        /* ── Footer ── */
        .footer {
            background-color: var(--dark-surface) !important;
            border-top: 1px solid var(--dark-border);
            color: var(--text-muted) !important;
        }

        .footer h3 {
            color: var(--text-primary) !important;
        }

        .footer a {
            color: var(--text-muted) !important;
            transition: color 0.2s;
        }

        .footer a:hover {
            color: var(--accent-red) !important;
        }

        .footer .copyright {
            color: var(--text-muted) !important;
        }

        /* ── Loader ── */
        .loader {
            background: var(--dark-bg) !important;
        }

        .spinner-border {
            color: var(--accent-red) !important;
        }

        /* ── Mobile menu ── */
        .site-mobile-menu {
            background: var(--dark-surface) !important;
        }

        .site-mobile-menu a {
            color: var(--text-secondary) !important;
        }

        /* ── Slider dots/arrows ── */
        .tns-nav button {
            background: var(--dark-border) !important;
        }

        .tns-nav button.tns-nav-active {
            background: var(--accent-red) !important;
        }

        /* ── Hide tiny-slider cloned items ── */
        .tns-item.tns-slide-cloned {
            visibility: hidden !important;
            pointer-events: none !important;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--dark-border);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-red);
        }
    </style>

    <title>House Rent - Find Your Dream Home</title>
</head>

<body>
    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close">
                <span class="icofont-close js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>

    @include('frontend.includes.header')

    @yield('content')

    @include('frontend.includes.footer')

    <div id="overlayer"></div>
    <div class="loader">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('frontend/js/aos.js') }}"></script>
    <script src="{{ asset('frontend/js/navbar.js') }}"></script>
    <script src="{{ asset('frontend/js/counter.js') }}"></script>
    <script src="{{ asset('frontend/js/custom.js?v=2') }}"></script>
</body>

</html>