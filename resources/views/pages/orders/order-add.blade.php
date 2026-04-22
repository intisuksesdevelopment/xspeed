<?php $page = 'order-add'; ?>
@extends('pages.layout.mainlayout')
@section('content')
    <div x-data="orderData()" @contact-selected.window="handleContact($event.detail)" class="page-wrapper">
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
                                                <span>Transaction ID : #<span id="transaction-id"></span></span>
                                                <span class="d-none"><input id="trx_id" name="trx_id"></span>
                                                <span class="d-none"><input id="type" name="type"
                                                        value="order"></span>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <!-- Supplier -->
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Supplier</label>
                                                    <select x-ref="supplier" x-model="supplierId" class="form-control"
                                                        x-cloak></select>
                                                </div>
                                            </div>

                                            <!-- Contact -->
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Contact</label>
                                                    <div x-data="dropdownContact()"
                                                        @contacts-updated.window="contacts = $event.detail"
                                                        class="position-relative">

                                                        <!-- Trigger (seperti select) -->
                                                        <div @click="toggle"
                                                            class="form-control d-flex justify-content-between align-items-center"
                                                            style="cursor:pointer">

                                                            <span x-text="selectedName || 'Pilih Contact'"></span>
                                                            <span>▼</span>
                                                        </div>

                                                        <!-- Dropdown -->
                                                        <div x-show="open" @click.outside="open = false"
                                                            class="border bg-white position-absolute w-100 mt-1"
                                                            style="z-index:999; max-height:200px; overflow-y:auto; left:0; right:0;">

                                                            <template x-for="contact in contacts" :key="contact.uuid">
                                                                <div @click="select(contact)" class="p-2 hover-bg"
                                                                    style="cursor:pointer">
                                                                    <span x-text="contact.name"></span>
                                                                </div>
                                                            </template>

                                                            <div x-show="contacts.length === 0" class="p-2 text-muted">
                                                                Tidak ada contact
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Info Card -->
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="card bg-dark text-light mb-3 shadow-sm">
                                                    <div
                                                        class="card-header d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">Detail Contact & Supplier</span>
                                                        <button class="btn btn-sm d-flex align-items-center" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#contactSupplierInfo"
                                                            aria-expanded="false" aria-controls="contactSupplierInfo">
                                                            <i data-feather="chevrons-down"></i>
                                                        </button>
                                                    </div>

                                                    <div class="collapse fade show" id="contactSupplierInfo">
                                                        <div class="card-body">

                                                            <!-- Contact Info -->
                                                            <div class="row mb-2">
                                                                <div
                                                                    class="col-5 text-xs font-bold text-primarydark text-uppercase">
                                                                    Nama:</div>
                                                                <div class="col-7 text-light" x-text="contactName"></div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div
                                                                    class="col-5 text-xs font-bold text-primarydark text-uppercase">
                                                                    Divisi:</div>
                                                                <div class="col-7 text-light" x-text="contactPosition">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2 pb-1 border-bottom border-primarydark">
                                                                <div
                                                                    class="col-5 text-xs font-bold text-primarydark text-uppercase">
                                                                    Telepon:</div>
                                                                <div class="col-7 text-light text-sm font-semibold"
                                                                    x-text="contactPhone"></div>
                                                            </div>

                                                            <!-- Supplier Info -->
                                                            <div class="row mt-2">
                                                                <div
                                                                    class="col-5 text-xs font-bold text-primarydark text-uppercase">
                                                                    Supplier:</div>
                                                                <div class="col-7 text-light font-bold uppercase"
                                                                    x-text="supplierName"></div>
                                                            </div>
                                                            <div class="row">
                                                                <div
                                                                    class="col-5 text-xs font-bold text-primarydark text-uppercase">
                                                                    Alamat:</div>
                                                                <div class="col-7 text-light text-[10px] font-semibold"
                                                                    x-text="supplierAddress"></div>
                                                            </div>
                                                            <div class="row">
                                                                <div
                                                                    class="col-5 text-xs font-bold text-primarydark text-uppercase">
                                                                    Email:</div>
                                                                <div class="col-7 text-light text-[10px] font-semibold"
                                                                    x-text="supplierEmail"></div>
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
                        <div class="accordion-card-one accordion" id="accordionExample2">
                            <div class="accordion-item">
                                <div class="accordion-header" id="headingTwo">
                                    <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                        aria-controls="collapseTwo">
                                        <div class="text-editor add-list">
                                            <div class="addproduct-icon list icon">
                                                <h5><i data-feather="life-buoy" class="add-info"></i><span>Product
                                                        Orders</span></h5>
                                                <a href="javascript:void(0);"><i data-feather="chevron-down"
                                                        class="chevron-down-add"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseTwo" class="accordion-collapse collapse show"
                                    aria-labelledby="headingTwo" data-bs-parent="#accordionExample2">
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
                                                        <div id="order-list">
                                                            <div class="table-responsive product-list">
                                                                {{-- <table class="table datanew  table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="no-sort">
                                                                                <label class="checkboxs">
                                                                                    <input type="checkbox"
                                                                                        id="select-all">
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
                                                                            <th>Order</th>
                                                                            <th>Total</th>
                                                                            <th>Created by</th>
                                                                            <th>Status</th>
                                                                            <th class="no-sort">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    </tbody>
                                                                </table> --}}
                                                            </div>
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
                                                                {{-- <tr>
                                                                <td>Tax (<span id="tax-value">10</span>%)</td>
                                                                <td class="text-end" id="tax">0,00</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Shipping</td>
                                                                <td class="text-end" id="shipping">0,00</td>
                                                            </tr> --}}
                                                                <tr>
                                                                    <td class="danger">Discount (<span
                                                                            id="discount-value">0</span>%)</td>
                                                                    <td class="danger text-end" id="discount">0,00
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Total</td>
                                                                    <td class="text-end"><span id="total">0,00</span>
                                                                        IDR</td>
                                                                </tr>
                                                            </table>
                                                        </div>

                                                        <div class="d-grid btn-block mb-3">
                                                            <a class="btn btn-secondary" href="javascript:void(0);">
                                                                Grand Total : <span id="grandtotal">0,00</span><span>
                                                                    IDR</span>
                                                            </a>
                                                        </div>
                                                        <div class="block-section payment-method">
                                                            <h6>Payment Method</h6>
                                                            <div
                                                                class="row d-flex align-items-center justify-content-center methods">
                                                                <div class="col-12 col-md-12 col-lg-12 col-sm-12">
                                                                    <div class="input-blocks mb-3 ">
                                                                        <select class="select" name="payment_method"
                                                                            id="payment-method-select"
                                                                            onchange="paymentMethodChange()">
                                                                            @foreach ($paymentMethods as $paymentMethod)
                                                                                <option value="{{ $paymentMethod['id'] }}"
                                                                                    data-method="{{ $paymentMethod['method'] }}">
                                                                                    {{ $paymentMethod['name'] }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div id="div-payment">
                                                                        <div class="mb-3 input-blocks">
                                                                            <label class="form-label">Payment
                                                                                Amount</label>
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control"
                                                                                    id="payment_total"
                                                                                    name="payment_total" placeholder="0"
                                                                                    oninput="formatThousandSeparator(this)"
                                                                                    onchange="calculateChange(this)">
                                                                                <button type="button"
                                                                                    class="col-lg-3 btn btn-primary ms-2"
                                                                                    onclick="paymentFull()">Payment
                                                                                    Full</button>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div id="div-cash">
                                                                        <div class="mb-3 input-blocks">
                                                                            <label class="form-label">Payment
                                                                                Change</label>
                                                                            <input type="text" class="form-control"
                                                                                id="payment_change" name="payment_change"
                                                                                placeholder="0" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 input-blocks" id="div-bank">
                                                                        <label class="form-label">Bank</label>
                                                                        <select class="select" name="bank"
                                                                            id="bank-select">
                                                                            @foreach ($banks as $bank)
                                                                                <option value="{{ $bank['code'] }}">
                                                                                    {{ $bank['name'] }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div id="div-account">
                                                                        <div class="mb-3 input-blocks">
                                                                            <label class="form-label">Account
                                                                                Number</label>
                                                                            <input type="text" class="form-control"
                                                                                id="account_number" name="account_number">
                                                                        </div>
                                                                        <div class="mb-3 input-blocks">
                                                                            <label class="form-label">Account
                                                                                Name</label>
                                                                            <input type="text" class="form-control"
                                                                                id="account_name" name="account_name">
                                                                        </div>
                                                                    </div>
                                                                    <div id="div-credit">
                                                                        <div class="mb-3 input-blocks">
                                                                            <label class="form-label">Card
                                                                                Number</label>
                                                                            <input type="text" class="form-control"
                                                                                id="card_number" name="card_number">
                                                                        </div>
                                                                        <div class="mb-3 input-blocks">
                                                                            <label class="form-label">Installment</label>
                                                                            <select class="select" name="installment"
                                                                                id="installment-select">

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div id="div-duedate">
                                                                        <div class="input-blocks">
                                                                            <label>Due Date</label>
                                                                            <div class="input-groupicon calender-input">
                                                                                <i data-feather="calendar"
                                                                                    class="info-img"></i>
                                                                                <input type="text"
                                                                                    class="datetimepicker" id="due-date"
                                                                                    name="due-date"
                                                                                    style="z-index: 1000;position: relative;"
                                                                                    placeholder="Choose">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-none">
                                                                        <input type="text" id="payment-desc"
                                                                            name="payment_desc">
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <div
                                                                            class="input-blocks summer-description-box transfer mb-3">
                                                                            <label>Notes</label>
                                                                            <textarea name="description" class="form-control h-100" rows="5" maxlength="300"></textarea>
                                                                            <p class="mt-1">Maximum 300 Characters
                                                                            </p>
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
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="btn-addproduct mb-4">
                        <button type="button" class="btn btn-cancel me-2"
                            onclick="window.location.href='{{ url('product') }}'">Cancel</button>
                        <button type="submit" class="btn btn-submit" id="submit-add-button">Save Order</button>
                    </div>
                </div>
            </form>
            <!-- /add -->

        </div>
    </div>
@endsection
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
                            {{-- <table class="table table-hover align-middle mb-0" id="item-list">
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
                            </table> --}}
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
<!-- Di head atau sebelum closing body -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="{{ asset('/build/js/page/order.js') }}"></script>
<script>
    const apiBrandUrl = 'brand/all';
    const apiCategoryUrl = 'category/all';
    const apiSupplierUrl = 'supplier/all';
    const apiSubcategoryUrl = 'subcategory';
    const apiContactUrl = 'contact/';
    document.addEventListener('alpine:init', () => {
        Alpine.data('orderData', () => ({
            suppliers: [],
            contacts: [],
            paymentMethods: @json($paymentMethods),
            orderItems: [],
            supplierId: '',
            contactId: '',
            contactName: '-',
            contactPosition: '-',
            contactPhone: '-',
            supplierName: '-',
            supplierAddress: '-',
            supplierEmail: '-',
            paymentMethod: 'cash',
            paymentAmount: 0,
            paymentChange: 0,
            totals: {
                subtotal: 0,
                discountAmount: 0,
                total: 0,
            },
            transactionId: `ORD-{{ now()->format('Ymd') }}-0001`,
            brands: [],
            categories: [],
            subcategories: [],
            brandId: '',
            categoryId: '',
            subcategoryId: '',
            loadingContacts: false,
            async fetchBrands() {
                try {
                    const data = await window.apiFetch({
                        endpoint: apiBrandUrl
                    });
                    this.brands = data.data || [];
                } catch (error) {
                    console.error("Error fetching brands:", error);
                }
            },
            async fetchSuppliers() {
                try {
                    const data = await window.apiFetch({
                        endpoint: apiSupplierUrl
                    });
                    this.suppliers = data.data || [];

                    this.$nextTick(() => {
                        const select = this.$refs.supplier;

                        // Tambahkan "All Suppliers"
                        const options = [{
                            id: '',
                            text: 'All Suppliers'
                        }].concat(
                            this.suppliers.map(s => ({
                                id: s.uuid,
                                text: s.name
                            }))
                        );

                        $(select).empty();
                        options.forEach(opt => {
                            const option = document.createElement('option');
                            option.value = opt.id;
                            option.textContent = opt.text;
                            select.appendChild(option);
                        });

                        $(select).select2({
                            dropdownParent: $(select).closest('.page-wrapper'),
                            placeholder: 'Silakan pilih',
                            allowClear: true
                        });

                        $(select).on('change', e => {
                            this.supplierId = e.target.value;
                            this.fetchContacts();
                            this.updateSupplierInfo();
                        });
                    });
                } catch (err) {
                    console.error('Error fetching suppliers:', err);
                }
            },
            async fetchContacts() {
                if (!this.supplierId) {
                    this.contacts = [];
                    this.contactId = '';
                    this.updateContactInfo();
                    this.loadingContacts = false;
                    return;
                }
                this.loadingContacts = true;
                const data = await window.apiFetch({
                    endpoint: apiContactUrl + this.supplierId
                });
                this.contacts = data.data || [];
                this.$dispatch('contacts-updated', this.contacts);
                this.$nextTick(() => {
                    const select = this.$refs.contact;

                    if (!select) {
                        console.warn('Select belum ready');
                        return;
                    }

                    $(select).empty();

                    this.contacts.forEach(c => {
                        const option = document.createElement('option');
                        option.value = c.uuid;
                        option.textContent = c.name;
                        select.appendChild(option);
                    });

                    $(select).select2({
                        placeholder: 'Select Contact',
                        allowClear: true
                    });

                    $(select).val(this.contactId).trigger('change');

                    $(select).on('change', e => {
                        this.contactId = e.target.value;
                        this.updateContactInfo();
                    });
                });
            },

            updateContactInfo() {
                const contact = this.contacts.find(c => c.uuid === this.contactId) || {};
                this.contactName = contact.name || '-';
                this.contactPosition = contact.position || '-';
                this.contactPhone = contact.phone || '-';
            },

            updateSupplierInfo() {
                const supplier = this.suppliers.find(s => s.uuid === this.supplierId) || {};
                this.supplierName = supplier.name || '-';
                this.supplierAddress = supplier.address || '-';
                this.supplierEmail = supplier.email || '-';
            },
            async fetchCategories() {
                try {
                    const data = await window.apiFetch({
                        endpoint: apiCategoryUrl
                    });
                    this.categories = data.data || [];
                } catch (error) {
                    console.error("Error fetching categories:", error);
                }
            },
            async fetchSubcategories(categoryId) {
                try {
                    const data = await window.apiFetch({
                        endpoint: `${apiSubcategoryUrl}/${categoryId}`
                    });
                    this.subcategories = data.data || [];
                } catch (error) {
                    console.error("Error fetching subcategories:", error);
                }
            },
            updateSupplierInfo() {
                const supplier = this.suppliers.find(s => s.uuid === this.supplierId) || {};
                this.supplierName = supplier.name || '-';
                this.supplierAddress = supplier.address || '-';
                this.supplierEmail = supplier.email || '-';
            },
            updateContactInfo() {
                const contact = this.contacts.find(c => c.uuid === this.contactId) || {};
                this.contactName = contact.name || '-';
                this.contactPosition = contact.position || '-';
                this.contactPhone = contact.phone || '-';
            },
            recalculateTotal() {
                const subtotal = this.orderItems.reduce((acc, item) => acc + (item.qty * item
                    .sell_price), 0);
                const discountAmount = subtotal * 0.1; // Example: 10% discount
                const total = subtotal - discountAmount;

                this.totals = {
                    subtotal,
                    discountAmount,
                    total
                };
                this.updateChange();
            },

            formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(amount);
            },

            addItem(item) {
                const existing = this.orderItems.find(i => i.sku === item.sku);
                if (existing) {
                    existing.qty++;
                } else {
                    this.orderItems.push({
                        ...item,
                        qty: 1
                    });
                }
                this.recalculateTotal();
            },

            // Remove item from the order
            removeItem(sku) {
                this.orderItems = this.orderItems.filter(item => item.sku !== sku);
                this.recalculateTotal();
            },

            // Select/Deselect all items
            selectAllItems() {
                const isSelected = document.getElementById("select-all").checked;
                this.orderItems.forEach(item => item.selected = isSelected);
            },

            // Reset order form (clear all items, payment, supplier, etc.)
            cancelOrder() {
                this.orderItems = [];
                this.supplierId = '';
                this.contactId = '';
                this.paymentAmount = 0;
                this.recalculateTotal();
            },
            updateChange() {
                this.paymentChange = this.paymentAmount >= this.totals.total ? this
                    .paymentAmount -
                    this.totals.total : 0;
            },
            dropdownContact() {
                return {
                    open: false,
                    contacts: [],
                    selected: null,
                    selectedName: '',

                    init() {
                        this.contacts = this.$root.contacts || [];
                    },

                    toggle() {
                        this.open = !this.open;
                    },

                    select(contact) {
                        this.selected = contact;
                        this.selectedName = contact.name;
                        this.open = false;

                        this.$dispatch('contact-selected', contact);
                    }
                }
            },
            handleContact(contact) {
                this.contactId = contact.uuid;
                this.contactName = contact.name;
                this.contactPosition = contact.position;
                this.contactPhone = contact.phone;
            },
            init() {
                this.fetchSuppliers();
                this.fetchBrands();
                this.fetchCategories();
                this.fetchSubcategories();
                generateTransactionID("ORD"); // Tambahkan
                document.getElementById('transaction-id').textContent = this.transactionId;
                document.getElementById('trx_id').value = this.transactionId;
            }

        }));
    });
</script>
