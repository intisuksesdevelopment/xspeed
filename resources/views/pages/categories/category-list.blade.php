<?php $page = 'category'; ?>
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

    #imagePreviewModal .modal-content {
        background: rgba(0, 0, 0, 0.9);
    }

    #imagePreviewModal .modal-header,
    #imagePreviewModal .modal-body {
        background: transparent;
        color: white;
    }

    #imagePreviewModal .btn-close {
        filter: invert(1);
    }

    #imagePreviewModal .modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

</style>
<div class="page-wrapper" x-data="categoryTable()" x-cloak @refresh-categories.window="fetchCategories()">
    <div class="content">
        @component('pages.components.breadcrumb')
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
                                    <input type="text" class="form-control" :placeholder="`{{ __('label.searchby') }} ${filters.searchBy}...`" x-model="filters.search" @keyup.debounce.500ms="fetchCategories()">
                                </div>
                            </div>
                        </div>

                        <!-- SORT -->
                        <div class="col-md-3">
                            <select class="form-select" x-model="filters.sort" @change="fetchCategories()">
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
                                <th>{{ __('common.items') }}</th>
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
                                    <td x-text="item.items_count || 0"></td>
                                    <td class="action-table-data">
                                        <div class="edit-delete-action">
                                            <a class="me-2 p-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-category" :data-image-url="item.image_url || ''" @click="openEditModal(item)">
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
                <div class="d-flex justify-content-between align-items-center mt-3" x-show="!loading">
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
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong x-text="itemToDelete?.name"></strong>?</p>
                    <p class="text-muted">This action cannot be undone.</p>
                    <div class="modal-footer-btn delete">
                        <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-submit" @click="deleteItem()">
                            <i data-feather="trash-2" class="feather-14"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <div class="page-title">
                        <h4>Image Preview</h4>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="preview-modal-image" src="" alt="Image Preview" class="img-fluid" style="max-height: 70vh; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const API_CATEGORY_URL = "{{ route('api-category-all') }}";

    function categoryTable() {
        return {
            items: []
            , loading: false
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

            itemToDelete: null
            , isDeleting: false,

            init() {
                this.fetchCategories();
            },

            async fetchCategories() {
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

                    let res = await fetch(`${API_CATEGORY_URL}?${params}`);
                    let result = await res.json();

                    if (result.success) {
                        let data = result.data;
                        // Handle paginated response
                        if (data.data && data.total !== undefined) {
                            this.items = data.data;
                            this.total = data.total;
                            this.lastPage = data.last_page || 1;
                            this.page = data.current_page || 1;
                        } else if (Array.isArray(data)) {
                            // Handle non-paginated response
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
                    console.error('Error fetching categories:', e);
                } finally {
                    this.loading = false;
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
                this.fetchCategories();
            },

            nextPage() {
                if (this.page < this.lastPage) {
                    this.page++;
                    this.fetchCategories();
                }
            },

            prevPage() {
                if (this.page > 1) {
                    this.page--;
                    this.fetchCategories();
                }
            },

            changePerPage(val) {
                this.perPage = val;
                this.page = 1;
                this.fetchCategories();
            },

            formatDate(datetime) {
                if (!datetime) return '-';
                const date = new Date(datetime);
                return new Intl.DateTimeFormat('id-ID', {
                    year: 'numeric'
                    , month: 'short'
                    , day: '2-digit'
                }).format(date);
            },

            openEditModal(item) {
                document.getElementById('id').value = item.id;
                document.getElementById('code').value = item.code;
                document.getElementById('name').value = item.name;
                document.getElementById('description').value = item.description || '';
                const statusCheckbox = document.getElementById('status-edit');
                if (statusCheckbox) statusCheckbox.checked = (item.status == 0);

                // Initialize image preview directly
                setEditCategoryImage(item.image_url);
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
                if (!this.itemToDelete || this.isDeleting) return;

                this.isDeleting = true;
                this.loading = true;
                const item = this.itemToDelete;
                const id = item.id;

                // Hide modal
                const modalEl = document.getElementById('deleteConfirmModal');
                if (modalEl) {
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                }

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
                    let res = await fetch(`{{ route('category-delete', ':id') }}`.replace(':id', id), {
                        method: 'DELETE'
                        , headers: {
                            'X-CSRF-TOKEN': csrfToken
                            , 'Content-Type': 'application/json'
                            , 'Accept': 'application/json'
                        }
                    });

                    let data = await res.json();

                    if (!res.ok || !data.success) {
                        this.fetchCategories();
                        document.getElementById('danger-message').textContent = data.message || 'Delete failed';
                        new bootstrap.Modal(document.getElementById('danger-alert-modal')).show();
                    } else {
                        document.getElementById('success-message').textContent = data.message || 'Deleted successfully';
                        new bootstrap.Modal(document.getElementById('success-alert-modal')).show();
                        this.fetchCategories();
                    }
                } catch (e) {
                    console.error('Delete error:', e);
                    this.fetchCategories();
                    document.getElementById('danger-message').textContent = 'An error occurred while deleting';
                    new bootstrap.Modal(document.getElementById('danger-alert-modal')).show();
                } finally {
                    this.isDeleting = false;
                }

                this.itemToDelete = null;
            },

            refreshList() {
                this.fetchCategories();
            }
        }
    }

    // Global function to refresh category table — directly accesses Alpine component
    window.refreshCategoryTable = function() {
        var wrapper = document.querySelector('.page-wrapper');
        if (wrapper && wrapper.__x) {
            wrapper.__x.$data.fetchCategories();
        } else {
            // Fallback using custom event
            window.dispatchEvent(new CustomEvent('refresh-categories'));
        }
    };

    // Set edit category image preview
    function setEditCategoryImage(imageUrl) {
        const preview = document.getElementById('edit-category-preview');
        const placeholder = document.getElementById('edit-category-placeholder');
        const currentImageUrl = document.getElementById('edit-category-current-image-url');

        if (currentImageUrl) currentImageUrl.value = imageUrl || '';

        if (preview && imageUrl && imageUrl.trim() !== '') {
            preview.src = imageUrl;
            preview.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        } else if (preview) {
            preview.src = '';
            preview.style.display = 'none';
            if (placeholder) placeholder.style.display = 'flex';
        }
    }

    // Open larger image preview
    function openImagePreview(prefix) {
        const preview = document.getElementById(prefix + '-preview');
        // For edit modals, try to get the current stored image URL
        let currentImageUrl = null;
        if (prefix.startsWith('edit-')) {
            currentImageUrl = document.getElementById(prefix + '-current-image-url');
        }

        let imageSrc = preview ? preview.src : '';

        // If preview is hidden/not set, try current image URL
        if (!imageSrc || imageSrc === '' || imageSrc.includes('data:,')) {
            if (currentImageUrl) imageSrc = currentImageUrl.value;
        }

        if (imageSrc && imageSrc.trim() !== '' && !imageSrc.includes('data:,')) {
            document.getElementById('preview-modal-image').src = imageSrc;
            const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
            modal.show();
        }
    }

    // Reset add category modal preview when opened (like brand pattern)
    (function() {
        const addCategoryModal = document.getElementById('add-category');
        if (addCategoryModal) {
            addCategoryModal.addEventListener('show.bs.modal', function() {
                const preview = document.getElementById('add-category-preview');
                const placeholder = document.getElementById('add-category-placeholder');
                const fileInput = document.getElementById('add-category-file');

                if (preview) {
                    preview.src = '';
                    preview.style.display = 'none';
                }
                if (placeholder) placeholder.style.display = 'flex';
                if (fileInput) fileInput.value = '';
            });
        }

        // Initialize image on edit-category modal BEFORE it opens (show.bs.modal)
        // Reads image_url directly from the trigger element's data-image-url attribute
        const editCategoryModal = document.getElementById('edit-category');
        if (editCategoryModal) {
            editCategoryModal.addEventListener('show.bs.modal', function(e) {
                const trigger = e.relatedTarget;
                if (trigger) {
                    const imageUrl = trigger.getAttribute('data-image-url');
                    if (imageUrl) {
                        setEditCategoryImage(imageUrl);
                    } else {
                        setEditCategoryImage('');
                    }
                }
            });
        }
    })();

    // Global image preview function for category/subcategory
    function previewImage(input, prefix) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            const preview = document.getElementById(prefix + '-preview');
            const placeholder = document.getElementById(prefix + '-placeholder');

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function handleCategoryFormSubmit(form, submitButtonId) {
        let formData = new FormData(form);
        let submitButton = document.getElementById(submitButtonId);
        if (submitButton) submitButton.disabled = true;

        // Show processing indicator
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: "Processing..."
                , text: "Please wait."
                , icon: "info"
                , showConfirmButton: false
                , allowOutsideClick: false
            });
        }

        fetch(form.action, {
                method: "POST"
                , headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                , }
                , body: formData
            , })
            .then((response) => response.json())
            .then((data) => {
                if (typeof Swal !== 'undefined') Swal.close();
                if (submitButton) submitButton.disabled = false;

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

                // First, close the form modal (add/edit) using Bootstrap Modal API
                const formModal = form.closest('.modal');
                if (formModal) {
                    const bsModal = bootstrap.Modal.getInstance(formModal);
                    if (bsModal) bsModal.hide();
                }

                // Then show success/error alert modal
                const messageEl = document.getElementById(messageId);
                const modalEl = document.getElementById(modalId);
                if (messageEl) messageEl.textContent = modalMessage;
                if (modalEl) new bootstrap.Modal(modalEl).show();

                if (data.success) {
                    setTimeout(() => {
                        window.refreshCategoryTable();
                    }, 1000);
                }
            })
            .catch((error) => {
                console.error("Submission failed:", error);
                if (typeof Swal !== 'undefined') Swal.close();
                if (submitButton) submitButton.disabled = false;
                const dangerMsg = document.getElementById("danger-message");
                if (dangerMsg) dangerMsg.textContent = error.message || "An error occurred";
                const dangerModal = document.getElementById("danger-alert-modal");
                if (dangerModal) new bootstrap.Modal(dangerModal).show();
            });
    }

</script>
@endsection
