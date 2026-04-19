<?php $page = 'product-details'; ?>
@extends('pages.layout.mainlayout')

@section('content')
    <style>
        .card-modern {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .label {
            font-size: 12px;
            color: #888;
            margin-bottom: 4px;
        }

        .value {
            font-weight: 600;
            font-size: 14px;
        }

        .price {
            font-size: 22px;
            font-weight: bold;
            color: #0d6efd;
        }

        .badge-modern {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        .product-image {
            border-radius: 12px;
            overflow: hidden;
            background: #f8f9fa;
            padding: 10px;
        }

        .product-image img {
            width: 100%;
            border-radius: 10px;
            object-fit: cover;
        }
    </style>
    <div class="page-wrapper" x-data="productDetail()" x-init="fetchItem()">

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product Details</h4>
                    <h6>Full details of a product</h6>
                </div>
            </div>

            <div class="row">
                <!-- 🔥 LEFT -->
                <div class="col-lg-8 col-sm-12">
                    <div class="card card-modern">
                        <div class="card-body">

                            <!-- LOADING -->
                            <div x-show="loading" class="placeholder-glow">
                                <div class="placeholder col-12 mb-2"></div>
                                <div class="placeholder col-8 mb-2"></div>
                                <div class="placeholder col-6"></div>
                            </div>

                            <!-- DATA -->
                            <div class="productdetails" x-show="!loading && item">
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <div class="label">Product</div>
                                        <div class="value" x-text="item.name"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="label">SKU</div>
                                        <div class="value" x-text="item.sku || '-'"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="label">Category</div>
                                        <div class="value" x-text="formatCategory(item.category)"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="label">Brand</div>
                                        <div class="value" x-text="formatCategory(item.brand)"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="label">Stock</div>
                                        <div class="value" x-text="item.stock + ' ' + item.unit"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="label">Min Stock</div>
                                        <div class="value" x-text="item.stock_min + ' ' + item.unit"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="label">Sell Price</div>
                                        <div class="price" x-text="formatRupiah(item.sell_price)"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="label">Status</div>
                                        <span class="badge badge-modern"
                                            :class="item.status == 1 ? 'bg-success' : 'bg-danger'"
                                            x-text="item.status == 1 ? 'Active' : 'Inactive'">
                                        </span>
                                    </div>

                                    <div class="col-12">
                                        <div class="label">Description</div>
                                        <div class="value" x-text="item.description || '-'"></div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- 🔥 RIGHT (IMAGES) -->
                <div class="col-lg-4 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="slider-product-details">

                                <div class="owl-carousel owl-theme product-slide" x-ref="carousel">

                                    <div class="product-image">
                                        <template x-for="img in (item?.images || [])" :key="img.id">
                                            <img :src="img.path" class="mb-2">
                                        </template>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- 🔥 ALPINE -->
    <script>
        let uuid = window.location.pathname.split('/').pop();

        function productDetail() {
            return {
                item: null,
                loading: true,

                async fetchItem() {
                    try {
                        const url = `/api/product/detail/${uuid}`;

                        const res = await fetch(url);
                        const json = await res.json();

                        this.item = json.data;

                        this.$nextTick(() => {
                            if (this.item?.images?.length) {
                                $(this.$refs.carousel).owlCarousel({
                                    items: 1,
                                    loop: true,
                                    nav: true
                                });
                            }
                        });

                        this.item = json.data;

                        this.$nextTick(() => {
                            if (this.item?.images?.length) {
                                $(this.$refs.carousel).owlCarousel({
                                    items: 1,
                                    loop: true,
                                    nav: true
                                });
                            }
                        });

                    } catch (e) {
                        console.error('Error:', e);
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
@endsection
