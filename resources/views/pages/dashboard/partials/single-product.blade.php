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
	<!-- end search arewa -->
	
	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>See more Details</p>
						<h1>{{ strtoupper($data['product']['name']) }}</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- single product -->
	<div class="single-product mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-md-5">
					<div class="single-product-img">
						<img src="{{ $data['product']['image_url'] }}" alt="">
					</div>
				</div>
				<div class="col-md-7">
					<div class="single-product-content">
						<h3>{{ strtoupper($data['product']['name']) }}</h3>
						<p class="single-product-pricing"><span>Per {{ $data['product']['unit'] }}</span>{{ \App\Services\UtilService::formatCurrency($data['product']['sell_price'], $data['product']['currency']) }}</p>
						<p>{{ $data['product']['description'] }}</p>
						<div class="single-product-form">
							<form action="index.html">
								<input type="number" placeholder="0">
							</form>
							<a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
							<p><strong>Categories: </strong>{{ $data['product']['category']['name'] }}</p>
						</div>
						<h4>Share:</h4>
						<ul class="product-share">
							<li><a href=""><i class="fab fa-facebook-f"></i></a></li>
							<li><a href=""><i class="fab fa-twitter"></i></a></li>
							<li><a href=""><i class="fab fa-google-plus-g"></i></a></li>
							<li><a href=""><i class="fab fa-linkedin"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end single product -->

	<!-- more products -->
	<div class="more-products mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">	
						<h3><span class="orange-text">Related</span> Products</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p>
					</div>
				</div>
			</div>
			<div class="row">
				@foreach($data['products'] as $product)
					<div class="col-lg-3 col-md-6 text-center">
						<div class="single-product-item">
							<div class="product-image">
								<a href="./?uuid={{ $product['uuid'] }}"> <img src="{{ $product['image_url'] }}" alt="product"></a>
							</div>
							<h6>{{ strtoupper($product->name) }}</h6>
							<h5 class="product-price">{{ \App\Services\UtilService::formatCurrency($product['sell_price'], $product['currency']) }}</h5>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
	<!-- end more products -->

	<!-- logo carousel -->
	<div class="logo-carousel-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="logo-carousel-inner">
						<div class="single-logo-item">
							<img src="assets/img/company-logos/1.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/2.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/3.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/4.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/5.png" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end logo carousel -->
</body>