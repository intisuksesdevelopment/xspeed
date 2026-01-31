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
        height: 0;
        /* Tambahkan height: 0 untuk memastikan tidak ada ruang kosong */
        overflow: hidden;
        /* Sembunyikan konten yang melebihi tinggi 0 */
        display: block;
        /* Tetap block agar transisi scaleY berfungsi */
    }

    .show-manual {
        transition: transform 0.2s ease-in-out;
        transform-origin: top;
        transform: scaleY(1);
        height: auto;
        /* Biarkan tinggi menyesuaikan konten */
        display: block;
    }

    .collapse-icon {
        transition: transform 0.2s ease-in-out;
    }

    .sidebar-toggle .collapse-icon {
        transform: rotate(0deg);
        /* Ikon menghadap ke kanan secara default */
    }

    .sidebar-toggle.open .collapse-icon {
        transform: rotate(90deg);
        /* Ikon menghadap ke bawah saat terbuka */
    }

    .product-card {
        transition: box-shadow 0.3s ease-in-out;
        /* Efek transisi yang lebih halus */
    }

    .product-card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        cursor: pointer;
    }

    .pagination {
        --bs-pagination-color: #000;
        /* Warna teks default */
        --bs-pagination-bg: #fff;
        /* Warna background default */
        --bs-pagination-border-width: 1px;
        --bs-pagination-border-color: #dee2e6;
        --bs-pagination-border-radius: 0.375rem;
        --bs-pagination-hover-color: #000;
        --bs-pagination-hover-bg: #e9ecef;
        --bs-pagination-hover-border-color: #dee2e6;
        --bs-pagination-focus-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        --bs-pagination-focus-outline: 0;
        --bs-pagination-active-color: #fff;
        --bs-pagination-active-bg: #051922;
        /* Warna background aktif */
        --bs-pagination-active-border-color: #051922;
        /* Warna border aktif */
        --bs-pagination-disabled-color: #6c757d;
        --bs-pagination-disabled-bg: #fff;
        --bs-pagination-disabled-border-color: #dee2e6;
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: var(--bs-pagination-border-radius);
    }

    .page-link {
        position: relative;
        display: block;
        padding: 0.375rem 0.75rem;
        color: var(--bs-pagination-color);
        text-decoration: none;
        background-color: var(--bs-pagination-bg);
        border: var(--bs-pagination-border-width) solid var(--bs-pagination-border-color);
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .page-link:hover {
        z-index: 2;
        color: var(--bs-pagination-hover-color);
        background-color: var(--bs-pagination-hover-bg);
        border-color: var(--bs-pagination-hover-border-color);
    }

    .page-link:focus {
        z-index: 3;
        color: var(--bs-pagination-color);
        background-color: var(--bs-pagination-bg);
        outline: var(--bs-pagination-focus-outline);
        box-shadow: var(--bs-pagination-focus-shadow);
    }

    .page-item:first-child .page-link {
        border-top-left-radius: var(--bs-pagination-border-radius);
        border-bottom-left-radius: var(--bs-pagination-border-radius);
    }

    .page-item:last-child .page-link {
        border-top-right-radius: var(--bs-pagination-border-radius);
        border-bottom-right-radius: var(--bs-pagination-border-radius);
    }

    .page-item.active .page-link {
        z-index: 3;
        color: var(--bs-pagination-active-color);
        /* Teks aktif jadi putih */
        background-color: var(--bs-pagination-active-bg);
        /* Background aktif jadi #051922 */
        border-color: var(--bs-pagination-active-border-color);
    }

    .page-item.disabled .page-link {
        color: var(--bs-pagination-disabled-color);
        background-color: var(--bs-pagination-disabled-bg);
        border-color: var(--bs-pagination-disabled-border-color);
    }

    .breadcrumb {
        background-color: transparent;
        /* Make the background transparent */
        padding: 0.5rem;
        /* Adjust padding as needed */
        margin-bottom: 1rem;
        /* Space below the breadcrumb */
    }

    .breadcrumb-item+.breadcrumb-item::before {
        content: var(--bs-breadcrumb-divider, "/");
        /* Default separator is '/' */
        padding-right: 0.5rem;
        padding-left: 0.5rem;
        color: #6c757d !important;
        /* Light gray color */
    }

    .breadcrumb-item.active {
        color: #212529;
        /* Dark text for the active item */
    }
</style>
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <h2 class=" text-light">{{ strtoupper(__('messages.product')) }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->
<div class="container-fluid bg-light">
    <div class="row">
        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('main') }}">{{ strtoupper(__('messages.dashboard')) }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ strtoupper(__('messages.category')) }}</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-3 sidebar">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Kategori</h5>
            </div>
            @foreach ($data["categories"] as $category)
            <div class="sidebar-item">
                <div class="d-flex justify-content-between align-items-center sidebar-toggle px-2"
                    data-target="#{{ $category->code }}-sub">
                    @if($category->subcategories->isEmpty())
                    <div>
                        <a href="{{ route('all-product-category', ['categoryCode' => $category->code]) }}"
                            style="color: inherit; text-decoration: none;">{{ $category->name }} ({{
                            $category->countItems }})</a>
                    </div>
                    @else
                    <div>{{ $category->name }} <span class="text-muted">({{ $category->countItems }})</span></div>
                    @endif
                    @if($category->subcategories->isNotEmpty())
                    <i class="bi bi-caret-right-fill collapse-icon"></i>
                    @endif
                </div>
                @if($category->subcategories->isNotEmpty())
                <div class="subcategory-list collapse-manual px-3" id="{{ $category->code }}-sub">
                    @foreach ($category->subcategories as $subcategory)
                    <a href="{{ route('all-product-category', ['categoryCode' => $category->code]) }}"
                        class="sidebar-link ms-3">{{ $subcategory->name }} ({{ $subcategory->countItems }})</a>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <div class="col-md-9 product-grid">
            <div class="row row-cols-2 row-cols-md-4 p-3">
                @foreach ($data['products']->items() as $product)


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
                                        \App\Services\UtilService::formatCurrency($product->sell_price,
                                        $product->currency) }}</p>
                                    {{-- <p class="text-muted small text-right text-decoration-line-through mb-0">
                                        3.000.000 IDR</p> --}}
                                </div>

                            </a>
                        </div>
                    </div>
                </div>
                @endforeach




            </div>
            @if ($data['products']->isEmpty())
            <div style="display: flex; justify-content: center;">
                <p class="text-secondary">Produk is empty</p>
            </div>
            @else
            <div class="row row-cols-2 row-cols-md-4 p-3 justify-content-end">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        @if ($data['products']->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                        @else
                        <li class="page-item"><a class="page-link" href="{{ $data['products']->previousPageUrl() }}"
                                rel="prev">Previous</a></li>
                        @endif

                        @foreach ($data['products']->getUrlRange(1, $data['products']->lastPage()) as $page => $url)
                        @if ($page == $data['products']->currentPage())
                        <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                        @endforeach

                        @if ($data['products']->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $data['products']->nextPageUrl() }}"
                                rel="next">Next</a></li>
                        @else
                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                        @endif
                    </ul>
                </nav>
            </div>
            @endif
            {{-- <div class="row row-cols-2 row-cols-md-4 p-3">
                <div class="product-card col-lg-2 border border-solid position-relative m-1">
                    <a href="www.google.com" class="d-block text-decoration-none">
                        <figure class="m-0">
                            <img src="https://img.webike-cdn.net/s202/catalogue/images/44098/0096_TS.jpg"
                                class="img-fluid">
                        </figure>
                        <div class="p-2">
                            <p class=" small text-muted mb-1 text-decoration-none text-left"><a href=""
                                    class="text-decoration-none text-muted">YAMAHA</a></p>
                            <h6 class="mb-1 text-decoration-none"><a href=""
                                    class="text-decoration-none text-dark  text-left">Rangka R25 fullset</a></h6>
                            <p class="fw-bold text-danger mb-0 text-right"><strong>2.500.000 IDR</strong></p>
                            <p class="small text-muted mb-0  text-right" style="text-decoration: line-through;">
                                3.000.000 IDR</p>
                        </div>
                    </a>
                </div>
                <div class="product-card col-lg-2 border border-solid position-relative m-1">
                    <a href="www.google.com" class="d-block text-decoration-none">
                        <figure class="m-0">
                            <img src="https://img.webike-cdn.net/s202/catalogue/images/44098/0096_TS.jpg"
                                class="img-fluid">
                        </figure>
                        <div class="p-2">
                            <p class=" small text-muted mb-1 text-decoration-none text-left"><a href=""
                                    class="text-decoration-none text-muted">YAMAHA</a></p>
                            <h6 class="mb-1 text-decoration-none"><a href=""
                                    class="text-decoration-none text-dark  text-left">Rangka R25 fullset</a></h6>
                            <p class="fw-bold text-danger mb-0 text-right"><strong>2.500.000 IDR</strong></p>
                            <p class="small text-muted mb-0  text-right" style="text-decoration: line-through;">
                                3.000.000 IDR</p>
                        </div>
                    </a>
                </div>
            </div> --}}

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