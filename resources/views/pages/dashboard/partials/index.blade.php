<style>
	.swiper {
		width: 100%;
		padding-top: 50px;
		padding-bottom: 50px;
	}

	.swiper-slide {
		background-position: center;
		background-size: cover;
		width: 300px;
		height: 300px;
	}

	.swiper-slide img {
		display: block;
		width: 100%;
	}

	.card-product-group {
		transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
	}

	.card-product-group:hover {
		transform: translateY(-5px);
		/* Sedikit mengangkat card */
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
		/* Menambahkan shadow */
	}

	@media (max-width: 767.98px) {
		.carousel-item img {
			object-fit: contain !important;
			height: auto;
		}

		.single-logo-item {
			max-width: 80px;
		}

		.product-section {
			padding: 1rem !important;
		}

		.swiper-slide {
			width: 160px !important;
		}

		.product-section h3 {
			font-size: 1.25rem;
		}
	}

	.hero-area {
		padding: 0;
		margin: 0;
	}

	.carousel-control-prev,
	.carousel-control-next {
		top: 50%;
		transform: translateY(-50%);
		bottom: auto;
	}

	.hero-area,
	.carousel-item,
	.carousel-inner {
		height: auto;
	}

	.carousel-item img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		display: block;
	}

	.logo-carousel-section {
		padding: 2rem 0;
		background-color: #fff;
	}

	.logo-carousel-inner {
		row-gap: 1rem;
		column-gap: 1.5rem;
	}

	.single-logo-item {
		text-align: center;
		flex: 0 1 auto;
		max-width: 100px;
		margin: 0 auto;
	}


	.logo-img {
		display: block;
		margin-left: auto;
		margin-right: auto;
		width: 100%;
		height: auto;
		object-fit: contain;
	}
</style>
<div class="top-header-area" id="sticker">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-sm-12 text-center">
				<div class="main-menu-wrap">
					<!-- logo -->
					<div class="site-logo d-none d-md-block">
						<a href="{{ route('main') }}">
							<img src="{{ asset('build/plugins/dashboard/assets/img/logo-exspeed3.png') }}" alt="">
						</a>
					</div>

					<!-- logo -->

					<!-- menu start -->
					<nav class="main-menu">
						<ul>
							<li>
								<div class="header-icons">
									{{-- <a class="shopping-cart" href="cart"><i class="fas fa-shopping-cart"></i></a>
									--}}
									<a class="mobile-hide search-bar-icon" href="#"><i class="fas fa-search"></i></a>
								</div>
							</li>
						</ul>
					</nav>
					{{-- <a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a> --}}
					{{-- <div class="mobile-menu"></div> --}}
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
					alt="Slider 1" style="object-fit: cover;">
				<div class="carousel-caption d-none d-md-block"></div>
			</div>
			<div class="carousel-item">
				<img src="{{ asset('build/plugins/dashboard/assets/img/benner-brembo.jpg') }}" class="d-block w-100"
					alt="Slider 2" style="object-fit: cover;">
				<div class="carousel-caption d-none d-md-block"></div>
			</div>
			<div class="carousel-item">
				<img src="{{ asset('build/plugins/dashboard/assets/img/benner-brembo.jpg') }}" class="d-block w-100"
					alt="Slider 3" style="object-fit: cover;">
				<div class="carousel-caption d-none d-md-block"></div>
			</div>
		</div>

		<!-- Controls (only on desktop) -->
		<a class="carousel-control-prev d-none d-md-block" href="#jumbotronSlider" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next d-none d-md-block" href="#jumbotronSlider" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
</div>

<!-- Responsive optimization -->
<style>

</style>

<!-- logo carousel -->
<div class="logo-carousel-inner d-flex flex-wrap justify-content-center align-items-center">
	@foreach ($data['brands'] as $brand)
	<div class="single-logo-item">
		<img src="{{ $brand->image_url }}" alt="{{ $brand->name }}" class="logo-img">
	</div>
	@endforeach
