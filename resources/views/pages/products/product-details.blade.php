<?php $page = 'product-details'; ?>
@extends('pages.layout.mainlayout')

@section('content')
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
                    <div class="card">
                        <div class="card-body">

                            <!-- LOADING -->
                            <div x-show="loading">Loading...</div>

                            <!-- DATA -->
                            <div class="productdetails" x-show="!loading && item">
                                <ul class="product-bar">

                                    <li>
                                        <h4>Product</h4>
                                        <h6 x-text="item.name"></h6>
                                    </li>

                                    <li>
                                        <h4>Category</h4>
                                        <h6 x-text="formatCategory(item.category)"></h6>
                                    </li>

                                    <li x-show="item.subcategory">
                                        <h4>Sub Category</h4>
                                        <h6 x-text="formatCategory(item.subcategory)"></h6>
                                    </li>

                                    <li>
                                        <h4>Brand</h4>
                                        <h6 x-text="formatCategory(item.brand)"></h6>
                                    </li>

                                    <li>
                                        <h4>Unit</h4>
                                        <h6 x-text="item.unit"></h6>
                                    </li>

                                    <li>
                                        <h4>SKU</h4>
                                        <h6 x-text="item.sku"></h6>
                                    </li>

                                    <li>
                                        <h4>Minimum Qty</h4>
                                        <h6 x-text="item.stock_min + ' ' + item.unit"></h6>
                                    </li>

                                    <li>
                                        <h4>Quantity</h4>
                                        <h6 x-text="item.stock + ' ' + item.unit"></h6>
                                    </li>

                                    <li>
                                        <h4>Basic Price</h4>
                                        <h6 x-text="item.basic_price"></h6>
                                    </li>

                                    <li>
                                        <h4>Sell Price</h4>
                                        <h6 x-text="item.sell_price"></h6>
                                    </li>

                                    <li>
                                        <h4>Status</h4>
                                        <h6 x-text="item.availability ?? mapStatus(item.status)"></h6>
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

                <!-- 🔥 RIGHT (IMAGES) -->
                <div class="col-lg-4 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="slider-product-details">

                                <div class="owl-carousel owl-theme product-slide" x-ref="carousel">

                                    <template x-for="img in (item?.images || [])" :key="img.id">
                                        <div class="slider-product">
                                            <img :src="img.path" alt="img">
                                            <h4 x-text="img.name || ''"></h4>
                                            <h6 x-text="img.description || ''"></h6>
                                        </div>
                                    </template>

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
