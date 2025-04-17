<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>ExpeedShop</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="{{ asset('build/plugins/dashboard/assets/img/logo-exspeed3.png')}}">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->

	<link rel="stylesheet" href="{{ url('build/plugins/dashboard/assets/css/all.min.css')}}">
	<!-- bootstrap -->
	<link rel="stylesheet" href="{{ url('build/plugins/dashboard/assets/bootstrap/css/bootstrap.min.css')}}">
	<!-- owl carousel -->
	<link rel="stylesheet" href="{{ url('build/plugins/dashboard/assets/css/owl.carousel.css')}}">
	<!-- magnific popup -->
	<link rel="stylesheet" href="{{ url('build/plugins/dashboard/assets/css/magnific-popup.css')}}">
	<!-- animate css -->
	<link rel="stylesheet" href="{{ url('build/plugins/dashboard/assets/css/animate.css')}}">
	<!-- mean menu css -->
	<link rel="stylesheet" href="{{ url('build/plugins/dashboard/assets/css/meanmenu.min.css')}}">
	<!-- main style -->
	<link rel="stylesheet" href="{{ url('build/plugins/dashboard/assets/css/main.css')}}">
	<!-- responsive -->
	<link rel="stylesheet" href="{{ url('build/plugins/dashboard/assets/css/responsive.css')}}">
	<style>  
        h1 {  
            text-align: center; /* Menengahka <h1> */  
            font-weight: bold;  
            margin-bottom: 20px;  
			color: aliceblue;
        }  
        p {  
            text-align: center; /* Menengahkan teks dalam <p> */  
            line-height: 1.6;  
			color: aliceblue;
        }  
    </style>  

