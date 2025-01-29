<?php $page = 'product-details'; ?>
@extends('pages.layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product Details</h4>
                    <h6>Full details of a product</h6>
                </div>
            </div>
            <!-- /add -->
            <div class="row">
                <div class="col-lg-8 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="bar-code-view d-none">
                                <img src="{{ URL::asset('/build/img/barcode/barcode1.png') }}" alt="barcode">
                                <a class="printimg">
                                    <img src="{{ URL::asset('/build/img/icons/printer.svg') }}" alt="print">
                                </a>
                            </div>
                            <div class="productdetails">
                                <ul class="product-bar">
                                    <li>
                                        <h4>Product</h4>
                                        <h6>{{$item['name']}}</h6>
                                    </li>
                                    <li>
                                        <h4>Category</h4>
                                        <h6>{{$item['category']['name']}}</h6>
                                    </li>
                                    <li>
                                        <h4>Sub Category</h4>
                                        <h6>{{$item['subcategory']['name']}}</h6>
                                    </li>
                                    <li>
                                        <h4>Brand</h4>
                                        <h6>{{$item['brand']['name']}}</h6>
                                    </li>
                                    <li>
                                        <h4>Unit</h4>
                                        <h6>{{$item['unit']}}</h6>
                                    </li>
                                    <li>
                                        <h4>SKU</h4>
                                        <h6>{{$item['sku']}}</h6>
                                    </li>
                                    <li>
                                        <h4>Minimum Qty</h4>
                                        <h6>{{$item['stock_min']}}</h6>
                                    </li>
                                    <li>
                                        <h4>Quantity</h4>
                                        <h6>{{$item['stock']}}</h6>
                                    </li>
                                    {{-- <li>
                                        <h4>Tax</h4>
                                        <h6>0.00 %</h6>
                                    </li> --}}
                                    {{-- <li>
                                        <h4>Discount Type</h4>
                                        <h6>Percentage</h6>
                                    </li> --}}
                                    <li>
                                        <h4>Basic Price</h4>
                                        <h6>{{$item['basic_price']}}</h6>
                                    </li>
                                    <li>
                                        <h4>Sell Price</h4>
                                        <h6>{{$item['sell_price']}}</h6>
                                    </li>
                                    <li>
                                        <h4>Status</h4>
                                        <h6>{{$item['status']}}</h6>
                                    </li>
                                    <li>
                                        <h4>Description</h4>
                                        <h6>{{$item['description']}}</h6>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="slider-product-details">
                                <div class="owl-carousel owl-theme product-slide">
                                    @foreach($item['images'] as $image)
                                        <div class="slider-product">
                                            <img src="{{ $image['path'] }}" alt="img">
                                            <h4>{{$image['name']}}</h4>
                                            <h6>{{$image['description']}}</h6>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /add -->
        </div>
    </div>
@endsection
