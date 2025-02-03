<?php $page = 'category-list'; ?>
@extends('pages.layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        @component('components.breadcrumb')
        @slot('title')
        Category
        @endslot
        @slot('li_1')
        Manage your categories
        @endslot
        @slot('li_2')
        Add Category
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
                                        <option>Choose Category</option>
                                        <option>Laptop</option>
                                        <option>Electronics</option>
                                        <option>Shoe</option>
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
                                <th>Category</th>
                                <th>Created On</th>
                                <th>Status</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>{{ $category['code']}}</td>
                                <td>{{ $category['name']}}</td>
                                <td>{{ $category['created_at']}}</td>
                                <td>
                                    @if ($category['status']==0)
                                    <span class="badge badge-linesuccess">{{ $category['availability']}}</span>
                                    @else
                                    <span class="badge badge-danger">{{ $category['availability']}}</span>
                                    @endif
                                </td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="#" data-bs-toggle="modal"
                                            data-bs-target="#edit-category" data-id="{{ $category['id']}}"
                                            data-code="{{ $category['code']}}" data-name="{{ $category['name']}}"
                                            data-description="{{ $category['description']}}"
                                            data-status="{{ $category['status']}}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a class="p-2" href="javascript:void(0);" onclick="deleteCategory({{ $category['id']}})">
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
        submitForm('categoryAddForm', 'submit-add-button','status-add',null);
        submitForm('categoryEditForm', 'submit-edit-button','status-edit',null);
        // Handle modal data injection
        var editButtons = document.querySelectorAll('[data-bs-target="#edit-category"]');

        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var categoryId = this.getAttribute('data-id');
                var categoryCode = this.getAttribute('data-code');
                var categoryName = this.getAttribute('data-name');
                var categoryDescription = this.getAttribute('data-description');
                const categoryStatus = this.getAttribute('data-status');
                const statusCheckbox = document.getElementById('status-edit');
                statusCheckbox.checked = (categoryStatus == 0);

                // Inject data into the modal form fields
                document.getElementById('id').value = categoryId;
                document.getElementById('code').value = categoryCode;
                document.getElementById('name').value = categoryName;
                document.getElementById('description').value = categoryDescription;
                document.getElementById('status-edit').value = categoryStatus;
            });
        });
        window.deleteRack = function(id) {
                deleteData(`{{ route('category-delete', ':id') }}`, id, document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            };
    });
    </script>

@endsection