</div>

<!-- end logo carousel -->

<!-- product section -->
<div class="product-section mt-100 mb-100">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2 text-center">
				<div class="section-title">
					<h3><span class="orange-text">New</span> Ready Stock !</h3>
					<p>Discover our latest products, now available for immediate purchase. Don't miss out on these new arrivals!</p>
				</div>
			</div>
		</div>

		<div class="container mt-5">
			<div class="row justify-content-center g-5">
				{{-- Grouping and showing products --}}
				@php
				$groupedProducts = [];
				foreach($data['products'] as $product) {
				$groupedProducts[$product->sku][] = $product;
				}
				@endphp

				@foreach($groupedProducts as $sku => $products)
				<div class="col-6 col-md-3 col-lg-2 p-2">
					<a href="{{ route('single-product', ['uuid' => $products[0]->uuid]) }}" class="text-decoration-none text-dark">
						<div class="card h-100 shadow-sm d-flex flex-column">
							<div
								style="height: 160px; overflow: hidden; border: 1px solid #dee2e6; border-radius: 5px; display: flex; justify-content: center; align-items: center;">
								<img src="{{ $products[0]->image_url }}" class="w-100 h-100 object-fit-cover"
									style="object-fit: cover;" alt="{{ $products[0]->name }}">
							</div>
							<div class="card-body d-flex flex-column justify-content-between">
								<div>
									<p class="text-muted text-left small mb-1">{{ $products[0]->category->name }}</p>
									<h6 class="text-dark mb-2 text-truncate">{{ $products[0]->name }}</h6>
								</div>
								<div>
									<p class="text-danger text-right fw-bold mb-0">
										{{ \App\Services\UtilService::formatCurrency($products[0]->sell_price,
										$products[0]->currency) }}
									</p>
								</div>
							</div>
						</div>
					</a>
				</div>
				@endforeach

			</div>

			{{-- View More Button --}}
			<div class="row mt-4">
				<div class="col-12 text-center">
					<a href="{{ route('all-product') }}" class="btn btn-outline-dark px-4 py-2 rounded-pill">
						View More
					</a>
				</div>
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

<div class="product-section mt-100 mb-5 bg-dark text-light px-3 py-4 py-md-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2 text-center">
				<div class="section-title mb-4">
					<h3 class="text-light mb-1">
						<span class="orange-text">More</span> Category!
					</h3>
					<p class="text-light mb-0">Explore our wide range of categories to find the perfect products for your needs.</p>
					{{-- <p class="text-muted mb-0">See more Details</p> --}}
					<div class="underline mx-auto mt-2" style="width: 50px; height: 3px; background: orange;"></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="swiper mySwiper overflow-hidden">
					<div class="swiper-wrapper">
						@foreach($data['categories'] as $category)
						<div class="swiper-slide text-center">
							<a href="{{ route('all-product-category', ['categoryCode' => $category->code]) }}"
								style="color: inherit; text-decoration: none;"
								class="text-decoration-none d-block px-2">
								<div class="card border-0 shadow-sm bg-white">
									<div class="product-image p-2">
										<img src="{{ $category['image_url'] }}" alt="product" class="img-fluid rounded"
											style="width: 150px; height: 150px; object-fit: cover;">
									</div>
									<h6 class="text-dark mb-3">{{ strtoupper($category->name) }}</h6>
								</div>
							</a>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
	var swiper = new Swiper(".mySwiper", {
		effect: "coverflow",
		grabCursor: true,
		centeredSlides: true,
		slidesPerView: "auto",
		coverflowEffect: {
			rotate: 30,
			stretch: 0,
			depth: 100,
			modifier: 1,
			slideShadows: false, // Nonaktifkan bayangan panjang
		},
		pagination: {
			el: ".swiper-pagination",
		},
		});


</script>
<!-- Tambahkan CSS untuk hover effect -->
<style>
	.swiper-slide {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
	}

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