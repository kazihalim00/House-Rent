<style>
    .site-footer {
        background-color: #16213e !important;
        border-top: 1px solid #2a3a5c;
        padding: 60px 0 0;
        color: #8892a4;
    }

    .site-footer .widget h3 {
        color: #f0f4ff;
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 12px;
    }

    .site-footer .widget h3::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 32px;
        height: 2px;
        background: #e53935;
        border-radius: 2px;
    }

    .site-footer address {
        color: #8892a4;
        font-size: 14px;
        line-height: 1.7;
        margin-bottom: 16px;
    }

    .site-footer .links li {
        margin-bottom: 8px;
    }

    .site-footer .links li a {
        color: #8892a4 !important;
        font-size: 14px;
        text-decoration: none;
        transition: color 0.2s;
    }

    .site-footer .links li a:hover {
        color: #e53935 !important;
    }

    .site-footer .float-start.links {
        margin-right: 30px;
    }

    .site-footer .social {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        padding: 0;
        margin-top: 16px;
        list-style: none;
    }

    .site-footer .social li a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #1e2a45;
        border: 1px solid #2a3a5c;
        color: #8892a4 !important;
        font-size: 16px;
        transition: background 0.2s, color 0.2s, border-color 0.2s;
        text-decoration: none;
    }

    .site-footer .social li a:hover {
        background: #e53935 !important;
        border-color: #e53935 !important;
        color: #fff !important;
    }

    .footer-bottom {
        background: #111827;
        border-top: 1px solid #2a3a5c;
        margin-top: 48px;
        padding: 20px 0;
        text-align: center;
    }

    .footer-bottom p,
    .footer-bottom div {
        color: #8892a4;
        font-size: 13px;
        margin: 0;
        line-height: 1.8;
        text-align: center !important;
        width: 100%;
    }

    .footer-bottom a {
        color: #e53935 !important;
        text-decoration: none;
    }

    .footer-bottom a:hover {
        text-decoration: underline;
    }
</style>

<div class="site-footer">
    <div class="container">
        <div class="row">

            {{-- Contact --}}
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="widget">
                    <h3>Contact Us</h3>
                    <address>Sylhet, Bangladesh</address>
                    <ul class="list-unstyled links">
                        <li><a href="tel:+8801700000000">+880 1700-000000</a></li>
                        <li><a href="tel:+8801800000000">+880 1800-000000</a></li>
                        <li><a href="mailto:info@houserent.com">info@houserent.com</a></li>
                    </ul>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="widget">
                    <h3>Quick Links</h3>
                    <ul class="list-unstyled float-start links">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ route('house-detail') }}">Properties</a></li>
                        <li><a href="{{ url('/') }}#services">Services</a></li>
                        <li><a href="{{ url('/') }}#about">About Us</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                    <ul class="list-unstyled float-start links">
                        @auth
                            <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                        @endauth
                        <li><a href="{{ route('house-detail') }}">All Houses</a></li>
                        <li><a href="{{ route('house-detail') }}">Rent a House</a></li>
                        <li><a href="{{ url('/') }}#services">Easy Booking</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                </div>
            </div>

            {{-- Follow Us --}}
            <div class="col-lg-4">
                <div class="widget">
                    <h3>Follow Us</h3>
                    <ul class="list-unstyled links">
                        <li><a href="{{ url('/') }}#about">Our Vision</a></li>
                        <li><a href="{{ url('/') }}#about">About Us</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                    <ul class="social">
                        <li><a href="#" aria-label="Instagram"><span class="icon-instagram"></span></a></li>
                        <li><a href="#" aria-label="Twitter"><span class="icon-twitter"></span></a></li>
                        <li><a href="#" aria-label="Facebook"><span class="icon-facebook"></span></a></li>
                        <li><a href="#" aria-label="LinkedIn"><span class="icon-linkedin"></span></a></li>
                        <li><a href="#" aria-label="Pinterest"><span class="icon-pinterest"></span></a></li>
                        <li><a href="#" aria-label="Dribbble"><span class="icon-dribbble"></span></a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <p style="text-align:center; width:100%;">
                Copyright &copy; {{ date('Y') }}
                <strong style="color:#f0f4ff;"> Rent Cloud</strong>. All Rights Reserved.
            </p>
        </div>
    </div>
</div>