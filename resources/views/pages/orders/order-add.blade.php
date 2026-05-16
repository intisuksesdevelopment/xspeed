<?php $page = 'order-add'; ?>
@extends('pages.layout.mainlayout')

@section('content')
    <style>
        .dropdown-menu {
            z-index: 9999 !important;
        }

        .overlay-detail-panel {
            position: absolute;
            top: 110%;
            right: 0;
            width: 300px;

            z-index: 99999;
            /* 🔥 penting */
            display: none;

            background: white;
            border-radius: 8px;
        }

        #item-list {
            table-layout: fixed;
            width: 100%;
        }

        #item-list td,
        #item-list th {
            vertical-align: middle;
        }

        #item-list td:nth-child(1) {
            white-space: normal;
            /* product boleh multi-line */
        }

        #item-list td:not(:nth-child(1)) {
            white-space: nowrap;
        }
    </style>

    <div class="page-wrapper">
        <div class="content">

            <!-- BREADCRUMB -->
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

            <form id="orderAddForm" method="post" action="{{ route('api-order-add') }}">
                @csrf

                <div class="card">
                    <div class="card-body add-product pb-0">

                        <!-- ORDER INFO -->
                        <div class="accordion" id="accordionExample">

                            <div class="accordion-item">
                                <div class="accordion-header">
                                    <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                        <h5>Order Information</h5>
                                    </div>
                                </div>

                                <div id="collapseOne" class="accordion-collapse collapse show">

                                    <div class="accordion-body">

                                        <!-- TRX -->
                                        <span>Transaction ID : #<span id="transaction-id"></span></span>
                                        <input type="hidden" id="transactionId" name="transactionId">
                                        <input type="hidden" name="type" value="order">
                                        <input type="hidden" name="taxPercent" value="0">
                                        <input type="hidden" name="taxAmount" value="0">
                                        <input type="hidden" name="discPercent" value="0">
                                        <input type="hidden" name="discAmount" value="0">

                                        <div class="row g-2 mt-2 position-relative">
                                            <!-- SUPPLIER -->
                                            <div class="col-lg-3">
                                                <label>Supplier</label>
                                                <select id="supplier-select" name="supplierUuid" class="form-select">
                                                    <option></option>
                                                </select>
                                            </div>

                                            <!-- CONTACT -->
                                            <div class="col-lg-3">
                                                <label>Contact</label>
                                                <select id="contact-select" name="contact_id" class="form-select"
                                                    data-placeholder="Pilih Contact">
                                                    <option></option>
                                                </select>
                                            </div>

                                            <!-- TAX -->
                                            <div class="col-lg-3">
                                                <label>Tax Tipe</label>
                                                <select id="tax-type" name="taxType" class="form-select">
                                                    <option value="include">Include</option>
                                                    <option value="exclude">Exclude ({{ $config['ppn_rate'] ?? 0 }}%)
                                                    </option>
                                                </select>
                                            </div>
                                            <!-- DETAIL PANEL -->
                                            <div class="col-lg-1 d-flex align-items-end">
                                                <button type="button" id="toggle-detail"
                                                    class="btn btn-outline-info btn-sm">
                                                    Detail
                                                </button>
                                            </div>
                                            <div class="overlay-detail-panel">

                                                <div class="p-3 border rounded bg-light shadow">

                                                    <div><b>Nama:</b> <span id="contact-name">-</span></div>
                                                    <div><b>Divisi:</b> <span id="contact-position">-</span></div>
                                                    <div><b>Telp:</b> <span id="contact-phone">-</span></div>

                                                    <hr>

                                                    <div><b>Supplier:</b> <span id="supplier-name">-</span></div>
                                                    <div><b>Address:</b> <span id="supplier-address">-</span></div>
                                                    <div><b>Email:</b> <span id="supplier-email">-</span></div>

                                                </div>

                                            </div>

                                        </div>
                                        <div class="row g-2 mt-2">
                                            <!-- SUPPLIER -->
                                            <div class="col-lg-3">
                                                <label>Gudang</label>
                                                <select id="warehouse-select" name="warehouseId" class="form-select">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>




                                    </div>
                                </div>
                            </div>

                            <!-- PRODUCT -->
                            <div class="accordion-item mt-3">
                                <div class="accordion-header">
                                    <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                        <h5>Product Orders</h5>
                                    </div>
                                </div>

                                <div id="collapseTwo" class="accordion-collapse collapse show">

                                    <div class="accordion-body">

                                        <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width:320px;">Product</th>
                                                    <th style="width:120px;">SKU</th>
                                                    <th style="width:140px;" class="text-end">Sell Price</th>
                                                    <th style="width:140px;" class="text-center">Qty</th>
                                                    <th style="width:160px;" class="text-end">Total Cost</th>
                                                    <th style="width:80px;" class="text-center"></th>
                                                </tr>
                                            </thead>

                                            <tbody id="order-table-body"></tbody>
                                        </table>

                                        <button type="button" class="btn btn-primary btn-sm" onclick="addRow()">Add Product
                                        </button>

                                        <hr>

                                        <div class="d-flex">
                                            <div class="p-3 border rounded w-50 ms-auto">
                                                <div class="d-flex justify-content-between">
                                                    <span>Subtotal</span>
                                                    <strong id="subtotal">Rp 0</strong>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>Discount(<span name="discPercent">0</span>%)</span>
                                                    <strong id="discTotal">Rp 0</strong>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>Tax(<span name="taxPercent">0</span>%)</span>
                                                    <strong id="taxTotal">Rp 0</strong>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>Total</span>
                                                    <strong id="total">Rp 0</strong>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- BUTTON -->
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Save Order</button>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>

    @if (Route::is(['order', 'order-add-form']))
        <div class="modal fade" id="add-order-item" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content shadow-sm">

                    <!-- Header -->
                    <div class="modal-header">
                        <h5 class="modal-title fw-semibold">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">

                        <!-- Form -->
                        <form id="form-add-order">

                            <!-- Product Name -->
                            <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control" placeholder="Search or input product...">
                            </div>

                            <!-- Filters -->
                            <div class="row g-2 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Brand</label>
                                    <select class="form-select" id="brand-list"></select>
                                    <select x-model="brandId" class="select2 form-control" id="brand-select"
                                        name="brand_id">
                                        <template x-for="brand in brands" :key="brand.uuid">
                                            <option :value="brand.uuid" x-text="brand.name"></option>
                                        </template>
                                    </select>
                                </div>
                                {{-- <div class="col-md-4">
                                <label class="form-label">Category</label>
                                <select x-model="categoryId" class="select2 form-control" id="category-select"
                                    name="category_id">
                                    <template x-for="category in categories" :key="category.uuid">
                                        <option :value="category.uuid" x-text="category.name"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Sub Category</label>
                                <select x-model="subcategoryId" class="select2 form-control" id="subcategory-select"
                                    name="subcategory_id">
                                    <template x-for="subcategory in subcategories" :key="subcategory.uuid">
                                        <option :value="subcategory.uuid" x-text="subcategory.name"></option>
                                    </template>
                            </div> --}}
                            </div>

                            <!-- Table -->
                            <div class="table-responsive border rounded">
                                <table class="table table-hover align-middle mb-0" id="item-list">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width:40px;">
                                                <input type="checkbox" id="select-all-product" class="form-check-input">
                                            </th>
                                            <th>Product</th>
                                            <th>SKU</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">Currency</th>
                                            <th class="text-end">Sell Price</th>
                                            <th class="text-end">Total Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                        </form>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" form="form-add-order" class="btn btn-primary">
                            Submit
                        </button>
                    </div>

                </div>
            </div>
        </div>
        <!-- /add popup -->
    @endif

    <!-- Payment Modal -->
    <div class="modal fade" id="modal-payment" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-sm">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">Payment Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <span class="fs-5">Total Bayar:</span>
                        <strong class="fs-4 text-primary" id="payment_total_display">Rp 0</strong>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select id="payment_method_select" class="form-select">
                            <option value="1">Cash</option>
                            <option value="2">Bank Transfer</option>
                            <option value="3">Debit</option>
                            <option value="4">Due Date / Tempo</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="div_due_date">
                        <label class="form-label">Jatuh Tempo <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="payment_due_date">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" id="label_payment_amount">Nominal Uang (Rp)</label>
                        <input type="number" class="form-control" id="payment_amount_input" min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" id="label_payment_change">Kembalian (Rp)</label>
                        <input type="text" class="form-control" id="payment_change_display" readonly value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="btn-confirm-payment" class="btn btn-primary">Confirm & Pay</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Payment Modal -->


    <!-- script kamu -->
    <script src="{{ asset('/build/js/page/order.js') }}"></script>
    <script>
        const apiBrandUrl = 'brand/all';
        const apiCategoryUrl = 'category/all';
        const apiSupplierUrl = 'supplier/all';
        const apiWarehouseUrl = 'warehouse/all';
        const apiSubcategoryUrl = 'subcategory';
        const apiContactUrl = 'contact/';
        const apiProductUrl = 'product/';
        const config = @json($config);
        const taxPercent = config.ppn_rate || 0;
        let discPercent = 0;
        const searchProduct = debounce(async function(index, el) {
            const keyword = el.value;

            if (keyword.length < 2) return;

            $('#loading-' + index).show();

            const res = await apiFetch({
                endpoint: apiProductUrl + 'search',
                params: {
                    q: keyword,
                    limit: 10
                }
            });

            $('#loading-' + index).hide();

            renderDropdown(index, res.data || []);
        }, 400);
        const state = {
            items: [],
            supplier: null,
            discPercent: 0,
            taxPercent: config.ppn_rate || 0,
            taxType: 'include'
        };

        let selectedSupplier = null;

        $(document).ready(function() {
            initWarehouseSelect();
            initSupplierSelect();
            initOrder();
        });
        $(document).on('click', function(e) {
            if (!$(e.target).closest('[id^="dropdown-"], input').length) {
                $('[id^="dropdown-"]').hide();
            }
        });
        $('#tax-type').on('change', function() {
            state.taxType = this.value;

            state.taxPercent = this.value === 'include' ?
                0 :
                config.ppn_rate || 0;

            renderSummary();
        });
        $(document).on('click', '.product-item', function() {

            const item = $(this).data('item');
            const index = $(this).data('index');

            state.items[index] = {
                ...state.items[index],
                uuid: item.uuid,
                sku: item.sku,
                name: item.name,
                sell_price: item.sell_price,
                qty: 1,
                search: item.name, // 🔥 ini yang bikin text muncul
                readonly: true // 🔥 ini yang bikin readonly
            };

            $('#dropdown-' + index).hide();

            renderTable();
            recalcTotal();
        });
        $('#toggle-detail').on('click', function(e) {
            e.stopPropagation();
            $('.overlay-detail-panel').toggle();
        });

        // klik luar → close
        $(document).on('click', function() {
            $('.overlay-detail-panel').hide();
        });

        // biar klik di dalam panel gak nutup
        $('.overlay-detail-panel').on('click', function(e) {
            e.stopPropagation();
        });
        /* =========================
           INIT ORDER STATE
        ========================= */
        function initOrder() {
            initTransaction();
            addRow();

            recalcTotal();
        }
        async function initTransaction() {
            const trxId = generateTransactionID("ORD");
            $('#transaction-id').text(trxId);
            $('#transactionId').val(trxId);

        }
        /* =========================
           WAREHOUSE SELECT2
        ========================= */
        async function initWarehouseSelect() {
            const $warehouse = $('#warehouse-select');

            await loadSelect2($warehouse, {
                endpoint: apiWarehouseUrl,
                placeholder: 'Pilih Gudang',
                cacheKey: 'warehouses'
            });
        }

        /* =========================
           SUPPLIER SELECT2
        ========================= */
        async function initSupplierSelect() {
            const $supplier = $('#supplier-select');

            await loadSelect2($supplier, {
                endpoint: apiSupplierUrl,
                placeholder: 'Pilih Supplier',
                cacheKey: 'suppliers'
            });

            $supplier.on('change', function() {
                const id = $(this).val();

                const supplier = Select2Cache.suppliers.find(s => s.uuid === id);

                state.supplier = supplier;
                state.discPercent = supplier?.discount || 0;

                loadSupplierInfo(supplier);
                initContactSelect();

                renderSummary();
            });
        }

        /* =========================
           CONTACT SELECT2
        ========================= */
        async function initContactSelect() {

            if (!state.supplier) return;

            const $contact = $('#contact-select');

            safeDestroySelect2($contact);
            $contact.empty();

            const res = await apiFetch({
                endpoint: apiContactUrl + state.supplier.uuid
            });

            contactList = res.data || [];

            // placeholder
            $contact.append(new Option('', '', false, false));

            // data
            contactList.forEach(item => {
                $contact.append(new Option(item.name, item.uuid, false, false));
            });

            // init select2
            $contact.select2({
                placeholder: 'Pilih Contact',
                allowClear: true,
                width: '100%'
            });

            // 🔥 gunakan select2 event
            $contact.off('select2:select').on('select2:select', function(e) {

                const id = e.params.data.id;
                const contact = contactList.find(c => c.uuid === id);

                if (!contact) return;

                $('#contact-name').text(contact.name || '-');
                $('#contact-position').text(contact.position || '-');
                $('#contact-phone').text(contact.phone || '-');
            });
        }
        /* =========================
           LOAD SUPPLIER DETAIL
        ========================= */
        function loadSupplierInfo(supplier) {
            $('#supplier-name').text(supplier?.name || '-');
            $('#supplier-address').text(supplier?.address || '-');
            $('#supplier-email').text(supplier?.email || '-');
        }

        /* =========================
           PRODUCT SEARCH ROW
        ========================= */
        async function searchProductCore(index, el) {
            let keyword = $(el).val();

            if (keyword.length < 2) return;

            // 🔥 tampilkan loading
            $('#loading-' + index).show();

            const res = await apiFetch({
                endpoint: apiProductUrl + 'search',
                params: {
                    q: keyword
                }
            });

            let items = res.data || [];
            let dropdown = $('#dropdown-' + index);

            dropdown.empty().show();

            // 🔥 hide loading setelah data datang
            $('#loading-' + index).hide();

            if (items.length === 0) {
                dropdown.append(`<div class="dropdown-item text-muted">Tidak ada data</div>`);
                return;
            }

            items.forEach(p => {
                const row = $(`
            <div class="dropdown-item product-item"
                data-index="${index}"
                style="cursor:pointer;padding:6px;">
                ${p.name} - ${p.sku}
            </div>
        `);

                row.data('item', p);
                dropdown.append(row);
            });
        }

        function debounce(fn, delay = 300) {
            let timer;
            return function(...args) {
                clearTimeout(timer);
                timer = setTimeout(() => fn.apply(this, args), delay);
            };
        }
        /* =========================
           SELECT PRODUCT
        ========================= */
        function selectProduct(index, sku, name, price) {
            state.items[index] = {
                ...state.items[index],
                uuid: item.uuid,    
                sku: sku,
                name: name,
                sell_price: price,
                qty: 1
            };

            recalcTotal();
        }

        /* =========================
           ADD ROW
        ========================= */
        function addRow() {
            // cek hanya jika sudah ada item sebelumnya
            if (state.items.length > 0) {
                const last = state.items[state.items.length - 1];

                if (!last.sku) {
                    return Swal.fire('Oops', 'Isi product sebelumnya dulu', 'warning');
                }
            }

            state.items.push({
                uuid: null,
                sku: '',
                name: '',
                sell_price: 0,
                qty: 1,
                search: '',
                readonly: false
            });

            renderTable();
        }

        function setProduct(index, item) {
            state.items[index] = {
                ...state.items[index],
                product_id: item.id,
                uuid: item.uuid,
                sku: item.sku,
                name: item.name,
                sell_price: item.sell_price,
                qty: 1,
                search: item.name,
                readonly: true
            };

            renderAll();
        }
        /* =========================
           REMOVE ROW
        ========================= */
        function removeRow(index) {
            state.items.splice(index, 1);
            recalcTotal();
            renderTable();
        }

        /* =========================
           TOTAL CALCULATION
        ========================= */
        function calculateSummary() {
            let subtotal = 0;

            state.items.forEach(item => {
                subtotal += (item.qty || 0) * (item.sell_price || 0);
            });

            const discAmount = subtotal * (state.discPercent / 100);
            const afterDisc = subtotal - discAmount;

            let taxAmount = 0;
            let total = 0;

            if (state.taxType === 'include') {
                taxAmount = afterDisc * (state.taxPercent / (100 + state.taxPercent));
                total = afterDisc;
            } else {
                taxAmount = afterDisc * (state.taxPercent / 100);
                total = afterDisc + taxAmount;
            }

            return {
                subtotal,
                discAmount,
                taxAmount,
                total
            };
        }

        function renderSummary() {
            const {
                subtotal,
                discAmount,
                taxAmount,
                total
            } = calculateSummary();

            $('#subtotal').text(formatCurrency(subtotal));
            $('#discTotal').text(formatCurrency(discAmount));
            $('#taxTotal').text(formatCurrency(taxAmount));
            $('#total').text(formatCurrency(total));

            $('span[name="discPercent"]').text(state.discPercent);
            $('input[name="discPercent"]').val(state.discPercent);
            $('input[name="discAmount"]').val(discAmount);
            $('span[name="taxPercent"]').text(state.taxPercent);
            $('input[name="taxPercent"]').val(state.taxPercent);
            $('input[name="taxAmount"]').val(taxAmount);
        }

        function recalcTotal() {
            let subtotal = 0;

            const taxType = $('#tax-type').val();

            const taxPercent = parseFloat(state.taxPercent) || 0;
            const discPercent = parseFloat(state.discPercent) || 0;

            // hitung subtotal
            state.items.forEach(item => {
                const qty = parseFloat(item.qty) || 0;
                const price = parseFloat(item.sell_price) || 0;

                subtotal += qty * price;
            });

            // diskon
            const discAmount = subtotal * (discPercent / 100);

            // setelah diskon
            const totalAfterDisc = subtotal - discAmount;

            let taxAmount = 0;
            let total = 0;

            // TAX
            if (taxType === 'include') {

                // pajak sudah termasuk di harga
                taxAmount = totalAfterDisc * (taxPercent / (100 + taxPercent));

                // total tetap
                total = totalAfterDisc;

            } else {

                // pajak ditambahkan
                taxAmount = totalAfterDisc * (taxPercent / 100);

                total = totalAfterDisc + taxAmount;
            }

            // render UI
            $('span[name="discPercent"]').text(discPercent);
            $('input[name="discPercent"]').val(discPercent);
            $('input[name="discAmount"]').val(discAmount);
            $('span[name="taxPercent"]').text(taxPercent);
            $('input[name="taxPercent"]').val(taxPercent);
            $('input[name="taxAmount"]').val(taxAmount);

            $('#subtotal').text(formatCurrency(subtotal));
            $('#taxTotal').text(formatCurrency(taxAmount));
            $('#discTotal').text(formatCurrency(discAmount));
            $('#total').text(formatCurrency(total));
        }
        /* =========================
                  FORMAT CURRENCY
               ========================= */
        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(amount);
        }

        /* =========================
           RENDER TABLE (optional kalau kamu mau full JS control)
        ========================= */
        function renderTable() {
            let html = '';

            state.items.forEach((item, index) => {
                html += `
                <tr>
                    <td>
                        ${
                            item.readonly
                                ? `<span class="form-label">${item.search}</span>`
                                : `<input-wrapper>
                                                                                    <div style="position:relative;">
                                                                                        <input type="text"
                                                                                            class="form-control pe-5"
                                                                                            value="${item.search || ''}"
                                                                                            onkeyup="searchProduct(${index}, this)">

                                                                                        <div id="loading-${index}"
                                                                                            style="position:absolute; top:50%; right:10px; transform:translateY(-50%); display:none;">
                                                                                            <div class="spinner-border spinner-border-sm text-primary"></div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="dropdown-menu" id="dropdown-${index}" style="display:none;"></div> `
                                            }
                    </td>

                    <td>${item.sku || '-'}</td>
                    <td class="text-end">${formatCurrency(item.sell_price || 0)}</td>

                    <td class="text-center">
                        <div class="input-group">
                            <button class="btn btn-outline-secondary"
                                type="button"
                                onclick="changeQty(${index}, -1)"
                                ${item.qty <= 1 ? 'disabled' : ''}>
                                -
                            </button>
                            <input type="number"
                                value="${item.qty}"
                                class="form-control text-center"
                                onchange="updateQty(${index}, this.value)">

                            <button class="btn btn-outline-secondary" type="button" onclick="changeQty(${index}, 1)">+</button>
                        </div>
                    </td>

                    <td class="text-end">${formatCurrency((item.qty || 0) * (item.sell_price || 0))}</td>

                    <td class="text-center">
                        <button class="btn btn-danger btn-sm" onclick="removeRow(${index})">
                            Delete
                        </button>
                    </td>
                </tr>
                `;
            });

            $('#order-table-body').html(html);
        }
        const Select2Cache = {};

        function safeDestroySelect2($el) {
            if ($el.hasClass("select2-hidden-accessible")) {
                $el.blur();
                $el.select2('destroy');
            }
        }
        async function loadSelect2($el, options) {
            const {
                endpoint,
                placeholder = 'Select',
                params = {},
                map = (item) => ({
                    id: item.uuid ?? item.id,
                    text: item.name,
                    data: item
                }),
                cacheKey = null
            } = options;

            // cache
            if (cacheKey && Select2Cache[cacheKey]) {
                renderOptions($el, Select2Cache[cacheKey], placeholder);
                return Select2Cache[cacheKey];
            }

            $el.prop('disabled', true);

            const res = await apiFetch({
                endpoint,
                params
            });

            const data = res.data || [];

            if (cacheKey) {
                Select2Cache[cacheKey] = data;
            }

            renderOptions($el, data, placeholder, map);

            $el.prop('disabled', false);

            return data;
        }

        function renderOptions($el, data, placeholder, map) {

            safeDestroySelect2($el);
            $el.empty();

            // 1. placeholder dulu
            $el.append(new Option('', '', false, false));

            // 2. data
            data.forEach(item => {
                const opt = map(item);
                $el.append(new Option(opt.text, opt.id, false, false));
            });

            // 3. baru init select2
            $el.select2({
                placeholder,
                allowClear: true,
                width: '100%'
            });

            // 4. reset
            $el.val(null).trigger('change');
        }

        function changeQty(index, delta) {
            let current = state.items[index].qty || 1;

            let newQty = current + delta;

            if (newQty < 1) newQty = 1; // biar gak minus

            state.items[index].qty = newQty;

            renderTable();
            recalcTotal();
        }

        function updateQty(index, qty) {
            qty = parseInt(qty) || 1;
            if (qty < 1) qty = 1;

            state.items[index].qty = qty;

            renderAll();
        }

        function escapeHtml(str) {
            return $('<div>').text(str || '').html();
        }

        function renderDropdown(index, items = []) {

            const dropdown = $('#dropdown-' + index);

            dropdown.empty().show();

            // kosong
            if (items.length === 0) {
                dropdown.append(`
            <div class="dropdown-item text-muted">
                Tidak ada data
            </div>
        `);
                return;
            }

            items.forEach(item => {

                const row = $(`
            <div class="dropdown-item product-item"
                data-index="${index}"
                style="cursor:pointer;padding:8px;">

                <div class="fw-semibold">
                    ${escapeHtml(item.name)}
                </div>

                <small class="text-muted">
                    ${escapeHtml(item.sku)}
                </small>
            </div>
        `);

                // simpan object product
                row.data('item', item);

                dropdown.append(row);
            });
        }

        function renderAll() {
            renderTable();
            renderSummary();
        }
        document.getElementById('orderAddForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            if (!state.supplier) {
                return Swal.fire('Oops', 'Supplier wajib dipilih', 'warning');
            }

            if (state.items.length === 0 || state.items.some(i => !i.sku)) {
                return Swal.fire('Oops', 'Product belum lengkap', 'warning');
            }

            const { total } = calculateSummary();
            
            $('#payment_total_display').text(formatCurrency(total));
            $('#payment_amount_input').val(total);
            $('#payment_change_display').val(0);
            
            $('#modal-payment').data('total', total);
            
            // Reset to default
            $('#payment_method_select').val('1').trigger('change');
            
            const paymentModal = new bootstrap.Modal(document.getElementById('modal-payment'));
            paymentModal.show();
        });

        function calculatePayment() {
            const total = parseFloat($('#modal-payment').data('total')) || 0;
            const paid = parseFloat($('#payment_amount_input').val()) || 0;
            const isDueDate = $('#payment_method_select').val() == '4';

            if (isDueDate) {
                const remaining = total - paid;
                $('#payment_change_display').val(remaining > 0 ? remaining : 0);
            } else {
                const change = paid - total;
                $('#payment_change_display').val(change > 0 ? change : 0);
            }
        }

        $('#payment_method_select').on('change', function() {
            if($(this).val() == '4') {
                $('#div_due_date').removeClass('d-none');
                $('#label_payment_amount').text('DP / Uang Muka (Rp)');
                $('#label_payment_change').text('Kurang Bayar (Rp)');
                $('#payment_amount_input').val(0); // Default DP 0
            } else {
                $('#div_due_date').addClass('d-none');
                $('#label_payment_amount').text('Nominal Uang (Rp)');
                $('#label_payment_change').text('Kembalian (Rp)');
                const total = parseFloat($('#modal-payment').data('total')) || 0;
                $('#payment_amount_input').val(total); // Default full payment
            }
            calculatePayment();
        });

        $('#payment_amount_input').on('input', calculatePayment);

        document.getElementById('btn-confirm-payment').addEventListener('click', async function() {
            const btn = this;
            const isDueDate = $('#payment_method_select').val() == '4';
            const dueDate = $('#payment_due_date').val();

            if (isDueDate && !dueDate) {
                return Swal.fire('Oops', 'Tanggal Jatuh Tempo wajib diisi', 'warning');
            }

            btn.disabled = true;
            btn.innerText = 'Processing...';

            const formElement = document.getElementById('orderAddForm');

            try {
                const formData = new FormData(formElement);

                // Append items as JSON
                formData.append('items', JSON.stringify(state.items));
                
                const total = parseFloat($('#modal-payment').data('total')) || 0;
                const paid = parseFloat($('#payment_amount_input').val()) || 0;
                
                // Calculate change and remaining based on payment method
                const change = (!isDueDate && paid > total) ? paid - total : 0;
                const remaining = paid < total ? total - paid : 0;
                const status = remaining > 0 ? 1 : 0;
                
                // Append payment data
                formData.append('payment_method', $('#payment_method_select').val());
                formData.append('payment_total', paid);
                formData.append('payment_change', change);
                formData.append('payment_remaining', remaining);
                formData.append('status', status);

                // Append due date if payment method is tempo
                if (isDueDate && dueDate) {
                    formData.append('payment_date', dueDate);
                }

                // Debug: Log form data
                console.log('Submitting order with data:');
                for (let [key, value] of formData.entries()) {
                    console.log(key + ': ' + value);
                }

                const res = await fetch(formElement.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('[name=_token]').value
                    },
                    body: formData
                });

                const data = await res.json();

                if (!res.ok || !data.success) {
                    throw new Error(data.message || 'Terjadi kesalahan saat menyimpan order');
                }

                // Close modal
                const modalElement = document.getElementById('modal-payment');
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) {
                    modalInstance.hide();
                }

                Swal.fire('Success', data.message || 'Order berhasil dibuat', 'success').then(() => {
                    window.location.href = "/order";
                });

            } catch (err) {
                console.error('Order submission error:', err);
                Swal.fire('Oops', err.message || 'Terjadi kesalahan', 'error');
            } finally {
                btn.disabled = false;
                btn.innerText = 'Confirm & Pay';
            }
        });
    </script>
@endsection
