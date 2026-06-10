@extends('frontend.layout')

@section('content')

                <div class="hero">
                    <div class="hero-slide">
                        @foreach($houses->take(3) as $heroHouse)
                            <div class="img overlay"
                                style="background-image: url('{{ asset('upload/img/' . $heroHouse->home_image) }}')">
                            </div>
                        @endforeach
                    </div>

                    <div class="container">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-lg-9 text-center">
                                <h1 class="heading" data-aos="fade-up">Easiest way to find your dream home</h1>
                       
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <div class="container">
                        <div class="row mb-5 align-items-center">
                            <div class="col-lg-6">
                                <h2 class="font-weight-bold text-primary heading">Popular Properties</h2>
                            </div>
                            <div class="col-lg-6 text-lg-end">
                                <p>
                                    <a href="{{ route('house-detail') }}" class="btn btn-primary text-white py-3 px-4">View all properties</a>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="property-slider">
                                    @foreach($houses as $house)
                                        <div class="property-item">
                                            <a href="{{ route('panel.pages.show', $house->id) }}" class="img">
                                                <img src="{{ asset('upload/img/' . $house->home_image) }}" alt="Image" class="img-fluid"
                                                    style="height: 250px; object-fit: cover; width: 100%;" />
                                            </a>
                                            <div class="property-content">
                                                <div class="price mb-2"><span>৳ {{ number_format($house->home_price) }}</span></div>
                                                <div>
                                                    <span class="d-block mb-2 text-black-50">{{ $house->house_name }}</span>
                                                    <span class="city d-block mb-3">{{ $house->address }}, {{ $house->city }}</span>

                                                    <div class="specs d-flex mb-4">
                                                        <span class="d-block d-flex align-items-center me-3">
                                                            <span class="icon-bed me-2"></span>
                                                            <span class="caption">{{ $house->bed }} beds</span>
                                                        </span>
                                                        <span class="d-block d-flex align-items-center">
                                                            <span class="icon-bath me-2"></span>
                                                            <span class="caption">{{ $house->bath }} baths</span>
                                                        </span>
                                                    </div>

                                                    @if($house->reviews->count() > 0)
                                                        <div class="mb-3">
                                                            <div class="d-flex align-items-center">
                                                                <span class="text-warning me-2">
                                                                    @for($i = 1; $i <= $house->reviews->max('rating'); $i++)
                                                                        <span class="icon-star"></span>
                                                                    @endfor
                                                                </span>
                                                                <span class="text-secondary">{{ $house->reviews->count() }} reviews</span>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @auth
                                                        <a href="{{ route('book.house', $house->id) }}" class="btn btn-primary py-2 px-3">Book Now</a>
                                                    @else
                                                        <a href="{{ route('login') }}" class="btn btn-secondary py-2 px-3">Login to Book</a>
                                                    @endauth
                                                </div>
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
                            data-bs-slide="prev"
                            style="cursor:pointer; font-size: 14px; background: #e9ecef; font-weight: bold;">Prev</span>
                        <span class="btn btn-light rounded-pill px-4 py-2" data-bs-target="#testimonialCarousel"
                            data-bs-slide="next"
                            style="cursor:pointer; font-size: 14px; background: #e9ecef; font-weight: bold;">Next</span>
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
                                        style="height: 80px; width: 80px !important; object-fit: cover; border: 3px solid #f8f9fa; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" />

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

                                    <blockquote style="max-width: 700px; margin: 0 auto;">
                                        <p class="text-dark" style="font-size: 18px; font-style: italic;">
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
                        <h2 class="font-weight-bold heading text-primary mb-4">
                            About House Rent
                        </h2>
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
                                style="width: 50px; height: 50px;">
                                <span class="icon-home2"></span>
                            </span>
                            <div class="feature-text">
                                <h3 class="heading h5 font-weight-bold">Verified Properties</h3>
                                <p class="text-black-50 text-sm">
                                    Every house listed on our platform goes through a strict verification process by our admins.
                                </p>
                            </div>
                        </div>

                        <div class="d-flex feature-h mb-4">
                            <span
                                class="wrap-icon me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <span class="icon-person"></span>
                            </span>
                            <div class="feature-text">
                                <h3 class="heading h5 font-weight-bold">Direct Communication</h3>
                                <p class="text-black-50 text-sm">
                                    No middleman! We ensure that you communicate directly with genuine property owners.
                                </p>
                            </div>
                        </div>

                        <div class="d-flex feature-h">
                            <span
                                class="wrap-icon me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <span class="icon-security"></span>
                            </span>
                            <div class="feature-text">
                                <h3 class="heading h5 font-weight-bold">Secure Booking</h3>
                                <p class="text-black-50 text-sm">
                                    Book your desired home with our 100% secure and transparent digital system.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

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