</head>
<body>
	
	<!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->
	
	<!-- header -->
	<div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="dashboard">
								<img src="{{ asset('/build/plugins/dashboard/assets/img/logo-exspeed3.png')}}" alt="">
							
							</a>
						</div>
						<!-- logo -->

						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								<!-- <li class="current-list-item"><a href="#">Home</a>
									<ul class="sub-menu">
										<li><a href="index.html">Static Home</a></li>
										<li><a href="index_2.html">Slider Home</a></li>
									</ul>
								</li>
								<li><a href="about.html">About</a></li>
								<li><a href="#">Pages</a>
									<ul class="sub-menu">
										<li><a href="404.html">404 page</a></li>
										<li><a href="about.html">About</a></li>
										<li><a href="cart.html">Cart</a></li>
										<li><a href="checkout.html">Check Out</a></li>
										<li><a href="contact.html">Contact</a></li>
										<li><a href="news.html">News</a></li>
										<li><a href="shop.html">Shop</a></li>
									</ul>
								</li>
								<li><a href="news.html">News</a>
									<ul class="sub-menu">
										<li><a href="news.html">News</a></li>
										<li><a href="single-news.html">Single News</a></li>
									</ul>
								</li>
								<li><a href="contact.html">Contact</a></li>
								<li><a href="shop.html">Shop</a>
									<ul class="sub-menu">
										<li><a href="shop.html">Shop</a></li>
										<li><a href="checkout.html">Check Out</a></li>
										<li><a href="single-product.html">Single Product</a></li>
										<li><a href="cart.html">Cart</a></li>
									</ul>
								</li> -->
								<li>
									<div class="header-icons">
										<a class="shopping-cart" href="cart"><i class="fas fa-shopping-cart"></i></a>
										<a class="mobile-hide search-bar-icon" href="#"><i class="fas fa-search"></i></a>
									</div>
								</li>
							</ul>
						</nav>
						<a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
						<div class="mobile-menu"></div>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->
	
	<!-- search area -->
	<div class="search-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<span class="close-btn"><i class="fas fa-window-close"></i></span>
					<div class="search-bar">
						<div class="search-bar-tablecell">
							<h3>Search For:</h3>
							<input type="text" placeholder="Keywords">
							<button type="submit">Search <i class="fas fa-search"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end search area -->

	<!-- hero area -->
	<div class="hero-area hero-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 offset-lg-2 text-center">
					<!-- <div class="hero-text">
						<div class="hero-text-tablecell">
							<p class="subtitle">Fresh & Organic</p>
							<h1>Delicious Seasonal Fruits</h1>
							<div class="hero-btns">
								<a href="shop.html" class="boxed-btn">Fruit Collection</a>
								<a href="contact.html" class="bordered-btn">Contact Us</a>
							</div>
						</div>
					</div> -->
				</div>
			</div>
		</div>
	</div>
	<!-- end hero area -->

	<!-- logo carousel -->
	<div class="logo-carousel-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="logo-carousel-inner">
						<div class="single-logo-item">
							<img src="{{ asset('/build/plugins/dashboard/assets/img/company-logos/1.png')}}" alt="">
						</div>
						<div class="single-logo-item">
							<img src="{{ asset('/build/plugins/dashboard/assets/img/company-logos/2.png')}}" alt="">
						</div>
						<div class="single-logo-item">
							<img src="{{ asset('/build/plugins/dashboard/assets/img/company-logos/3.png')}}" alt="">
						</div>
						<div class="single-logo-item">
							<img src="{{ asset('/build/plugins/dashboard/assets/img/company-logos/4.png')}}" alt="">
						</div>
						<div class="single-logo-item">
							<img src="{{ asset('/build/plugins/dashboard/assets/img/company-logos/5.png')}}" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end logo carousel -->

	<!-- product section -->
	<div class="product-section mt-100 mb-100">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">	
						<h3><span class="orange-text">New</span> Ready Stock !</h3>
						<!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p> -->
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-3 col-md-6 text-center">
					<div class="single-product-item">
						<div class="product-image">
							<a href="single-product"><img src="{{ asset('/build/plugins/dashboard/assets/img/products/accosato.jpg')}}" alt=""></a>
						</div>
						<h6>ACCOSSATO HANDLE KOPLING LEVER ASSY CLUTCH CF009N 24 MM ITALY</h6>
						<h5 class="product-price">Rp. 1.999.000</h5>
						<!-- <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a> -->
					</div>
				</div>
				<div class="col-lg-3 col-md-6 text-center">
					<div class="single-product-item">
						<div class="product-image">
							<a href="single-product"><img src="{{ asset('/build/plugins/dashboard/assets/img/products/accosato.jpg')}}" alt=""></a>
						</div>
						<h6>ACCOSSATO HANDLE KOPLING LEVER ASSY CLUTCH CF009N 24 MM ITALY</h6>
						<h5 class="product-price">Rp. 1.999.000</h5>
						<!-- <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a> -->
					</div>
				</div>
				<div class="col-lg-3 col-md-6 offset-md-3 offset-lg-0 text-center">
					<div class="single-product-item">
						<div class="product-image">
							<a href="single-product"><img src="{{ asset('/build/plugins/dashboard/assets/img/products/accosato.jpg')}}" alt=""></a>
						</div>
						<h6>ACCOSSATO HANDLE KOPLING LEVER ASSY CLUTCH CF009N 24 MM ITALY</h6>
						<h5 class="product-price">Rp. 1.999.000</h5>
						<!-- <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a> -->
					</div>
				</div>
				<div class="col-lg-3 col-md-6 offset-md-3 offset-lg-0 text-center">
					<div class="single-product-item">
						<div class="product-image">
							<a href="single-product"><img src="{{ asset('/build/plugins/dashboard/assets/img/products/accosato.jpg')}}" alt=""></a>
						</div>
						<h6>ACCOSSATO HANDLE KOPLING LEVER ASSY CLUTCH CF009N 24 MM ITALY</h6>
						<h5 class="product-price">Rp. 1.999.000</h5>
						<!-- <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a> -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end product section -->

	<div>
		<div class="relative w-full overflow-hidden after:clear-both after:block after:content-['']">
			<div class="relative float-left -mr-[100%] hidden w-full transition-transform duration-[600ms] ease-in-out motion-reduce:transition-none" data-te-carousel-item="" style="backface-visibility: hidden">
				<div class="relative overflow-hidden bg-cover bg-no-repeat" style="background-position: 50%">
					<img src="{{ asset('/build/plugins/dashboard/assets/img/benner-motul.jpg')}}" class="object-cover w-full ">
					<div class="absolute bottom-0 left-0 right-0 top-0 h-full w-full overflow-hidden bg-black bg-fixed opacity-50">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- shop banner -->
	<!-- <section class="shop-banner">
    	<div class="container">
        </div>
    </section> -->
	<!-- end shop banner -->

	<!-- product section -->
	<div class="product-section mt-100 mb-100">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 text-center">
					<div class="single-product-item">
						<div class="product-image">
							<a href="https://www.tokopedia.com/xspeedshop" target="_blank"><img src="{{ asset('/build/plugins/dashboard/assets/img/products/accosato.jpg')}}" alt=""></a>
						</div>
						<h6>ACCOSSATO HANDLE KOPLING LEVER ASSY CLUTCH CF009N 24 MM ITALY</h6>
						<h5 class="product-price">Rp. 1.999.000</h5>
						<!-- <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a> -->
					</div>
				</div>
				<div class="col-lg-3 col-md-6 text-center">
					<div class="single-product-item">
						<div class="product-image">
							<a href="https://www.tokopedia.com/xspeedshop" target="_blank"><img src="{{ asset('/build/plugins/dashboard/assets/img/products/accosato.jpg')}}" alt=""></a>
						</div>
						<h6>ACCOSSATO HANDLE KOPLING LEVER ASSY CLUTCH CF009N 24 MM ITALY</h6>
						<h5 class="product-price">Rp. 1.999.000</h5>
						<!-- <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a> -->
					</div>
				</div>
				<div class="col-lg-3 col-md-6 offset-md-3 offset-lg-0 text-center">
					<div class="single-product-item">
						<div class="product-image">
							<a href="https://www.tokopedia.com/xspeedshop" target="_blank"><img src="{{ asset('/build/plugins/dashboard/assets/img/products/accosato.jpg')}}" alt=""></a>
						</div>
						<h6>ACCOSSATO HANDLE KOPLING LEVER ASSY CLUTCH CF009N 24 MM ITALY</h6>
						<h5 class="product-price">Rp. 1.999.000</h5>
						<!-- <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a> -->
					</div>
				</div>
				<div class="col-lg-3 col-md-6 offset-md-3 offset-lg-0 text-center">
					<div class="single-product-item">
						<div class="product-image">
							<a href="https://www.tokopedia.com/xspeedshop" target="_blank"><img src="{{ asset('/build/plugins/dashboard/assets/img/products/accosato.jpg')}}" alt=""></a>
						</div>
						<h6>ACCOSSATO HANDLE KOPLING LEVER ASSY CLUTCH CF009N 24 MM ITALY</h6>
						<h5 class="product-price">Rp. 1.999.000</h5>
						<!-- <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a> -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end product section -->

	<!-- footer -->
	<div class="footer-area">
		<div class="container">
			<div style="display: flex; justify-content: center;">
				<img src="{{ asset('/build/plugins/dashboard/assets/img/logo-exspeed3.png')}}" alt="logo">
			</div>
			<br>
			<h1>ABOUT US</h1>  

			<p>  
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
	</div>
	<!-- end footer -->
	
	<!-- copyright -->
	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<p>Copyrights &copy; 2025 - <a href="https://imransdesign.com/">Exspeed Shop</a>,  All Rights Reserved.</p>
				</div>
				<div class="col-lg-6 text-right col-md-12">
					<div class="social-icons">
						<ul>
							<li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end copyright -->
	<!-- jquery -->            
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/jquery-1.11.3.min.js') }}"></script>
	<!-- bootstrap -->
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/bootstrap/js/bootstrap.min.js') }}"></script>
	<!-- count down -->
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/jquery.countdown.js') }}"></script>
	<!-- isotope -->
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/jquery.isotope-3.0.6.min.js') }}"></script>
	<!-- waypoints -->
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/waypoints.js') }}"></script>
	<!-- owl carousel -->
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/owl.carousel.min.js') }}"></script>
	<!-- magnific popup -->
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/jquery.magnific-popup.min.js') }}"></script>
	<!-- mean menu -->
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/jquery.meanmenu.min.js') }}"></script>
	<!-- sticker js -->
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/sticker.js') }}"></script>
	<!-- main js -->
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/main.js') }}"></script>

</body>
</html>