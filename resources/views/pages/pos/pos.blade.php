<?php $page = 'pos'; ?>
@extends('pages.layout.mainlayout')
@section('content')
    <div class="page-wrapper pos-pg-wrapper ms-0">
        <div class="content pos-design p-0">
            <div class="btn-row d-sm-flex align-items-center">
                <a href="javascript:void(0);" class="btn btn-secondary mb-xs-3" data-bs-toggle="modal"
                    data-bs-target="#orders"><span class="me-1 d-flex align-items-center"><i data-feather="shopping-cart"
                            class="feather-16"></i></span>View Orders</a>
                <a href="javascript:void(0);" onclick="reset()" class="btn btn-info"><span class="me-1 d-flex align-items-center"><i
                            data-feather="rotate-cw" class="feather-16"></i></span>Reset</a>
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
                                        <img src="{{ URL::asset('/build/img/categories/category-01.png') }}" alt="Categories">
                                    </a>
                                    <h6><a href="javascript:void(0);">All Categories</a></h6>
                                    <span>{{ $items->count() }} Items</span>
                                </li>
                                @foreach($categories as $category)
                                    <li id="{{ $category['id']}}" data-category-id="{{ $category['id'] }}">
                                        <a href="javascript:void(0);">
                                            <img src="{{ URL::asset($category['image_url']) }}" alt="Categories">
                                        </a>
                                        <h6><a href="javascript:void(0);">{{ $category['name'] }}</a></h6>
                                        <span>{{ $category['countItems'] }} Items</span>
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
                                            @foreach($items as $item)
                                                <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3">
                                                    <div class="product-info default-cover card" id="product-{{ $item['sku'] }}">
                                                        <a href="javascript:void(0);" class="img-bg">
                                                            <img src="{{ URL::asset( $item['image_url'] ) }}"
                                                                alt="Products" style="width: 65px; height: 80px;">
                                                            <span><i data-feather="check" class="feather-16"></i></span>
                                                        </a>
                                                        <h6 class="cat-name"><a href="javascript:void(0);">{{ $item['category']['name'] }}</a></h6>
                                                        <h6 class="product-name"><a href="javascript:void(0);">{{ $item['name'] }}</a>
                                                        </h6>
                                                        <div class="d-flex align-items-center justify-content-between price">
                                                            <span class=" d-none" id="stock-{{ $item['sku'] }}" value="{{ \App\Services\UtilService::clearDecimal($item['stock']) }}"></span>
                                                            <span class=" d-none" id="price-{{ $item['sku'] }}" value="{{ $item['sell_price'] }}"></span>
                                                            <span>{{ \App\Services\UtilService::clearDecimal($item['stock']).' '.$item['unit'] }}</span>
                                                            <p>{{\App\Services\UtilService::formatCurrency($item['sell_price'],$item['currency']) }}</p>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @foreach($categories as $category)
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
                                    <span>Transaction ID : #<span id="transaction-id" ></span></span>
                                    <span class="d-none">Transaction ID : #<input id="trx_id" name="trx_id"></span>
                                    <span class="d-none">Transaction ID : #<input id="type" name="type" value="sales"></span>
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
                                        <select class="select2 form-control" name="customer" id="customer-select" onchange="calculate()">
                                            <option selected value="walkin">Walk in Customer</option>
                                            @foreach($customers as $customer)
                                             <option value="{{ $customer['code']}}">{{ $customer['name']}}</option>
                                            @endforeach
                                        </select>
                                       
                                    </div>
                                    <a href="#" class="btn btn-primary btn-icon" data-bs-toggle="modal"
                                        data-bs-target="#create"><i data-feather="user-plus" class="feather-16"></i></a>
                                </div>
                                <div class="card-body">
                                    <select class="select2 form-control" name="item" id="item-select">
                                        <option disabled selected>Select Item ...</option>
                                        @foreach($items as $item)
                                            <option value="{{ $item['sku']}}">{{ $item['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
    
                            <div class="product-added block-section">
                                <div class="head-text d-flex align-items-center justify-content-between">
                                    <h6 class="d-flex align-items-center mb-0">Product Added<span class="count" id="sales-item-count">0</span></h6>
                                    <a href="javascript:void(0);" class="d-flex align-items-center text-danger"><span
                                            class="me-1"><i data-feather="x" class="feather-16"></i></span>Clear all</a>
                                </div>
                                <div class="product-wrap"  id="sales-list">
                                   
                                </div>
                            </div>
                            <div class="block-section">
                                <div class="selling-info">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">
                                            <div class="input-block">
                                                <label>Order Tax</label>
                                                <select class="select " name="tax" id="tax-select" onchange="calculate()">
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
                                                <select class="select" name="shipping" id="shipping-select" onchange="calculate()">
                                                    <option selected  value="0">0</option>
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
                                                <select class="select" name="discount" id="discount-select" onchange="calculate()">
                                                    <option selected  value="0">0%</option>
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
                                            <td class="text-end"><span  id="total">0,00</span> IDR</td>
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
                                    <div class="row d-flex align-items-center justify-content-center methods">
                                        <div class="col-12 col-md-12 col-lg-12 col-sm-12">
                                            <div class="input-blocks mb-3 ">
                                                <select class="select" name="payment_method" id="payment-method-select" onchange="paymentMethodChange()">
                                                    @foreach($paymentMethods as $paymentMethod)
                                                        <option value="{{ $paymentMethod['id']}}" data-method="{{ $paymentMethod['method']}}">{{ $paymentMethod['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="div-payment">
                                                <div class="mb-3 input-blocks">
                                                    <label class="form-label">Payment Amount</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="payment_total" name="payment_total" placeholder="0" oninput="formatThousandSeparator(this)" onchange="calculateChange(this)">
                                                        <button type="button" class="col-lg-3 btn btn-primary ms-2" onclick="paymentFull()">Payment Full</button>
    
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="div-cash">
                                                <div class="mb-3 input-blocks">
                                                    <label class="form-label">Payment Change</label>
                                                    <input type="text" class="form-control" id="payment_change" name="payment_change" placeholder="0" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3 input-blocks" id="div-bank">
                                                <label class="form-label">Bank</label>
                                                <select class="select" name="bank" id="bank-select">
                                                    @foreach($banks as $bank)
                                                        <option value="{{ $bank['code']}}">{{ $bank['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="div-account">
                                                <div class="mb-3 input-blocks">
                                                    <label class="form-label">Account Number</label>
                                                    <input type="text" class="form-control" id="account_number" name="account_number">
                                                </div>
                                                <div class="mb-3 input-blocks">
                                                    <label class="form-label">Account Name</label>
                                                    <input type="text" class="form-control" id="account_name" name="account_name">
                                                </div>
                                            </div>
                                            <div id="div-credit">
                                                <div class="mb-3 input-blocks">
                                                    <label class="form-label">Card Number</label>
                                                    <input type="text" class="form-control" id="card_number" name="card_number">
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
                                                        <input type="text" class="datetimepicker" id="due-date" name="due-date" style="z-index: 1000;position: relative;"
                                                            placeholder="Choose">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-none">
                                                <input type="text"  id="payment-desc" name="payment_desc" >
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
                                        <span class="me-1 d-flex align-items-center"><i data-feather="pause" class="feather-16"></i></span>
                                        Hold
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-icon flex-fill" onclick="deleteOrder('void')">
                                        <span class="me-1 d-flex align-items-center"><i data-feather="trash-2" class="feather-16"></i></span>
                                        Delete
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-success btn-icon flex-fill"
                                        {{-- data-bs-toggle="modal" data-bs-target="#payment-completed"  --}}
                                        onclick="submitOrder(0)">
                                        <span class="me-1 d-flex align-items-center"><i data-feather="credit-card" class="feather-16"></i></span>
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
    <script>
    const encodedSales = "{{ base64_encode(json_encode($sales)) }}";
    const encodedItems = "{{ base64_encode(json_encode($items)) }}";
    const encodedCustomers = "{{ base64_encode(json_encode($customers)) }}";
    const productCategoryRoute = @json(route('product-category', ['category_id' => 'CATEGORY_ID']));


    </script>
@endsection
