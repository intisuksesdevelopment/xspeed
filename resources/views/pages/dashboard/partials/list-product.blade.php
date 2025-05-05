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
						{{-- <p>See more Details</p> --}}
						<h1>{{ strtoupper($data['category']->name) }}</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- list product -->
	<div class=" mt-150 mb-150">
		<div class="container">
			<div class="row pb-3">
				<div class="breadcrumb-text">
					{{-- <p>See more Details</p> --}}
					<p><span ><a class="text-dark" href="./dashboard">Dashboard/</a></span>
						<span class="active">{{ strtoupper($data['category']->name) }}</span></p>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<hr class="bg-dark">
				</div>
			</div>
			<div class="row gap-4">
				<div class="col-md-12">
					<div class="row">
						@php
							$groupedProducts = [];
							foreach($data['products'] as $product) {
								$groupedProducts[$product->sku][] = $product;
							}
						@endphp
						@foreach($groupedProducts as $sku => $products)
							<div class="col-lg-3 col-md-4 col-sm-6 pt-3">
								<div class="card position-relative h-100">
									{{-- Gambar Produk --}}
									<img src="{{ $products[0]->image_url }}" alt="{{ $products[0]->name }}" class="card__img">
									<div class="card-body d-flex flex-column h-100">
										<h5 class="card__title">{{ strtoupper($products[0]->name) }}</h5>
										<div class="d-flex justify-content-between">
											<span class="card__price">{{ \App\Services\UtilService::formatCurrency($products[0]->sell_price, $products[0]->currency) }}</span>
										</div>
										<div class="card__size mt-auto">
											@if($products[0]->size != null)
												<div class="size-selector">
													@foreach($products as $product)
														<button class="size-btn" data-price="{{ $product->sell_price }}" onclick="updatePrice('{{ $sku }}', '{{ $product->size }}', '{{ $product->sell_price }}')">
															{{ strtoupper($product->size) }}
														</button>
													@endforeach
												</div>
											@endif
										</div>
										<a href="./dashboard/single-product/?uuid={{ $product->uuid }}" class="card__button mt-2 text-center">Detail</a>
									</div>
								</div>
							</div>
						@endforeach
					
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end single product -->

	<!-- more products -->
	<div class="more-products mb-150" style="background-image: {{ asset('build/plugins/dashboard/assets/img/benner-brembo.jpg') }}; background-attachment: fixed; background-size: cover; background-position: center;">
		<div class="container bg-white">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title  p-5">    
						<h3><span class="orange-text">Related</span> Products</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p>
					</div>
				</div>
			</div>
			<div class="row g-2">
				@foreach($data['products'] as $product)
					<div class="col-lg-2 col-md-6 col-sm-6 text-center">
						<div class="single-product-item bg-white ">
							<!-- Product Image -->
							<div class="product-image">
								<a href="./dashboard/single-product/?uuid={{ $product->uuid }}">
									<img src="{{ $product->image_url }}" alt="product" class="img-fluid" style="max-width: 120px; height: 120px; object-fit: cover; border-radius: 5px;">
								</a>
							</div>
							<!-- Product Name -->
							<h5 class="my-1 text-uppercase" style="font-size: 0.9rem;">{{ strtoupper($product->name) }}</h5>
							<!-- Product Price -->
							<small>
								<p class="" style=" color: #051922; margin: 0.5rem 0;">
									{{ \App\Services\UtilService::formatCurrency($product->sell_price, $product->currency) }}
								</p>
							</small>
							<!-- Product Details Link -->
							<a href="./dashboard/single-product/?uuid={{ $product->uuid }}" class="text-primary" style="font-size: 0.8rem; text-decoration: none;">Detail</a>
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
</body>
<style>
	.single-product-item {
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.product-price {
    color: #ff4d4f; /* Membuat harga menonjol */
    font-size: 1rem;
    font-weight: bold;
}

.product-image img {
    border-radius: 8px;
}
	.more-products {
        position: relative;
        padding: 100px 0; /* Menambahkan padding agar konten tidak tertutup oleh background */
        color: white; /* Menyesuaikan warna teks agar kontras dengan background */
    }

    /* Parallax effect */
    .more-products {
        background-image: url({{ asset('build/plugins/dashboard/assets/img/benner-brembo.jpg') }});
        background-attachment: fixed;  /* Efek parallax */
        background-size: cover;       /* Memastikan background mengisi area */
        background-position: center;  /* Menjaga posisi background di tengah */
    }

    /* Hover effect pada produk */
    .single-product-item:hover .product-image img {
        transform: scale(1.05); /* Memperbesar gambar sedikit saat hover */
        transition: transform 0.3s ease;
    }
	/* Mengatur gambar produk agar memiliki ukuran tetap dan tidak berubah proporsional */
.card__img {
    width: 100%;
    height: 200px; /* Tentukan tinggi tetap untuk gambar */
    object-fit: cover; /* Memastikan gambar terpotong sesuai dengan ukuran */
    border-radius: 1rem;
}

/* Mengatur card body agar mengisi ruang yang ada */
.card-body {
    display: flex;
    flex-direction: column;
    height: 100%;
    padding: 1rem;
}

/* Menjaga agar harga dan tombol tidak bergerak */
.card__price {
    font-size: 1.2rem;
    font-weight: bold;
}

.card__size {
    margin-top: auto; /* Memastikan ukuran tombol tetap berada di bawah */
}

.size-selector {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 10px;
}

.size-btn {
    border-radius: 50px;
    padding: 8px 20px;
    font-size: 14px;
    background-color: #f0f0f0;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
}

.size-btn:hover {
    background-color: #007bff;
    color: white;
}

.card__button {
    background-color: #FBBD15;
    color: white;
    padding: 10px;
    border-radius: 8px;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    margin-top: 10px;
}

.card__button:hover {
    background-color: #e0a800;
}

</style>