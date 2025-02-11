<?php $page = 'users'; ?>  
@extends('pages.layout.mainlayout')  
@section('content')  
    <div class="page-wrapper">  
        <div class="content">  
            @component('pages.components.breadcrumb')  
                @slot('title')  
                    User List  
                @endslot  
                @slot('li_1')  
                    Manage Your Users  
                @endslot  
                @slot('li_2')  
                    Add New User  
                @endslot  
            @endcomponent  

            <!-- /product list -->  
            <div class="card table-list-card">  
                <div class="card-body">  
                    <div class="table-top">  
                        <div class="search-set">  
                            <div class="search-input">  
                                <a href="" class="btn btn-searchset"><i data-feather="search" class="feather-search"></i></a>  
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
                                            <option>Choose Name</option>  
                                            <option>Lilly</option>  
                                            <option>Benjamin</option>  
                                        </select>  
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
                                <div class="col-lg-3 col-sm-6 col-12">  
                                    <div class="input-blocks">  
                                        <i data-feather="zap" class="info-img"></i>  
                                        <select class="select">  
                                            <option>Choose Role</option>  
                                            <option>Store Keeper</option>  
                                            <option>Salesman</option>  
                                        </select>  
                                    </div>  
                                </div>  
                                <div class="col-lg-3 col-sm-6 col-12">  
                                    <div class="input-blocks">  
                                        <a class="btn btn-filters ms-auto">  
                                            <i data-feather="search" class="feather-search"></i> Search  
                                        </a>  
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
                                    <th>User Name</th>  
                                    <th>Name</th>  
                                    <th>Phone</th>  
                                    <th>Email</th>  
                                    <th>Role</th>  
                                    <th>Created On</th>  
                                    <th>Status</th>  
                                    <th class="no-sort">Action</th>  
                                </tr>  
                            </thead>  
                            <tbody>  
                                @foreach($users as $user)  
                                <tr>  
                                    <td>  
                                        <label class="checkboxs">  
                                            <input type="checkbox">  
                                            <span class="checkmarks"></span>  
                                        </label>  
                                    </td>  
                                    <td>{{ $user['username'] }}</td>  
                                    <td>{{ $user['name'] }}</td>  
                                    <td>{{ $user['phone'] }}</td>  
                                    <td>{{ $user['email'] }}</td>  
                                    <td>{{ $user['role'] }}</td>  
                                    <td>{{ $user['created_at'] }}</td>  
                                    <td>  
                                        @if ($user['status'] == 0)  
                                            <span class="badge badge-linesuccess">Active</span>  
                                        @else  
                                            <span class="badge badge-danger">Inactive</span>  
                                        @endif  
                                    </td>  
                                    <td class="action-table-data">  
                                        <div class="edit-delete-action">  
                                            <a class="me-2 p-2" href="#" data-bs-toggle="modal"  
                                                data-bs-target="#edit-user"  
                                                data-user='@json($user)'>  
                                                <i data-feather="edit" class="feather-edit"></i>  
                                            </a>  
                                            <a class="p-2" href="javascript:void(0);" onclick="deleteUser({{ $user['id']}})">  
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
            submitForm('userAddForm', 'submit-add-button','status-add',null);
            submitForm('userEditForm', 'submit-edit-button','status-edit',null);
            // Handle modal data injection
            var editButtons = document.querySelectorAll('[data-bs-target="#edit-user"]');

            editButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                var user = JSON.parse(this.getAttribute('data-user'));
                const statusCheckbox = document.getElementById('status-edit');
                statusCheckbox.checked = (user.status == 0);

                    // Inject data into the modal form fields
                    document.getElementById('uuid').value = user.uuid;
                    document.getElementById('nik').value = user.nik;
                    document.getElementById('username').value = user.username;
                    document.getElementById('name').value = user.name;
                    document.getElementById('phone').value = user.phone;
                    document.getElementById('email').value = user.email;
                    document.getElementById('role').value = user.role;
                    document.getElementById('status-edit').value = user.status;

                });
            });
            window.deleteUser = function(id) {
                deleteData(`{{ route('user-delete', ':id') }}`, id, document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            };
        });
    </script>
@endsection