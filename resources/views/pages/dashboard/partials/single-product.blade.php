<div class="top-header-area" id="sticker">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-sm-12 text-center">
				<div class="main-menu-wrap">
					<!-- logo -->
					<div class="site-logo">
						<a href="/dashboard">
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
									{{-- <a class="shopping-cart" href="cart"><i class="fas fa-shopping-cart"></i></a>
									--}}
									{{-- <a class="mobile-hide search-bar-icon" href="#"><i
											class="fas fa-search"></i></a> --}}
								</div>
							</li>
						</ul>
					</nav>
					{{-- <a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
					<div class="mobile-menu"></div> --}}
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
				<div class="breadcrumb-text  text-break">
					<h1>{{ strtoupper($data['product']['name']) }}</h1>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end breadcrumb section -->

<!-- Single Product Page -->
<div class="container my-5">
	<div class="row">
        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('main') }}">{{ strtoupper(__('messages.dashboard')) }}</a>
                </li>
				<li class="breadcrumb-item"><a href="{{ route('all-product-category', ['categoryCode' => $data['product']['category']['code']]) }}">{{ strtoupper($data['product']['category']['name']) }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ strtoupper($data['product']['name']) }}</li>
            </ol>
        </nav>
    </div>
	<div class="row align-items-start">

		<!-- Thumbnail -->
		<div class="col-12 col-md-2 order-2 order-md-1">
			{{-- Mobile: Horizontal thumbnail centered --}}
			<div class="d-block d-md-none text-center mt-3">
				<div class="d-flex justify-content-center overflow-auto">
					@php
					$allImages = array_merge(
					[ ['path' => $data['product']['image_url']] ],
					$data['product']['images']->toArray()
					);
					@endphp
					@foreach($allImages as $image)
					<div class="me-2">
						<img src="{{ $image['path'] }}" class="img-fluid border rounded thumbnail-img"
							onclick="changePreview(this)"
							style="cursor: pointer; width: 60px; height: 60px; object-fit: cover;">
					</div>
					@endforeach
				</div>
			</div>

			{{-- Desktop: Vertical thumbnail --}}
			<div class="d-none d-md-block">
				<div class="d-flex flex-column align-items-end">
					@foreach($allImages as $image)
					<div class="mb-2">
						<img src="{{ $image['path'] }}" class="img-fluid border rounded thumbnail-img"
							onclick="changePreview(this)"
							style="cursor: pointer; width: 60px; height: 60px; object-fit: cover;">
					</div>
					@endforeach
				</div>
			</div>
		</div>

		{{-- Main Image --}}
		<div class="col-12 col-md-5 order-1 order-md-2 text-center">
			<img id="mainImage" src="{{ $data['product']['image_url'] }}" class="img-fluid rounded"
				alt="Main Product Image" style="max-height: 400px; object-fit: contain;">
		</div>

		{{-- Product Details --}}
		<div class="col-12 col-md-5 order-3 order-md-3">
			<div class="px-3 px-md-0">
				<!-- Gantikan col-md-10 -->
				<h2 class="fw-bold mt-4 mt-md-0  text-break">{{ strtoupper($data['product']['name']) }}</h2>
				<p class="text-secondary">{{ $data['product']['description'] }}</p>
				<p class="text-left text-danger">
					<strong>{{ \App\Services\UtilService::formatCurrency($data['product']['sell_price'],
						$data['product']['currency']) }}</strong>
				</p>
				<p class="text-left text-muted">
					Availability: <span class="text-success">{{ $data['product']['stock'] }} in stock</span>
				</p>

				{{-- Color Picker --}}
				@if(!empty($data['product']['color']))
				@php $colors = explode(',', $data['product']['color']); @endphp
				<div class="mb-3">
					<label class="form-label">Color:</label><br>
					@foreach($colors as $color)
					<span class="badge bg-secondary me-1">{{ strtoupper(trim($color)) }}</span>
					@endforeach
				</div>
				@endif

				{{-- Checkout Links --}}
				@if(!empty($data['product']['link_url']))
				@php $links = json_decode($data['product']['link_url'], true); @endphp
				<div class="mb-2">Checkout in:</div>
				<div class="d-flex flex-wrap gap-2">
					@foreach($links as $link)
					<a href="{{ $link['link'] }}" target="_blank" class="btn btn-outline-dark btn-sm">{{ $link['name']
						}}</a>
					@endforeach
				</div>
				@endif
			</div>
		</div>


	</div>
</div>
<!-- End Single Product Page -->


