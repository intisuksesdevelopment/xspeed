<?php $page = 'add-product'; ?>
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
        product-list
        @endslot
        @slot('li_3')
        Back to Product
        @endslot
        @endcomponent
        <!-- /add -->
        <form id="productEditForm" method="post" action="{{ route('product-edit') }}">
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
                                            <div class="mb-3 d-none">
                                                <label class="form-label">uuid</label>
                                                <input type="text" name="uuid" value="{{ $item['uuid'] }}"
                                                    class="form-control">
                                            </div>
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Product Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ $item['name'] }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Warehouse</label>
                                                <select class="select2 form-control" name="warehouse_id">
                                                    @foreach($warehouses as $warehouse)
                                                    @if($warehouse['id'] == $item['warehouse_id'])
                                                    <option value="{{ $warehouse['id']}}" selected>{{
                                                        $warehouse['name']}}</option>
                                                    @else
                                                    <option value="{{ $warehouse['id']}}">{{ $warehouse['name']}}
                                                    </option>
                                                    @endif

                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Rack</label>
                                                <select class="select2 form-control" name="rack_id">
                                                    @foreach($racks as $rack)
                                                    @if($rack['id'] == $item['rack_id'])
                                                    <option value="{{ $rack['id']}}" selected>{{ $rack['name']}}
                                                    </option>
                                                    @else
                                                    <option value="{{ $rack['id']}}">{{ $rack['name']}}</option>
                                                    @endif
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
                                                    <select class="select2 form-control" name="brand_id">
                                                        @foreach($brands as $brand)
                                                        @if ($brand['id'] == $item['brand_id'])
                                                        <option value="{{ $brand['id']}}" selected>{{ $brand['name']}}
                                                        </option>
                                                        @else
                                                        <option value="{{ $brand['id']}}">{{ $brand['name']}}</option>
                                                        @endif
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
                                                        @if($category['id'] == $item['category_id'])
                                                        <option value="{{ $category['id']}}" selected>{{
                                                            $category['name']}}</option>
                                                        @else
                                                        <option value="{{ $category['id']}}">{{ $category['name']}}
                                                        </option>
                                                        @endif
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
                                                        @if($unit['unit'] == $item['unit'])
                                                        <option value="{{ $unit['unit']}}" selected>{{ $unit['unit'].' -
                                                            '.$unit['name']}}</option>
                                                        @else
                                                        <option value="{{ $unit['unit']}}">{{ $unit['unit'].' -
                                                            '.$unit['name']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="input-blocks add-product list">
                                                    <label>Sku</label>
                                                    <input type="text" class="form-control list"
                                                        value="{{ $item['sku'] }}" placeholder="Please Enter Item Code"
                                                        name="sku">
                                                    <button type="submit" class="btn btn-primaryadd">
                                                        Generate Sku
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Barcode</label>
                                                    <input type="text" class="form-control" name="barcode"
                                                        value="{{ $item['barcode'] }}">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Color</label>
                                                    <input type="text" class="form-control" name="color"
                                                        value="{{ $item['color'] }}">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- Editor -->
                                    <div class="col-lg-12">
                                        <div class="input-blocks summer-description-box transfer mb-3">
                                            <label>Description</label>
                                            <textarea class="form-control h-100" rows="5" name="description">{{ $item['description'] }}</textarea>
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
                                                        <input type="number" class="form-control"
                                                            value="{{ $item['basic_price'] }}" name="basic_price">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12">
                                                    <div class="input-blocks add-product">
                                                        <label>Sell Price</label>
                                                        <input type="number" class="form-control"
                                                            value="{{ $item['sell_price'] }}" name="sell_price">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12">
                                                    <div class="mb-3 add-product">
                                                        <label class="form-label">Currency</label>
                                                        <select class="select2 form-control" name="currency">
                                                            @if($item['currency'])
                                                            <option value="{{ $item['currency'] }}" selected>{{
                                                                $item['currency'] }}</option>
                                                            @endif
                                                            <option value="IDR">Indonesian Rupiah (IDR)</option>
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
                                                        <input type="number" class="form-control"
                                                            value={{ $item['stock'] }} name="stock">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12">
                                                    <div class="input-blocks add-product">
                                                        <label>Quantity Alert</label>
                                                        <input type="number" class="form-control"
                                                            value={{ $item['stock_min'] }} name="stock_min">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12">
                                                    <div class="mb-3 add-product">
                                                        <label class="form-label">Status</label>
                                                        <select class="select form-control" name="status">
                                                            <option value="0" {{ $item['status']==0 ? 'selected' : ''
                                                                }}>Available</option>
                                                            <option value="1" {{ $item['status']==1 ? 'selected' : ''
                                                                }}>Deleted</option>
                                                            <option value="2" {{ $item['status']==2 ? 'selected' : ''
                                                                }}>Not Active</option>
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
                                                                    <div class="add-choosen">
                                                                        @foreach($item['images'] as $index => $image)
                                                                            <div class="phone-img">
                                                                                <img src="{{ $image['path'] }}" alt="image" id="image{{ $index }}">
                                                                                <a href="javascript:void(0);"><i data-feather="x" class="x-square-add remove-product"></i></a>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-3">
                                                    @for ($i = 0; $i < 4; $i++)
                                                        <div class="col-lg-3 col-sm-6 col-12">
                                                            <div class="input-blocks add-product">
                                                                <label>Url Image {{ $i + 1 }}</label>
                                                                <input type="text" class="form-control" name="image{{ $i }}" value="{{ isset($item['images'][$i]) ? $item['images'][$i]['path'] : '' }}">
                                                            </div>
                                                        </div>
                                                    @endfor

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
                    <button type="button" class="btn btn-cancel me-2">Cancel</button>
                    <button type="submit" class="btn btn-submit" id="submit-edit-button">Edit Product</button>
                </div>
            </div>
        </form>
        <!-- /add -->

    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var subcategories = @json($subcategories);
        $('#category_id').trigger('change');
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

        // Trigger change event on page load to filter subcategories for the selected category
        $('#category_id').trigger('change');
        submitForm('productEditForm', 'submit-edit-button',null,'{{ route("product") }}');
    });
</script>
@endsection