<?php $page = 'product-list'; ?>
@extends('pages.layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        @component('components.breadcrumb')
        @slot('title')
        Product List
        @endslot
        @slot('li_1')
        Manage your products
        @endslot
        @slot('li_2')
        {{ url('add-product') }}
        @endslot
        @slot('li_3')
        Add New Product
        @endslot
        @slot('li_4')
        Import Product
        @endslot
        @endcomponent

        <!-- /product list -->
        <div class="card table-list-card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a href="javascript:void(0);" class="btn btn-searchset"><i data-feather="search"
                                    class="feather-search"></i></a>
                        </div>
                    </div>
                    <div class="search-path">
                        <a class="btn btn-filter" id="filter_search">
                            <i data-feather="filter" class="filter-icon"></i>
                            <span><img src="{{ URL::asset('/build/img/icons/closes.svg') }}" alt="img"></span>
                        </a>
                    </div>
                    <div class="form-sort">
                        <i data-feather="sliders" class="info-img"></i>
                        <select class="select">
                            <option>Sort by Date</option>
                            <option>14 09 23</option>
                            <option>11 09 23</option>
                        </select>
                    </div>
                </div>
                <!-- /Filter -->
                <div class="card mb-0" id="filter_inputs">
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <div class="row">
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="input-blocks">
                                            <i data-feather="box" class="info-img"></i>
                                            <select class="select">
                                                <option>Choose Product</option>
                                                <option>
                                                    Lenovo 3rd Generation</option>
                                                <option>Nike Jordan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="input-blocks">
                                            <i data-feather="stop-circle" class="info-img"></i>
                                            <select class="select">
                                                <option>Choose Categroy</option>
                                                <option>Laptop</option>
                                                <option>Shoe</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="input-blocks">
                                            <i data-feather="git-merge" class="info-img"></i>
                                            <select class="select">
                                                <option>Choose Sub Category</option>
                                                <option>Computers</option>
                                                <option>Fruits</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="input-blocks">
                                            <i data-feather="stop-circle" class="info-img"></i>
                                            <select class="select">
                                                <option>All Brand</option>
                                                <option>Lenovo</option>
                                                <option>Nike</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="input-blocks">
                                            <i class="fas fa-money-bill info-img"></i>
                                            <select class="select">
                                                <option>Price</option>
                                                <option>$12500.00</option>
                                                <option>$12500.00</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="input-blocks">
                                            <a class="btn btn-filters ms-auto"> <i data-feather="search"
                                                    class="feather-search"></i> Search </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Filter -->
                <div class="table-responsive product-list">
                    <table class="table datanew">
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
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>
                                    <div class="productimgname">
                                        @if ($item['image_url']!=null)
                                            <a href="javascript:void(0);" class="product-img stock-img">
                                                <img src="{{ $item['image_url'] }}" alt="product">
                                            </a>
                                            <a href="javascript:void(0);">{{$item['name']}}</a>

                                        @else
                                            @foreach($item['images'] as $image)
                                                @if ($loop->index == 0)
                                                    <a href="javascript:void(0);" class="product-img stock-img">
                                                        <img src="{{ $image['path'] }}" alt="product">
                                                    </a>
                                                    <a href="javascript:void(0);">{{$item['name']}}</a>

                                                @endif
                                            @endforeach
                                        @endif


                                       
                                    </div>
                                </td>
                                <td>{{ $item['sku']}}</td>
                                <td>{{ $item['category']['code']}}</td>
                                <td>{{ $item['brand']['code']}}</td>
                                <td>{{ $item['sell_price']}}</td>
                                <td>{{ $item['unit']}}</td>
                                <td>{{ $item['stock']}}</td>
                                <td>{{ $item['created_by']}}</td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 edit-icon p-2" href="{{ route('product-detail', ['uuid' => $item['uuid']]) }}">
                                            <i data-feather="eye" class="action-eye"></i>
                                        </a>                                        
                                        <a class="me-2 p-2" href="{{ route('product-edit-form', ['uuid' => $item['uuid']]) }}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a class="p-2" href="javascript:void(0);" onclick="deleteProduct({{ $item['id']}})">
                                            <i data-feather="trash-2" class="feather-trash-2"></i>
                                        </a>        
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /product list -->
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.deleteProduct = function(id) {
                deleteData(`{{ route('item-delete', ':id') }}`, id, document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            };
    });
</script>
@endsection