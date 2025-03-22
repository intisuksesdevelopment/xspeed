	<div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="/dashboard">
								<img src="/build/plugins/dashboard/assets/img/logo-expeed3.png" alt="">
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
										{{-- <a class="shopping-cart" href="cart"><i class="fas fa-shopping-cart"></i></a> --}}
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
							<img src="/build/plugins/dashboard/assets/img/company-logos/1.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="/build/plugins/dashboard/assets/img/company-logos/2.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="/build/plugins/dashboard/assets/img/company-logos/3.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="/build/plugins/dashboard/assets/img/company-logos/4.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="/build/plugins/dashboard/assets/img/company-logos/5.png" alt="">
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
				@foreach($data['products'] as $product)
					<div class="col-lg-3 col-md-6 text-center">
						<div class="single-product-item">
							<div class="product-image">
								<a href="./dashboard/single-product/?uuid={{ $product['uuid'] }}"> <img src="{{ $product['image_url'] }}" alt="product"></a>
							</div>
							<h6>{{ strtoupper($product->name) }}</h6>
							<h5 class="product-price">{{ \App\Services\UtilService::formatCurrency($product['sell_price'], $product['currency']) }}</h5>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
	<!-- end product section -->

	<div>
		<div class="relative w-full overflow-hidden after:clear-both after:block after:content-['']">
			<div class="relative float-left -mr-[100%] hidden w-full transition-transform duration-[600ms] ease-in-out motion-reduce:transition-none" data-te-carousel-item="" style="backface-visibility: hidden">
				<div class="relative overflow-hidden bg-cover bg-no-repeat" style="background-position: 50%">
					<img src="/build/plugins/dashboard/assets/img/benner-motul.jpg" class="object-cover w-full ">
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
				@foreach($data['brands'] as $brand)
					<div class="col-lg-3 col-md-6 text-center">
						<div class="single-product-item">
							<div class="product-image">
								<img src="{{ $brand['image_url'] }}" alt="product">
							</div>
							<h6>{{ strtoupper($brand->name) }}</h6>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
	<!-- end product section -->

	