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
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 sidebar">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Kategori</h5>
                </div>
				@foreach ($data["categories"] as $category)
					<div class="sidebar-item">
						<div class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#{{ $category->code }}-sub">
							<div>{{ $category->name }} <span class="text-muted">({{ $category->product_count }})</span></div>
							@if($category->subcategories->isNotEmpty())
								<i class="bi bi-plus"></i>
							@endif
						</div>
						@if($category->subcategories->isNotEmpty())
							@foreach ($category->subcategories as $subcategory)
								<div class="collapse" id="{{ $category->code }}-sub">
									<a href="#" class="sidebar-link ms-3">{{ $subcategory->name }} ({{ $subcategory->product_count }})</a>
								</div>
							@endforeach
						@endif
						
					</div>
				@endforeach
            </div>

            <div class="col-md-9 product-grid">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Knalpot</h2>
                    <a href="#" class="text-decoration-none text-muted">Lihat Semua 40,592 Produk <i class="bi bi-chevron-right"></i></a>
                </div>

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

                <div class="row row-cols-2 row-cols-md-4 g-3">
                    <div class="col">
                        <div class="product-card">
                            <div class="product-image-container">
                                <img src="https://img.webike-cdn.net/s202/catalogue/images/12345/akrapovic-full.jpg" alt="Knalpot Full System" class="product-image">
                            </div>
                            <div class="product-details">
                                <h6 class="fw-bold mb-1">Knalpot Full System</h6>
                                <p class="text-muted small mb-0">(13,204)</p>
                                <a href="#" class="btn btn-outline-secondary btn-sm mt-2">Lihat Semua Produk <i class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="product-card">
                            <div class="product-image-container">
                                <img src="https://img.webike-cdn.net/s202/catalogue/images/67890/peredam.jpg" alt="Peredam Panas Knalpot" class="product-image">
                            </div>
                            <div class="product-details">
                                <h6 class="fw-bold mb-1">Peredam Panas Knalpot</h6>
                                <p class="text-muted small mb-0">(95)</p>
                                <a href="#" class="btn btn-outline-secondary btn-sm mt-2">Lihat Semua Produk <i class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="product-card">
                            <div class="product-image-container">
                                <img src="https://img.webike-cdn.net/s202/catalogue/images/11223/glasswool.jpg" alt="Glass Wool" class="product-image">
                            </div>
                            <div class="product-details">
                                <h6 class="fw-bold mb-1">Glass Wool</h6>
                                <p class="text-muted small mb-0">(133)</p>
                                <a href="#" class="btn btn-outline-secondary btn-sm mt-2">Lihat Semua Produk <i class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="product-card">
                            <div class="product-image-container">
                                <img src="https://img.webike-cdn.net/s202/catalogue/images/44556/gasket.jpg" alt="Gasket Knalpot" class="product-image">
                            </div>
                            <div class="product-details">
                                <h6 class="fw-bold mb-1">Gasket Knalpot</h6>
                                <p class="text-muted small mb-0">(1,227)</p>
                                <a href="#" class="btn btn-outline-secondary btn-sm mt-2">Lihat Semua Produk <i class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const collapseElements = document.querySelectorAll('.sidebar-item [data-bs-toggle="collapse"]');
            collapseElements.forEach(collapseElement => {
                const plusIcon = document.createElement('i');
                plusIcon.classList.add('bi', 'bi-plus');
                const targetDiv = collapseElement.querySelector('.d-flex');
                if (targetDiv) {
                    targetDiv.appendChild(plusIcon);
                } else {
                    console.error("Elemen .d-flex tidak ditemukan di dalam .sidebar-item dengan collapse");
                }

                collapseElement.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-bs-target');
                    const collapseTarget = document.querySelector(targetId);
                    const currentIcon = this.querySelector('.bi');

                    if (collapseTarget) {
                        const bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapseTarget);
                        if (bsCollapse._element.classList.contains('show')) {
                            bsCollapse.hide();
                            if (currentIcon) {
                                currentIcon.classList.remove('bi-dash');
                                currentIcon.classList.add('bi-plus');
                            }
                        } else {
                            bsCollapse.show();
                            if (currentIcon) {
                                currentIcon.classList.remove('bi-plus');
                                currentIcon.classList.add('bi-dash');
                            } else {
                                const newMinusIcon = document.createElement('i');
                                newMinusIcon.classList.add('bi', 'bi-dash');
                                const targetDivIcon = this.querySelector('.d-flex');
                                if (targetDivIcon) {
                                    targetDivIcon.appendChild(newMinusIcon);
                                }
                            }
                        }
                    }

                    // Tutup dropdown lain saat satu dibuka
                    const allCollapses = document.querySelectorAll('.collapse');
                    allCollapses.forEach(collapse => {
                        if (collapse.id !== targetId) {
                            const bsCollapseOther = bootstrap.Collapse.getOrCreateInstance(collapse);
                            if (bsCollapseOther._element.classList.contains('show')) {
                                bsCollapseOther.hide();
                                const otherIcon = document.querySelector(`[data-bs-target="#${collapse.id}"] .bi`);
                                if (otherIcon) {
                                    otherIcon.classList.remove('bi-dash');
                                    otherIcon.classList.add('bi-plus');
                                }
                            }
                        }
                    });
                });

                // Inisialisasi Bootstrap Collapse
                const targetId = collapseElement.getAttribute('data-bs-target');
                const collapseTargetInitial = document.querySelector(targetId);
                if (collapseTargetInitial) {
                    bootstrap.Collapse.getOrCreateInstance(collapseTargetInitial);
                }
            });

            // Inisialisasi collapse yang tidak di-toggle langsung
            const nonToggleCollapses = document.querySelectorAll('.collapse:not([data-bs-toggle])');
            nonToggleCollapses.forEach(collapse => {
                bootstrap.Collapse.getOrCreateInstance(collapse);
            });

            // Tambahkan ikon + hanya pada sidebar-item yang memiliki collapse target
            const sidebarItems = document.querySelectorAll('.sidebar-item');
            sidebarItems.forEach(item => {
                const collapseTargetId = item.querySelector('[data-bs-toggle="collapse"]')?.getAttribute('data-bs-target');
                if (collapseTargetId) {
                    const plusIcon = document.createElement('i');
                    plusIcon.classList.add('bi', 'bi-plus');
                    const targetDiv = item.querySelector('.d-flex');
                    if (targetDiv) {
                        targetDiv.appendChild(plusIcon);
                    }
                }
            });
        });
    </script>