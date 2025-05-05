<div class="top-header-area" id="sticker">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-sm-12 text-center">
				<div class="main-menu-wrap">
					<!-- logo -->
					<div class="site-logo">
						<a href="/dashboard">
							<img src="{{  asset('build/plugins/dashboard/assets/img/logo-exspeed3.png')}}" alt="">
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
									{{-- <a class="shopping-cart" href="cart"><i class="fas fa-shopping-cart"></i></a>
									--}}
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
<div class="hero-area">
	<div id="jumbotronSlider" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#jumbotronSlider" data-slide-to="0" class="active"></li>
			<li data-target="#jumbotronSlider" data-slide-to="1"></li>
			<li data-target="#jumbotronSlider" data-slide-to="2"></li>
		</ol>

		<!-- Slides -->
		<div class="carousel-inner">
			<div class="carousel-item active">
				<img src="{{ asset('build/plugins/dashboard/assets/img/benner-brembo.jpg') }}" class="d-block w-100"
					alt="Slider 1" style=" object-fit: cover;">
				<div class="carousel-caption d-none d-md-block">
					{{-- <h5>Slider 1 Title</h5>
					<p>Deskripsi gambar pertama.</p> --}}
				</div>
			</div>
			<div class="carousel-item">
				<img src="{{ asset('build/plugins/dashboard/assets/img/benner-brembo.jpg') }}" class="d-block w-100"
					alt="Slider 2" style=" object-fit: cover;">
				<div class="carousel-caption d-none d-md-block">
					{{-- <h5>Slider 2 Title</h5>
					<p>Deskripsi gambar kedua.</p> --}}
				</div>
			</div>
			<div class="carousel-item">
				<img src="{{ asset('build/plugins/dashboard/assets/img/benner-brembo.jpg') }}" class="d-block w-100"
					alt="Slider 3" style=" object-fit: cover;">
				<div class="carousel-caption d-none d-md-block">
					{{-- <h5>Slider 3 Title</h5>
					<p>Deskripsi gambar ketiga.</p> --}}
				</div>
			</div>
		</div>

		<!-- Controls -->
		<a class="carousel-control-prev" href="#jumbotronSlider" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#jumbotronSlider" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>

	{{-- <div id="jumbotronSlider" class="carousel slide" data-bs-ride="carousel">
		<!-- Indicators -->
		<div class="carousel-indicators">
			<button type="button" data-bs-target="#jumbotronSlider" data-bs-slide-to="0" class="active"
				aria-current="true" aria-label="Slide 1"></button>
			<button type="button" data-bs-target="#jumbotronSlider" data-bs-slide-to="1" aria-label="Slide 2"></button>
			<button type="button" data-bs-target="#jumbotronSlider" data-bs-slide-to="2" aria-label="Slide 3"></button>
		</div>

		<!-- Slides -->
		<div class="carousel-inner">
			<div class="carousel-item active">
				<img src="{{  asset('build/plugins/dashboard/assets/img/benner-brembo.jpg')}}" class="d-block w-100"
					alt="Slider 1" style="height: 700px; object-fit: cover;">
				<div class="carousel-caption d-none d-md-block">
					<h5>Caption for Slider 1</h5>
					<p>Description for the first slider image.</p>
				</div>
			</div>
			<div class="carousel-item">
				<img src="{{  asset('build/plugins/dashboard/assets/img/benner-brembo.jpg')}}" class="d-block w-100"
					alt="Slider 2" style="height: 700px; object-fit: cover;">
				<div class="carousel-caption d-none d-md-block">
					<h5>Caption for Slider 2</h5>
					<p>Description for the second slider image.</p>
				</div>
			</div>
			<div class="carousel-item">
				<img src="{{  asset('build/plugins/dashboard/assets/img/benner-brembo.jpg')}}" class="d-block w-100"
					alt="Slider 3" style="height: 700px; object-fit: cover;">
				<div class="carousel-caption d-none d-md-block">
					<h5>Caption for Slider 3</h5>
					<p>Description for the third slider image.</p>
				</div>
			</div>
		</div>

		<!-- Controls -->
		<button class="carousel-control-prev" type="button" data-bs-target="#jumbotronSlider" data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#jumbotronSlider" data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button>
	</div> --}}
</div>
<!-- end hero area -->

