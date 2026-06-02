<?php $page = 'stock-edit'; ?>
@extends('pages.layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            @component('pages.components.breadcrumb')
                @slot('title')
                    {{ __('label.header.stock_edit') }}
                @endslot
                @slot('li_1')
                    {{ __('label.header.stock_update') }}
                @endslot
                @slot('li_2')
                    {{ url('stock') }}
                @endslot
                @slot('li_3')
                    Back to Stock
                @endslot
            @endcomponent
            <!-- /edit -->
            <form id="stockEditForm" method="post" action="{{ route('stock-update', $stock->uuid ?? '') }}">
                @csrf
                <input type="hidden" name="stock_id" value="{{ $stock->uuid ?? '' }}">
                <div class="card">
                    <div class="card-body add-product pb-0">
                        <!-- Stock Information Accordion -->
                        <div class="accordion-card-one accordion" id="accordionExample">
                            <div class="accordion-item">
                                <div class="accordion-header" id="headingOne">
                                    <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                        aria-controls="collapseOne">
                                        <div class="addproduct-icon">
                                            <h5><i data-feather="info"
                                                    class="add-info"></i><span>{{ __('label.stock_information') }}</span>
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
                                                    <label class="form-label">{{ __('common.reference_no') }}</label>
                                                    <input type="hidden" name="periode" value="{{ $stock->periode ?? '' }}">
                                                    <input type="text" class="form-control" id="periode" name="periode_display"
                                                        value="{{ $stock->periode ?? '' }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">{{ __('common.warehouse') }}</label>
                                                    <select class="select2 form-control" id="warehouse_id"
                                                        name="warehouse_id">
                                                        <option value="" disabled>{{ __('label.select.warehouse') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">{{ __('common.date') }}</label>
                                                    <div class="input-groupicon calender-input">
                                                        <i data-feather="calendar" class="info-img"></i>
                                                        <input type="text" class="datetimepicker" id="date"
                                                            placeholder="Choose" value="{{ $stock->created_at ? \Carbon\Carbon::parse($stock->created_at)->format('d-m-Y H:i') : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">{{ __('common.status') }}</label>
                                                    <select class="select2 form-control" id="status" name="status">
                                                        <option value="2" {{ ($stock->status ?? 2) == 2 ? 'selected' : '' }}>Waiting</option>
                                                        <option value="0" {{ ($stock->status ?? 2) == 0 ? 'selected' : '' }}>Success</option>
                                                        <option value="1" {{ ($stock->status ?? 2) == 1 ? 'selected' : '' }}>Rejected</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Select Products Accordion -->
                        <div class="accordion-card-one accordion" id="accordionExample2">
                            <div class="accordion-item">
                                <div class="accordion-header" id="headingTwo">
                                    <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                        aria-controls="collapseTwo">
                                        <div class="addproduct-icon">
                                            <h5><i data-feather="package"
                                                    class="add-info"></i><span>{{ __('label.select.product') }}</span>
                                            </h5>
                                            <a href="javascript:void(0);"><i data-feather="chevron-down"
                                                    class="chevron-down-add"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample2">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">{{ __('common.category') }}</label>
                                                    <select class="select2 form-control" id="category_id"
                                                        name="category_id">
                                                        <option value="" disabled selected>
                                                            {{ __('label.select.category') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">{{ __('common.sub_category') }}</label>
                                                    <select class="select2 form-control" id="subcategory_id"
                                                        name="subcategory_id">
                                                        <option value="" disabled selected>
                                                            {{ __('label.select.subcategory') }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">{{ __('common.brand') }}</label>
                                                    <select class="select2 form-control" id="brand_id" name="brand_id">
                                                        <option value="" disabled selected>
                                                            {{ __('label.select.brand') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-10 col-sm-8 col-12">
                                                <div class="input-blocks add-product">
                                                    <label class="form-label">{{ __('common.product') }}</label>
                                                    <select class="form-control" id="product_id" name="product_id">
                                                        <option value="" disabled selected>Select a product</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-4 col-12">
                                                <div class="input-blocks add-product">
                                                    <label class="form-label">&nbsp;</label>
                                                    <button type="button" class="btn btn-primary w-100"
                                                        id="add-item-btn">
                                                        <i data-feather="plus" class="me-1"></i> {{ __('common.add') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Added Products Table Accordion -->
                        <div class="accordion-card-one accordion" id="accordionExample3">
                            <div class="accordion-item">
                                <div class="accordion-header" id="headingThree">
                                    <div class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-controls="collapseThree">
                                        <div class="addproduct-icon">
                                            <h5><i data-feather="list" class="add-info"></i><span>Added Products</span>
                                                <span class="badge bg-primary ms-2" id="product-count">0 items</span>
                                            </h5>
                                            <a href="javascript:void(0);"><i data-feather="chevron-down"
                                                    class="chevron-down-add"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseThree" class="accordion-collapse collapse show"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample3">
                                    <div class="accordion-body">
                                        <div class="table-responsive">
                                            <table class="table" id="stock-table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 50px;">#</th>
                                                        <th>{{ __('common.product') }}</th>
                                                        <th class="text-center">{{ __('common.before') }}</th>
                                                        <th class="text-center">{{ __('common.count') }}</th>
                                                        <th class="text-end">{{ __('common.buy_price') }}</th>
                                                        <th class="text-end">{{ __('common.diff') }}</th>
                                                        <th class="text-center" style="width: 150px;">
                                                            {{ __('common.rack') }}</th>
                                                        <th class="text-center" style="width: 80px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="stock-table-body">
                                                    <tr class="empty-state-row">
                                                        <td colspan="8" class="text-center py-5">
                                                            <div class="empty-state">
                                                                <i data-feather="package"
                                                                    class="feather-lg text-muted mb-3"></i>
                                                                <p class="text-muted mb-0">No products added yet. Select
                                                                    products above to add.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden Input -->
                        <input type="hidden" id="products" name="products" class="form-control">

                        <!-- Action Buttons -->
                        <div class="col-lg-12">
                            <div class="btn-addproduct mb-4">
                                <button type="button" class="btn btn-cancel me-2"
                                    onclick="window.location.href='{{ url('admin/stock') }}'">{{ __('label.cancel') }}</button>
                                <button type="submit" class="btn btn-submit me-2" name="submit_action" value="save"
                                    id="submit-save-button">
                                    <i data-feather="save" class="me-1"></i> {{ __('label.save') }}
                                </button>
                                <button type="submit" class="btn btn-primary" name="submit_action" value="accept"
                                    id="submit-accept-button">
                                    <i data-feather="check-circle" class="me-1"></i> {{ __('label.accept') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /edit -->
        </div>
    </div>
    <script>
        // Pre-populated products from the stock being edited
        const initialProducts = {!! json_encode($stockProducts ?? []) !!};
        const selectedWarehouse = {!! json_encode($stock->warehouse_id ?? null) !!};
        const updateUrl = "{{ route('stock-update', $stock->uuid ?? '') }}";

        document.addEventListener('DOMContentLoaded', function() {
            let productList = [];
            let warehouses = [];
            let categories = [];
            let subcategories = [];
            let brands = [];
            let racks = [];
            let selectedProductData = null;

            // Fetch dropdown data from API (products loaded via AJAX Select2)
            // Fire requests immediately, populate as each resolves
            (async function initDropdowns() {
                const loadingHtml = '<option value="" disabled>Loading...</option>';

                const warehouseSelect = $('#warehouse_id').html(loadingHtml);
                const categorySelect = $('#category_id').html(loadingHtml);
                const subcategorySelect = $('#subcategory_id').html(loadingHtml);
                const brandSelect = $('#brand_id').html(loadingHtml);

                try {
                    const [
                        warehouseRes,
                        categoryRes,
                        subcategoryRes,
                        brandRes,
                        rackRes
                    ] = await Promise.all([
                        fetch('{{ route('api-warehouses') }}'),
                        fetch('{{ route('api-categories') }}'),
                        fetch('{{ route('api-subcategory-all') }}'),
                        fetch('{{ route('api-brand-all') }}'),
                        fetch('{{ route('api-rack-all') }}')
                    ]);

                    const [
                        warehouseData,
                        categoryData,
                        subcategoryData,
                        brandData,
                        rackData
                    ] = await Promise.all([
                        warehouseRes.json(),
                        categoryRes.json(),
                        subcategoryRes.json(),
                        brandRes.json(),
                        rackRes.json()
                    ]);

                    // Warehouses
                    warehouses = extractDataList(warehouseData);

                    warehouseSelect.html(
                        '<option value="" disabled>{{ __('label.select.warehouse') }}</option>'
                    );

                    warehouseSelect.append(
                        warehouses.map(w =>
                            `<option value="${w.id}" ${selectedWarehouse == w.id ? 'selected' : ''}>${w.name}</option>`
                        ).join('')
                    );

                    // Categories
                    categories = extractDataList(categoryData);

                    categorySelect.html(
                        '<option value="" disabled selected>{{ __('label.select.category') }}</option>'
                    );

                    categorySelect.append(
                        categories.map(c =>
                            `<option value="${c.id}">${c.name}</option>`
                        ).join('')
                    );

                    // Subcategories
                    subcategories = extractDataList(subcategoryData);

                    subcategorySelect.html(
                        '<option value="" disabled selected>{{ __('label.select.subcategory') }}</option>'
                    );

                    subcategorySelect.append(
                        subcategories.map(s =>
                            `<option value="${s.id}" data-category-id="${s.category_id}">
                    ${s.name}
                </option>`
                        ).join('')
                    );

                    // Brands
                    brands = extractDataList(brandData);

                    brandSelect.html(
                        '<option value="" disabled selected>{{ __('label.select.brand') }}</option>'
                    );

                    brandSelect.append(
                        brands.map(b =>
                            `<option value="${b.id}">${b.name}</option>`
                        ).join('')
                    );

                    // Racks
                    racks = extractDataList(rackData);

                    // Refresh Select2 sekali saja
                    warehouseSelect.trigger('change.select2');
                    categorySelect.trigger('change.select2');
                    subcategorySelect.trigger('change.select2');
                    brandSelect.trigger('change.select2');

                } catch (error) {
                    console.error('Dropdown initialization error:', error);
                }

                // Load initial products after dropdowns are ready
                loadInitialProducts();
                initProductSelect();
            })();

            function extractDataList(response) {
                if (response && response.original) {
                    const o = response.original;
                    if (Array.isArray(o.data)) return o.data;
                    if (Array.isArray(o)) return o;
                }
                if (response && Array.isArray(response.data)) return response.data;
                if (Array.isArray(response)) return response;
                return [];
            }

            // Load initial products from the stock being edited
            function loadInitialProducts() {
                if (initialProducts && initialProducts.length > 0) {
                    productList = initialProducts.map(p => ({
                        uuid: p.uuid,
                        name: p.name,
                        sku: p.sku,
                        stock: parseFloat(p.stock) || 0,
                        basic_price: parseFloat(p.basic_price) || 0,
                        image_url: p.image_url || '',
                        count: parseFloat(p.count) || 0,
                        rack: p.rack || ''
                    }));
                    renderTable();
                }
            }

            function initProductSelect() {
                const $productSelect = $('#product_id');
                console.log('Product select element:', $productSelect.length ? 'Found' : 'NOT FOUND');

                if ($productSelect.data('select2')) {
                    console.log('Select2 already initialized, destroying...');
                    $productSelect.select2('destroy');
                }

                console.log('Initializing Select2...');
                $productSelect.select2({
                    width: '100%',
                    placeholder: 'Search product by name or SKU...',
                    allowClear: true,
                    minimumInputLength: 0,
                    language: {
                        searching: function() {
                            return 'Searching products...';
                        },
                        noResults: function() {
                            return 'No products found';
                        }
                    },
                    ajax: {
                        url: '{{ route('api-items') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            console.log('Select2 request:', params);
                            return {
                                search: params.term || '',
                                page: params.page || 1,
                                category_id: $('#category_id').val() || '',
                                subcategory_id: $('#subcategory_id').val() || '',
                                brand_id: $('#brand_id').val() || '',
                            };
                        },
                        processResults: function(data, params) {
                            console.log('Select2 response:', data);
                            return {
                                results: data.results || [],
                                pagination: data.pagination || { more: false }
                            };
                        },
                        error: function(xhr, status, error) {
                            console.error('Select2 AJAX error:', status, error);
                            console.log('Response:', xhr.responseText);
                        },
                        cache: false,
                    },
                    templateResult: function(data) {
                        if (data.loading) {
                            return $(
                                '<span class="text-muted"><i class="fa fa-spinner fa-spin me-1"></i> Searching...</span>'
                            );
                        }
                        if (!data.text) {
                            return $('<span class="text-muted"></span>').text(data.text ||
                                'Type to search...');
                        }

                        const $wrapper = $('<span class="d-flex align-items-center gap-2"></span>');
                        if (data.sku) {
                            $wrapper.append($('<strong class=" me-1"></strong>').text('[' + data
                                .sku +
                                ']'));
                        }
                        $wrapper.append($('<span></span>').text(data.text));
                        return $wrapper;
                    },
                    templateSelection: function(data) {
                        if (!data.text) return data.text;
                        return data.sku ? '[' + data.sku + '] ' + data.text : data.text;
                    }
                }).on('select2:select', function(e) {
                    // Store the full selected product data for when user clicks Add
                    selectedProductData = e.params.data;
                });
            }

            function removeProduct(sku) {
                productList = productList.filter(product => product.sku !== sku);
                renderTable();
                showSuccess('Product removed successfully.');
            }

            function renderTable() {
                const tbody = $('#stock-table-body');
                tbody.empty();

                // Update product count
                $('#product-count').text(`${productList.length} item${productList.length !== 1 ? 's' : ''}`);

                if (productList.length === 0) {
                    tbody.html(`
                    <tr class="empty-state-row">
                        <td colspan="8" class="text-center py-5">
                            <div class="empty-state">
                                <i data-feather="package" class="feather-lg text-muted mb-3"></i>
                                <p class="text-muted mb-0">No products added yet. Select products above to add.</p>
                            </div>
                        </td>
                    </tr>
                `);
                    // Reinitialize feather icons
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                    document.getElementById('products').value = '[]';
                    return;
                }

                let index = 1;
                productList.forEach(product => {
                    const basicPrice = parseFloat(product.basic_price) || 0;
                    const stockQty = parseFloat(product.stock) || 0;
                    const countQty = parseFloat(product.count) || 0;
                    const buyPriceTotal = basicPrice * stockQty;

                    const row = `
                    <tr data-sku="${product.sku}">
                        <td class="text-center text-muted">${index}</td>
                        <td>
                            <div class="productimgname d-flex align-items-center gap-2">
                                <img src="${product.image_url}" alt="${product.name}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <span class="d-block fw-medium">${product.name}</span>
                                    <small class="text-muted">${product.sku}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">${clearDecimal(stockQty)}</td>
                        <td class="text-center" style="width: 120px;">
                            <input type="text" class="form-control form-control-sm text-center quantity-input"
                                   id="input-${product.sku}" value="${clearDecimal(countQty)}">
                        </td>
                        <td class="text-end">${formatRupiah(buyPriceTotal)}</td>
                        <td class="text-end" id="total-${product.sku}">${formatRupiah((countQty - stockQty) * basicPrice)}</td>
                        <td style="width: 150px;">
                            <select class="select2 form-control form-control-sm rack-select" id="rack-${product.sku}">
                                <option value="">Select Rack</option>
                                ${racks.map(rack => `<option value="${rack.id}" ${product.rack == rack.id ? 'selected' : ''}>${rack.name}</option>`).join('')}
                            </select>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeProduct('${product.sku}')" title="Remove">
                                    <i data-feather="trash-2" class="feather-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                    tbody.append(row);
                    index++;
                });

                // Reinitialize feather icons and select2
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
                $('.rack-select').select2({
                    width: '100%',
                    placeholder: 'Select Rack'
                });

                const productListJson = JSON.stringify(productList);
                document.getElementById('products').value = productListJson;
            }

            // Initial render
            renderTable();

            // Quantity input change handler
            $('#stock-table-body').on('input', '.quantity-input', function() {
                const sku = $(this).attr('id').split('-')[1];
                const newCount = parseInt($(this).val());
                const product = productList.find(p => p.sku === sku);

                if (product) {
                    // Update total difference
                    const diff = newCount - parseFloat(product.stock);
                    const newTotal = diff * product.basic_price;
                    product.count = newCount;
                    $(`#total-${sku}`).text(formatRupiah(newTotal));
                    updateHiddenInput();
                }
            });

            // Rack change handler
            $('#stock-table-body').on('change', '.rack-select', function() {
                const sku = $(this).attr('id').split('-')[1];
                const product = productList.find(p => p.sku === sku);
                if (product) {
                    product.rack = $(this).val();
                    updateHiddenInput();
                }
            });

            function updateHiddenInput() {
                document.getElementById('products').value = JSON.stringify(productList);
            }

            // Category change handler - filter subcategories and products
            $('#category_id').on('change', function() {
                const selectedCategoryId = $(this).val();

                $('#subcategory_id option').each(function() {
                    const subcategoryCategoryId = $(this).data('category-id');
                    if (selectedCategoryId && subcategoryCategoryId == selectedCategoryId) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                $('#subcategory_id').val('');
                $('#subcategory_id').trigger('change');
                refreshProductSelect();
            });

            // Subcategory and Brand change handler
            $('#subcategory_id, #brand_id').on('change', function() {
                refreshProductSelect();
            });

            // Clear product selection when filters change - AJAX will auto-refetch with new params
            function refreshProductSelect() {
                selectedProductData = null;
                $('#product_id').val(null).trigger('change');
            }

            // Add item button click
            $('#add-item-btn').on('click', function() {
                const selected = selectedProductData;

                if (!selected || !selected.id) {
                    showWarning("Please select a product.");
                    return;
                }

                // Check if product already exists
                if (productList.find(p => p.sku === selected.sku)) {
                    showWarning("Product already exists in the list.");
                    return;
                }

                // Add product to list
                const product = {
                    uuid: selected.id,
                    name: selected.text,
                    sku: selected.sku,
                    stock: parseFloat(selected.stock) || 0,
                    basic_price: parseFloat(selected.basic_price) || 0,
                    image_url: selected.image_url || '',
                    count: parseFloat(selected.stock) || 0
                };

                productList.push(product);
                renderTable();
                // showSuccess('Product added successfully.');

                // Reset product selection
                selectedProductData = null;
                $('#product_id').val(null).trigger('change');
            });

            // Form submit handler
            document.getElementById('stockEditForm').addEventListener('submit', function(event) {
                event.preventDefault();

                const form = this;
                const formData = new FormData(form);
                const submitAction = formData.get('submit_action');
                const submitButton = submitAction === 'accept' ?
                    document.getElementById('submit-accept-button') :
                    document.getElementById('submit-save-button');

                submitButton.disabled = true;

                // Set the status based on action
                if (submitAction === 'accept') {
                    formData.set('status', '0'); // Success/Approved
                } else {
                    formData.set('status', '2'); // Waiting/Pending
                }

                Swal.fire({
                    title: "Processing...",
                    text: submitAction === 'accept' ? "Accepting stock..." : "Saving stock...",
                    icon: "info",
                    showConfirmButton: false,
                    allowOutsideClick: false
                });

                // Validate warehouse is selected
                const warehouseId = document.getElementById('warehouse_id').value;
                if (!warehouseId) {
                    Swal.close();
                    submitButton.disabled = false;
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Please select a warehouse before submitting.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validate product list
                if (productList.length === 0) {
                    Swal.close();
                    submitButton.disabled = false;
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Product list is empty. Please add at least one product.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                fetch(updateUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.close();
                        submitButton.disabled = false;

                        const modalId = data.success ? 'success-alert-modal' : 'danger-alert-modal';
                        const messageId = data.success ? 'success-message' : 'danger-message';
                        let modalMessage = data.success ? data.message : 'Submission failed';

                        // Handle nested error messages
                        if (!data.success && data.message) {
                            if (typeof data.message === 'object') {
                                modalMessage = Object.values(data.message).flat().join(', ');
                            } else {
                                modalMessage = data.message;
                            }
                        }

                        document.getElementById(messageId).textContent = modalMessage;
                        new bootstrap.Modal(document.getElementById(modalId)).show();

                        if (data.success) {
                            setTimeout(() => {
                                window.location.href = '{{ route('stock-list') }}';
                            }, 2000);
                        }
                    }).catch(error => {
                        Swal.close();
                        submitButton.disabled = false;
                        document.getElementById('danger-message').textContent = error.message ||
                            'An error occurred';
                        new bootstrap.Modal(document.getElementById('danger-alert-modal')).show();
                        console.error('Submission failed:', error);
                    });
            });

            // Expose removeProduct to global scope for onclick handlers
            window.removeProduct = function(sku) {
                productList = productList.filter(product => product.sku !== sku);
                renderTable();
                showSuccess('Product removed successfully.');
            };

            // Helper function to generate random number
            function generateRandomNumber() {
                return Math.floor(Math.random() * 900) + 100;
            }

            // Helper function to format date
            function formatDate(date) {
                const day = ("0" + date.getDate()).slice(-2);
                const month = ("0" + (date.getMonth() + 1)).slice(-2);
                const year = date.getFullYear();
                return `${day}-${month}-${year}`;
            }
        });
    </script>
@endsection
