<?php $page = 'order-add'; ?>
@extends('pages.layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        @component('pages.components.breadcrumb')
        @slot('title')
        New Order
        @endslot
        @slot('li_1')
        Create new order
        @endslot
        @slot('li_2')
        {{ url('order') }}
        @endslot
        @slot('li_3')
        Back to Order
        @endslot
        @endcomponent
        <!-- /add -->
        <form id="orderAddForm" method="post" action="{{ route('order-add') }}">
            @csrf
            <div class="card">
                <div class="card-body add-product pb-0">
                    <div class="accordion-card-one accordion" id="accordionExample">
                        <div class="accordion-item">
                            <div class="accordion-header" id="headingOne">
                                <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                    aria-controls="collapseOne">
                                    <div class="addproduct-icon">
                                        <h5><i data-feather="info" class="add-info"></i><span>Order Information</span>
                                        </h5>
                                        <a href="javascript:void(0);"><i data-feather="chevron-down"
                                                class="chevron-down-add"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <span>Transaction ID : #<span id="transaction-id" ></span></span>
                                            <span class="d-none">Transaction ID : #<input id="trx_id" name="trx_id"></span>
                                            <span class="d-none">Transaction ID : #<input id="type" name="type" value="sales"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Supplier</label>
                                                <select class="select2 form-control" id="supplier-select" name="supplier_id">
                                                    @foreach($suppliers as $supplier)
                                                    <option value="{{ $supplier['uuid']}}" selected>{{
                                                        $supplier['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Contact Sales</label>
                                                <select class="select2 form-control" id="contact-select" name="contact_id">
                                                 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="mb-3 add-product">
                                                    <div class="flex flex-row content-center gap-2 font-bold text-xs uppercase text-primarydark">
                                                        <span class="font-medium">Nama :</span><span class="" id="contact-name">Jakson</span>
                                                    </div>
                                                    <div class="flex flex-row content-center gap-2 font-bold text-xs uppercase text-primarydark">
                                                        <span class="font-medium">Divisi :</span><span class="" id="contact-position">admin</span>
                                                    </div>
                                                    <div class="flex flex-row content-center gap-2 pb-1 border-b-2 border-primarydark font-bold text-xs uppercase text-primarydark">
                                                        <span class="font-medium">Telepon :</span><span class="text-[10px] font-semibold" id="contact-phone">08123456789</span>
                                                    </div>
                                                    <div>
                                                        <span class="font-bold uppercase text-primarydark" id="supplier-name"></span>
                                                    </div>
                                                    <div>
                                                        <span class=" uppercase text-primarydark text-[10px] font-semibold" id="supplier-address"></span>
                                                    </div>
                                                    <div>
                                                        <span class=" text-primarydark text-[10px] font-semibold" id="supplier-email"></span>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-card-one accordion" id="accordionExample2">
                        <div class="accordion-item">
                            <div class="accordion-header" id="headingTwo">
                                <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                    aria-controls="collapseTwo">
                                    <div class="text-editor add-list">
                                        <div class="addproduct-icon list icon">
                                            <h5><i data-feather="life-buoy" class="add-info"></i><span>Product Orders</span></h5>
                                            <a href="javascript:void(0);"><i data-feather="chevron-down"
                                                    class="chevron-down-add"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample2">
                                <div class="accordion-body">
                                    <div class="input-blocks add-products">
                                        <div class="single-pill-product">
                                            <ul class="nav nav-pills" id="pills-tab1" role="tablist">
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                            aria-labelledby="pills-home-tab">
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-6 col-12">
                                                    <div class="table-responsive product-list">
                                                        <table class="table datanew  table-hover">
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
                                                                    <th>Stock</th>
                                                                    <th>Created by</th>
                                                                    <th>Status</th>
                                                                    <th class="no-sort">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                               
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 col-sm-6 col-12">
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12">
                                                    <div class="order-total">
                                                        <table class="table table-responsive table-borderless">
                                                            <tr>
                                                                <td>Sub Total</td>
                                                                <td class="text-end" id="subtotal">0,00</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tax (<span id="tax-value">10</span>%)</td>
                                                                <td class="text-end" id="tax">0,00</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Shipping</td>
                                                                <td class="text-end" id="shipping">0,00</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="danger">Discount (<span id="discount-value">0</span>%)</td>
                                                                <td class="danger text-end" id="discount">0,00</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Total</td>
                                                                <td class="text-end"><span  id="total">0,00</span> IDR</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    
                                                    <div class="d-grid btn-block">
                                                        <a class="btn btn-secondary" href="javascript:void(0);">
                                                            Grand Total : <span id="grandtotal">0,00</span><span> IDR</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="btn-addproduct mb-4">
                    <button type="button" class="btn btn-cancel me-2"
                        onclick="window.location.href='{{ url('product') }}'">Cancel</button>
                    <button type="submit" class="btn btn-submit" id="submit-add-button">Save Product</button>
                </div>
            </div>
        </form>
        <!-- /add -->

    </div>
</div>
<script>

        const encodedItems = "{{ base64_encode(json_encode($items)) }}";
        const encodedBrands = "{{ base64_encode(json_encode($brands)) }}";
        const encodedCategories = "{{ base64_encode(json_encode($categories)) }}";
        const encodedSubcategories = "{{ base64_encode(json_encode($subcategories)) }}";
        const productCategoryRoute = @json(route('product-category', ['category_id' => 'CATEGORY_ID']));
       
</script>
@endsection