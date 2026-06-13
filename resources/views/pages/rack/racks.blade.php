<?php $page = 'racks'; ?>
@extends('pages.layout.mainlayout')
@section('content')
<style>
    .fade-row {
        transition: all 0.2s ease;
    }

    .fade-row:hover {
        background-color: #f8f9fa;
    }

    .profile-pic-upload .profile-pic {
        position: relative;
        width: 100px;
        height: 100px;
        border: 2px dashed #d1d1d1;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f8f8;
        overflow: hidden;
    }

    .profile-pic-upload .profile-pic img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-pic-upload .profile-pic span {
        color: #888;
        font-size: 12px;
        text-align: center;
    }

    .profile-pic-upload .profile-pic .plus-down-add {
        display: block;
        margin: 0 auto 5px;
    }

    .profile-pic-upload .profile-pic:hover {
        border-color: #0d6efd;
        background: #f0f0f0;
    }

    #rackImagePreviewModal .modal-content {
        background: rgba(0, 0, 0, 0.9);
    }

    #rackImagePreviewModal .modal-header,
    #rackImagePreviewModal .modal-body {
        background: transparent;
        color: white;
    }

    #rackImagePreviewModal .btn-close {
        filter: invert(1);
    }

    #rackImagePreviewModal .modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

</style>
<div class="page-wrapper" x-data="rackTable()" x-init="init()" x-cloak @refresh-racks.window="fetchRacks()">
    <div class="content">
        @component('pages.components.breadcrumb')
        @slot('title')
        Rack
        @endslot
        @slot('li_1')
        Manage your racks
        @endslot
        @slot('li_2')
        Add New Rack
        @endslot
        @endcomponent

        <!-- /product list -->
        <div class="card table-list-card">
            <div class="card-body">
                <div class="table-top">

                    <div class="row g-3 align-items-end">

                        <!-- SEARCH -->
                        <div class="col-md-5">
                            <div>
                                <div class="mb-1">
                                    <small class="text-muted">
                                        {{ __('label.searchby') }}:
                                        <strong x-text="filters.searchBy"></strong>
                                    </small>
                                </div>

                                <div class="input-group">

                                    <!-- Dropdown -->
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-search"></i>
                                    </button>

                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" @click.prevent="filters.searchBy = 'Name'">{{ __('common.name') }}</a></li>
                                        <li><a class="dropdown-item" href="#" @click.prevent="filters.searchBy = 'Code'">{{ __('common.code') }}</a></li>
                                    </ul>

                                    <!-- Input -->
                                    <input type="text" class="form-control" :placeholder="`{{ __('label.searchby') }} ${filters.searchBy}...`" x-model="filters.search" @keyup.debounce.500ms="fetchRacks()">
                                </div>
                            </div>
                        </div>

                        <!-- SORT -->
                        <div class="col-md-3">
                            <select class="form-select" x-model="filters.sort" @change="fetchRacks()">
                                <option value="desc">{{ __('common.new') }}</option>
                                <option value="asc">{{ __('common.old') }}</option>
                            </select>
                        </div>

                        <!-- PER PAGE -->
                        <div class="col-md-4 text-md-end">
                            <div class="d-inline-flex align-items-center gap-2">
                                <span class="text-muted">{{ __('common.show') }}</span>
                                <select class="form-select form-select-sm w-auto" x-model="perPage" @change="changePerPage(perPage)">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <span class="text-muted">{{ __('common.enteries') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /Filter -->
                <div class="table-responsive position-relative">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="no-sort">
                                    <label class="checkboxs">
                                        <input type="checkbox" id="select-all">
                                        <span class="checkmarks"></span>
                                    </label>
                                </th>
                                <th>{{ __('common.code') }}</th>
                                <th>Image</th>
                                <th>{{ __('common.name') }}</th>
                                <th>{{ __('common.description') }}</th>
                                <th class="no-sort"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- EMPTY -->
                            <tr x-show="!loading && items.length === 0" x-cloak>
                                <td colspan="6" class="text-center py-3">No data found</td>
                            </tr>

                            <!-- DATA -->
                            <template x-for="item in items" :key="item.id">
                                <tr class="fade-row">
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td x-text="item.code"></td>
                                    <td>
                                        <img :src="item.image_url || '/assets/img/icons/brand-icon-01.svg'" alt="" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                    </td>
                                    <td x-text="item.name"></td>
                                    <td class="text-truncate" style="max-width: 200px;" x-text="item.description || '-'"></td>
                                    <td class="action-table-data">
                                        <div class="edit-delete-action">
                                            <a class="me-2 p-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-rack" @click="openEditModal(item)">
                                                <i data-feather="edit" class="feather-edit"></i>
                                            </a>
                                            <a class="p-2" href="javascript:void(0);" @click="confirmDelete(item)">
                                                <i data-feather="trash-2" class="feather-trash-2"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                    <!-- Loading Overlay -->
                    <template x-if="loading">
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(255,255,255,0.7); z-index: 10; min-height: 200px;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- PAGINATION -->
                <div class="d-flex justify-content-between align-items-center mt-3" x-show="!loading && total > 0">
                    <div>
                        <span class="text-muted">Showing <span x-text="from"></span> to <span x-text="to"></span> of <span x-text="total"></span> entries</span>
                    </div>
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-outline-secondary" @click="prevPage()" :disabled="page <= 1">
                            <i class="fa fa-chevron-left"></i>
                        </button>
                        <template x-for="p in visiblePages" :key="p">
                            <button class="btn btn-sm" :class="p === page ? 'btn-primary' : 'btn-outline-secondary'" @click="goToPage(p)" x-text="p"></button>
                        </template>
                        <button class="btn btn-sm btn-outline-secondary" @click="nextPage()" :disabled="page >= lastPage">
                            <i class="fa fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /product list -->
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 custom-modal-header">
                    <div class="page-title">
                        <h4>Confirm Delete</h4>
                    </div>
                </div>
                <div class="modal-deletecontent custom-modal-body text-center">
                    <i data-feather="x-circle" class="feather-24 text-danger mx-auto d-block"></i>
                    <h4 class="pt-2 text-muted">Delete Rack</h4>
                    <p>Are you sure you want to delete <strong x-text="itemToDelete?.name"></strong>?</p>
                    <p class="text-muted">This action cannot be undone.</p>
                    <div class="modal-footer-btn delete">
                        <a href="javascript:void(0);" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</a>
                        <a href="javascript:void(0);" class="btn btn-submit" @click="deleteItem()">
                            <i data-feather="trash-2" class="feather-14"></i> Delete
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Image Preview Modal -->
    <div class="modal fade" id="rackImagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <div class="page-title">
                        <h4>Image Preview</h4>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="rack-preview-modal-image" src="" alt="Rack Image" class="img-fluid" style="max-height: 70vh; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Image preview function for rack modals
    function previewRackImage(input, prefix) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            const preview = document.getElementById(`${prefix}-preview`);
            const placeholder = document.getElementById(`${prefix}-placeholder`);

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Initialize rack image preview when edit modal opens
    function initEditRackImage(imageUrl) {
        const preview = document.getElementById('edit-rack-preview');
        const placeholder = document.getElementById('edit-rack-placeholder');
        const currentImageUrl = document.getElementById('edit-rack-current-image-url');

        if (currentImageUrl) currentImageUrl.value = imageUrl || '';

        if (imageUrl && imageUrl.trim() !== '') {
            preview.src = imageUrl;
            preview.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        } else {
            preview.src = '';
            preview.style.display = 'none';
            if (placeholder) placeholder.style.display = 'flex';
        }
    }

    // Open larger image preview
    function openRackImagePreview(prefix) {
        const preview = document.getElementById(`${prefix}-preview`);
        const currentImageUrl = document.getElementById(`${prefix}-current-image-url`);

        let imageSrc = preview ? preview.src : '';

        // If preview is hidden/not set, try current image URL (for edit modal)
        if (!imageSrc || imageSrc === '' || imageSrc.includes('data:,')) {
            imageSrc = currentImageUrl ? currentImageUrl.value : '';
        }

        if (imageSrc && imageSrc.trim() !== '' && !imageSrc.includes('data:,')) {
            document.getElementById('rack-preview-modal-image').src = imageSrc;
            const modal = new bootstrap.Modal(document.getElementById('rackImagePreviewModal'));
            modal.show();
        }
    }
    const API_RACK_URL = "{{ route('api-rack-paged') }}";

    window.rackTable = function() {
        return {
            items: []
            , loading: true
            , page: 1
            , perPage: 10
            , lastPage: 1
            , total: 0
            , from: 0
            , to: 0,

            filters: {
                search: ''
                , searchBy: 'Name'
                , sort: 'desc'
            },

            itemToDelete: null,

            init() {
                this.fetchRacks();
            },

            async fetchRacks() {
                this.loading = true;

                try {
                    let params = new URLSearchParams({
                        search: this.filters.search
                        , search_by: this.filters.searchBy
                        , sortBy: 'created_at'
                        , sortDirection: this.filters.sort
                        , page: this.page
                        , per_page: this.perPage
                    });

                    let res = await fetch(`${API_RACK_URL}?${params}`);
                    let result = await res.json();

                    if (result.success) {
                        let data = result.data;
                        if (data.data && data.total !== undefined) {
                            this.items = data.data;
                            this.total = data.total;
                            this.lastPage = data.last_page || 1;
                            this.page = data.current_page || 1;
                        } else if (Array.isArray(data)) {
                            this.items = data;
                            this.total = data.length;
                            this.lastPage = 1;
                        } else {
                            this.items = [];
                            this.total = 0;
                            this.lastPage = 1;
                        }
                        this.updatePagination();
                    }
                } catch (e) {
                    console.error('Error fetching racks:', e);
                } finally {
                    this.loading = false;
                    this.$nextTick(() => {
                        if (typeof feather !== 'undefined') {
                            feather.replace();
                        }
                    });
                }
            },

            updatePagination() {
                this.from = (this.page - 1) * this.perPage + 1;
                this.to = Math.min(this.page * this.perPage, this.total);
            },

            get visiblePages() {
                let pages = [];
                let start = Math.max(1, this.page - 2);
                let end = Math.min(this.lastPage, start + 4);
                if (end - start < 4) {
                    start = Math.max(1, end - 4);
                }
                for (let i = start; i <= end; i++) {
                    pages.push(i);
                }
                return pages;
            },

            goToPage(p) {
                this.page = p;
                this.fetchRacks();
            },

            nextPage() {
                if (this.page < this.lastPage) {
                    this.page++;
                    this.fetchRacks();
                }
            },

            prevPage() {
                if (this.page > 1) {
                    this.page--;
                    this.fetchRacks();
                }
            },

            changePerPage(val) {
                this.perPage = val;
                this.page = 1;
                this.fetchRacks();
            },

            openEditModal(item) {
                document.getElementById('id').value = item.id;
                document.getElementById('code').value = item.code;
                document.getElementById('name').value = item.name;
                document.getElementById('description').value = item.description || '';
                const statusCheckbox = document.getElementById('status-edit');
                if (statusCheckbox) statusCheckbox.checked = (item.status == 0);

                // Initialize image preview
                initEditRackImage(item.image_url);
            },

            confirmDelete(item) {
                this.itemToDelete = item;
                const modalEl = document.getElementById('deleteConfirmModal');
                if (modalEl) {
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }
            },

            async deleteItem() {
                if (!this.itemToDelete) return;

                const item = this.itemToDelete;
                const id = item.id;

                const modalEl = document.getElementById('deleteConfirmModal');
                if (modalEl) {
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                }

                this.items = this.items.filter(i => i.id !== id);
                this.total--;

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
                    let res = await fetch(`{{ route('rack-delete', ':id') }}`.replace(':id', id), {
                        method: 'DELETE'
                        , headers: {
                            'X-CSRF-TOKEN': csrfToken
                            , 'Content-Type': 'application/json'
                            , 'Accept': 'application/json'
                        }
                    });

                    let data = await res.json();

                    if (!res.ok || !data.success) {
                        this.fetchRacks();
                        document.getElementById('danger-message').textContent = data.message || 'Delete failed';
                        new bootstrap.Modal(document.getElementById('danger-alert-modal')).show();
                    } else {
                        document.getElementById('success-message').textContent = data.message || 'Deleted successfully';
                        new bootstrap.Modal(document.getElementById('success-alert-modal')).show();
                        setTimeout(() => {
                            window.refreshRackTable();
                        }, 1000);
                    }
                } catch (e) {
                    console.error('Delete error:', e);
                    this.fetchRacks();
                    document.getElementById('danger-message').textContent = 'An error occurred while deleting';
                    new bootstrap.Modal(document.getElementById('danger-alert-modal')).show();
                }

                this.itemToDelete = null;
            },

            refreshList() {
                this.fetchRacks();
            }
        }
    };

    // Global function to refresh rack table
    window.refreshRackTable = function() {
        window.dispatchEvent(new CustomEvent('refresh-racks'));
    };

    // Form handlers are defined via onsubmit attribute on form tags

    function handleRackFormSubmit(form, submitButtonId, statusCheckboxId) {
        // Update checkbox value BEFORE creating FormData (if the checkbox still exists in DOM)
        // if (statusCheckboxId) {
        //     const checkbox = document.getElementById(statusCheckboxId);
        //     if (checkbox) {
        //         checkbox.value = checkbox.checked ? 0 : 1;
        //     }
        // }

        let formData = new FormData(form);
        let submitButton = document.getElementById(submitButtonId);
        submitButton.disabled = true;

        Swal.fire({
            title: "Processing..."
            , text: "Please wait."
            , icon: "info"
            , showConfirmButton: false
            , allowOutsideClick: false
        , });

        fetch(form.action, {
                method: "POST"
                , headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                , }
                , body: formData
            , })
            .then((response) => response.json())
            .then((data) => {
                Swal.close();
                submitButton.disabled = false;

                const modalId = data.success ? "success-alert-modal" : "danger-alert-modal";
                const messageId = data.success ? "success-message" : "danger-message";
                let modalMessage = data.success ? data.message : "Submission failed";

                if (!data.success && data.message) {
                    if (typeof data.message === "object") {
                        modalMessage = Object.values(data.message).flat().join(", ");
                    } else {
                        modalMessage = data.message;
                    }
                }

                document.getElementById(messageId).textContent = modalMessage;
                new bootstrap.Modal(document.getElementById(modalId)).show();

                if (data.success) {
                    setTimeout(() => {
                        // Close the modal containing this form
                        const modal = form.closest('.modal');
                        if (modal) {
                            const bsModal = bootstrap.Modal.getInstance(modal);
                            if (bsModal) bsModal.hide();
                        }
                        // Refresh table only (not page reload)
                        window.refreshRackTable();
                    }, 1000);
                }
            })
            .catch((error) => {
                console.error("Submission failed:", error);
                Swal.close();
                submitButton.disabled = false;
                document.getElementById("danger-message").textContent = error.message || "An error occurred";
                new bootstrap.Modal(document.getElementById("danger-alert-modal")).show();
            });
    }

</script>
@endsection
