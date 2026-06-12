@extends('frontend.layout')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <div class="hero">
        <div class="hero-slide">
            @foreach($heroHouses as $heroHouse)
                @php
                    $heroImages = json_decode($heroHouse->home_image, true) ?: [$heroHouse->home_image];
                    $heroDisplayImage = $heroImages[0] ?? 'default.jpg';
                @endphp
                <div class="img overlay" style="background-image: url('{{ asset('upload/img/' . $heroDisplayImage) }}')">
                </div>
            @endforeach
        </div>

        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-9 text-center">
                    <h1 class="heading" data-aos="fade-up">Seeking Your Space?<br> Property Awaits For You!</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="section" id="popularhouses">
        <div class="container">
            <div class="row mb-5 align-items-center">
                <div class="col-lg-6">
                    <h2 class="font-weight-bold text-primary heading">Popular Properties</h2>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <p>
                        <a href="{{ route('house-detail') }}" class="btn btn-primary text-white py-3 px-4">View all
                            properties</a>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="property-slider">
                        @foreach($houses as $house)
                            @php
                                $houseImages = json_decode($house->home_image, true) ?: [$house->home_image];
                                $displayImage = $houseImages[0] ?? 'default.jpg';
                            @endphp
                            <div class="property-item">
                                <a href="{{ route('panel.pages.show', $house->id) }}" class="img">
                                    <img src="{{ asset('upload/img/' . $displayImage) }}" alt="Image" />
                                </a>
                                <div class="property-content">
                                    <div class="price mb-2"><span>৳ {{ number_format($house->home_price) }}</span></div>
                                    <span class="d-block mb-1 text-black-50">{{ $house->house_name }}</span>
                                    <span class="city d-block mb-3">{{ $house->address }}, {{ $house->city }}</span>
                                    <div class="specs d-flex mb-3">
                                        <span class="d-block d-flex align-items-center me-3">
                                            <span class="icon-bed me-2"></span>
                                            <span class="caption">{{ $house->bed }} beds</span>
                                        </span>
                                        <span class="d-block d-flex align-items-center">
                                            <span class="icon-bath me-2"></span>
                                            <span class="caption">{{ $house->bath }} baths</span>
                                        </span>
                                    </div>

                                    {{-- Review placeholder — always same height --}}
                                    <div class="review-area mb-3" style="min-height: 28px;">
                                        @if($house->reviews->count() > 0)
                                            <div class="d-flex align-items-center">
                                                <span class="text-warning me-2">
                                                    @for($i = 1; $i <= $house->reviews->max('rating'); $i++)
                                                        <span class="icon-star"></span>
                                                    @endfor
                                                </span>
                                                <span class="text-secondary" style="font-size:13px;">{{ $house->reviews->count() }}
                                                    reviews</span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Button always at bottom --}}
                                    @auth
                                        <a href="{{ route('book.house', $house->id) }}" class="btn btn-primary py-2 px-3">Book
                                            Now</a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-secondary py-2 px-3">Login to Book</a>
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="features-1" id="services">
        <div class="container">
            <div class="row">
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="box-feature text-center">
                        <span class="flaticon-house"></span>
                        <h3 class="mb-3">Our Properties</h3>
                        <p>We provide the most beautiful and affordable houses in the city.</p>
                        <p><a href="{{ route('house-detail') }}" class="learn-more">Learn More</a></p>
                    </div>
                </div>
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="500">
                    <div class="box-feature text-center">
                        <span class="flaticon-building"></span>
                        <h3 class="mb-3">Easy Booking</h3>
                        <p>Book your dream house online with just a few clicks.</p>
                        <p><a href="{{ route('house-detail') }}" class="learn-more">Learn More</a></p>
                    </div>
                </div>
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="box-feature text-center">
                        <span class="flaticon-house-3"></span>
                        <h3 class="mb-3">Trusted Owners</h3>
                        <p>All our property owners are verified for your security.</p>
                        <p><a href="#" class="learn-more">Learn More</a></p>
                    </div>
                </div>
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="600">
                    <div class="box-feature text-center">
                        <span class="flaticon-house-1"></span>
                        <h3 class="mb-3">Physical Visit</h3>
                        <p>Request an appointment to visit the property before renting.</p>
                        <p><a href="#" class="learn-more">Learn More</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="section sec-testimonials">
        <div class="container">
            <div class="row mb-5 align-items-center">
                <div class="col-md-6">
                    <h2 class="font-weight-bold heading text-primary mb-4 mb-md-0">Customer Says</h2>
                </div>
                <div class="col-md-6 text-md-end">
                    <div>
                        <span class="btn btn-light rounded-pill px-4 py-2 me-2" data-bs-target="#testimonialCarousel"
                            data-bs-slide="prev" style="cursor:pointer; font-size:14px; font-weight:bold;">Prev</span>
                        <span class="btn btn-light rounded-pill px-4 py-2" data-bs-target="#testimonialCarousel"
                            data-bs-slide="next" style="cursor:pointer; font-size:14px; font-weight:bold;">Next</span>
                    </div>
                </div>
            </div>

            <div id="testimonialCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel"
                data-bs-interval="4000">
                <div class="carousel-inner">
                    @if($reviews->count() > 0)
                        @foreach($reviews as $key => $review)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <div class="testimonial text-center px-3">
                                    <img src="{{ asset('upload/img/' . ($review->user->user_image ?? 'default.png')) }}"
                                        alt="User Image" class="img-fluid rounded-circle mb-4 mx-auto"
                                        style="height:80px; width:80px !important; object-fit:cover; border:3px solid rgba(255,255,255,0.1); box-shadow:0 4px 8px rgba(0,0,0,0.3);" />
                                    <div class="rate mb-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <span class="icon-star text-warning"></span>
                                            @else
                                                <span class="icon-star text-muted"></span>
                                            @endif
                                        @endfor
                                    </div>
                                    <h3 class="h5 text-primary mb-4">{{ $review->user->name ?? 'House Rent User' }}</h3>
                                    <blockquote style="max-width:700px; margin:0 auto;">
                                        <p class="text-dark" style="font-size:18px; font-style:italic;">
                                            &ldquo;{{ $review->comment }}&rdquo;</p>
                                    </blockquote>
                                    <p class="text-black-50 mt-3 font-weight-bold">Verified Customer</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="carousel-item active">
                            <div class="text-center w-100">
                                <p class="text-muted italic">No reviews yet. Be the first to leave a review from your dashboard!
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="section section-4 bg-light" id="about">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-5">
                    <h2 class="font-weight-bold heading text-primary mb-4">About House Rent</h2>
                    <p class="text-black-50">
                        We are the most trusted platform for finding your perfect home in the city. Our goal is to connect
                        property owners with genuine tenants easily, transparently, and securely.
                    </p>
                </div>
            </div>

            <div class="row justify-content-between mb-5">
                <div class="col-lg-7 mb-5 mb-lg-0 order-lg-2">
                    <div class="img-about dots">
                        <img src="{{ asset('frontend/images/hero_bg_3.jpg') }}" alt="About Us"
                            class="img-fluid rounded-3 shadow" />
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="d-flex feature-h mb-4">
                        <span
                            class="wrap-icon me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                            style="width:50px; height:50px; flex-shrink:0;">
                            <span class="icon-home2"></span>
                        </span>
                        <div class="feature-text">
                            <h3 class="heading h5 font-weight-bold">Verified Properties</h3>
                            <p class="text-black-50 text-sm">Every house listed on our platform goes through a strict
                                verification process by our admins.</p>
                        </div>
                    </div>
                    <div class="d-flex feature-h mb-4">
                        <span
                            class="wrap-icon me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                            style="width:50px; height:50px; flex-shrink:0;">
                            <span class="icon-person"></span>
                        </span>
                        <div class="feature-text">
                            <h3 class="heading h5 font-weight-bold">Direct Communication</h3>
                            <p class="text-black-50 text-sm">No middleman! We ensure that you communicate directly with
                                genuine property owners.</p>
                        </div>
                    </div>
                    <div class="d-flex feature-h">
                        <span
                            class="wrap-icon me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                            style="width:50px; height:50px; flex-shrink:0;">
                            <span class="icon-security"></span>
                        </span>
                        <div class="feature-text">
                            <h3 class="heading h5 font-weight-bold">Secure Booking</h3>
                            <p class="text-black-50 text-sm">Book your desired home with our 100% secure and transparent
                                digital system.</p>
                        </div>
                    </div>
                </div>
            </div>

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

            <style>
                /* Custom Animations & Glassmorphism Design */
                .team-section {
                    background-color: #0f172a;
                    /* Deep dark blue background */
                    min-height: 100vh;
                }

                .team-card {
                    background: rgba(30, 41, 59, 0.7);
                    backdrop-filter: blur(12px);
                    -webkit-backdrop-filter: blur(12px);
                    border: 1px solid rgba(255, 255, 255, 0.05);
                    border-radius: 20px;
                    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                    position: relative;
                    overflow: hidden;
                    z-index: 1;
                }

                /* 3D Hover & Glow Effect */
                .team-card:hover {
                    transform: translateY(-15px) scale(1.03);
                    background: rgba(30, 41, 59, 0.9);
                    box-shadow: 0 20px 40px rgba(59, 130, 246, 0.3),
                        inset 0 0 20px rgba(59, 130, 246, 0.1);
                    border-color: rgba(59, 130, 246, 0.4);
                    z-index: 10;
                }

                /* Animated Image Ring */
                .img-wrapper {
                    position: relative;
                    display: inline-block;
                    border-radius: 50%;
                    padding: 4px;
                    background: linear-gradient(45deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.1));
                    transition: all 0.4s ease;
                }

                .team-card:hover .img-wrapper {
                    background: linear-gradient(45deg, #3b82f6, #8b5cf6, #06b6d4);
                    box-shadow: 0 0 25px rgba(59, 130, 246, 0.6);
                    transform: scale(1.05);
                }

                .img-wrapper img {
                    border-radius: 50%;
                    border: 4px solid #0f172a;
                    object-fit: cover;
                    transition: all 0.4s ease;
                }

                /* Name Styling */
                .member-name {
                    font-size: 1.6rem;
                    font-weight: 800;
                    color: #f8fafc;
                    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
                    transition: all 0.3s ease;
                    margin-top: 1rem;
                    margin-bottom: 0.5rem;
                }

                .team-card:hover .member-name {
                    color: #60a5fa;
                    /* Glowy Blue on hover */
                }

                /* Bio Styling */
                .member-bio {
                    color: #cbd5e1;
                    font-size: 0.9rem;
                    line-height: 1.6;
                    margin-bottom: 1.5rem;
                }

                /* Social Buttons */
                .social-btn {
                    color: #94a3b8;
                    font-size: 1.5rem;
                    transition: all 0.3s ease;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.05);
                }

                .social-btn:hover {
                    transform: translateY(-5px);
                    background: rgba(255, 255, 255, 0.1);
                }

                .social-btn.linkedin:hover {
                    color: #0a66c2;
                    box-shadow: 0 5px 15px rgba(10, 102, 194, 0.4);
                }

                .social-btn.github:hover {
                    color: #ffffff;
                    box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
                }

                .social-btn.portfolio:hover {
                    color: #10b981;
                    box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
                }
            </style>

            <section class="py-5 team-section" id="team">
                <div class="container">

                    <div class="row text-center mb-5">
                        <div class="col-12">
                            <h2 class="fw-bold mb-2" style="color: #ffffff; font-size: 2.5rem;">Meet Our Team</h2>
                            <p style="color: #94a3b8; font-size: 1.1rem;">
                                Dedicated professionals working together to achieve excellence
                            </p>
                        </div>
                    </div>

                    <div class="row g-4 justify-content-center">

                        @foreach($members as $member)
                            <div class="col-lg-3 col-md-6 col-sm-12">

                                <div class="team-card text-center p-4">

                                    <div class="img-wrapper mb-3">
                                        <img src="{{ asset('upload/team/' . $member->image) }}" width="150" height="150"
                                            alt="{{ $member->name }}">
                                    </div>

                                    <p
                                        style="color: #38bdf8; font-size: 0.75rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 0;">
                                        {{$member->role}}
                                    </p>

                                    <h5 class="member-name">
                                        {{ $member->name }}
                                    </h5>

                                    <p class="member-bio">
                                        {{ $member->short_bio }}
                                    </p>

                                    <div class="d-flex justify-content-center gap-3">

                                        @if($member->linkedin)
                                            <a href="{{ $member->linkedin }}" target="_blank" class="social-btn linkedin">
                                                <i class="fa-brands fa-linkedin-in"></i>
                                            </a>
                                        @endif

                                        @if($member->github)
                                            <a href="{{ $member->github }}" target="_blank" class="social-btn github">
                                                <i class="fa-brands fa-github"></i>
                                            </a>
                                        @endif

                                        @if($member->portfolio)
                                            <a href="{{ $member->portfolio }}" target="_blank" class="social-btn portfolio">
                                                <i class="fa-solid fa-globe"></i>
                                            </a>
                                        @endif

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>

                </div>
            </section>
            <div class="row section-counter mt-5 pt-4 border-top">
                <div class="col-6 col-sm-6 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="counter-wrap mb-5 mb-lg-0 text-center">
                        <span class="number"><span
                                class="countup text-primary">{{ \App\Models\Home::count() }}</span>+</span>
                        <span class="caption text-black-50 d-block">Total Properties</span>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="counter-wrap mb-5 mb-lg-0 text-center">
                        <span class="number"><span
                                class="countup text-primary">{{ \App\Models\User::count() }}</span>+</span>
                        <span class="caption text-black-50 d-block">Happy Users</span>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="500">
                    <div class="counter-wrap mb-5 mb-lg-0 text-center">
                        <span class="number"><span
                                class="countup text-primary">{{ \App\Models\Booking::count() }}</span>+</span>
                        <span class="caption text-black-50 d-block">Successful Bookings</span>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="600">
                    <div class="counter-wrap mb-5 mb-lg-0 text-center">
                        <span class="number"><span
                                class="countup text-primary">{{ \App\Models\Review::count() }}</span>+</span>
                        <span class="caption text-black-50 d-block">User Reviews</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection