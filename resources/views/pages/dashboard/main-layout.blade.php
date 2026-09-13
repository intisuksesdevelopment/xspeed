<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="XSPEED MOTOSHOP - Toko spare part & aksesoris motor: oli, ban, aki, lampu, busi, kampas rem dan lainnya dengan harga terbaik.">

    <!-- title -->
    <title>XSPEED MOTOSHOP - Spare Part & Aksesoris Motor</title>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('/build/img/logo-header.png') }}">
    <!-- google font (satu request saja; Orbitron untuk heading, Poppins body, Rajdhani/Inter pendukung) -->
    <link
        href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- fontawesome -->

    {{-- <link rel="stylesheet" href="{{ asset('build/build/css/all.min.css')}}"> --}}
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- owl carousel -->
    {{-- <link rel="stylesheet" href="{{ asset('build/build/css/owl.carousel.css')}}">
	<!-- magnific popup -->
	<link rel="stylesheet" href="{{ asset('build/build/css/magnific-popup.css')}}">
	<!-- animate css -->
	<link rel="stylesheet" href="{{ asset('build/build/css/animate.css')}}">
	<!-- mean menu css -->
	<link rel="stylesheet" href="{{ asset('build/build/css/meanmenu.min.css')}}">
	<!-- main style -->
	<link rel="stylesheet" href="{{ asset('build/build/css/main.css')}}"> --}}
    <!-- responsive -->
    <link rel="stylesheet" href="{{ asset('/build/css/responsive.css') }}">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" /> --}}
    <link rel="stylesheet" href="{{ asset('/build/css/dashboard.css') }}">

    <style>[x-cloak] { display: none !important; }</style>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @if (Route::is(['main']))
        <!-- swiper css - dipakai section home saja -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    @endif

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
   
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top custom-navbar px-3 px-md-4">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div>
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('main') }}">
                    <img src="{{ asset('/build/img/logo-exspeed3.png') }}" alt="" class="hero-moto-img" loading="eager" decoding="async">
                    {{-- <span class="fw-bold text-white font-rajdhani">XSPEED <span
                            class="text-accent-color">MOTOPARTS</span></span> --}}
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">

                    <span class="custom-toggler"></span>
                </button>
            </div>


            <div class="collapse navbar-collapse" id="navbarNav">
                @php
                    $isHome = Route::is('main');
                    $homeUrl = route('main');
                    $anchor = function (string $suffix) use ($isHome, $homeUrl) {
                        return $isHome ? '#' . $suffix : $homeUrl . '#' . $suffix;
                    };
                @endphp
                <ul class="navbar-nav align-items-lg-center gap-lg-4 mt-3 mt-lg-0 ms-auto">
                    <li><a class="nav-link" href="{{ $anchor('home') }}">Home</a></li>
                    <li><a class="nav-link" href="{{ $anchor('products') }}">Products</a></li>
                    <li><a class="nav-link" href="{{ $anchor('gallery') }}">Gallery</a></li>
                    <li><a class="nav-link" href="{{ $anchor('testimonials') }}">Testimonials</a></li>
                    <li><a class="nav-link" href="{{ $anchor('about') }}">About</a></li>
                    <li><a class="nav-link" href="{{ $anchor('contact') }}">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!--PreLoader-->
    {{-- <div class="loader">
		<div class="loader-inner">
			<div class="circle"></div>
		</div>
	</div> --}}
    <!--PreLoader Ends-->
    @if (Route::is(['main']))
        @include('pages.dashboard.partials.index')
    @endif
    @if (Route::is(['single-product']))
        @include('pages.dashboard.partials.single-product')
    @endif
    @if (Route::is(['list-product']))
        @include('pages.dashboard.partials.list-product')
    @endif
    @if (Route::is(['all-product']) || Route::is(['all-product-category']))
        @include('pages.dashboard.partials.all-product')
    @endif
    <!-- footer -->
    {{-- <div class="footer-area text-light py-5">
        <div class="container">
            <div class="d-flex justify-content-center mb-3">
                <img src="{{asset('/build/img/logo-header.png') }}" alt="logo"
                    class="img-fluid" style="max-width: 180px;">
            </div>

            <h3 class="text-center mb-4">ABOUT US</h3>

            <p class="text-center mx-auto" style="max-width: 800px; font-size: 0.95rem;">
                Buy various products at the Xspeedshop Store online now. You can buy products from the
                Xspeedshop Store safely & easily from Bandung City. Want to shop more economically &
                affordably at the Xspeedshop Store? You can use the 0% Installment feature from
                various banks and the Free Shipping feature at the Xspeedshop Store so you can shop
                online comfortably at Tokopedia. Buy various latest products at the Xspeedshop Store
                easily from the palm of your hand using the Tokopedia Application. Also keep checking
                the Xspeedshop Store for updates on Products, Voucher Codes to the Latest Promos
                from the Latest Xspeedshop Store online at Tokopedia!
            </p>
        </div>
    </div> --}}
    <!-- end footer -->


    <section>
        <div class="copyright bg-primary-color  py-3">
            <div class="container">
                <div class="row align-items-center">

                    <!-- Left -->
                    <div class="col-md-6 text-center text-md-start mb-2 mb-md-0 font-accent-color">
                        Copyright &copy; {{ date('Y') }} Exspeed Shop, All Rights Reserved.
                    </div>

                    <!-- Right -->
                    <div class="col-md-6 text-center text-md-end">
                        <div class="social-icons">
                            <ul class="list-inline mb-0 text-accent-color">
                                <li class="list-inline-item me-2">
                                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                                </li>
                                <li class="list-inline-item me-2">
                                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                                </li>
                                <li class="list-inline-item me-2">
                                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                                </li>
                                <li class="list-inline-item me-2">
                                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" aria-label="Dribbble"><i class="fab fa-dribbble" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- bootstrap bundle (jQuery sudah tidak dipakai di storefront) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- count down -->
    {{-- <script src="{{ URL::asset('/build/build/js/jquery.countdown.js') }}"></script> --}}
    <!-- isotope -->
    {{-- <script src="{{ URL::asset('/build/build/js/jquery.isotope-3.0.6.min.js') }}"></script> --}}
    <!-- waypoints -->
    {{-- <script src="{{ URL::asset('/build/build/js/waypoints.js') }}"></script> --}}
    <!-- owl carousel -->
    {{-- <script src="{{ URL::asset('/build/build/js/owl.carousel.min.js') }}"></script> --}}
    <!-- magnific popup -->
    {{-- <script src="{{ URL::asset('/build/build/js/jquery.magnific-popup.min.js') }}"></script> --}}
    <!-- mean menu -->
    {{-- <script src="{{ URL::asset('/build/build/js/jquery.meanmenu.min.js') }}"></script> --}}
    <!-- sticker js -->
    {{-- <script src="{{ URL::asset('/build/build/js/sticker.js') }}"></script> --}}
    <!-- main js -->
    {{-- <script src="{{ URL::asset('/build/build/js/main.js') }}"></script> --}}

    {{-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script> --}}


</body>

</html>