<!-- logo carousel -->
<div class="logo-carousel-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="logo-carousel-inner d-flex flex-wrap justify-content-center align-items-center gap-4">
					@foreach ( $data['brands'] as $brand )
					<div class="single-logo-item">
						<img src="{{  $brand->image_url }}" alt="{{ $brand->name }}" class="logo-img">
					</div>
					@endforeach
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

		<div class="container mt-5">
			<div class="row justify-content-center g-5">
				<!-- Loop over products -->
				@php
				$groupedProducts = [];
				foreach($data['products'] as $product) {
					$groupedProducts[$product->sku][] = $product;
				}
				@endphp

				@foreach($groupedProducts as $sku => $products)
				<div class="col-lg-3 col-md-4 col-sm-6 d-flex justify-content-center mb-4">
					<!-- Card -->
					<div class="card__article position-relative">
						<!-- Product Image -->
						<img src="{{ $products[0]['image_url'] }}" alt="{{ $products[0]['name'] }}" class="card__img">

						<!-- Card Data -->
						<div class="card__data">
							<span class="card__description text-secondary" style="font-size: 10px">
								{{ strtoupper($products[0]->category->name) }}
							</span>
							<h2 class="card__title" style="font-size: 12px">{{ strtoupper($products[0]->name) }}</h2>
							<p style="font-size: 10px">{{ Str::limit(strtoupper($products[0]->description), 50) }}</p>
						
							<!-- Display Size if Available -->
							@if($products[0]->size != null)
							<div class="size-selector">
								@foreach($products as $product)
								<button class="size-btn" data-price="{{ $product->sell_price }}"
									onclick="updatePrice('{{ $sku }}', '{{ $product->size }}', '{{ $product->sell_price }}')">
									{{ strtoupper($product->size) }}
								</button>
								@endforeach
							</div>
							@endif

							<!-- Price -->
							<div class="text-white">
								<h6 class="card__ text-white" id="price-{{ $sku }}" style="font-size: 10px">
									{{ \App\Services\UtilService::formatCurrency($products[0]->sell_price) }}
								</h6>
							</div>

							<!-- Product Detail Link -->
							<div class="text-center mt-2">
								<a class="card__button text-center"
									href="./dashboard/single-product/?uuid={{ $products[0]['uuid'] }}"
									style=" color: #FBBD15;">Detail</a>
							</div>
						</div>
					</div>
				</div>
				@endforeach


			</div>
		</div>



	</div>
</div>
<!-- end product section -->

<div>
	<div class="relative w-full overflow-hidden after:clear-both after:block after:content-['']">
		<div class="relative float-left -mr-[100%] hidden w-full transition-transform duration-[600ms] ease-in-out motion-reduce:transition-none"
			data-te-carousel-item="" style="backface-visibility: hidden">
			<div class="relative overflow-hidden bg-cover bg-no-repeat" style="background-position: 50%">
				<img src="{{  asset('build/plugins/dashboard/assets/img/benner-motul.jpg')}}"
					class="object-cover w-full ">
				<div
					class="absolute bottom-0 left-0 right-0 top-0 h-full w-full overflow-hidden bg-black bg-fixed opacity-50">
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
<div class="product-section mt-100 mb-100 bg-dark text-light p-5">
	<div class="container">
		<div class="row">
			@foreach($data['categories'] as $category)
			<div class="col-lg-3 col-md-6 text-center p-5">
				<div class="single-product card border-0" style="transition: transform 0.3s, box-shadow 0.3s;">
					<div class="product-image">
						<img src="{{ $category['image_url'] }}" alt="product" class="img-fluid"
							style="width: 175px; height: 175px; object-fit: cover; border-radius: 10px;">
					</div>
					<h6 class="text-dark p-3">{{ strtoupper($category->name) }}</h6>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>

