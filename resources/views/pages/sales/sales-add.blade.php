<?php $page = 'sales-add'; ?>
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
                    New Sale
                @endslot
                @slot('li_1')
                    Create new sale
                @endslot
                @slot('li_2')
                    {{ url('admin/sales') }}
                @endslot
                @slot('li_3')
                    Back to Sales
                @endslot
            @endcomponent

            <form id="salesAddForm" method="post" action="{{ route('api-sales-add') }}">
                @csrf

                <div class="card">
                    <div class="card-body add-product pb-0">

                        <!-- SALES INFO -->
                        <div class="accordion" id="accordionExample">

                            <div class="accordion-item">
                                <div class="accordion-header">
                                    <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                        <h5>Sales Information</h5>
                                    </div>
                                </div>

                                <div id="collapseOne" class="accordion-collapse collapse show">

                                    <div class="accordion-body">

                                        <!-- TRX -->
                                        <span>Transaction ID : #<span id="transaction-id"></span></span>
                                        <input type="hidden" id="transactionId" name="transactionId">
                                        <input type="hidden" name="type" value="sales">
                                        <input type="hidden" name="taxPercent" value="0">
                                        <input type="hidden" name="taxAmount" value="0">
                                        <input type="hidden" name="discPercent" value="0">
                                        <input type="hidden" name="discAmount" value="0">

                                        <div class="row g-2 mt-2 position-relative">
                                            <!-- CUSTOMER -->
                                            <div class="col-lg-3">
                                                <label>Customer Name</label>
                                                <select id="customer-select" name="customerUuid" class="form-select">
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
                                                <label>Tax Type</label>
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

                                                    <div><b>Customer:</b> <span id="customer-name">-</span></div>
                                                    <div><b>Address:</b> <span id="customer-address">-</span></div>
                                                    <div><b>Email:</b> <span id="customer-email">-</span></div>

                                                </div>

                                            </div>

                                        </div>
                                        <div class="row g-2 mt-2">
                                            <!-- WAREHOUSE -->
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
                                        <h5>Product Sales</h5>
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

                                            <tbody id="sales-table-body"></tbody>
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
                            <button type="submit" class="btn btn-primary">Save Sale</button>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>

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
                            <option value="">Loading...</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bank Account <span class="text-danger">*</span></label>
                        <select id="bank_account_select" class="form-select">
                            <option value="">Loading...</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="div_manual_bank_account">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label">Bank <span class="text-danger">*</span></label>
                                <select id="manual_bank_id" class="form-select">
                                    <option value="">Pilih Bank</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor Rekening <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="manual_account_number"
                                    placeholder="1234567890">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Pemilik <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="manual_account_name"
                                    placeholder="Nama Pemilik Rekening">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Cabang</label>
                                <input type="text" class="form-control" id="manual_branch" placeholder="Cabang Bank">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 d-none" id="div_installment_period">
                        <label class="form-label">Periode Cicilan <span class="text-danger">*</span></label>
                        <select id="installment_period_select" class="form-select">
                            <option value="">Pilih Periode</option>
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
                    <button type="button" id="btn-confirm-payment" class="btn btn-primary">Confirm &amp; Pay</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Payment Modal -->

    <!-- script -->
    <script src="{{ asset('/build/js/page/sales.js') }}"></script>
    <script>
        const apiCustomerUrl = 'customer/all';
        const apiWarehouseUrl = 'warehouse/all';
        const apiProductUrl   = 'product/';
        const apiPaymentMethodUrl = 'payment-method/all';
        const apiBankAccountUrl   = 'bank-account/all';
        const config = @json($config);
    </script>
@endsection
