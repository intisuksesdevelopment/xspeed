<?php $page = 'racks'; ?>
@extends('pages.layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            @component('pages.components.breadcrumb')
                @slot('title')
                    Rack
                @endslot
                @slot('li_1')
                    Manage your Rack
                @endslot
                @slot('li_2')
                    Add New Rack
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
                            <a class="btn btn-filter" id="filter_search">
                                <i data-feather="filter" class="filter-icon"></i>
                                <span><img src="{{ URL::asset('/build/img/icons/closes.svg') }}" alt="img"></span>
                            </a>
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
                                        <i data-feather="zap" class="info-img"></i>
                                        <select class="select">
                                            <option>Choose Variant</option>
                                            <option>Size (T-shirts)</option>
                                            <option>Size (Shoes)</option>
                                            <option>Color</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <i data-feather="calendar" class="info-img"></i>
                                        <div class="input-groupicon">
                                            <input type="text" class="datetimepicker" placeholder="Choose Date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <i data-feather="stop-circle" class="info-img"></i>
                                        <select class="select">
                                            <option>Choose Status</option>
                                            <option>Active</option>
                                            <option>Inactive</option>
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
                                    <th>Code</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Created On</th>
                                    <th>Status</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($racks as $rack)
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>{{ $rack['code']}}</td>
                                    <td><span class="d-flex"><img
                                        src="{{ URL::asset($rack['image_url']) }}"
                                        alt=""></span></td>
                                    <td>{{ $rack['name']}}</td>
                                    <td>{{ $rack['description']}}</td>
                                    <td>{{ $rack['created_at']}}</td>
                                    <td>
                                        @if ($rack['status']==0)
                                        <span class="badge badge-linesuccess">{{ $rack['availability']}}</span>
                                        @else
                                        <span class="badge badge-danger">{{ $rack['availability']}}</span>
                                        @endif
                                    </td>
                                    <td class="action-table-data">
                                        <div class="edit-delete-action">
                                            <a class="me-2 p-2" href="#" data-bs-toggle="modal"
                                                data-bs-target="#edit-rack"
                                                data-id="{{ $rack['id']}}"
                                                data-code="{{ $rack['code']}}"
                                                data-name="{{ $rack['name']}}"
                                                data-description="{{ $rack['description']}}"
                                                data-image="{{ $rack['image_url']}}"
                                                data-status="{{ $rack['status']}}">
                                                <i data-feather="edit" class="feather-edit"></i>
                                            </a>
                                            <a class="p-2" href="javascript:void(0);" onclick="deleteData({{ $rack['id']}})">
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
            // custom checkbox

            //

            // Handle form submission

            submitForm('rackAddForm', 'submit-add-button','status-add',null);
            submitForm('rackEditForm', 'submit-add-button','status-edit',null);
            // Handle modal data injection
            var editButtons = document.querySelectorAll('[data-bs-target="#edit-rack"]');

            editButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var rackId = this.getAttribute('data-id');
                    var rackCode = this.getAttribute('data-code');
                    var rackName = this.getAttribute('data-name');
                    var rackDescription = this.getAttribute('data-description');
                    var rackImageUrl = this.getAttribute('data-image');
                    const rackStatus = this.getAttribute('data-status');
                    const statusCheckbox = document.getElementById('status-edit');
                    statusCheckbox.checked = (rackStatus == 0);

                    // Inject data into the modal form fields
                    document.getElementById('id').value = rackId;
                    document.getElementById('code').value = rackCode;
                    document.getElementById('name').value = rackName;
                    document.getElementById('description').value = rackDescription;
                    document.getElementById('image_url').value = rackImageUrl;
                    document.getElementById('status-edit').value = rackStatus;
                });
            });
            window.deleteRack = function(id) {
                deleteData(`{{ route('rack-delete', ':id') }}`, id, document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            };
        });
    </script>
@endsection