<!-- Tambahkan CSS untuk hover effect -->
<style>
	.single-product:hover {
		transform: scale(1.05);
		/* Membesar saat hover */
		box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
		/* Tambahkan bayangan */
	}

	.single-logo-item {
		width: 150px;
		/* Set the width for the logo container */
		height: 100px;
		/* Set the height for the logo container */
		overflow: hidden;
		/* Ensures that logos that are too large don't overflow the container */
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.single-logo-item img {
		width: 100%;
		/* Makes the image fit the width of the container */
		height: 100%;
		/* Makes the image fit the height of the container */
		object-fit: contain;
		/* Ensures the image fits within the container without losing its aspect ratio */
		transition: transform 0.3s ease;
	}

	.single-logo-item img:hover {
		transform: scale(1.1);
		/* Optional: Adds a hover effect to scale the image */
	}
</style>
<style>
	:root {
		--first-color: #051922;
		--title-color: #FBBD15;
		--text-color: hsl(0, 0%, 35%);
		--body-color: hsl(0, 0%, 95%);
		--container-color: #051922;
		--body-font: "Poppins", sans-serif;
		--h2-font-size: 1.25rem;
		--small-font-size: .813rem;
	}

	.size-selector {
		display: flex;
		gap: 1rem;
		/* Jarak antar tombol */
		margin-bottom: 1rem;
		/* Ruang bawah untuk tombol */
	}

	.size-btn {
		padding: 0.5rem 1rem;
		background-color: transparent;
		border: 1px solid #FBBD15;
		color: #FBBD15;
		font-size: 9px;
		font-weight: bold;
		border-radius: 0.5rem;
		cursor: pointer;
		transition: background-color 0.3s, color 0.3s;
	}

	.size-btn:hover {
		background-color: #FBBD15;
		color: black;
	}

	.card__container {
		display: grid;
		gap: 2rem;
		/* Custom gap for more spacing */
		grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
		/* Ensuring responsive columns */
	}

	.card__article {
		position: relative;
		overflow: hidden;
		margin-bottom: 1.5rem;
		/* Margin between cards */
	}

	.card__img {
		width: 100%;
		border-radius: 1.5rem;
	}

	.card__data {
		width: 100%;
		background-color: var(--container-color);
		padding: 1.5rem 2rem;
		box-shadow: 0 8px 24px hsla(0, 0%, 0%, 0.15);
		border-radius: 1rem;
		position: absolute;
		bottom: -9rem;
		left: 0;
		right: 0;
		margin-inline: auto;
		opacity: 0;
		transition: opacity 1s 1s;
	}

	.card__description {
		display: block;
		margin-bottom: .25rem;
	}

	.card__title {
		font-size: var(--h2-font-size);
		font-weight: 500;
		color: var(--title-color);
		margin-bottom: .75rem;
	}

	.card__button {
		text-decoration: none;
		font-size: var(--small-font-size);
		font-weight: 500;
		color: var(--body-color);
	}

	.card__button:hover {
		text-decoration: underline;
	}

	/* Hover Animations */
	.card__article:hover .card__data {
		animation: show-data 1s forwards;
		opacity: 1;
		transition: opacity .3s;
	}

	.card__article:hover {
		animation: remove-overflow 2s forwards;
	}

	.card__article:not(:hover) {
		animation: show-overflow 2s forwards;
	}

	.card__article:not(:hover) .card__data {
		animation: remove-data 1s forwards;
	}

	/* Card animation */
	@keyframes show-data {
		50% {
			transform: translateY(-10rem);
		}

		100% {
			transform: translateY(-7rem);
		}
	}

	@keyframes remove-overflow {
		to {
			overflow: initial;
		}
	}

	@keyframes remove-data {
		0% {
			transform: translateY(-7rem);
		}

		50% {
			transform: translateY(-10rem);
		}

		100% {
			transform: translateY(.5rem);
		}
	}

	@keyframes show-overflow {
		0% {
			overflow: initial;
			pointer-events: none;
		}

		50% {
			overflow: hidden;
		}
	}
</style>
<!-- end product section -->

<script>
	// Simple hover script for displaying links
		document.querySelectorAll('.single-product-item').forEach(item => {
			item.addEventListener('mouseenter', () => {
				const linkContainer = item.querySelector('div[style*="display: none"]');
				linkContainer.style.display = 'flex';
			});
			item.addEventListener('mouseleave', () => {
				const linkContainer = item.querySelector('div[style*="display: flex"]');
				linkContainer.style.display = 'none';
			});
		});
		function updatePrice(sku, size, price) {
			// Update the displayed price when a size is selected
			document.getElementById('price-' + sku).textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(price);
			
			// Optionally, change size label or other details if needed
			console.log("Selected size: " + size);
			console.log("New price: " + price);
		}
</script>