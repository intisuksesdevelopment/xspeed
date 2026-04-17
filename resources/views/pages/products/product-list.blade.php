<?php $page = 'product-list'; ?>
@extends('pages.layout.mainlayout')

@section('content')
    <div class="page-wrapper" x-data="productTable()" x-init="init()">
        <div class="content">

            <!-- FILTER -->
            <div class="table-top">

                <!-- SEARCH -->
                <input type="text" class="form-control" placeholder="Search..." x-model="filters.search"
                    @keyup.debounce.500ms="fetchProducts()">

                <!-- SELECT -->
                <div class="d-flex gap-2 mt-2">

                    <!-- WAREHOUSE -->
                    <select class="form-control" x-model="filters.warehouse" @change="fetchProducts()">

                        <option value="">Warehouse</option>

                        <template x-for="w in warehouses" :key="w.code">
                            <option :value="w.code" x-text="w.name"></option>
                        </template>
                    </select>

                    <!-- BRAND -->
                    <select class="form-control" x-model="filters.brand" @change="fetchProducts()">

                        <option value="">Brand</option>

                        <template x-for="b in brands" :key="b.code">
                            <option :value="b.code" x-text="b.name"></option>
                        </template>
                    </select>

                    <!-- SORT -->
                    <select class="form-control" x-model="filters.sort" @change="fetchProducts()">
                        <option value="desc">Newest</option>
                        <option value="asc">Oldest</option>
                    </select>

                </div>
            </div>

            <!-- TABLE -->
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th class="no-sort">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all">
                                <span class="checkmarks"></span>
                            </label>
                        </th>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Sell Price</th>
                        <th>Unit</th>
                        <th>Qty</th>
                        <th>Created by</th>
                        <th>Created at</th>
                        <th>Status</th>
                        <th class="no-sort">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- LOADING -->
                    <tr x-show="loading" x-cloak>
                        <td colspan="12" class="text-center py-3">
                            Loading...
                        </td>
                    </tr>

                    <!-- EMPTY STATE -->
                    <tr x-show="!loading && items.length === 0" x-cloak>
                        <td colspan="12" class="text-center py-3">
                            No data found
                        </td>
                    </tr>

                    <!-- DATA -->
                    <template x-for="item in items" :key="item.uuid">
                        <tr>

                            <!-- CHECKBOX -->
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox" :value="item.uuid" x-model="selected">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>

                            <!-- PRODUCT -->
                            <td>
                                <div class="productimgname">

                                    <a href="javascript:void(0);" class="product-img stock-img">
                                        <img :src="getImage(item)" alt="product" class="img-fluid rounded">
                                    </a>

                                    <a href="javascript:void(0);" class="product-name" x-text="item.name"
                                        :title="item.name"></a>
                                </div>
                            </td>

                            <td x-text="item.sku"></td>
                            <td x-text="item.category?.code ?? '-'"></td>
                            <td x-text="item.brand?.code ?? '-'"></td>
                            <td x-text="formatRupiah(item.sell_price)"></td>
                            <td x-text="item.unit"></td>
                            <td x-text="item.stock"></td>
                            <td x-text="item.created_by ?? '-'"></td>
                            <td x-text="formatDate(item.created_at)"></td>
                            <!-- STATUS -->
                            <td>
                                <span class="badge" :class="item.status == 0 ? 'badge-linesuccess' : 'badge-linedanger'"
                                    x-text="item.availability">
                                </span>
                            </td>

                            <!-- ACTION -->
                            <td>
                                <div class="edit-delete-action">

                                    <a class="me-2 edit-icon p-2" :href="`${PRODUCT_DETAIL_BASE}/${item.uuid}`"
                                        @click="$nextTick(() => feather.replace())">
                                        <i data-feather="eye"></i>
                                    </a>
                                    <a class="me-2 p-2" :href="item.uuid ? `${ROUTES.productEdit}/${item.uuid}` : '#'">
                                        <i data-feather="edit"></i>
                                    </a>
                                    <a class="p-2" href="javascript:void(0);" @click="deleteItem(item.uuid)">
                                        <i data-feather="trash-2"></i>
                                    </a>

                                </div>
                            </td>

                        </tr>
                    </template>

                </tbody>
            </table>

        </div>
    </div>

    <!-- 🚀 ALPINE SCRIPT -->
    <script>
        const PRODUCT_DETAIL_BASE = "{{ url('admin/product/detail') }}";
        const ROUTES = {
            productDetail: (uuid) => `{{ url('admin/product/detail') }}/${uuid}`,
            productEdit: (uuid) => `{{ url('admin/product/edit') }}/${uuid}`,
        };
        const API_PRODUCT_URL = "{{ route('api-product-paged') }}";
        const API_BRAND_URL = "{{ route('api-brand-all') }}";
        const API_CATEGORY_URL = "{{ route('api-category-all') }}";
        const API_WAREHOUSE_URL = "{{ route('api-warehouse-all') }}";

        function productTable() {
            return {
                items: [],
                warehouses: [],
                brands: [],
                loading: false,
                selected: [],
                selectAll: false,
                page: 1,
                lastPage: 1,
                total: 0,
                filters: {
                    search: '',
                    warehouse: '',
                    brand: '',
                    sort: 'desc'
                },

                // INIT (sekali jalan)
                async init() {
                    if (this.initialized) return;

                    this.initialized = true;
                    await Promise.all([
                        this.fetchWarehouses(),
                        this.fetchBrands(),
                    ]);
                    this.fetchProducts();
                },

                // 🔥 FETCH FILTER (warehouse + brand)
                async fetchWarehouses() {
                    try {
                        let res = await fetch(API_WAREHOUSE_URL);
                        let data = await res.json();

                        this.warehouses = data.warehouses;

                    } catch (e) {
                        console.error(e);
                    }
                },
                async fetchBrands() {
                    try {
                        const res = await fetch(API_BRAND_URL);
                        let data = await res.json();
                        this.brands = data.brands;
                    } catch (e) {
                        console.error('Filter error:', e);
                    }
                },
                getImage(item) {
                    if (item.image_url) return item.image_url;

                    if (item.images && item.images.length > 0) {
                        return item.images[0].path;
                    }

                    return '/build/img/image-not-found.jpg';
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
                formatRupiah(value) {
                    if (!value) return '-';

                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(value);
                },
                watchSelectAll() {
                    if (this.selectAll) {
                        this.selected = this.items.map(i => i.uuid);
                    } else {
                        this.selected = [];
                    }
                },

                // 🔥 FETCH PRODUCT
                async fetchProducts() {
                    if (this.controller) {
                        this.controller.abort();
                    }
                    this.controller = new AbortController();
                    this.loading = true;

                    try {
                        let params = new URLSearchParams({
                            ...this.filters,
                            page: this.page
                        });

                        let res = await fetch(`/api/product/paged?${params}`);
                        let result = await res.json();

                        // 🔥 penting: ambil nested data
                        let paginated = result.data;

                        this.items = paginated.data;
                        this.page = paginated.current_page;
                        this.lastPage = Math.ceil(paginated.total / paginated.per_page);
                        this.total = paginated.total;

                    } catch (e) {
                        console.error(e);
                    }

                    this.loading = false;
                    this.$nextTick(() => {
                        if (window.feather) feather.replace();
                    });
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
                }

            }

        }
    </script>
@endsection