<!-- more products -->
<div class="more-products mb-150"
	style="background-image: {{ asset('build/plugins/dashboard/assets/img/benner-brembo.jpg') }}; background-attachment: fixed; background-size: cover; background-position: center;">
	<div class="container bg-white">
		<div class="row">
			<div class="col-lg-8 offset-lg-2 text-center">
				<div class="section-title  p-5">
					<h3><span class="orange-text">Related</span> Products</h3>
					<p>Discover other products you might be interested in. These related items are selected based on category, features, or customer favorites.</p>
				</div>
			</div>
		</div>
		<div class="row">
			@foreach ($data['products'] as $product)

			<div class="col-6 col-md-3 col-lg-2 my-2">
				<div class="card h-100 shadow-sm d-flex flex-column">
					{{-- Gambar --}}
					<div
						style="height: 160px; overflow: hidden; border 1px solid #dee2e6; border-radius: 5px; display: flex; justify-content: center; align-items: center;">
						<img src="{{ $product->image_url }}" class="w-100 h-100 object-fit-cover"
							style="object-fit: cover;" alt="{{ $product->name }}">
					</div>

					{{-- Info Produk --}}
					<div class="card-body d-flex flex-column justify-content-between">
						<a href="{{ route('single-product', ['uuid' => $product->uuid]) }}"
							class="text-decoration-none text-dark">

							<div>
								<p class="text-muted text-left small mb-1">{{ $product->category->name }}</p>
								<h6 class="text-dark mb-2 text-truncate">{{ $product->name }}</h6>
							</div>
							<div>
								<p class="text-danger text-right fw-bold mb-0">{{
									\App\Services\UtilService::formatCurrency($product->sell_price, $product->currency)
									}}</p>
								{{-- <p class="text-muted small text-right text-decoration-line-through mb-0">3.000.000
									IDR</p> --}}
							</div>

						</a>
					</div>
				</div>
			</div>
			@endforeach

		</div>
	</div>
</div>

<!-- end more products -->

<!-- logo carousel -->
<div class="d-none logo-carousel-inner d-flex flex-wrap justify-content-center align-items-center">
	@foreach ($data['brands'] as $brand)
	<div class="single-logo-item">
		<img src="{{ $brand->image_url }}" alt="{{ $brand->name }}" class="logo-img">
	</div>
	@endforeach
</div>
<!-- end logo carousel -->


</body>
<style>
	@media (max-width: 768px) {
		.main-preview {
			max-height: 240px;
		}

		.single-logo-item {
			max-width: 150px;
		}
	}

	.logo-carousel-inner {
		scrollbar-width: none;
		-ms-overflow-style: none;
	}

	.logo-carousel-inner::-webkit-scrollbar {
		display: none;
	}
	.logo-img {
		max-height: 40px;
		max-width: 100%;
		object-fit: contain;
	}


	.thumbnail-img:hover {
		border: 2px solid #007bff;
	}

	.thumbnail-img.active {
		border: 2px solid #0d6efd;
	}

	.single-product:hover {
		transform: scale(1.05);
		/* Membesar saat hover */
		box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
		/* Tambahkan bayangan */
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

	.more-products {
		position: relative;
		padding: 100px 0;
		/* Menambahkan padding agar konten tidak tertutup oleh background */
		color: white;
		/* Menyesuaikan warna teks agar kontras dengan background */
	}

	/* Parallax effect */
	.more-products {
		background-image: url({{ asset('build/plugins/dashboard/assets/img/benner-brembo.jpg')
	}
	});
	background-attachment: fixed;
	/* Efek parallax */
	background-size: cover;
	/* Memastikan background mengisi area */
	background-position: center;
	/* Menjaga posisi background di tengah */
	}

	/* Hover effect pada produk */
	.single-product-item:hover .product-image img {
		transform: scale(1.05);
		/* Memperbesar gambar sedikit saat hover */
		transition: transform 0.3s ease;
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
<script>
	function changePreview(img) {
		const mainImage = document.getElementById('mainImage');
		if (!mainImage) return;

		mainImage.src = img.src;

		// Optional: highlight selected thumbnail
		document.querySelectorAll('.thumbnail-img').forEach(el => el.classList.remove('active'));
		img.classList.add('active');
	}

    function adjustQty(amount) {
        const qtyInput = document.getElementById('qty');
        let qty = parseInt(qtyInput.value) || 1;
        qty = Math.max(1, qty + amount);
        qtyInput.value = qty;
    }
</script>