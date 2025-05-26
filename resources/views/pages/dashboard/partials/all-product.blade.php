    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .sidebar {
            background-color: #f8f9fa;
            padding: 15px;
        }
        .sidebar-item {
            padding: 8px 0;
            cursor: pointer;
        }
        .sidebar-item:hover {
            background-color: #e9ecef;
        }
        .sidebar-link {
            display: block;
            padding: 8px 15px;
            text-decoration: none;
            color: #212529;
        }
        .sidebar-link:hover {
            background-color: #e9ecef;
        }
        .product-grid {
            padding: 15px;
        }
        .product-card {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .product-image-container {
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            padding: 10px;
        }
        .product-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .product-details {
            padding: 10px;
            text-align: center;
        }
        .filter-bar {
            background-color: #f0f0f0;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    .collapse-manual {
    transition: transform 0.2s ease-in-out;
    transform-origin: top;
    transform: scaleY(0);
    height: 0; /* Tambahkan height: 0 untuk memastikan tidak ada ruang kosong */
    overflow: hidden; /* Sembunyikan konten yang melebihi tinggi 0 */
    display: block; /* Tetap block agar transisi scaleY berfungsi */
}

.show-manual {
    transition: transform 0.2s ease-in-out;
    transform-origin: top;
    transform: scaleY(1);
    height: auto; /* Biarkan tinggi menyesuaikan konten */
    display: block;
}
    .collapse-icon {
        transition: transform 0.2s ease-in-out;
    }
    .sidebar-toggle .collapse-icon {
        transform: rotate(0deg); /* Ikon menghadap ke kanan secara default */
    }
    .sidebar-toggle.open .collapse-icon {
        transform: rotate(90deg); /* Ikon menghadap ke bawah saat terbuka */
    }
	.product-card {
		transition: box-shadow 0.3s ease-in-out; /* Efek transisi yang lebih halus */
		}

		.product-card:hover {
		box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
		cursor: pointer;
		}
        .breadcrumb {
  font-size: 0.9em;
  color: #555;
}

    .breadcrumb a {
    color: #051922;
    text-decoration: none;
    }

    .breadcrumb a:hover {
    text-decoration: underline;
    }

    .breadcrumb .separator {
    margin: 0 5px;
    }

    .breadcrumb span {
    font-weight: bold;
    }
    </style>
    <!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<h2>PRODUCTS</h2>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->
    <div class="container-fluid">
       <div class="breadcrumb bg-light">
            <a href="{{ url('dashboard') }}">{{ __('messages.dashboard') }}</a>
            <span class="separator">/</span>
            <span >{{ __('messages.category') }}</span>
        </div>
        <div class="row">
            <div class="col-md-3 sidebar">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Kategori</h5>
                </div>
				@foreach ($data["categories"] as $category)
					<div class="sidebar-item">
						<div class="d-flex justify-content-between align-items-center sidebar-toggle px-2" data-target="#{{ $category->code }}-sub">
							<div>{{ $category->name }} <span class="text-muted">({{ $category->countItems }})</span></div>
							@if($category->subcategories->isNotEmpty())
								<i class="bi bi-caret-right-fill collapse-icon"></i>
							@endif
						</div>
						@if($category->subcategories->isNotEmpty())
							<div class="subcategory-list collapse-manual px-3" id="{{ $category->code }}-sub">
								@foreach ($category->subcategories as $subcategory)
									<a href="#" class="sidebar-link ms-3">{{ $subcategory->name }} ({{ $subcategory->countItems }})</a>
								@endforeach
							</div>
						@endif
					</div>
				@endforeach
				<div class="sidebar-item">
					<a href="#" class="sidebar-link">Knalpot</a>
				</div>
				<div class="sidebar-item">
					<a href="#" class="sidebar-link">Filter Knalpot</a>
				</div>
				<div class="sidebar-item">
					<a href="#" class="sidebar-link">Aksesoris Knalpot</a>
				</div>
            </div>

            <div class="col-md-9 product-grid">
                <div class="filter-bar mb-3">
                    <h5>Belanja Berdasarkan Model</h5>
                    <div class="row gx-2 align-items-center">
                        <div class="col-md-3">
                            <select class="form-select form-select-sm">
                                <option selected>Produsen</option>
                                <option value="1">Akrapovic</option>
                                <option value="2">Yoshimura</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-sm">
                                <option selected>Kapasitas Mesin</option>
                                <option value="1">150cc</option>
                                <option value="2">250cc</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-sm">
                                <option selected>Model</option>
                                <option value="1">R25</option>
                                <option value="2">Ninja 250</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-danger btn-sm w-100">CARI PRODUK PER MODEL</button>
                        </div>
                    </div>
                    <div class="mt-2">
                        <i class="bi bi-person"></i> Mybike: <a href="#" class="text-decoration-none text-muted">Masuk untuk Mengakses Motor Saya</a>
                    </div>
                </div>
                <div class="row">
                    @foreach ($data['products'] as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="{{ asset($product->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">
                                        <del>TK {{ $product->price }}</del>
                                        TK {{ $product->discount_price ?? $product->price }}
                                    </p>
                                    <a href="{{ route('single-product') }}?uuid={{ $product->uuid }}">{{ __('messages.detail') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center">
                    {{ $data['products']->links() }}
                </div>
                <div class="row row-cols-2 row-cols-md-4 p-3">
					<div class="product-card col-lg-2 border border-solid position-relative m-1">
						<a href="www.google.com" class="d-block text-decoration-none">
							<figure class="m-0">
								<img src="https://img.webike-cdn.net/s202/catalogue/images/44098/0096_TS.jpg" class="img-fluid">
							</figure>
							<div class="p-2">
								<p class=" small text-muted mb-1 text-decoration-none text-left"><a href="" class="text-decoration-none text-muted">YAMAHA</a></p>
								<h6 class="mb-1 text-decoration-none"><a href="" class="text-decoration-none text-dark  text-left">Rangka R25 fullset</a></h6>
								<p class="fw-bold text-danger mb-0 text-right"><strong>2.500.000 IDR</strong></p>
								<p class="small text-muted mb-0  text-right" style="text-decoration: line-through;">3.000.000 IDR</p>
							</div>
						</a>
					</div>
					<div class="product-card col-lg-2 border border-solid position-relative m-1">
						<a href="www.google.com" class="d-block text-decoration-none">
							<figure class="m-0">
								<img src="https://img.webike-cdn.net/s202/catalogue/images/44098/0096_TS.jpg" class="img-fluid">
							</figure>
							<div class="p-2">
								<p class=" small text-muted mb-1 text-decoration-none text-left"><a href="" class="text-decoration-none text-muted">YAMAHA</a></p>
								<h6 class="mb-1 text-decoration-none"><a href="" class="text-decoration-none text-dark  text-left">Rangka R25 fullset</a></h6>
								<p class="fw-bold text-danger mb-0 text-right"><strong>2.500.000 IDR</strong></p>
								<p class="small text-muted mb-0  text-right" style="text-decoration: line-through;">3.000.000 IDR</p>
							</div>
						</a>
					</div>
                </div>
				
            </div>
        </div>
    </div>
	<script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleElements = document.querySelectorAll('.sidebar-toggle');

            toggleElements.forEach(toggleElement => {
                toggleElement.addEventListener('click', function() {
                    const targetSelector = this.getAttribute('data-target');
                    const targetElement = document.querySelector(targetSelector);
                    const collapseIcon = this.querySelector('.collapse-icon');

                    if (targetElement) {
                        targetElement.classList.toggle('show-manual');
                        this.classList.toggle('open'); // Tambahkan/hapus kelas 'open' pada toggle

                        if (collapseIcon) {
                            collapseIcon.classList.toggle('bi-caret-right-fill');
                            collapseIcon.classList.toggle('bi-caret-down-fill');
                        }
                    }
                });

                // Inisialisasi: sembunyikan dropdown
                const subcategoryLists = document.querySelectorAll('.subcategory-list');
                subcategoryLists.forEach(list => {
                    list.classList.add('collapse-manual');
                });
            });

        });
    </script>