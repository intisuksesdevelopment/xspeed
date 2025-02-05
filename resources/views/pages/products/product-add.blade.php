<?php $page = 'product-add'; ?>
@extends('pages.layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        @component('pages.components.breadcrumb')
        @slot('title')
        New Product
        @endslot
        @slot('li_1')
        Create new product
        @endslot
        @slot('li_2')
        {{ url('product') }}
        @endslot
        @slot('li_3')
        Back to Product
        @endslot
        @endcomponent
        <!-- /add -->
        <form id="productAddForm" method="post" action="{{ route('product-add') }}">
            @csrf
            <div class="card">
                <div class="card-body add-product pb-0">
                    <div class="accordion-card-one accordion" id="accordionExample">
                        <div class="accordion-item">
                            <div class="accordion-header" id="headingOne">
                                <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                    aria-controls="collapseOne">
                                    <div class="addproduct-icon">
                                        <h5><i data-feather="info" class="add-info"></i><span>Product Information</span>
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
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Product Name</label>
                                                <input type="text" class="form-control" name="name">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Warehouse</label>
                                                <select class="select2 form-control" id="warehouse_id" name="warehouse_id">
                                                    @foreach($warehouses as $warehouse)
                                                    <option value="{{ $warehouse['id']}}" selected>{{
                                                        $warehouse['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Rack</label>
                                                <select class="select2 form-control" id="rack_id" name="rack_id">
                                                    @foreach($racks as $rack)
                                                    <option value="{{ $rack['id']}}" selected>{{ $rack['name']}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="addservice-info">
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <div class="add-newplus">
                                                        <label class="form-label">Brand</label>
                                                        <a href="javascript:void(0);" data-bs-toggle="modal"
                                                            data-bs-target="#add-units-brand"><i
                                                                data-feather="plus-circle"
                                                                class="plus-down-add"></i><span>Add New</span></a>
                                                    </div>
                                                    <select class="select2 form-control" id="brand_id" name="brand_id">
                                                        @foreach($brands as $brand)
                                                        <option value="{{ $brand['id']}}" selected>{{ $brand['name']}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <div class="add-newplus">
                                                        <label class="form-label">Category</label>
                                                        <a href="javascript:void(0);" data-bs-toggle="modal"
                                                            data-bs-target="#add-units-category"><i
                                                                data-feather="plus-circle"
                                                                class="plus-down-add"></i><span>Add
                                                                New</span></a>
                                                    </div>
                                                    <select class="select2 form-control" name="category_id"
                                                        id="category_id">
                                                        @foreach($categories as $category)
                                                        <option value="{{ $category['id']}}" selected>{{
                                                            $category['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Sub Category</label>
                                                    <select class="select2 form-control" name="subcategory_id"
                                                        id="subcategory_id">
                                                        {{-- @foreach($subcategories as $subcategory)
                                                        <option value="{{ $subcategory['id']}}" selected>{{
                                                            $subcategory['name']}}</option>
                                                        @endforeach --}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add-product-new">
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <div class="add-newplus">
                                                        <label class="form-label">Unit</label>
                                                        <a href="javascript:void(0);" data-bs-toggle="modal"
                                                            data-bs-target="#add-unit"><i data-feather="plus-circle"
                                                                class="plus-down-add"></i><span>Add New</span></a>
                                                    </div>
                                                    <select class="select2 form-control" name="unit">

                                                        @foreach($units as $unit)
                                                        <option value="{{ $unit['unit']}}" selected>{{ $unit['unit'].' -
                                                            '.$unit['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="input-blocks add-product list">
                                                    <label>Sku</label>
                                                    <input type="text" class="form-control list"
                                                        placeholder="Please Enter Item Code" name="sku" id="sku-input">
                                                    <button type="submit" class="btn btn-primaryadd"
                                                        id="generate-sku-btn">
                                                        Generate Sku
                                                    </button>
                                                </div>

                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="input-blocks add-product list">
                                                    <label>Barcode</label>
                                                    <input type="text" class="form-control list"
                                                        placeholder="Please Enter Item Barcode" name="barcode" id="barcode-input">
                                                    <button type="submit" class="btn btn-primaryadd"
                                                        id="generate-barcode-btn">
                                                        Generate Barcode
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Color</label>
                                                    <input type="text" class="form-control" name="color">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- Editor -->
                                    <div class="col-lg-12">
                                        <div class="input-blocks summer-description-box transfer mb-3">
                                            <label>Description</label>
                                            <textarea class="form-control h-100" rows="5" name="desc"></textarea>
                                            <p class="mt-1">Maximum 60 Characters</p>
                                        </div>
                                    </div>
                                    <!-- /Editor -->
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
                                            <h5><i data-feather="life-buoy" class="add-info"></i><span>Pricing &
                                                    Stocks</span></h5>
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
                                                <div class="col-lg-4 col-sm-6 col-12">
                                                    <div class="input-blocks add-product">
                                                        <label>Basic Price</label>
                                                        <input type="number" class="form-control" value="0"
                                                            name="basic_price">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12">
                                                    <div class="input-blocks add-product">
                                                        <label>Sell Price</label>
                                                        <input type="number" class="form-control" value="0"
                                                            name="sell_price">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12">
                                                    <div class="mb-3 add-product">
                                                        <label class="form-label">Currency</label>
                                                        <select class="select2 form-control" name="currency">
                                                            <option value="IDR" selected>Indonesian Rupiah (IDR)
                                                            </option>
                                                            <option value="USD">US Dollar (USD)</option>
                                                            <option value="EUR">Euro (EUR)</option>
                                                            <option value="JPY">Japanese Yen (JPY)</option>
                                                            <option value="MYR">Malaysian Ringgit (MYR)</option>
                                                            <option value="THB">Thai Baht (THB)</option>
                                                            <option value="SGD">Singapore Dollar (SGD)</option>
                                                            <option value="CNY">Chinese Yuan (CNY)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4 col-sm-6 col-12">
                                                    <div class="input-blocks add-product">
                                                        <label>Quantity</label>
                                                        <input type="number" class="form-control" value="0"
                                                            name="stock">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12">
                                                    <div class="input-blocks add-product">
                                                        <label>Quantity Alert</label>
                                                        <input type="number" class="form-control" value="0"
                                                            name="stock_min">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12">
                                                    <div class="mb-3 add-product">
                                                        <label class="form-label">Status</label>
                                                        <select class="select form-control" name="status">
                                                            <option value="0" selected>Available</option>
                                                            <option value="1">Not Available</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-card-one accordion" id="accordionExample3">
                                                <div class="accordion-item">
                                                    <div class="accordion-header" id="headingThree">
                                                        <div class="accordion-button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseThree"
                                                            aria-controls="collapseThree">
                                                            <div class="addproduct-icon list">
                                                                <h5><i data-feather="image"
                                                                        class="add-info"></i><span>Images</span></h5>
                                                                <a href="javascript:void(0);"><i
                                                                        data-feather="chevron-down"
                                                                        class="chevron-down-add"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="collapseThree" class="accordion-collapse collapse show"
                                                        aria-labelledby="headingThree"
                                                        data-bs-parent="#accordionExample3">
                                                        <div class="accordion-body">
                                                            <div class="text-editor add-list add">
                                                                <div class="col-lg-12">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-6 col-12">
                                                            <div class="input-blocks add-product">
                                                                <label>Url Imaage 1</label>
                                                                <input type="text" class="form-control" name="image1">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-6 col-12">
                                                            <div class="input-blocks add-product">
                                                                <label>Url Imaage 2</label>
                                                                <input type="text" class="form-control" name="image2">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-6 col-12">
                                                            <div class="input-blocks add-product">
                                                                <label>Url Imaage 3</label>
                                                                <input type="text" class="form-control" name="image3">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-6 col-12">
                                                            <div class="input-blocks add-product">
                                                                <label>Url Imaage 4</label>
                                                                <input type="text" class="form-control" name="image4">
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
    document.addEventListener('DOMContentLoaded', function() {
        var categories = @json($categories);
        var subcategories = @json($subcategories);
        var brands = @json($brands);
        // Event listener for category dropdown change
        $('#category_id').on('change', function() {
            var selectedCategoryId = $(this).val();
            $('#subcategory_id').empty();
            $.each(subcategories, function(index, subcategory) {
                if (subcategory.category_id == selectedCategoryId) {
                    var option = $('<option>', {
                        value: subcategory.id,
                        text: subcategory.name
                    });
                    $('#subcategory_id').append(option);

                    // Select the first option that is appended
                    if (index === 0) {
                        $('#subcategory_id').val(subcategory.id);
                    }
                }
            });
        });
// Example function to generate a SKU (you can customize this as needed)
    function generateSKU(category, brand, id) {
        const catCode = category.replace(/\s+/g, '').toUpperCase();
        const brandCode = brand.replace(/\s+/g, '').toUpperCase();
        const uniqueId = id.toString();
        return `${catCode}-${brandCode}-${uniqueId}`;
    }

    document.getElementById('generate-sku-btn').addEventListener('click', function(event) {
        event.preventDefault();

        var categoryCode = (categories.find(cat => cat.id == $('#category_id').val()) != null) ? categories.find(cat => cat.id == $('#category_id').val()).code : 'common';
        var brandCode = (brands.find(brand => brand.id == $('#brand_id').val()) != null) ? brands.find(brand => brand.id == $('#brand_id').val()).code : '';

        const id = Math.floor(Math.random() * 1000000);

        const sku = generateSKU(categoryCode, brandCode, id);
        document.getElementById('sku-input').value = sku;
    });
    document.getElementById('generate-barcode-btn').addEventListener('click', function(event) {
        event.preventDefault();
        var timestampValue = Math.floor(Date.now() / 1000); 
        document.getElementById('barcode-input').value = timestampValue;
    });

    $('#category_id').trigger('change');
    submitForm('productAddForm', 'submit-add-button',null,null);
    });
</script>
@endsection