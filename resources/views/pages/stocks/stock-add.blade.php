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
        {{ url('stock') }}
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
                    <!-- Stock Information Accordion -->
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
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Reference No.</label>
                                                <input type="text" class="form-control" id="periode" name="periode" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Warehouse</label>
                                                <select class="select2 form-control" id="warehouse_id" name="warehouse_id">
                                                    <option value="" disabled selected>Select a warehouse</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Date</label>
                                                <div class="input-groupicon calender-input">
                                                    <i data-feather="calendar" class="info-img"></i>
                                                    <input type="text" class="datetimepicker" id="date" placeholder="Choose">
                                                </div>
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
                                        <h5><i data-feather="package" class="add-info"></i><span>Select Products</span>
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
                                                <label class="form-label">Category</label>
                                                <select class="select2 form-control" id="category_id" name="category_id">
                                                    <option value="" disabled selected>Select a category</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Sub Category</label>
                                                <select class="select2 form-control" id="subcategory_id" name="subcategory_id">
                                                    <option value="" disabled selected>Select a sub category</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Brand</label>
                                                <select class="select2 form-control" id="brand_id" name="brand_id">
                                                    <option value="" disabled selected>Select a brand</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-10 col-sm-8 col-12">
                                            <div class="input-blocks add-product">
                                                <label class="form-label">Product</label>
                                                <select class="form-control" id="product_id" name="product_id">
                                                    <option value="" disabled selected>Select a product</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-4 col-12">
                                            <div class="input-blocks add-product">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="button" class="btn btn-primary w-100" id="add-item-btn">
                                                    <i data-feather="plus" class="me-1"></i> Add
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
                                <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                    aria-controls="collapseThree">
                                    <div class="addproduct-icon">
                                        <h5><i data-feather="list" class="add-info"></i><span>Added Products</span>
                                            <span class="badge bg-primary ms-2" id="product-count">0 items</span>
                                        </h5>
                                        <a href="javascript:void(0);"><i data-feather="chevron-down"
                                                class="chevron-down-add"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample3">
                                <div class="accordion-body">
                                    <div class="table-responsive">
                                        <table class="table" id="stock-table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="text-center" style="width: 50px;">#</th>
                                                    <th>Product</th>
                                                    <th class="text-center">Before</th>
                                                    <th class="text-center">Count</th>
                                                    <th class="text-end">Buy Price</th>
                                                    <th class="text-end">Diff</th>
                                                    <th class="text-center" style="width: 150px;">Rack</th>
                                                    <th class="text-center" style="width: 80px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="stock-table-body">
                                                <tr class="empty-state-row">
                                                    <td colspan="8" class="text-center py-5">
                                                        <div class="empty-state">
                                                            <i data-feather="package" class="feather-lg text-muted mb-3"></i>
                                                            <p class="text-muted mb-0">No products added yet. Select products above to add.</p>
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
                    <div class="d-none">
                        <input type="text" id="products" name="products" class="form-control">
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-lg-12">
                        <div class="btn-addproduct mb-4">
                            <button type="button" class="btn btn-cancel me-2"
                                onclick="window.location.href='{{ url('stock') }}'">Cancel</button>
                            <button type="submit" class="btn btn-submit" id="submit-add-button">Save Stock Opname</button>
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
        let productList = [];
        let warehouses = [];
        let categories = [];
        let subcategories = [];
        let brands = [];
        let racks = [];
        let selectedProductData = null;

        // Fetch dropdown data from API (products loaded via AJAX Select2)
        async function fetchDropdownsData() {
            try {
                const [warehousesRes, categoriesRes, subcategoriesRes, brandsRes, racksRes] = await Promise.all([
                    fetch('{{ route("api.warehouses") }}'),
                    fetch('{{ route("api.categories") }}'),
                    fetch('{{ route("api.subcategories") }}'),
                    fetch('{{ route("api.brands") }}'),
                    fetch('{{ route("api.racks") }}')
                ]);

                warehouses = await warehousesRes.json();
                categories = await categoriesRes.json();
                subcategories = await subcategoriesRes.json();
                brands = await brandsRes.json();
                racks = await racksRes.json();

                populateDropdowns();
                $('#warehouse_id').trigger('change');
            } catch (error) {
                console.error('Error fetching dropdown data:', error);
                showError('Failed to load data. Please refresh the page.');
            }
        }

        function populateDropdowns() {
            // Warehouse
            const warehouseSelect = $('#warehouse_id');
            warehouseSelect.empty().append('<option value="" disabled selected>Select a warehouse</option>');
            warehouses.forEach(warehouse => {
                warehouseSelect.append(`<option value="${warehouse.id}">${warehouse.name}</option>`);
            });
            warehouseSelect.trigger('change.select2');

            // Category
            const categorySelect = $('#category_id');
            categorySelect.empty().append('<option value="" disabled selected>Select a category</option>');
            categories.forEach(category => {
                categorySelect.append(`<option value="${category.id}">${category.name}</option>`);
            });
            categorySelect.trigger('change.select2');

            // Sub Category
            const subcategorySelect = $('#subcategory_id');
            subcategorySelect.empty().append('<option value="" disabled selected>Select a sub category</option>');
            subcategories.forEach(subcategory => {
                subcategorySelect.append(`<option value="${subcategory.id}" data-category-id="${subcategory.category_id}">${subcategory.name}</option>`);
            });
            subcategorySelect.trigger('change.select2');

            // Brand
            const brandSelect = $('#brand_id');
            brandSelect.empty().append('<option value="" disabled selected>Select a brand</option>');
            brands.forEach(brand => {
                brandSelect.append(`<option value="${brand.id}">${brand.name}</option>`);
            });
            brandSelect.trigger('change.select2');

            // Product - AJAX powered Select2
            initProductSelect();
        }

        function initProductSelect() {
            if ($('#product_id').data('select2')) {
                $('#product_id').select2('destroy');
            }

            $('#product_id').select2({
                width: '100%',
                placeholder: 'Search product by name or SKU...',
                allowClear: true,
                minimumInputLength: 2,
                language: {
                    searching: function() {
                        return 'Searching products...';
                    },
                    inputTooShort: function() {
                        return 'Type at least 2 characters to search';
                    },
                    noResults: function() {
                        return 'No products found';
                    }
                },
                ajax: {
                    url: '{{ route("api.items") }}',
                    dataType: 'json',
                    delay: 400,
                    data: function(params) {
                        return {
                            search: params.term || '',
                            page: params.page || 1,
                            category_id: $('#category_id').val() || '',
                            subcategory_id: $('#subcategory_id').val() || '',
                            brand_id: $('#brand_id').val() || '',
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results,
                            pagination: data.pagination
                        };
                    },
                    cache: true
                },
                templateResult: function(data) {
                    if (data.loading) {
                        return $('<span class="text-muted"><i class="fa fa-spinner fa-spin me-1"></i> Searching...</span>');
                    }
                    if (!data.text) {
                        return $('<span class="text-muted"></span>').text(data.text || 'Type to search...');
                    }

                    const $wrapper = $('<span class="d-flex align-items-center gap-2"></span>');
                    if (data.sku) {
                        $wrapper.append($('<strong class=" me-1"></strong>').text('[' + data.sku + ']'));
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

        // Initialize
        fetchDropdownsData();

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
                                   id="input-${product.sku}" value="${clearDecimal(stockQty)}">
                        </td>
                        <td class="text-end">${formatRupiah(buyPriceTotal)}</td>
                        <td class="text-end" id="total-${product.sku}">0,00</td>
                        <td style="width: 150px;">
                            <select class="select2 form-control form-control-sm rack-select" id="rack-${product.sku}">
                                <option value="">Select Rack</option>
                                ${racks.map(rack => `<option value="${rack.id}">${rack.name}</option>`).join('')}
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
                const newTotal = (newCount * product.basic_price) - (product.stock * product.basic_price);
                product.count = newCount;
                $(`#total-${sku}`).text(formatRupiah(newTotal));
            }
        });

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

        // Warehouse change - generate reference number
        $('#warehouse_id').on('change', function() {
            const currentDate = new Date();
            const formattedDate = formatDate(currentDate);
            const warehouseCode = warehouses.find(war => war.id == $('#warehouse_id').val())?.code || 'common';
            const unixTimestamp = Math.floor(currentDate.getTime() / 1000);
            const randomNumber = generateRandomNumber();
            const periode = `${warehouseCode}-${unixTimestamp}${randomNumber}`;

            $('#date').val(formattedDate);
            $('#periode').val(periode);
        });

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
            showSuccess('Product added successfully.');

            // Reset product selection
            selectedProductData = null;
            $('#product_id').val(null).trigger('change');
        });

        // Form submit handler
        document.getElementById('stockAddForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const form = this;
            const formData = new FormData(form);
            const submitButton = document.getElementById('submit-add-button');
            submitButton.disabled = true;

            Swal.fire({
                title: "Processing...",
                text: "Please wait.",
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

            fetch(form.action, {
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
                        window.location.href = '{{ route("stock-list") }}';
                    }, 2000);
                }
            }).catch(error => {
                Swal.close();
                submitButton.disabled = false;
                document.getElementById('danger-message').textContent = error.message || 'An error occurred';
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
