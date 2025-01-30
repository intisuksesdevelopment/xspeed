<?php $page = 'warehouse'; ?>
@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            @component('components.breadcrumb')
                @slot('title')
                    Warehouse
                @endslot
                @slot('li_1')
                    Manage your warehouse
                @endslot
                @slot('li_2')
                    Add New Warehouse
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
                                <div class="layout-hide-box">
                                    <a href="javascript:void(0);" class="me-3 layout-box"><i data-feather="layout"
                                            class="feather-search"></i></a>
                                    <div class="layout-drop-item card">
                                        <div class="drop-item-head">
                                            <h5>Want to manage datatable?</h5>
                                            <p>Please drag and drop your column to reorder your table and enable see option
                                                as you want.</p>
                                        </div>
                                        <ul>
                                            <li>
                                                <div
                                                    class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                                    <span class="status-label"><i data-feather="menu"
                                                            class="feather-menu"></i>Shop</span>
                                                    <input type="checkbox" id="option1" class="check" checked>
                                                    <label for="option1" class="checktoggle"> </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div
                                                    class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                                    <span class="status-label"><i data-feather="menu"
                                                            class="feather-menu"></i>Product</span>
                                                    <input type="checkbox" id="option2" class="check" checked>
                                                    <label for="option2" class="checktoggle"> </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div
                                                    class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                                    <span class="status-label"><i data-feather="menu"
                                                            class="feather-menu"></i>Reference No</span>
                                                    <input type="checkbox" id="option3" class="check" checked>
                                                    <label for="option3" class="checktoggle"> </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div
                                                    class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                                    <span class="status-label"><i data-feather="menu"
                                                            class="feather-menu"></i>Date</span>
                                                    <input type="checkbox" id="option4" class="check" checked>
                                                    <label for="option4" class="checktoggle"> </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div
                                                    class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                                    <span class="status-label"><i data-feather="menu"
                                                            class="feather-menu"></i>Responsible Person</span>
                                                    <input type="checkbox" id="option5" class="check" checked>
                                                    <label for="option5" class="checktoggle"> </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div
                                                    class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                                    <span class="status-label"><i data-feather="menu"
                                                            class="feather-menu"></i>Notes</span>
                                                    <input type="checkbox" id="option6" class="check" checked>
                                                    <label for="option6" class="checktoggle"> </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div
                                                    class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                                    <span class="status-label"><i data-feather="menu"
                                                            class="feather-menu"></i>Quantity</span>
                                                    <input type="checkbox" id="option7" class="check" checked>
                                                    <label for="option7" class="checktoggle"> </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div
                                                    class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                                    <span class="status-label"><i data-feather="menu"
                                                            class="feather-menu"></i>Actions</span>
                                                    <input type="checkbox" id="option8" class="check" checked>
                                                    <label for="option8" class="checktoggle"> </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
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
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <i data-feather="archive" class="info-img"></i>
                                        <select class="select">
                                            <option>Choose Warehouse</option>
                                            <option>Legendary</option>
                                            <option>Determined</option>
                                            <option>Sincere</option>
                                            <option>Pretty</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <i data-feather="user" class="info-img"></i>
                                        <select class="select">
                                            <option>Choose Person</option>
                                            <option>Steven</option>
                                            <option>Gravely</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <i data-feather="calendar" class="info-img"></i>
                                        <div class="input-groupicon">
                                            <input type="text" class="datetimepicker" placeholder="Created Date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <i data-feather="user" class="info-img"></i>
                                        <select class="select">
                                            <option>Choose Status</option>
                                            <option>Active</option>
                                            <option>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12 ms-auto">
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
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Foto</th>
                                    <th>Status</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($warehouses as $warehouse)
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>{{ $warehouse['code']}}</td>
                                    <td>{{ $warehouse['name']}}</td>
                                    <td>{{ $warehouse['description']}}</td>
                                    <td>{{ $warehouse['address']}}</td>
                                    <td>{{ $warehouse['phone']}}</td>
                                    <td>{{ $warehouse['image_url']}}</td>
                                    <td>
                                        @if ($warehouse['status']==0)
                                        <span class="badge badge-linesuccess">{{ $warehouse['availability']}}</span>
                                        @else
                                        <span class="badge badge-danger">{{ $warehouse['availability']}}</span>
                                        @endif
                                    </td>
                                    <td class="action-table-data">
                                        <div class="edit-delete-action">
                                            <a class="me-2 p-2" href="#" data-bs-toggle="modal"
                                                data-bs-target="#edit-warehouse" 
                                                data-id="{{ $warehouse['id']}}"
                                                data-code="{{ $warehouse['code']}}" 
                                                data-name="{{ $warehouse['name']}}"
                                                data-description="{{ $warehouse['description']}}"
                                                data-phone="{{ $warehouse['phone']}}"
                                                data-address="{{ $warehouse['address']}}"
                                                data-image_url="{{ $warehouse['image_url']}}"
                                                data-status="{{ $warehouse['status']}}">
                                                <i data-feather="edit" class="feather-edit"></i>
                                            </a>
                                            <a class="p-2" href="javascript:void(0);" onclick="deleteData({{ $warehouse['id']}})">
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
            document.getElementById('warehouseAddForm').addEventListener('submit', function(event) {
                event.preventDefault();
    
                let form = this;
                let formData = new FormData(form);
                let submitButton = document.getElementById('submit-add-button');
                submitButton.disabled = true;
                const checkbox = document.getElementById('status-add'); // Set initial value based on checked state
                    checkbox.value = checkbox.checked ? 0 : 1; // Update value when checkbox is toggled
                    checkbox.addEventListener('change', function() { checkbox.value = this.checked ? 0 : 1; });
                    Swal.fire({
                            title: "Processing...",
                            text: "Please wait.",
                            icon: "info",
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
    
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    submitButton.disabled = false;
                    const modalId = data.success ? 'success-alert-modal' : 'danger-alert-modal';
                    const messageId = data.success ? 'success-message' : 'danger-message';
                    const modalMessage = data.success ? data.message : data.message || 'Submission failed';
    
                    document.getElementById(messageId).textContent = modalMessage;
                    new bootstrap.Modal(document.getElementById(modalId)).show();
    
                    console.error(modalMessage, data.error);
    
                    document.getElementByName('cancel-button').click();
                })
                .catch(error => {
                    Swal.close();
                    submitButton.disabled = false;
                    document.getElementById('failed-message').textContent = error;
                    new bootstrap.Modal(document.getElementById('danger-alert-modal')).show();
                    console.error('Submission failed:', error);
                });
            });

            document.getElementById('warehouseEditForm').addEventListener('submit', function(event) {
                event.preventDefault();
    
                let form = this;
                let formData = new FormData(form);
                let submitButton = document.getElementById('submit-edit-button');
                submitButton.disabled = true;
    
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    const modalId = data.success ? 'success-alert-modal' : 'danger-alert-modal';
                    const messageId = data.success ? 'success-message' : 'danger-message';
                    const modalMessage = data.success ? data.message : data.message || 'Submission failed';
                    submitButton.disabled = false;
    
                    document.getElementById(messageId).textContent = modalMessage;
                    new bootstrap.Modal(document.getElementById(modalId)).show();
    
                    console.error(modalMessage, data.error);
    
                    document.getElementByName('cancel-button').click();
                })
                .catch(error => {
                    document.getElementById('failed-message').textContent = error;
                    new bootstrap.Modal(document.getElementById('danger-alert-modal')).show();
                    console.error('Submission failed:', error);
                    submitButton.disabled = false;
                });
            });
    
            // Handle modal data injection
            var editButtons = document.querySelectorAll('[data-bs-target="#edit-warehouse"]');
    
            editButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var warehouseId = this.getAttribute('data-id');
                    var warehouseCode = this.getAttribute('data-code');
                    var warehouseName = this.getAttribute('data-name');
                    var warehouseDescription = this.getAttribute('data-description');
                    var warehousePhone = this.getAttribute('data-phone');
                    var warehouseAddress = this.getAttribute('data-address');
                    var warehouseImageUrl = this.getAttribute('data-Image-url');
                    const warehouseStatus = this.getAttribute('data-status');
                    const statusCheckbox = document.getElementById('status-edit');
                    statusCheckbox.checked = (warehouseStatus == 0);
    
                    // Inject data into the modal form fields
                    document.getElementById('id').value = warehouseId;
                    document.getElementById('code').value = warehouseCode;
                    document.getElementById('name').value = warehouseName;
                    document.getElementById('description').value = warehouseDescription;
                    document.getElementById('phone').value = warehousePhone;
                    document.getElementById('address').value = warehouseAddress;
                    document.getElementById('image_url').value = warehouseImageUrl;
                    document.getElementById('status-edit').value = warehouseStatus;
                });
            });
    
            // Handle data deletion
            window.deleteData = function(id) {
                const url = `{{ route('warehouse-delete', ':id') }}`.replace(':id', id);
    
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, remove!",
                    cancelButtonText: "Cancel",
                    confirmButtonClass: "btn btn-primary",
                    cancelButtonClass: "btn btn-danger ml-1",
                    buttonsStyling: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Processing...",
                            text: "Please wait.",
                            icon: "info",
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                        fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.close();
                            if (data.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Removed!",
                                    text: "Data has been removed.",
                                    confirmButtonClass: "btn btn-success",
                                    buttonsStyling: false,
                                    confirmButtonText: "OK"
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Failed!",
                                    text: data.message,
                                    confirmButtonClass: "btn btn-danger",
                                });
                            }
                        })
                        .catch(error => {
                            Swal.close();
                            console.error('Error:', error);
                            Swal.fire({
                                icon: "error",
                                title: "Failed!",
                                text: "An error occurred while deleting the warehouse.",
                                confirmButtonClass: "btn btn-danger",
                            });
                        });
                    }
                });
            };
        });
    </script>
@endsection
