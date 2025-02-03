<?php $page = 'suppliers'; ?>
@extends('pages.layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            @component('components.breadcrumb')
                @slot('title')
                    Supplier List
                @endslot
                @slot('li_1')
                    Manage Your Supplier
                @endslot
                @slot('li_2')
                    Add New Supplier List
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
                                <option>25 9 23</option>
                                <option>12 9 23</option>
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
                                            <option>Choose Supplier Name</option>
                                            <option>Dazzle Shoes</option>
                                            <option>A-Z Store</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <i data-feather="globe" class="info-img"></i>
                                        <select class="select">
                                            <option>Choose Country</option>
                                            <option>Mexico</option>
                                            <option>Italy</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
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
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Telp</th>
                                    <th>Alamat</th>
                                    <th>Npwp</th>
                                    <th>Diskon</th>
                                    <th>Status</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suppliers as $supplier)
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>{{ $supplier['code']}}</td>
                                    <td>{{ $supplier['name']}}</td>
                                    <td>{{ $supplier['email']}}</td>
                                    <td>{{ $supplier['phone']}}</td>
                                    <td>{{ $supplier['address']}}</td>
                                    <td>{{ $supplier['npwp']}}</td>
                                    <td>{{ $supplier['discount']}}</td>
                                    <td>
                                        @if ($supplier['status']==0)
                                        <span class="badge badge-linesuccess">{{ $supplier['availability']}}</span>
                                        @else
                                        <span class="badge badge-danger">{{ $supplier['availability']}}</span>
                                        @endif
                                    </td>
                                    <td class="action-table-data">
                                        <div class="edit-delete-action">
                                            <a class="me-2 p-2" href="#" data-bs-toggle="modal"
                                                data-bs-target="#edit-supplier"
                                                data-id="{{ $supplier['id']}}"
                                                data-code="{{ $supplier['code']}}"
                                                data-name="{{ $supplier['name']}}"
                                                data-email="{{ $supplier['email']}}"
                                                data-phone="{{ $supplier['phone']}}"
                                                data-address="{{ $supplier['address']}}"
                                                data-npwp="{{ $supplier['npwp']}}"
                                                data-discount="{{ $supplier['discount']}}"
                                                data-status="{{ $supplier['status']}}">
                                                <i data-feather="edit" class="feather-edit"></i>
                                            </a>
                                            <a class="p-2" href="javascript:void(0);" onclick="deleteSupplier({{ $supplier['id']}})">
                                                <i data-feather="trash-2" class="feather-trash-2"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>
    </div>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            submitForm('supplierAddForm', 'submit-add-button','status-add',null);
            submitForm('supplierEditForm', 'submit-edit-button','status-add',null);

            // Handle modal data injection
            var editButtons = document.querySelectorAll('[data-bs-target="#edit-supplier"]');

            editButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var supplierId = this.getAttribute('data-id');
                    var supplierCode = this.getAttribute('data-code');
                    var supplierName = this.getAttribute('data-name');
                    var supplierEmail = this.getAttribute('data-email');
                    var supplierPhone = this.getAttribute('data-phone');
                    var supplierAddress = this.getAttribute('data-address');
                    var supplierNpwp = this.getAttribute('data-npwp');
                    var supplierDiscount = this.getAttribute('data-discount');
                    const supplierStatus = this.getAttribute('data-status');
                    const statusCheckbox = document.getElementById('status-edit');
                    statusCheckbox.checked = (supplierStatus == 0);

                    // Inject data into the modal form fields
                    document.getElementById('id').value = supplierId;
                    document.getElementById('code').value = supplierCode;
                    document.getElementById('name').value = supplierName;
                    document.getElementById('email').value = supplierEmail;
                    document.getElementById('phone').value = supplierPhone;
                    document.getElementById('address').value = supplierAddress;
                    document.getElementById('npwp').value = supplierNpwp;
                    document.getElementById('discount').value = supplierDiscount;
                    document.getElementById('status-edit').value = supplierStatus;
                });
            });

            // Handle data deletion
            window.deleteSupplier = function(id) {
                deleteData(`{{ route('supplier-delete', ':id') }}`, id, document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            };
        });
    </script>
@endsection
