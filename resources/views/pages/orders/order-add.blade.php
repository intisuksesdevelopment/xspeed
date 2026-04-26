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

            <form id="orderAddForm" method="post" action="{{ route('order-add') }}">
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
                                                <select id="supplier-select" name="supplier_id" class="form-select">
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
                                                <select id="warehouse-select" name="warehouse_id" class="form-select">
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
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>SKU</th>
                                                    <th>Price</th>
                                                    <th>Qty</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody id="order-table-body"></tbody>
                                        </table>

                                        <button type="button" class="btn btn-secondary btn-sm" onclick="addRow()">
                                            Add Product Row
                                        </button>

                                        <hr>

                                        <div class="p-3 bg-light border rounded w-50">
                                            <div class="d-flex justify-content-between">
                                                <span>Subtotal</span>
                                                <strong id="subtotal">Rp 0</strong>
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

        const searchProduct = debounce(function(index, el) {
            searchProductCore(index, el);
        }, 1500);

        let orderItems = [];
        let selectedSupplier = null;
        $(document).on('click', function() {
            $('.dropdown-menu').hide();
        });
        $(document).ready(function() {

            initSupplierSelect();
            initOrder();
        });
        $(document).on('click', '.dropdown-item', function() {
            const parent = $(this).closest('[id^="dropdown-"]');

            const index = parent.attr('id').replace('dropdown-', '');

            selectProduct(
                index,
                $(this).data('sku'),
                $(this).data('name'),
                $(this).data('price')
            );

            parent.hide();
        });
        $(document).on('click', function(e) {
            if (!$(e.target).closest('[id^="dropdown-"], input').length) {
                $('[id^="dropdown-"]').hide();
            }
        });
        $(document).on('change', '#tax-rate', function() {

            if (this.value === 'include') {
                $('input[name="taxPercent"]').val(0);
            } else {
                $('input[name="taxPercent"]').val(config.ppn_rate || 0);
            }

            recalcTotal();
        });
        $(document).on('click', '.product-item', function() {

            const item = $(this).data('item');
            const index = $(this).data('index');

            orderItems[index] = {
                ...orderItems[index],
                sku: item.sku,
                name: item.name,
                sell_price: item.sell_price,
                qty: 1
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
            $('#transaction_id').text(trxId);
            $('#transaction_id').val(trxId);

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

            $supplier.on('change', async function() {
                const id = $(this).val();

                if (!id) return;

                const supplier = Select2Cache.suppliers.find(s => s.uuid === id);
                selectedSupplier = supplier;

                loadSupplierInfo(supplier);

                await initContactSelect(id);
            });
        }

        /* =========================
           CONTACT SELECT2
        ========================= */
        async function initContactSelect() {

            if (!selectedSupplier) return;

            const $contact = $('#contact-select');

            safeDestroySelect2($contact);
            $contact.empty();

            const res = await apiFetch({
                endpoint: apiContactUrl + selectedSupplier.uuid
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

            const res = await apiFetch({
                endpoint: apiProductUrl + 'search',
                params: {
                    q: keyword
                }
            });

            let items = res.data || [];

            let dropdown = $('#dropdown-' + index);

            dropdown
                .empty()
                .show(); // 🔥 WAJIB

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
            orderItems[index] = {
                ...orderItems[index],
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

            // kalau masih belum ada row → langsung boleh tambah
            if (orderItems.length === 0) {
                orderItems.push({
                    sku: '',
                    name: '',
                    sell_price: 0,
                    qty: 1,
                    search: '',
                    searchResults: []
                });

                renderTable();
                return;
            }

            // ambil row terakhir
            const lastItem = orderItems[orderItems.length - 1];

            // 🔥 validasi hanya untuk row ke-2 dan seterusnya
            if (!lastItem.sku) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Isi product di baris sebelumnya dulu'
                });
                return;
            }

            // kalau valid → tambah row
            orderItems.push({
                sku: '',
                name: '',
                sell_price: 0,
                qty: 1,
                search: '',
                searchResults: []
            });

            renderTable();
        }
        /* =========================
           REMOVE ROW
        ========================= */
        function removeRow(index) {
            orderItems.splice(index, 1);
            recalcTotal();
            renderTable();
        }

        /* =========================
           TOTAL CALCULATION
        ========================= */
        function recalcTotal() {

            let subtotal = 0;
            let taxAmount = 0;
            let discAmount = 0;

            const taxType = $('#tax-rate').val();
            const taxPercent = parseFloat($('input[name="taxPercent"]').val()) || 0;

            // hitung subtotal
            orderItems.forEach(item => {
                subtotal += (item.qty || 0) * (item.sell_price || 0);
            });

            // 🔥 TAX LOGIC
            if (taxType === 'include') {
                // harga sudah termasuk pajak
                taxAmount = subtotal * (taxPercent / (100 + taxPercent));
            } else {
                // pajak di luar
                taxAmount = subtotal * (taxPercent / 100);
            }

            // 🔥 TOTAL
            let total = taxType === 'include' ?
                subtotal // sudah termasuk pajak
                :
                subtotal + taxAmount;

            // 🔥 render UI
            $('#subtotal').text(formatCurrency(subtotal));
            $('#tax-amount').text(formatCurrency(taxAmount));
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

            orderItems.forEach((item, index) => {
                html += `
        <tr>
            <td>
                <input type="text"
                       class="form-control"
                       value="${item.search || ''}"
                       onkeyup="searchProduct(${index}, this)">
                <div class="dropdown-menu" id="dropdown-${index}" style="display:none;"></div>
            </td>

            <td>${item.sku || '-'}</td>
            <td>${formatCurrency(item.sell_price || 0)}</td>

            <td>
                <input type="number" value="${item.qty}" class="form-control">
            </td>

            <td>${formatCurrency((item.qty || 0) * (item.sell_price || 0))}</td>

            <td>
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
                    id: item.uuid,
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
    </script>
@endsection
