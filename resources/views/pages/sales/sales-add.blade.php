<?php $page = 'sales-add'; ?>
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
        <form id="salesAddForm" method="post" action="{{ route('sales-add') }}">
            @csrf
            <div class="card">
                <div class="page-wrapper p-0 m-0">
                    <div class="content p-0">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4> Add Sales</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <form action="sales-list">
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="input-blocks">
                                                <label>Customer Name</label>
                                                <div class="row">
                                                    <div class="col-lg-10 col-sm-10 col-10">
                                                        <select class="select">
                                                            <option>Choose</option>
                                                            <option>Customer Name</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                                        <div class="add-icon">
                                                            <a href="#" class="choose-add"><i
                                                                    data-feather="plus-circle"
                                                                    class="plus"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="input-blocks">
                                                <label>Date</label>
                                                <div class="input-groupicon calender-input">
                                                    <i data-feather="calendar" class="info-img"></i>
                                                    <input type="text" class="datetimepicker"
                                                        placeholder="Choose">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="input-blocks">
                                                <label>Supplier</label>
                                                <select class="select">
                                                    <option>Choose</option>
                                                    <option>Supplier Name</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-sm-6 col-12">
                                            <div class="input-blocks">
                                                <label>Product Name</label>
                                                <div class="input-groupicon select-code">
                                                    <input type="text"
                                                        placeholder="Please type product code and select">
                                                    <div class="addonset">
                                                        <img src="{{ URL::asset('/build/img/icons/qrcode-scan.svg')}}" alt="img">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive no-pagination">
                                        <table class="table  datanew">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Qty</th>
                                                    <th>Purchase Price($)</th>
                                                    <th>Discount($)</th>
                                                    <th>Tax(%)</th>
                                                    <th>Tax Amount($)</th>
                                                    <th>Unit Cost($)</th>
                                                    <th>Total Cost(%)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 ms-auto">
                                            <div class="total-order w-100 max-widthauto m-auto mb-4">
                                                <ul>
                                                    <li>
                                                        <h4>Order Tax</h4>
                                                        <h5>$ 0.00</h5>
                                                    </li>
                                                    <li>
                                                        <h4>Discount</h4>
                                                        <h5>$ 0.00</h5>
                                                    </li>
                                                    <li>
                                                        <h4>Shipping</h4>
                                                        <h5>$ 0.00</h5>
                                                    </li>
                                                    <li>
                                                        <h4>Grand Total</h4>
                                                        <h5>$ 0.00</h5>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <div class="input-blocks">
                                                <label>Order Tax</label>
                                                <div class="input-groupicon select-code">
                                                    <input type="text" value="0" class="p-2">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <div class="input-blocks">
                                                <label>Discount</label>
                                                <div class="input-groupicon select-code">
                                                    <input type="text" value="0" class="p-2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <div class="input-blocks">
                                                <label>Shipping</label>
                                                <div class="input-groupicon select-code">
                                                    <input type="text" value="0" class="p-2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <div class="input-blocks mb-5">
                                                <label>Status</label>
                                                <select class="select">
                                                    <option>Choose</option>
                                                    <option>Completed</option>
                                                    <option>Inprogress</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-end">
                                            <button type="button" class="btn btn-cancel add-cancel me-3"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-submit add-sale">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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