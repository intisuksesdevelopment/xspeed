<?php $page = 'product-list'; ?>
@extends('pages.layout.mainlayout')

@section('content')
    <style>
        .fade-row {
            transition: all 0.2s ease;
        }

        .fade-row:hover {
            background-color: #f8f9fa;
        }

        .product-name {
            display: inline-block;
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            vertical-align: middle;
        }

        .brand-name {
            display: inline-block;
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            vertical-align: middle;
        }
    </style>
    <div class="page-wrapper" x-data="productTable()" x-init="init()" x-cloak>
        <div class="content position-relative">

            <div class="table-top">

                <div class="row g-2 align-items-center">

                    <!-- SEARCH -->
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false"><i class="fa fa-search" aria-hidden="true"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Name</a></li>
                                <li><a class="dropdown-item" href="#">SKU</a></li>
                                <li><a class="dropdown-item" href="#">Brand</a></li>
                                <li><a class="dropdown-item" href="#">Rack</a></li>
                            </ul>
                            <input type="text" class="form-control" placeholder="{{ __('common.search') }}..."
                                x-model="filters.search" @keyup.debounce.500ms="fetchProducts()">
                        </div>
                    </div>

                    <!-- FILTER -->
                    <div class="col-md-5">
                        <div class="d-flex gap-2">
                            <select class="form-select" x-model="filters.warehouse" @change="fetchProducts()">
                                <option value=""> {{ __('common.warehouse') }}</option>
                                <template x-for="w in warehouses" :key="w.code">
                                    <option :value="w.code" x-text="w.name"></option>
                                </template>
                            </select>

                            <select class="form-select" x-model="filters.brand" @change="fetchProducts()">
                                <option value=""> {{ __('common.brand') }}</option>
                                <template x-for="b in brands" :key="b.code">
                                    <option :value="b.code" x-text="b.name"></option>
                                </template>
                            </select>

                            <select class="form-select" x-model="filters.sort" @change="fetchProducts()">
                                <option value="desc">Newest</option>
                                <option value="asc">Oldest</option>
                            </select>

                        </div>
                    </div>

                    <!-- PER PAGE -->
                    <div class="col-md-3 text-md-end">
                        <div class="d-inline-flex align-items-center gap-2">
                            <span>Show</span>

                            <select class="form-select form-select-sm w-auto" x-model="perPage"
                                @change="changePerPage(perPage)">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>

                            <span>entries</span>
                        </div>
                    </div>

                </div>

            </div>

            <!-- TABLE -->
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Produk</th>
                        <th>Stok</th>
                        <th>Rak</th>
                        <th>Merk</th>
                        <th>Harga Pokok</th>
                        <th>Harga Jual</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    {{-- <!-- LOADING -->
                    <tr x-show="loading" x-cloak>
                        <td colspan="8" class="text-center py-3">Loading...</td>
                    </tr> --}}

                    <!-- EMPTY -->
                    <tr x-show="!loading && items.length === 0" x-cloak>
                        <td colspan="8" class="text-center py-3">No data found</td>
                    </tr>

                    <!-- DATA -->
                    <template x-for="item in items" :key="item.uuid">
                        <tr>
                            <td x-text="item.sku"></td>
                            <td>
                                <div class="productimgname d-flex align-items-center gap-2">
                                    <img :src="getImage(item)" width="40" class="rounded"
                                        onerror="this.src='/build/img/image-not-found.jpg'">
                                    <span class="product-name" :title="item.name" x-text="item.name"></span>
                                </div>
                            </td>
                            <td x-text="item.stock"></td>
                            <td x-text="item.rack_name ?? '-'"></td>
                            <td class="brand-name" x-text="item.brand_code ?? '-'" :title="item.brand_name"></td>
                            <td x-text="formatRupiah(item.basic_price ?? 0)"></td>
                            <td x-text="formatRupiah(item.sell_price?? 0)"></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a class="btn btn-sm btn-info" :href="ROUTES.productDetail(item.uuid)" title="Detail">
                                        <i data-feather="eye" class="feather-14"></i>
                                    </a>
                                    <a class="btn btn-sm btn-warning" :href="ROUTES.productEdit(item.uuid)" title="Update">
                                        <i data-feather="edit" class="feather-14"></i>
                                    </a>
                                    <a class="btn btn-sm btn-danger" :href="ROUTES.productDelete(item.uuid)"
                                        title="Delete">
                                        <i data-feather="trash-2" class="feather-14"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </template>

                </tbody>
            </table>
            <template x-if="loading">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                    style="background: rgba(255,255,255,0.5); z-index: 999;">
                    <div class="spinner-border text-primary"></div>
                </div>
            </template>
            <!-- PAGINATION -->
            <div class="d-flex justify-content-between align-items-center mt-3" x-show="!loading && total > 0">

                <!-- INFO -->
                <div>
                    Showing
                    <span x-text="((page - 1) * perPage) + 1"></span>
                    -
                    <span x-text="Math.min(page * perPage, total)"></span>
                    of
                    <span x-text="total"></span>
                    entries
                </div>

                <!-- BUTTON -->
                <div class="btn-group">

                    <button class="btn btn-sm btn-outline-secondary" :disabled="page === 1"
                        @click="prevPage()">Prev</button>

                    <template x-for="p in pages" :key="p">
                        <button class="btn btn-sm" :class="p === page ? 'btn-primary' : 'btn-outline-primary'"
                            @click="goToPage(p)" x-text="p"></button>
                    </template>

                    <button class="btn btn-sm btn-outline-secondary" :disabled="page === lastPage"
                        @click="nextPage()">Next</button>

                </div>
            </div>

        </div>
    </div>

    <script>
        const ROUTES = {
            productDetail: (uuid) => `/admin/product/detail/${uuid}`,
            productEdit: (uuid) => `/admin/product/edit/${uuid}`,
            productDelete: (uuid) => `/admin/product/delete/${uuid}`,
        };
        const API_PRODUCT_URL = "{{ route('api-product-paged') }}";
        const API_BRAND_URL = "{{ route('api-brand-all') }}";
        const API_WAREHOUSE_URL = "{{ route('api-warehouse-all') }}";

        function productTable() {
            return {
                items: [],
                warehouses: [],
                brands: [],

                loading: false,
                isFetching: false,
                controller: null,

                selected: [],
                selectAll: false,
                prefetchCache: {},
                page: 1,
                perPage: 10,
                lastPage: 1,
                total: 0,

                initialized: false,

                filters: {
                    search: '',
                    warehouse: '',
                    brand: '',
                    sort: 'desc'
                },

                init() {
                    if (this.initialized) return;
                    this.initialized = true;

                    this.fetchWarehouses();
                    this.fetchBrands();
                    this.fetchProducts();
                },

                async fetchWarehouses() {
                    try {
                        console.log('Fetching warehouses from:', API_WAREHOUSE_URL);
                        let res = await fetch(API_WAREHOUSE_URL);
                        let data = await res.json();
                        console.log('Warehouses response:', data);
                        this.warehouses = data.data ?? [];
                    } catch (e) {
                        console.error('Failed to fetch warehouses:', e);
                    }
                },

                async fetchBrands() {
                    try {
                        console.log('Fetching brands from:', API_BRAND_URL);
                        let res = await fetch(API_BRAND_URL);
                        let data = await res.json();
                        console.log('Brands response:', data);
                        this.brands = data.data ?? [];
                    } catch (e) {
                        console.error('Failed to fetch brands:', e);
                    }
                },

                debounceFetch: null,

                // triggerFetch() {
                //     clearTimeout(this.debounceFetch);
                //     this.debounceFetch = setTimeout(() => {
                //         this.page = 1;
                //         this.fetchProducts();
                //     }, 300);
                // },
                async prefetchPage(page) {

                    if (this.prefetching) return; // 🔥 cegah loop
                    if (page > this.lastPage) return;
                    if (this.prefetchCache[page]) return;

                    this.prefetching = true;

                    try {
                        let params = new URLSearchParams({
                            page: page,
                            per_page: this.perPage
                        });

                        let res = await fetch(`${API_PRODUCT_URL}?${params}`);
                        let result = await res.json();

                        if (!result.success) return;

                        this.prefetchCache[page] = result.data;

                    } catch (e) {
                        console.error('Prefetch error:', e);
                    } finally {
                        this.prefetching = false;
                    }
                },
                async fetchProducts() {
                    this.loading = true;
                    console.log('Fetching products with filters:', this.filters);

                    try {
                        let params = new URLSearchParams({
                            page: this.page,
                            per_page: this.perPage,
                            search: this.filters.search,
                            warehouse: this.filters.warehouse,
                            brand: this.filters.brand
                        });

                        console.log('API URL:', `${API_PRODUCT_URL}?${params}`);
                        let res = await fetch(`${API_PRODUCT_URL}?${params}`);

                        let text = await res.text();

                        let result = JSON.parse(text);
                        console.log('API Response:', result);

                        let paginated = result.data;

                        this.items = paginated.data || [];
                        console.log('Items loaded:', this.items.length);
                        this.page = paginated.current_page || 1;
                        this.lastPage = paginated.last_page || 1;
                        this.total = paginated.total || 0;

                    } catch (e) {
                        console.error('ERROR:', e);
                    } finally {
                        console.log('DONE FETCH');
                        this.loading = false;
                        // Wait for Alpine.js to finish rendering before initializing feather icons
                        this.$nextTick(() => {
                            if (typeof feather !== 'undefined') {
                                feather.replace();
                            }
                        });
                    }
                },
                get pages() {
                    let pages = [];

                    let start = Math.max(1, this.page - 2);
                    let end = Math.min(this.lastPage, this.page + 2);

                    for (let i = start; i <= end; i++) {
                        pages.push(i);
                    }

                    return pages;
                },
                goToPage(p) {
                    if (p === this.page) return;

                    this.page = p;
                    this.fetchProducts();
                },
                nextPage() {
                    if (this.page < this.lastPage) {
                        this.page++;
                        this.fetchProducts();
                    }
                },

                prevPage() {
                    if (this.page > 1) {
                        this.page--;
                        this.fetchProducts();
                    }
                },

                changePerPage(val) {
                    this.perPage = val;
                    this.page = 1;
                    this.fetchProducts();
                },

                getImage(item) {
                    if (item.image_url) return item.image_url;
                    // if (item.images?.length) return item.images[0].path;
                    return '/build/img/image-not-found.jpg';
                },

                formatRupiah(val) {
                    if (!val) return '-';
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(val);
                },

                formatDate(datetime) {
                    if (!datetime) return '-';

                    const date = new Date(datetime);

                    return new Intl.DateTimeFormat('id-ID', {
                        year: 'numeric',
                        month: 'short',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit'
                    }).format(date);
                },
            }
        }
    </script>
@endsection
