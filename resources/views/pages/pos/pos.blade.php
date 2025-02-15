<?php $page = 'pos'; ?>
@extends('pages.layout.mainlayout')
@section('content')
    <div class="page-wrapper pos-pg-wrapper ms-0">
        <div class="content pos-design p-0">
            <div class="btn-row d-sm-flex align-items-center">
                <a href="javascript:void(0);" class="btn btn-secondary mb-xs-3" data-bs-toggle="modal"
                    data-bs-target="#orders"><span class="me-1 d-flex align-items-center"><i data-feather="shopping-cart"
                            class="feather-16"></i></span>View Orders</a>
                <a href="javascript:void(0);" class="btn btn-info"><span class="me-1 d-flex align-items-center"><i
                            data-feather="rotate-cw" class="feather-16"></i></span>Reset</a>
                <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#recents"><span
                        class="me-1 d-flex align-items-center"><i data-feather="refresh-ccw"
                            class="feather-16"></i></span>Transaction</a>
            </div>

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
                                <span>80 Items</span>
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
                                                        <p>{{ $item['sell_price'] }}</p>
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
                                <span>Transaction ID : #<span id="transaction-id" name="transaction_id"></span></span>
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
                                    <select class="select2 form-control" name="customer">
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
                                            <select class="select">
                                                <option>GST 5%</option>
                                                <option>GST 10%</option>
                                                <option>GST 15%</option>
                                                <option>GST 20%</option>
                                                <option>GST 25%</option>
                                                <option>GST 30%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="input-block">
                                            <label>Shipping</label>
                                            <select class="select">
                                                <option>15</option>
                                                <option>20</option>
                                                <option>25</option>
                                                <option>30</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="input-block">
                                            <label>Discount</label>
                                            <select class="select">
                                                <option>10%</option>
                                                <option>10%</option>
                                                <option>15%</option>
                                                <option>20%</option>
                                                <option>25%</option>
                                                <option>30%</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="order-total">
                                <table class="table table-responsive table-borderless">
                                    <tr>
                                        <td>Sub Total</td>
                                        <td class="text-end" id="subtotal">0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Tax (GST 5%)</td>
                                        <td class="text-end" id="tax">0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Shipping</td>
                                        <td class="text-end" id="shipping">0.00</td>
                                    </tr>
                                    <tr>
                                        <td class="danger">Discount (10%)</td>
                                        <td class="danger text-end" id="discount">0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td class="text-end"><span  id="total"></span> IDR</td>
                                    </tr>
                                </table>
                            </div>
                            

                            <div class="block-section payment-method">
                                <h6>Payment Method</h6>
                                <div class="row d-flex align-items-center justify-content-center methods">
                                    <div class="col-md-6 col-lg-4 item">
                                        <div class="default-cover">
                                            <a href="javascript:void(0);">
                                                <img src="{{ URL::asset('/build/img/icons/cash-pay.svg')}}"
                                                    alt="Payment Method">
                                                <span>Cash</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 item">
                                        <div class="default-cover">
                                            <a href="javascript:void(0);">
                                                <img src="{{ URL::asset('/build/img/icons/credit-card.svg')}}"
                                                    alt="Payment Method">
                                                <span>Debit Card</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 item">
                                        <div class="default-cover">
                                            <a href="javascript:void(0);">
                                                <img src="{{ URL::asset('/build/img/icons/qr-scan.svg')}}" alt="Payment Method">
                                                <span>Scan</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid btn-block">
                                <a class="btn btn-secondary" href="javascript:void(0);">
                                    Grand Total : <span id="grandtotal"></span><span> IDR</span>
                                </a>
                            </div>
                            <div class="btn-row d-sm-flex align-items-center justify-content-between">
                                <a href="javascript:void(0);" class="btn btn-info btn-icon flex-fill"
                                    data-bs-toggle="modal" data-bs-target="#hold-order"><span
                                        class="me-1 d-flex align-items-center"><i data-feather="pause"
                                            class="feather-16"></i></span>Hold</a>
                                <a href="javascript:void(0);" class="btn btn-danger btn-icon flex-fill"><span
                                        class="me-1 d-flex align-items-center"><i data-feather="trash-2"
                                            class="feather-16"></i></span>Void</a>
                                <a href="javascript:void(0);" class="btn btn-success btn-icon flex-fill"
                                    data-bs-toggle="modal" data-bs-target="#payment-completed"><span
                                        class="me-1 d-flex align-items-center"><i data-feather="credit-card"
                                            class="feather-16"></i></span>Payment</a>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
    <script>
            const productCategoryRoute = @json(route('product-category', ['category_id' => 'CATEGORY_ID']));
            const productElements = document.querySelectorAll('.product-info');
            const selectElement = document.getElementById('item-select');
            const sales = @json($sales, JSON_UNESCAPED_SLASHES);
            const items = @json($items, JSON_UNESCAPED_SLASHES);
            const salesList = document.getElementById('sales-list');

            const shippingCost = 40.21; // Fixed shipping cost
            const taxRate = 0.05; // 5% GST
            const discountRate = 0.10; // 10% discount

            document.addEventListener('DOMContentLoaded', function() {
                $(selectElement).select2();

                // Event listener for Select2 change event
                $(selectElement).on('change', function() {
                    const selectedItemSku = $(this).val();
                    const selectedItem =items.find(item => item.sku === selectedItemSku);
                    if (selectedItem) {
                        addProductToSalesList(selectedItem);
                    }
                });
                function calculateTotals() {
                    let subtotal = 0;
                    const productItems = salesList.querySelectorAll('.product-list');

                    productItems.forEach(function(productItem) {
                        const qty = parseFloat(productItem.querySelector('input[name="qty"]').value);
                        const price = parseFloat(productItem.querySelector('.info p').innerText.replace('$', ''));
                        subtotal += qty * price;
                    });

                    const tax = subtotal * taxRate;
                    const discount = subtotal * discountRate;
                    const total = subtotal + tax + shippingCost - discount;

                    const options = { minimumFractionDigits: 2, maximumFractionDigits: 2 };
                    document.getElementById('subtotal').innerText = subtotal.toLocaleString('de-DE', options);
                    document.getElementById('tax').innerText = tax.toLocaleString('de-DE', options);
                    document.getElementById('shipping').innerText = shippingCost.toLocaleString('de-DE', options);
                    document.getElementById('discount').innerText = `-${discount.toLocaleString('de-DE', options)}`;
                    document.getElementById('total').innerText = total.toLocaleString('de-DE', options);
                    document.getElementById('grandtotal').innerText = total.toLocaleString('de-DE', options);
        
                }
                sales.forEach(function(sale) {
                    var saleDiv = `
                        <div class="default-cover p-4 mb-4">
                            <span class="badge bg-secondary d-inline-block mb-4">Order ID : #${sale.trx_id}</span>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 record mb-3">
                                    <table>
                                        <tr class="mb-3">
                                            <td>Cashier</td>
                                            <td class="colon">:</td>
                                            <td class="text">${sale.created_by}</td>
                                        </tr>
                                        <tr>
                                            <td>Customer</td>
                                            <td class="colon">:</td>
                                            <td class="text">${sale.cust_name}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-sm-12 col-md-6 record mb-3">
                                    <table>
                                        <tr>
                                            <td>Total</td>
                                            <td class="colon">:</td>
                                            <td class="text">${sale.final_total} ${sale.currency.toUpperCase()}</td>
                                        </tr>
                                        <tr>
                                            <td>Date</td>
                                            <td class="colon">:</td>
                                            <td class="text">${convertTimestamp(sale.created_at)}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <p class="p-4">${sale.description}</p>
                            <div class="btn-row d-sm-flex align-items-center justify-content-between">
                                <a href="javascript:void(0);" class="btn btn-info btn-icon flex-fill">Open</a>
                                <a href="javascript:void(0);" class="btn btn-danger btn-icon flex-fill">Products</a>
                                <a href="javascript:void(0);" class="btn btn-success btn-icon flex-fill">Print</a>
                            </div>
                        </div>
                    `;

                    if (sale.payment_status === 2) {
                        document.getElementById('sales-hold-list').innerHTML += saleDiv;
                    } else if (sale.payment_status === 1) {
                        document.getElementById('sales-unpaid-list').innerHTML += saleDiv;
                    } else if (sale.payment_status === 0) {
                        document.getElementById('sales-paid-list').innerHTML += saleDiv;
                    }
                });
                function generateTransactionID() {
                    const unixTimestamp = Math.floor(Date.now() / 1000);
                    const randomNumber = Math.floor(100000 + Math.random() * 900000);
                    return `${unixTimestamp}${randomNumber}`;
                }
                function updateSalesItemCount() {
                    const itemCount = salesList.querySelectorAll('.product-list').length;
                    document.getElementById('sales-item-count').innerText = itemCount;
                    calculateTotals();
                }
                window.removeSalesItem = function(itemId) {
                    const salesItem = document.getElementById(`sales-item-${itemId}`);
                    if (salesItem) {
                        salesItem.remove();
                        updateSalesItemCount();
                    }            
                };
                document.getElementById('transaction-id').innerText = generateTransactionID();

                productElements.forEach(function(productElement) {
                    productElement.addEventListener('click', function() {
                        const itemId = this.id.split('-')[1];
                        const selectedItem = items.find(item => item.sku === itemId);
                        addProductToSalesList(selectedItem);
                    });
                });
                selectElement.addEventListener('change', function() {
                    const selectedItemSku = this.value;
                    const selectedItem = items.find(item => item.sku === selectedItemSku);
                    if (selectedItem) {
                        addProductToSalesList(selectedItem);
                    }
                });
                function addProductToSalesList(item) {
                    const itemId = item.sku;
                    let itemQty = 1;
                    const itemName = item.name;
                    const itemImage = item.image_url;
                    const itemPrice = item.sell_price;
                    const itemStock = item.stock;

                    let existingProduct = salesList.querySelector(`.product-info[data-item="${itemId}"]`);
                    if (existingProduct) {
                        let qtyInput = document.getElementById("qty-" + itemId);
                        itemQty = parseInt(qtyInput.value) + 1;
                        qtyInput.value = itemQty; // Update the quantity input value
                    } else {
                        let productHtml = `
                            <div class="product-list d-flex align-items-center justify-content-between" id="sales-item-${itemId}">
                                <div class="d-flex align-items-center product-info" data-item="${itemId}">
                                    <a href="javascript:void(0);" class="img-bg">
                                        <img src="${itemImage}" alt="Products">
                                    </a>
                                    <div class="info">
                                        <span>PT0005</span>
                                        <h6><a href="javascript:void(0);">${itemName}</a></h6>
                                        <p>${itemPrice}</p>
                                    </div>
                                </div>
                                <div class="qty-item text-center">
                                    <div class="d-none">
                                        <span id="sales-stock-${itemId}">${itemStock}</span>
                                        <span id="sales-price-${itemId}">${itemPrice}</span>
                                    </div>
                                    <a href="javascript:void(0);" class="dec d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="minus"><i data-feather="minus-circle" class="feather-14"></i></a>
                                    <input type="text" class="form-control text-center" id="qty-${itemId}" name="qty" value="${itemQty}">
                                    <a href="javascript:void(0);" class="inc d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="plus"><i data-feather="plus-circle" class="feather-14"></i></a>
                                </div>
                                <div class="d-flex align-items-center action">
                                    <a class="btn-icon edit-icon me-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-product">
                                        <i data-feather="edit" class="feather-14"></i>
                                    </a>
                                    <a class="btn-icon delete-icon confirm-text" href="javascript:void(0);" onclick="removeSalesItem('${itemId}')">
                                        <i data-feather="trash-2" class="feather-14"></i>
                                    </a>
                                </div>
                            </div>
                        `;
                        salesList.innerHTML += productHtml;
                        feather.replace();
                    }
                    updateSalesItemCount();
                }

                document.getElementById('sales-list').addEventListener("click", function (event) {
                    let target = event.target;
                    let qtyItem = target.closest(".qty-item");

                    if (!qtyItem) return; // If not clicking inside qty-item, do nothing

                    let inputField = qtyItem.querySelector("input");
                    let itemId = inputField.id.replace("qty-", ""); // Extract itemId
                    let stock = parseInt(document.getElementById(`sales-stock-${itemId}`).textContent, 10);
                    let price = parseFloat(document.getElementById(`sales-price-${itemId}`).textContent);
                    let infoDiv = qtyItem.closest(".product-list").querySelector(".info p"); // Get price display
                    let qty = parseInt(inputField.value, 10);

                    // Handle decrement (-)
                    if (target.closest(".dec")) {
                        if (qty > 1) {
                            qty--;
                            inputField.value = qty;
                            infoDiv.textContent = (price * qty).toFixed(2); // Update total price
                        }
                    }

                    // Handle increment (+)
                    if (target.closest(".inc")) {
                        if (qty < stock) {
                            qty++;
                            inputField.value = qty;
                            infoDiv.textContent = (price * qty).toFixed(2); // Update total price
                        } else {
                            alert("Stock limit reached!");
                        }
                    }
                });

            });

    </script>
@endsection
