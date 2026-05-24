<?php $page = 'product-details'; ?>
@extends('pages.layout.mainlayout')
@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        .product-bar li {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .product-bar li:last-child {
            border-bottom: none;
        }

        .product-bar h4 {
            font-weight: 600;
            margin: 0;
            color: #637381;
            min-width: 150px;
        }

        .product-bar h6 {
            margin: 0;
            color: #212b35;
            text-align: right;
        }

        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .slider-product {
            text-align: center;
        }

        .slider-product img {
            max-height: 300px;
            object-fit: contain;
            margin-bottom: 15px;
        }
    </style>
    <div class="page-wrapper" x-data="productDetail()" x-init="init()" x-cloak>
        <div class="content">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">Product Details</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/admin/product/list">Products</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a :href="ROUTES.productEdit(item.uuid)" class="btn btn-warning" x-show="item.uuid">
                        <i data-feather="edit" class="feather-16"></i> Edit
                    </a>
                </div>
            </div>

            <!-- Loading State -->
            <div x-show="loading" class="text-center py-5">
                <div class="spinner-border text-primary"></div>
                <p class="mt-2">Loading product details...</p>
            </div>

            <!-- Error State -->
            <div x-show="!loading && error" class="alert alert-danger">
                <span x-text="error"></span>
            </div>

            <!-- Product Details -->
            <div x-show="!loading && item" class="row">
                <div class="col-lg-8 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="bar-code-view d-none">
                                <img :src="'/build/img/barcode/barcode1.png'" alt="barcode">
                                <a class="printimg">
                                    <img src="{{ asset('build/img/icons/printer.svg') }}" alt="print">
                                </a>
                            </div>
                            <div class="productdetails">
                                <!-- Status Badge -->
                                <div class="mb-3 text-end">
                                    <span class="badge" :class="item.status === 0 ? 'bg-success' : 'bg-danger'"
                                        x-text="item.availability || '-'">
                                    </span>
                                </div>
                                <ul class="product-bar">
                                    <li>
                                        <h4>Product</h4>
                                        <h6 x-text="item.name"></h6>
                                    </li>
                                    <li>
                                        <h4>Category</h4>
                                        <h6
                                            x-text="item.category_name ? item.category_code + ' - ' + item.category_name : '-'">
                                        </h6>
                                    </li>
                                    <li>
                                        <h4>Sub Category</h4>
                                        <h6 x-text="item.subcategory_name || '-'"></h6>
                                    </li>
                                    <li>
                                        <h4>Brand</h4>
                                        <h6 x-text="item.brand_name || '-'"></h6>
                                    </li>
                                    <li>
                                        <h4>Unit</h4>
                                        <h6 x-text="item.unit || '-'"></h6>
                                    </li>
                                    <li>
                                        <h4>SKU</h4>
                                        <h6 x-text="item.sku"></h6>
                                    </li>
                                    <li>
                                        <h4>Minimum Qty</h4>
                                        <h6 x-text="(item.stock_min || 0) + ' ' + (item.unit || '')"></h6>
                                    </li>
                                    <li>
                                        <h4>Quantity</h4>
                                        <h6 x-text="(item.stock || 0) + ' ' + (item.unit || '')"></h6>
                                    </li>
                                    <li>
                                        <h4>Rack</h4>
                                        <h6 x-text="item.rack_name || '-'"></h6>
                                    </li>
                                    <li>
                                        <h4>Warehouse</h4>
                                        <h6 x-text="item.warehouse_name || '-'"></h6>
                                    </li>
                                    <li>
                                        <h4>Basic Price</h4>
                                        <h6 x-text="formatRupiah(item.basic_price)"></h6>
                                    </li>
                                    <li>
                                        <h4>Sell Price</h4>
                                        <h6 x-text="formatRupiah(item.sell_price)"></h6>
                                    </li>
                                    <li>
                                        <h4>Margin</h4>
                                        <h6 x-text="calculateMargin()"></h6>
                                    </li>
                                    <li>
                                        <h4>Description</h4>
                                        <h6 x-text="item.description || '-'"></h6>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-images">

                                <!-- Main Image -->
                                <div class="main-image mb-3 text-center">
                                    <img :src="currentImage" alt="Product Image" class="img-fluid rounded"
                                        style="max-height: 300px; object-fit: contain; cursor: zoom-in;"
                                        @click="openPreview(currentImage, item.name)"
                                        onerror="this.src='/build/img/image-not-found.jpg'">
                                </div>
                                <!-- Thumbnail Gallery -->
                                <div class="thumbnail-gallery d-flex gap-2 flex-wrap" x-show="images.length > 0">
                                    <template x-for="(img, index) in images" :key="img.id">
                                        <img :src="img.path" :alt="img.name" class="thumbnail rounded"
                                            :class="currentImage === img.path ? 'border border-primary' : ''"
                                            style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;"
                                            @click="currentImage = img.path; openPreview(img.path, img.name, img.description)">
                                    </template>
                                </div>
                                <!-- No Images -->
                                <div x-show="images.length === 0" class="text-center py-4">
                                    <img src="/build/img/image-not-found.jpg" alt="No Image" class="img-fluid rounded"
                                        style="max-height: 200px;">
                                    <p class="text-muted mt-2">No images available</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Preview Modal - Pure Alpine.js -->
    <div id="image-preview-modal"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; background: rgba(0,0,0,0.9); align-items: center; justify-content: center;"
        onclick="if(event.target === this) closePreviewModal()">
        <div style="position: relative; max-width: 90%; max-height: 90%;">
            <button type="button" id="btn-close-preview"
                style="position: absolute; top: -40px; right: 0; background: white; border: none; border-radius: 50%; width: 36px; height: 36px; cursor: pointer; font-size: 18px;">×</button>
            <img id="preview-img" src="" alt=""
                style="max-width: 100%; max-height: 80vh; object-fit: contain; border-radius: 8px;">
            <div style="text-align: center; margin-top: 15px; color: white;">
                <p id="preview-name" style="margin: 0;"></p>
                <small id="preview-desc" style="color: #aaa;"></small>
            </div>
        </div>
    </div>

    <script>
        const ROUTES = {
            productEdit: (uuid) => `/admin/product/edit/${uuid}`,
            productList: () => `/admin/product/list`,
        };

        const API_PRODUCT_DETAIL_URL = "{{ route('api-product-detail', ['uuid' => 'UUID_PLACEHOLDER']) }}";

        function productDetail() {
            return {
                item: {},
                images: [],
                currentImage: '/build/img/image-not-found.jpg',
                loading: true,
                error: null,

                init() {
                    // Add click listener to close button
                    document.getElementById('btn-close-preview').addEventListener('click', closePreviewModal);

                    // Extract UUID from URL path
                    const pathParts = window.location.pathname.split('/');
                    const uuidIndex = pathParts.findIndex(p => p === 'detail');
                    const uuid = uuidIndex !== -1 ? pathParts[uuidIndex + 1] : null;

                    if (!uuid) {
                        this.error = 'Product UUID not found in URL';
                        this.loading = false;
                        return;
                    }

                    this.fetchProductDetail(uuid);
                },

                async fetchProductDetail(uuid) {
                    this.loading = true;
                    this.error = null;

                    try {
                        const url = API_PRODUCT_DETAIL_URL.replace('UUID_PLACEHOLDER', uuid);
                        const res = await fetch(url);

                        if (!res.ok) {
                            throw new Error(`HTTP error! status: ${res.status}`);
                        }

                        const result = await res.json();

                        if (!result.success) {
                            throw new Error(result.message || 'Failed to fetch product details');
                        }

                        this.item = result.data;
                        this.images = result.data.images || [];
                        // Set first image as current image if available
                        if (this.images.length > 0) {
                            this.currentImage = this.images[0].path;
                        } else {
                            this.currentImage = '/build/img/image-not-found.jpg';
                        }

                        // Reinitialize feather icons after images load
                        setTimeout(() => {
                            if (typeof feather !== 'undefined') {
                                feather.replace();
                            }
                        }, 100);

                    } catch (e) {
                        console.error('Error fetching product detail:', e);
                        this.error = e.message || 'Failed to load product details';
                    } finally {
                        this.loading = false;
                    }
                },

                formatRupiah(value) {
                    if (!value && value !== 0) return '-';
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(value);
                },

                calculateMargin() {
                    const basic = parseFloat(this.item.basic_price) || 0;
                    const sell = parseFloat(this.item.sell_price) || 0;

                    if (basic === 0) return '-';

                    const margin = ((sell - basic) / basic * 100).toFixed(2);
                    return `${margin}%`;
                },

                openPreview(imagePath, imageName = '', imageDesc = '') {
                    // Use vanilla JS to show modal
                    const modal = document.getElementById('image-preview-modal');
                    const img = modal.querySelector('img');
                    const nameEl = modal.querySelector('p');
                    const descEl = modal.querySelector('small');

                    img.src = imagePath;
                    img.alt = imageName;
                    nameEl.textContent = imageName;
                    nameEl.style.display = imageName ? 'block' : 'none';
                    descEl.style.display = imageDesc ? 'block' : 'none';
                    descEl.textContent = imageDesc || '';

                    modal.style.display = 'flex';
                },

                closePreviewModal() {
                    const modal = document.getElementById('image-preview-modal');
                    modal.style.display = 'none';
                }
            }
        }

        // Global function for modal close (accessible from onclick)
        function closePreviewModal() {
            const modal = document.getElementById('image-preview-modal');
            modal.style.display = 'none';
        }
    </script>
@endsection
