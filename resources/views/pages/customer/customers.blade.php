<?php $page = 'customers'; ?>
@extends('pages.layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            @component('pages.components.breadcrumb')
                @slot('title')
                    Customer List
                @endslot
                @slot('li_1')
                    Manage your Customer
                @endslot
                @slot('li_2')
                    Add New Customer
                @endslot
            @endcomponent

            <!-- /product list -->
            <div class="card table-list-card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a href="" class="btn btn-searchset"><i data-feather="search"
                                        class="feather-search"></i></a>
                            </div>
                        </div>
                        <div class="search-path">
                            <div class="d-flex align-items-center">
                                <a class="btn btn-filter" id="filter_search">
                                    <i data-feather="filter" class="filter-icon"></i>
                                    <span><img src="{{ URL::asset('/build/img/icons/closes.svg') }}" alt="img"></span>
                                </a>

                            </div>
                        </div>
                        <div class="form-sort">
                            <i data-feather="sliders" class="info-img"></i>
                            <select class="select">
                                <option>Sort by Date</option>
                                <option>Newest</option>
                                <option>Oldest</option>
                            </select>
                        </div>
                    </div>
                    <!-- /Filter -->
                    <div class="card" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <i data-feather="user" class="info-img"></i>
                                        <select class="select">
                                            <option>Choose Customer Name</option>
                                            <option>Benjamin</option>
                                            <option>Ellen</option>
                                            <option>Freda</option>
                                            <option>Kaitlin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <i data-feather="globe" class="info-img"></i>
                                        <select class="select">
                                            <option>Choose Country</option>
                                            <option>India</option>
                                            <option>USA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12 ms-auto">
                                    <div class="input-blocks">
                                        <a class="btn btn-filters ms-auto"> <i data-feather="search"
                                                class="feather-search"></i> Search </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Filter -->
                    <div class="table-responsive">
                        <table class="table  datanew">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Customer Name</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Limit Transaction</th>
                                    <th>Limit Debt</th>
                                    <th>Discount</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $customer->code }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>{{ $customer->address }}</td>
                                        <td>{{ $customer->limit_transaction }}</td>
                                        <td>{{ $customer->limit_debt }}</td>
                                        <td>{{ $customer->discount }}</td>
                                        <td>{{ $customer->created_at }}</td>
                                        <td>
                                            @if($customer->status == 0)
                                                <span class="badges bg-lightgreen">Active</span>
                                            @else
                                                <span class="badges bg-lightred">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="action-table-data">
                                            <div class="edit-delete-action">
                                                <a class="me-2 p-2" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#edit-customer"
                                                    data-id="{{ $customer['id']}}"
                                                    data-code="{{ $customer['code']}}"
                                                    data-name="{{ $customer['name']}}"
                                                    data-email="{{ $customer['email']}}"
                                                    data-phone="{{ $customer['phone']}}"
                                                    data-address="{{ $customer['address']}}"
                                                    data-limit-transaction="{{ $customer['limit_transaction']}}"
                                                    data-limit-debt="{{ $customer['limit_debt']}}"
                                                    data-discount="{{ $customer['discount']}}"
                                                    data-status="{{ $customer['status']}}">
                                                    <i data-feather="edit" class="feather-edit"></i>
                                                </a>
                                                <a class="p-2" href="javascript:void(0);" onclick="deleteCustomer({{ $customer['id']}})">
                                                    <i data-feather="trash-2" class="feather-trash-2"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            submitForm('customerAddForm', 'submit-add-button', 'status-add', null);
            submitForm('customerEditForm', 'submit-edit-button', 'status-edit', null);

            // Handle modal data injection
            var editButtons = document.querySelectorAll('[data-bs-target="#edit-customer"]');

            editButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var customerId = this.getAttribute('data-id');
                    var customerCode = this.getAttribute('data-code');
                    var customerName = this.getAttribute('data-name');
                    var customerEmail = this.getAttribute('data-email');
                    var customerPhone = this.getAttribute('data-phone');
                    var customerAddress = this.getAttribute('data-address');
                    var customerLimitTransaction = this.getAttribute('data-limit-transaction');
                    var customerLimitDebt = this.getAttribute('data-limit-debt');
                    var customerDiscount = this.getAttribute('data-discount');
                    const customerStatus = this.getAttribute('data-status');
                    const statusCheckbox = document.getElementById('status-edit');
                    statusCheckbox.checked = (customerStatus == 0);

                    // Inject data into the modal form fields
                    document.getElementById('id').value = customerId;
                    document.getElementById('code').value = customerCode;
                    document.getElementById('name').value = customerName;
                    document.getElementById('email').value = customerEmail;
                    document.getElementById('phone').value = customerPhone;
                    document.getElementById('address').value = customerAddress;
                    document.getElementById('limit_transaction').value = customerLimitTransaction;
                    document.getElementById('limit_debt').value = customerLimitDebt;
                    document.getElementById('discount').value = customerDiscount;
                    document.getElementById('status-edit').value = customerStatus;
                });
            });

            window.deleteCustomer = function(id) {
                deleteData(`{{ route('customer-delete', ':id') }}`, id, document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            };
        });
    </script>
@endsection
