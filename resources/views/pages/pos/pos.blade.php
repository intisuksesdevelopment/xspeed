<?php $page = 'pos'; ?>
@extends('pages.layout.mainlayout')
@section('content')
    <div class="page-wrapper pos-pg-wrapper ms-0">
        <div class="content pos-design p-0">
            <div class="btn-row d-sm-flex align-items-center">
                <a href="javascript:void(0);" class="btn btn-secondary mb-xs-3" data-bs-toggle="modal"
                    data-bs-target="#orders"><span class="me-1 d-flex align-items-center"><i data-feather="shopping-cart"
                            class="feather-16"></i></span>View Orders</a>
                <a href="javascript:void(0);" onclick="reset()" class="btn btn-info"><span
                        class="me-1 d-flex align-items-center"><i data-feather="rotate-cw"
                            class="feather-16"></i></span>Reset</a>
                <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#recents"><span
                        class="me-1 d-flex align-items-center"><i data-feather="refresh-ccw"
                            class="feather-16"></i></span>Transaction</a>
            </div>
            <form id="posAddForm" method="post" action="{{ route('pos-add') }}">
                @csrf
                <div class="row align-items-start pos-wrapper">
                    <div class="col-md-12 col-lg-8">
                        <div class="pos-categories tabs_wrapper">
                            <h5>Categories</h5>
                            <p>Select From Below Categories</p>
                            <ul class="tabs owl-carousel pos-category" id="categoryList">
                                <li id="all">
                                    <a href="javascript:void(0);">
                                        <img src="{{ asset('build/img/categories/category-01.png') }}" alt="Categories">
                                    </a>
                                    <h6><a href="javascript:void(0);">All Categories</a></h6>
                                    <span>{{ $items->count() }} Items</span>
                                </li>
                                @foreach ($categories as $category)
                                    <li id="{{ $category['id'] }}" data-category-id="{{ $category['id'] }}">
                                        <a href="javascript:void(0);">
                                            <img src="{{ URL::asset($category['image_url']) }}" alt="Categories">
                                        </a>
                                        <h6><a href="javascript:void(0);">{{ $category['name'] }}</a></h6>
                                        <span>{{ $category['items_count'] ?? 0 }} Items</span>
                                    </li>
                                @endforeach

                            </ul>
                            <div class="pos-products">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="mb-3">Products</h5>
                                </div>
                                <div class="tabs_container">
                                </div>
                                <div class="tabs_container">
                                    <div class="tab_content active" data-tab="all">
                                        <div class="row">
                                            @foreach ($items as $item)
                                                <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3">
                                                    <div class="product-info default-cover card"
                                                        id="product-{{ $item['sku'] }}">
                                                        <a href="javascript:void(0);" class="img-bg">
                                                            <img src="{{ URL::asset($item['image_url']) }}" alt="Products"
                                                                style="width: 65px; height: 80px;">
                                                            <span><i data-feather="check" class="feather-16"></i></span>
                                                        </a>
                                                        <h6 class="cat-name"><a
                                                                href="javascript:void(0);">{{ $item['category']['name'] }}</a>
                                                        </h6>
                                                        <h6 class="product-name"><a
                                                                href="javascript:void(0);">{{ $item['name'] }}</a>
                                                        </h6>
                                                        <div
                                                            class="d-flex align-items-center justify-content-between price">
                                                            <span class="d-none" id="stock-{{ $item['sku'] }}"
                                                                data-value="{{ \App\Services\UtilService::clearDecimal($item['stock']) }}"></span>
                                                            <span class="d-none" id="price-{{ $item['sku'] }}"
                                                                data-value="{{ $item['sell_price'] }}"></span>
                                                            <span>{{ \App\Services\UtilService::clearDecimal($item['stock']) }}
                                                                {{ $item['unit'] }}</span>
                                                            <p>{{ \App\Services\UtilService::formatCurrency($item['sell_price'], $item['currency']) }}
                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @foreach ($categories as $category)
                                        <div class="tab_content" data-tab="{{ $category['id'] }}">
                                            <div class="row" id="content-{{ $category['id'] }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 ps-0">
                        <aside class="product-order-list">
                            <div class="head d-flex align-items-center justify-content-between w-100">
                                <div class="">
                                    <h5>Order List</h5>
                                    <span>Transaction ID : #<span id="transaction-id"></span></span>
                                    <span class="d-none">Transaction ID : #<input id="trx_id" name="trx_id"></span>
                                    <span class="d-none">Transaction ID : #<input id="type" name="type"
                                            value="sales"></span>
                                </div>
                                <div class="">
                                    <a class="confirm-text" href="javascript:void(0);"><i data-feather="trash-2"
                                            class="feather-16 text-danger"></i></a>
                                    <a href="javascript:void(0);" class="text-default"><i data-feather="more-vertical"
                                            class="feather-16"></i></a>
                                </div>
                            </div>
                            <div class="customer-info block-section">
                                <h6>Customer Information</h6>
                                <div class="input-block d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <select class="select2 form-control" name="customer" id="customer-select"
                                            onchange="calculate()">
                                            <option selected value="walkin">Walk in Customer</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer['code'] }}">{{ $customer['name'] }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <a href="#" class="btn btn-primary btn-icon" data-bs-toggle="modal"
                                        data-bs-target="#create"><i data-feather="user-plus" class="feather-16"></i></a>
                                </div>
                                <div class="input-block mt-3">
                                    <label>Warehouse</label>
                                    <select class="select2 form-control" name="warehouse" id="warehouse-select" required>
                                        <option value="">Select Warehouse</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse['id'] }}" {{ $loop->first ? 'selected' : '' }}>
                                                {{ $warehouse['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="card-body">
                                    <select class="select2 form-control" name="item" id="item-select">
                                        <option disabled selected>Loading...</option>
                                    </select>
                                </div>
                                <!-- Hidden fields for backend -->
                                <input type="hidden" name="transactionId" id="transactionId">
                                <input type="hidden" name="customerUuid" id="customerUuid">
                                <input type="hidden" name="warehouseId" id="warehouseId"
                                    value="{{ $warehouses->first()['id'] ?? 1 }}">
                                <input type="hidden" name="taxPercent" id="taxPercent" value="10">
                                <input type="hidden" name="discPercent" id="discPercent" value="0">
                            </div>

                            <div class="product-added block-section">
                                <div class="head-text d-flex align-items-center justify-content-between">
                                    <h6 class="d-flex align-items-center mb-0">Product Added<span class="count"
                                            id="sales-item-count">0</span></h6>
                                    <a href="javascript:void(0);" class="d-flex align-items-center text-danger"><span
                                            class="me-1"><i data-feather="x" class="feather-16"></i></span>Clear
                                        all</a>
                                </div>
                                <div class="product-wrap" id="sales-list">

                                </div>
                            </div>
                            <div class="block-section">
                                <div class="selling-info">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">
                                            <div class="input-block">
                                                <label>Order Tax</label>
                                                <select class="select " name="tax" id="tax-select"
                                                    onchange="calculate()">
                                                    <option value="10">10%</option>
                                                    <option value="11">11%</option>
                                                    <option value="12">12%</option>
                                                    <option value="13">13%</option>
                                                    <option value="14">14%</option>
                                                    <option value="15">15%</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="input-block">
                                                <label>Shipping</label>
                                                <select class="select" name="shipping" id="shipping-select"
                                                    onchange="calculate()">
                                                    <option selected value="0">0</option>
                                                    <option value="10000">10.000</option>
                                                    <option value="15000">15.000</option>
                                                    <option value="20000">25.000</option>
                                                    <option value="30000">30.000</option>
                                                    <option value="50000">50.000</option>
                                                    <option value="75000">70.000</option>
                                                    <option value="100000">100.000</option>
                                                    <option value="1500000">150.000</option>
                                                    <option value="2000000">200.000</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="input-block">
                                                <label>Discount</label>
                                                <select class="select" name="discount" id="discount-select"
                                                    onchange="calculate()">
                                                    <option selected value="0">0%</option>
                                                    <option value="1">1%</option>
                                                    <option value="2">2%</option>
                                                    <option value="3">3%</option>
                                                    <option value="4">4%</option>
                                                    <option value="5">5%</option>
                                                    <option value="6">6%</option>
                                                    <option value="7">7%</option>
                                                    <option value="8">8%</option>
                                                    <option value="9">9%</option>
                                                    <option value="10">10%</option>
                                                    <option value="11">11%</option>
                                                    <option value="12">12%</option>
                                                    <option value="13">13%</option>
                                                    <option value="14">14%</option>
                                                    <option value="15">15%</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                            <td class="text-end"><span id="total">0,00</span> IDR</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="d-grid btn-block">
                                    <a class="btn btn-secondary" href="javascript:void(0);">
                                        Grand Total : <span id="grandtotal">0,00</span><span> IDR</span>
                                    </a>
                                </div>
                                <div class="block-section payment-method">
                                    <h6>Payment Method</h6>
                                    <style>
                                        /* Hide conditional payment divs by default, div-payment always visible */
                                        #div-cash,
                                        #div-bank,
                                        #div-account,
                                        #div-credit,
                                        #div-duedate {
                                            display: none;
                                        }
                                    </style>
                                    <div class="row d-flex align-items-center justify-content-center methods">
                                        <div class="col-12 col-md-12 col-lg-12 col-sm-12">
                                            <div class="input-blocks mb-3 ">
                                                <select class="select" name="payment_method" id="payment-method-select"
                                                    onchange="paymentMethodChange()">
                                                    @foreach ($paymentMethods as $paymentMethod)
                                                        <option value="{{ $paymentMethod['id'] }}"
                                                            data-method="{{ $paymentMethod['name'] }}"
                                                            data-installments='{{ $paymentMethod['installments'] ?? '[]' }}'>
                                                            {{ $paymentMethod['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="div-payment">
                                                <div class="mb-3 input-blocks">
                                                    <label class="form-label">Payment Amount</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="payment_total"
                                                            name="payment_total" placeholder="0"
                                                            oninput="formatThousandSeparator(this)"
                                                            onchange="calculateChange(this)">
                                                        <button type="button" class="col-lg-3 btn btn-primary ms-2"
                                                            onclick="paymentFull()">Payment Full</button>

                                                    </div>
                                                </div>
                                            </div>
                                            <div id="div-cash">
                                                <div class="mb-3 input-blocks">
                                                    <label class="form-label">Payment Change</label>
                                                    <input type="text" class="form-control" id="payment_change"
                                                        name="payment_change" placeholder="0" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3 input-blocks" id="div-bank">
                                                <label class="form-label">Bank</label>
                                                <select class="select" name="bank" id="bank-select">
                                                    @foreach ($banks as $bank)
                                                        <option value="{{ $bank['code'] }}">{{ $bank['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="div-account">
                                                <div class="mb-3 input-blocks">
                                                    <label class="form-label">Account Number</label>
                                                    <input type="text" class="form-control" id="account_number"
                                                        name="account_number">
                                                </div>
                                                <div class="mb-3 input-blocks">
                                                    <label class="form-label">Account Name</label>
                                                    <input type="text" class="form-control" id="account_name"
                                                        name="account_name">
                                                </div>
                                            </div>
                                            <div id="div-credit">
                                                <div class="mb-3 input-blocks">
                                                    <label class="form-label">Card Number</label>
                                                    <input type="text" class="form-control" id="card_number"
                                                        name="card_number">
                                                </div>
                                                <div class="mb-3 input-blocks">
                                                    <label class="form-label">Installment</label>
                                                    <select class="select" name="installment" id="installment-select">

                                                    </select>
                                                </div>
                                            </div>
                                            <div id="div-duedate">
                                                <div class="input-blocks">
                                                    <label>Due Date</label>
                                                    <div class="input-groupicon calender-input">
                                                        <i data-feather="calendar" class="info-img"></i>
                                                        <input type="text" class="datetimepicker" id="due-date"
                                                            name="due-date" style="z-index: 1000;position: relative;"
                                                            placeholder="Choose">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-none">
                                                <input type="text" id="payment-desc" name="payment_desc">
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="input-blocks summer-description-box transfer mb-3">
                                                    <label>Notes</label>
                                                    <textarea name="description" class="form-control h-100" rows="5" maxlength="300"></textarea>
                                                    <p class="mt-1">Maximum 300 Characters</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="btn-row d-sm-flex align-items-center justify-content-between">
                                    <a href="javascript:void(0);" class="btn btn-info btn-icon flex-fill"
                                        data-bs-toggle="modal" data-bs-target="#hold-order" onclick="submitOrder(2)">
                                        <span class="me-1 d-flex align-items-center"><i data-feather="pause"
                                                class="feather-16"></i></span>
                                        Hold
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-icon flex-fill"
                                        onclick="deleteOrder('void')">
                                        <span class="me-1 d-flex align-items-center"><i data-feather="trash-2"
                                                class="feather-16"></i></span>
                                        Delete
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-success btn-icon flex-fill"
                                        {{-- data-bs-toggle="modal" data-bs-target="#payment-completed"  --}} onclick="submitOrder(0)">
                                        <span class="me-1 d-flex align-items-center"><i data-feather="credit-card"
                                                class="feather-16"></i></span>
                                        Payment
                                    </a>
                                </div>

                            </div>
                        </aside>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- View Orders Modal -->
    <div class="modal fade" id="orders" tabindex="-1" aria-labelledby="ordersLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ordersLabel">View Orders</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="orders-table-body">
                                <tr>
                                    <td colspan="6" class="text-center">No orders found</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction History Modal -->
    <div class="modal fade" id="recents" tabindex="-1" aria-labelledby="recentsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="recentsLabel">Recent Transactions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Payment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="transactions-table-body">
                                @if ($sales && count($sales) > 0)
                                    @foreach ($sales as $sale)
                                        <tr>
                                            <td>{{ $sale['trx_id'] ?? '-' }}</td>
                                            <td>{{ $sale['cust_name'] ?? 'Walk-in' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($sale['created_at'])->format('d M Y H:i') }}</td>
                                            <td>{{ $sale['sub_total_item'] ?? 0 }} items</td>
                                            <td>{{ \App\Services\UtilService::formatCurrency($sale['final_total'] ?? 0, $sale['currency'] ?? 'IDR') }}
                                            </td>
                                            <td>
                                                @if ($sale['payment_status'] == 0)
                                                    <span class="badge bg-success">Paid</span>
                                                @elseif($sale['payment_status'] == 1)
                                                    <span class="badge bg-warning">Partial</span>
                                                @else
                                                    <span class="badge bg-danger">Unpaid</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);" class="btn btn-sm btn-info"
                                                    onclick="viewTransaction('{{ $sale['trx_id'] }}')">
                                                    <i data-feather="eye" class="feather-14"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">No transactions found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hold Order Modal -->
    <div class="modal fade" id="hold-order" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Held</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <i data-feather="check-circle" class="feather-40 text-success mb-3"></i>
                    <h4>Order Held Successfully</h4>
                    <p>You can resume this order later from View Orders</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('/build/js/page/pos.js') }}"></script>

    <script>
        const encodedSales = @json($sales);
        const encodedItems = @json($items);
        const encodedCustomers = @json($customers);
        const productCategoryRoute = @json(route('product-category', ['category_id' => 'CATEGORY_ID']));
        const apiProductUrl = 'product/';
        const apiBrandUrl = 'brand/all';
        const apiCategoryUrl = 'category/all';

        // Configuration for POS
        const config = {
            ppn_rate: 10,
            currency: 'IDR'
        };

        // View transaction details
        function viewTransaction(trxId) {
            console.log('View transaction:', trxId);
            // TODO: Implement transaction detail view
            Swal.fire('Info', 'Transaction detail view coming soon', 'info');
        }

        /* =========================
           INIT ITEM SELECT (AJAX)
        ========================= */
        const Select2Cache = {};

        function safeDestroySelect2($el) {
            if ($el.hasClass("select2-hidden-accessible")) {
                $el.blur();
                $el.select2('destroy');
            }
        }

        async function apiFetch(options) {
            const { endpoint, params = {} } = options;
            const queryString = new URLSearchParams(params).toString();
            const url = `/api/${endpoint}${queryString ? '?' + queryString : ''}`;

            const res = await fetch(url, {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }

            return res.json();
        }

        async function loadSelect2($el, options) {
            const {
                endpoint,
                placeholder = 'Select',
                params = {},
                map = (item) => ({
                    id: item.uuid ?? item.sku ?? item.id,
                    text: item.name,
                    data: item
                }),
                cacheKey = null
            } = options;

            if (cacheKey && Select2Cache[cacheKey]) {
                renderOptions($el, Select2Cache[cacheKey], placeholder, map);
                return Select2Cache[cacheKey];
            }

            $el.prop('disabled', true);

            const res = await apiFetch({ endpoint, params });
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
            $el.append(new Option('', '', false, false));
            data.forEach(item => {
                const opt = map(item);
                $el.append(new Option(opt.text, opt.id, false, false));
            });
            $el.select2({
                placeholder,
                allowClear: true,
                width: '100%'
            });
            $el.val(null).trigger('change');
        }

        function escapeHtml(str) {
            return $('<div>').text(str || '').html();
        }

        async function initItemSelect() {
            const $item = $('#item-select');

            $item.select2({
                ajax: {
                    url: '/api/' + apiProductUrl + 'search',
                    headers: {
                        'Accept': 'application/json'
                    },
                    data: function(params) {
                        return {
                            q: params.term,
                            limit: 10
                        };
                    },
                    processResults: function(data) {
                        const items = data.data || [];
                        return {
                            results: items.map(item => ({
                                id: item.sku,
                                text: item.name + ' - ' + item.sku,
                                data: item
                            }))
                        };
                    }
                },
                placeholder: 'Cari Produk...',
                allowClear: true,
                width: '100%',
                minimumInputLength: 2
            });

            $item.on('select2:select', function(e) {
                const item = e.params.data.data;
                if (item) {
                    addProductToSales(item);
                }
            });

            $item.on('select2:clear', function(e) {
                salesItems = [];
                renderSalesList();
            });
        }

        // Add product to sales list
        function addProductToSales(item) {
            // Check if item already exists in sales
            const existingIndex = salesItems.findIndex(s => s.sku === item.sku);

            if (existingIndex !== -1) {
                // Increment quantity if already exists
                salesItems[existingIndex].qty += 1;
            } else {
                // Add new item
                salesItems.push({
                    sku: item.sku,
                    name: item.name,
                    price: item.sell_price,
                    qty: 1,
                    stock: item.stock,
                    unit: item.unit
                });
            }

            renderSalesList();
            calculate();
        }

        // Initialize on document ready
        $(document).ready(function() {
            initItemSelect();
        });
    </script>
@endsection
