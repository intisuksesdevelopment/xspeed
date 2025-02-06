<?php $page = 'subcategory'; ?>
@extends('pages.layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        @component('pages.components.breadcrumb')
        @slot('title')
        Sub Category list
        @endslot
        @slot('li_1')
        Manage your subcategories
        @endslot
        @slot('li_2')
        Add Sub Category
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
                                        @foreach($categories as $category)
                                        <option value={{$category['id']}}>{{$category['name']}}</option>
                                        @endforeach
                                        <option>Choose Category</option>
                                        <option>Laptop</option>
                                        <option>Electronics</option>
                                        <option>Shoe</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="input-blocks">
                                    <i data-feather="zap" class="info-img"></i>
                                    <select class="select">
                                        <option>Choose SubCategory</option>
                                        <option>Fruits</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="input-blocks">
                                    <i data-feather="stop-circle" class="info-img"></i>
                                    <select class="select">
                                        <option>Category Code</option>
                                        <option>CT001</option>
                                        <option>CT002</option>
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
                                <th>Image</th>
                                <th>Sub Category</th>
                                <th>Parent category</th>
                                <th>Category Code</th>
                                <th>Description</th>
                                <th>Created On</th>
                                <th>Status</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subcategories as $subcategory)
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>
                                    <a class="product-img">
                                        <img src="{{ URL::asset('/build/img/products/product1.jpg') }}" alt="product">
                                    </a>
                                </td>
                                <td>{{ $subcategory['name']}}</td>
                                <td>{{ $subcategory['category']['name']}}</td>
                                <td>{{ $subcategory['code']}}</td>
                                <td>{{ $subcategory['description']}}</td>
                                <td>{{ $subcategory['created_at']}}</td>
                                <td>
                                    @if ($subcategory['status']==0)
                                    <span class="badge badge-linesuccess">{{ $subcategory['availability']}}</span>
                                    @else
                                    <span class="badge badge-danger">{{ $subcategory['availability']}}</span>
                                    @endif
                                </td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="#" data-bs-toggle="modal"
                                            data-bs-target="#edit-sub-category" data-id="{{ $subcategory['id']}}"
                                            data-category-id="{{ $subcategory['category_id']}}"
                                            data-code="{{ $subcategory['code']}}" data-name="{{ $subcategory['name']}}"
                                            data-description="{{ $subcategory['description']}}"
                                            data-status="{{ $subcategory['status']}}"
                                            data-image-url="{{ $subcategory['image_url']}}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a class="p-2" href="javascript:void(0);"
                                            onclick="deleteSubcategory({{ $subcategory['id']}})">
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
            var categories = @json($categories);
            // custom checkbox

            submitForm('subCategoryAddForm', 'submit-add-button','status-add',null);
            submitForm('subCategoryEditForm', 'submit-edit-button','status-edit',null);

            categories.forEach(function(category) {
                var option = document.createElement('option'); 
                option.value = category.id; // Assuming category has 'id' and 'name' properties 
                option.text = category.name; 

                // Select all elements with the name 'category-id'
                var selectElements = document.getElementsByName('category-id'); 

                // Loop through each element in the NodeList and append the option
                for (var i = 0; i < selectElements.length; i++) {
                    selectElements[i].appendChild(option.cloneNode(true));
                }
            });



            // Handle modal data injection
            var editButtons = document.querySelectorAll('[data-bs-target="#edit-sub-category"]');
        

            editButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var subCategoryId = this.getAttribute('data-id');
                    var categoryId = this.getAttribute('data-category-id');
                    var subCategoryCode = this.getAttribute('data-code');
                    var subCategoryName = this.getAttribute('data-name');
                    var subCategoryDescription = this.getAttribute('data-description');
                    var subCategoryImageUrl = this.getAttribute('data-image-url');
                    const subCategoryStatus = this.getAttribute('data-status');
                    const statusCheckbox = document.getElementById('edit-status');
                    statusCheckbox.checked = (subCategoryStatus == 0);

                    // Inject data into the modal form fields
                    document.getElementById('edit-id').value = subCategoryId;
                    document.getElementById('edit-code').value = subCategoryCode;
                    document.getElementById('edit-name').value = subCategoryName;
                    document.getElementById('edit-description').value = subCategoryDescription;
                    document.getElementById('edit-image-url').value = subCategoryImageUrl;
                    document.getElementById('edit-status').value = subCategoryStatus;
                });
            });

            window.deleteSubcategory = function(id) {
                deleteData(`{{ route('subcategory-delete', ':id') }}`, id, document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            };

        });
</script>


@endsection