<?php $page = 'stock-add'; ?>
@extends('pages.layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        @component('pages.components.breadcrumb')
        @slot('title')
        New Stock Opname
        @endslot
        @slot('li_1')
        Create new Stock Opname
        @endslot
        @slot('li_2')
        {{ url('product') }}
        @endslot
        @slot('li_3')
        Back to Stock
        @endslot
        @endcomponent
        <!-- /add -->
        <form id="stockAddForm" method="post" action="{{ route('stock-add') }}">
            @csrf
            <div class="card">
                <div class="card-body add-product pb-0">
                    <div class="accordion-card-one accordion" id="accordionExample">
                        <div class="accordion-item">
                            <div class="accordion-header" id="headingOne">
                                <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                    aria-controls="collapseOne">
                                    <div class="addproduct-icon">
                                        <h5><i data-feather="info" class="add-info"></i><span>Stock Information</span>
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
                                            <div class="input-blocks">
                                                <label class="form-label">Reference No.</label>
                                                <input type="text" class="form-control" id="periode" name="periode"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Warehouse</label>
                                                <select class="select2 form-control" id="warehouse_id"
                                                    name="warehouse_id">
                                                    @foreach($warehouses as $warehouse)
                                                    <option value="{{ $warehouse['id']}}" selected>{{
                                                        $warehouse['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="input-blocks">
                                                <label>Date</label>
                                                <div class="input-groupicon calender-input">
                                                    <i data-feather="calendar" class="info-img"></i>
                                                    <input type="text" class="datetimepicker" id="date"
                                                        placeholder="Choose">
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
                                            <h5><i data-feather="life-buoy" class="add-info"></i><span>Product</span></h5>
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
                                                    <div class="input-blocks">
                                                        <label class="form-label">Category</label>
                                                        <select class="select2 form-control" id="category_id"
                                                            name="category_id">
                                                            <option value="" disabled selected>Select a category</option>
                                                            @foreach($categories as $category)
                                                            <option value="{{ $category['id']}}" >{{
                                                                $category['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12">
                                                    <div class="input-blocks">
                                                        <label class="form-label">Sub Category</label>
                                                        <select class="select2 form-control" id="subcategory_id"
                                                            name="subcategory_id">
                                                            <option value="" disabled selected>Select a sub category</option>

                                                            @foreach($subcategories as $subcategory)
                                                            <option value="{{ $subcategory['id']}}" >{{
                                                                $subcategory['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12">
                                                    <div class="input-blocks">
                                                        <label class="form-label">Brand</label>
                                                        <select class="select2 form-control" id="brand_id"
                                                            name="brand_id">
                                                            <option value="" disabled selected>Select a brand</option>
                                                            @foreach($brands as $brand)
                                                            <option value="{{ $brand['id']}}" >{{
                                                                $brand['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-sm-6 col-12">
                                                    <div class="input-blocks">
                                                        <label class="form-label">Product</label>
                                                        <select class="select2 form-control" id="product_id" name="product_id">
                                                            <option value="" disabled selected>Select a product</option>
                                                            @foreach($items as $item)
                                                            <option value="{{ $item['uuid']}}">{{ $item['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 col-sm-6 col-12">
                                                    <div class="input-blocks">
                                                        <label class="form-label">&nbsp;</label>                                                      
                                                        <button type="button" class="btn btn-primaryadd"
                                                        id="add-item-btn">
                                                        Add Product
                                                    </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                <div class="modal-body-table">
                                                    <div class="table-responsive">
                                                        <table class="table" id="stock-table">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2">Product Name</th>
                                                                    <th rowspan="2">Sku</th>
                                                                    <th colspan="2" class="text-center">QTY</th>
                                                                    <th colspan="2" class="text-center">Price</th>
                                                                    <th rowspan="2">Action</th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-center">Before</th>
                                                                    <th class="text-center">Count</th>
                                                                    <th class="text-end">Buy</th>
                                                                    <th class="text-end">Diff</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                             
                                                            </tbody>
                                                        </table>
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
        var warehouses = @json($warehouses);
        var categories = @json($categories);
        var subcategories = @json($subcategories);
        var items = @json($items);

        $('#product-carousel').owlCarousel({
            items: 1,
            loop: true,
            margin: 10,
            nav: true,
            dots: true
        });
        
        let productList = [
            
        ];
        function renderTable() {
            $('#stock-table tbody').empty();
            productList.forEach(product => {
                const newRow = `
                    <tr>
                        <td>
                            <div class="productimgname">
                                <a href="javascript:void(0);" class="product-img stock-img">
                                    <img src="${product.image_url}" alt="product">
                                </a>
                                <a href="javascript:void(0);">${product.name}</a>
                            </div>
                        </td>
                        <td>${product.sku}</td>
                        <td class="text-center">${clearDecimal(product.stock)}</td>
                        <td class="text-center">
                            <div class="product-quantity">
                                 <input type="text" class="quntity-input" id="input-${product.sku}" value="${clearDecimal(product.stock)}">
                            </div>
                        </td>
                        <td class="text-end">${formatRupiah(product.stock * product.basic_price)}</td>
                        <td class="text-end" id="total-${product.sku}">0,00</td>

                        <td class="action-table-data">
                            <div class="edit-delete-action">
                                <a class="me-2 p-2" href="#" data-bs-toggle="modal"
                                    data-bs-target="#detail-product" data-sku="${product.sku}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye action-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </a>
                                
                                <a class="me-2 p-2" data-bs-toggle="modal" data-bs-target="#edit-units">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </a>
                                <a class="confirm-text p-2" href="javascript:void(0);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
                $('#stock-table tbody').append(newRow);
            });
        }
        renderTable();

        $('#stock-table').on('input', '.quntity-input', function() {
            const sku = $(this).attr('id').split('-')[1]; // Extract SKU from ID
            const newCount = parseInt($(this).val());
            const product = productList.find(p => p.sku === sku);
            const existingProduct = productList.find(product => product.sku === sku);


            // Update total price
            const newTotal = (newCount * product.basic_price)-(product.stock * product.basic_price);
            existingProduct.count =newTotal;
            $(`#total-${sku}`).text(formatRupiah(newTotal));
        });
        $('#stock-table').on('click', '[data-bs-toggle="modal"]', function() {
            const sku = this.getAttribute('data-sku')
            const product = productList.find(p => p.sku === sku);

            // Populate the modal with product details
            $('#modal-product-name').text(product.name);
            $('#modal-product-category').text(product.category.code + ' - ' + product.category.name);
            $('#modal-product-subcategory').text(product.subcategory ? product.subcategory.code + ' - ' + product.subcategory.name : '');
            $('#modal-product-brand').text(product.brand.code + ' - ' + product.brand.name);
            $('#modal-product-unit').text(product.unit);
            $('#modal-product-sku').text(product.sku);
            $('#modal-product-min-qty').text(product.stock_min + ' ' + product.unit);
            $('#modal-product-qty').text(product.stock + ' ' + product.unit);
            $('#modal-product-basic-price').text(product.basic_price);
            $('#modal-product-sell-price').text(product.sell_price);
            $('#modal-product-status').text(product.status);
            $('#modal-product-description').text(product.description);
                // Clear previous images
            $('#product-carousel').trigger('destroy.owl.carousel'); // Destroy the carousel
            $('#product-carousel').html(''); 

            // Populate the image slider with product images
            product.images.forEach(image => {
                const imageSlide = `
                <div class="slider-product">
                    <img src="${image.path}" alt="img">
                    <h4>${image.name}</h4>
                    <h6>${image.description}</h6>
                </div>
                `;
                $('#product-carousel').append(imageSlide);
            });
            // Reinitialize Owl Carousel after adding new images
            $('#product-carousel').owlCarousel({
                        items: 1,
                        loop: true,
                        margin: 10,
                        nav: true,
                        dots: true
                    });        
        });
        function generateRandomNumber() {
                return Math.floor(Math.random() * 900) + 100;
        }

        
        function formatDate(date) {
                const day = ("0" + date.getDate()).slice(-2);
                const month = ("0" + (date.getMonth() + 1)).slice(-2);
                const year = date.getFullYear();
                return `${day}-${month}-${year}`;
        }
        $('#warehouse_id').on('change', function() {
            
                const currentDate = new Date();
                const formattedDate = formatDate(currentDate);

                const warehouseCode = (warehouses.find(war => war.id == $('#warehouse_id').val()) != null) ? warehouses.find(war => war.id == $('#warehouse_id').val()).code : 'common';

                const unixTimestamp = Math.floor(currentDate.getTime() / 1000);
                const randomNumber = generateRandomNumber();
                const periode = `${warehouseCode}-${unixTimestamp}${randomNumber}`;

                $('#date').val(formattedDate);
                $('#periode').val(periode);
        });
        $('#category_id').on('change', function() {
                const selectedCategoryId = $(this).val();

                // Filter subcategories based on selected category
                $('#subcategory_id option').each(function() {
                    const subcategoryCategoryId = $(this).data('category-id');
                    if (subcategoryCategoryId == selectedCategoryId) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                $('#subcategory_id').val('');
                $('#subcategory_id').trigger('change');
            });

            $('#subcategory_id, #brand_id').on('change', function() {
                filterProducts();
            });

            $('#product_id').on('select2:open', function() {
                filterProducts();
            });

            function filterProducts() {
                const selectedCategoryId = $('#category_id').val();
                const selectedSubcategoryId = $('#subcategory_id').val();
                const selectedBrandId = $('#brand_id').val();

                // Filter products based on selected category, subcategory, and brand
                $('#product_id').html('<option value="" disabled selected>Select a product</option>'); // Clear existing options

                items.forEach(function(item) {
                    if ((!selectedCategoryId || item.category_id == selectedCategoryId) &&
                        (!selectedSubcategoryId || item.subcategory_id == selectedSubcategoryId) &&
                        (!selectedBrandId || item.brand_id == selectedBrandId)) {
                        const option = `<option value="${item.uuid}" data-category-id="${item.category_id}" data-subcategory-id="${item.subcategory_id}" data-brand-id="${item.brand_id}">${item.name}</option>`;
                        $('#product_id').append(option);
                    }
                });

                $('#product_id').trigger('change.select2');
            }
        $('#warehouse_id').trigger('change');
        $('#add-item-btn').on('click', function () {
                const selectedProductId = $('#product_id').val();

                if (!selectedProductId) {
                    alert("Please select a product.");
                    return;
                }

                // Get the selected item from the items array
                const selectedItem = items.find(item => item.uuid === selectedProductId);
                selectedItem.count = selectedItem.stock;
                if (!selectedItem) {
                    alert("Selected product not found.");
                    return;
                }

                const selectedProductName = selectedItem.name;
                const selectedProductSku = selectedItem.sku;

                
                const existingProduct = productList.find(product => product.sku === selectedProductSku.sku);
                
                // If the product doesn't exist, add it to the list
                if (!existingProduct) {
                    productList.push(selectedItem);
                    renderTable(); // Refresh the table to include the new product
                } else {
                    console.log('Product with this SKU already exists');
                }
            });

     });
   </script>
@endsection