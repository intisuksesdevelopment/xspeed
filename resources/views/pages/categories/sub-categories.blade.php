<?php $page = 'subcategory'; ?>
@extends('pages.layout.mainlayout')
@section('content')
    <style>
        .fade-row {
            transition: all 0.2s ease;
        }

        .fade-row:hover {
            background-color: #f8f9fa;
        }
    </style>
    <div class="page-wrapper" x-data="subCategoryTable()" x-init="init()" x-cloak>
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
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-search"></i>
                                        </button>

                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"
                                                    @click.prevent="filters.searchBy = 'Name'">{{ __('common.name') }}</a>
                                            </li>
                                            <li><a class="dropdown-item" href="#"
                                                    @click.prevent="filters.searchBy = 'Code'">{{ __('common.code') }}</a>
                                            </li>
                                        </ul>

                                        <!-- Input -->
                                        <input type="text" class="form-control"
                                            :placeholder="`{{ __('label.searchby') }} ${filters.searchBy}...`"
                                            x-model="filters.search" @keyup.debounce.500ms="fetchSubCategories()">
                                    </div>
                                </div>
                            </div>

                            <!-- SORT -->
                            <div class="col-md-3">
                                <select class="form-select" x-model="filters.sort" @change="fetchSubCategories()">
                                    <option value="desc">{{ __('common.new') }}</option>
                                    <option value="asc">{{ __('common.old') }}</option>
                                </select>
                            </div>

                            <!-- PER PAGE -->
                            <div class="col-md-4 text-md-end">
                                <div class="d-inline-flex align-items-center gap-2">
                                    <span class="text-muted">{{ __('common.show') }}</span>
                                    <select class="form-select form-select-sm w-auto" x-model="perPage"
                                        @change="changePerPage(perPage)">
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
                                    <th>{{ __('common.name') }}</th>
                                    <th>{{ __('common.parentcategory') }}</th>
                                    <th>{{ __('common.code') }}</th>
                                    <th class="no-sort"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Empty state -->
                                <tr x-show="!loading && items.length === 0">
                                    <td colspan="5" class="text-center py-3">No data found</td>
                                </tr>
                                <!-- Data rows -->
                                <template x-for="item in items" :key="item.id">
                                    <tr class="fade-row">
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td x-text="item.name"></td>
                                        <td x-text="item.category?.name ?? '-'"></td>
                                        <td x-text="item.code"></td>
                                        <td class="action-table-data">
                                            <div class="edit-delete-action">
                                                <a class="me-2 p-2" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#edit-sub-category" @click="openEditModal(item)">
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
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                style="background: rgba(255,255,255,0.7); z-index: 10; min-height: 200px;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- PAGINATION -->
                    <div class="d-flex justify-content-between align-items-center mt-3" x-show="!loading && total > 0">
                        <div>
                            <span class="text-muted">Showing <span x-text="from"></span> to <span x-text="to"></span> of
                                <span x-text="total"></span> entries</span>
                        </div>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-outline-secondary" @click="prevPage()" :disabled="page <= 1">
                                <i class="fa fa-chevron-left"></i>
                            </button>
                            <template x-for="p in visiblePages" :key="p">
                                <button class="btn btn-sm" :class="p === page ? 'btn-primary' : 'btn-outline-secondary'"
                                    @click="goToPage(p)" x-text="p"></button>
                            </template>
                            <button class="btn btn-sm btn-outline-secondary" @click="nextPage()"
                                :disabled="page >= lastPage">
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
                            <a href="javascript:void(0);" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</a>
                            <a href="javascript:void(0);" class="btn btn-submit" @click="deleteItem()">
                                <i data-feather="trash-2" class="feather-14"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const API_SUBCATEGORY_URL = "{{ route('api-subcategory-paged') }}";
        const API_CATEGORY_URL = "{{ route('api-category-all') }}";

        // Store reference globally BEFORE Alpine initializes
        window.subCategoryTable = function() {
            return {
                items: [],
                categories: [],
                loading: true,
                page: 1,
                perPage: 10,
                lastPage: 1,
                total: 0,
                from: 0,
                to: 0,

                filters: {
                    search: '',
                    searchBy: 'Name',
                    categoryId: '',
                    sort: 'desc'
                },

                itemToDelete: null,

                init() {
                    this.fetchCategories().then(() => {
                        this.populateModalDropdowns();
                    });
                    this.fetchSubCategories();
                },

                populateModalDropdowns() {
                    const addSelect = document.getElementById('add-category-id');
                    if (addSelect) {
                        addSelect.innerHTML = '';
                        this.categories.forEach(cat => {
                            const option = document.createElement('option');
                            option.value = cat.id;
                            option.text = cat.name;
                            addSelect.appendChild(option);
                        });
                    }
                    const editSelect = document.getElementById('edit-category-id');
                    if (editSelect) {
                        editSelect.innerHTML = '';
                        this.categories.forEach(cat => {
                            const option = document.createElement('option');
                            option.value = cat.id;
                            option.text = cat.name;
                            editSelect.appendChild(option);
                        });
                    }
                },

                async fetchCategories() {
                    try {
                        let res = await fetch(API_CATEGORY_URL);
                        let result = await res.json();
                        if (result.success) {
                            this.categories = result.data || [];
                        }
                    } catch (e) {
                        console.error('Error fetching categories:', e);
                    }
                },

                async fetchSubCategories() {
                    this.loading = true;

                    try {
                        let params = new URLSearchParams({
                            search: this.filters.search,
                            search_by: this.filters.searchBy,
                            category_id: this.filters.categoryId,
                            sortBy: 'created_at',
                            sortDirection: this.filters.sort,
                            page: this.page,
                            per_page: this.perPage
                        });

                        let res = await fetch(`${API_SUBCATEGORY_URL}?${params}`);
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
                        console.error('Error fetching subcategories:', e);
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
                    this.fetchSubCategories();
                },

                nextPage() {
                    if (this.page < this.lastPage) {
                        this.page++;
                        this.fetchSubCategories();
                    }
                },

                prevPage() {
                    if (this.page > 1) {
                        this.page--;
                        this.fetchSubCategories();
                    }
                },

                changePerPage(val) {
                    this.perPage = val;
                    this.page = 1;
                    this.fetchSubCategories();
                },

                formatDate(datetime) {
                    if (!datetime) return '-';
                    const date = new Date(datetime);
                    return new Intl.DateTimeFormat('id-ID', {
                        year: 'numeric',
                        month: 'short',
                        day: '2-digit'
                    }).format(date);
                },

                openEditModal(item) {
                    document.getElementById('edit-id').value = item.id;
                    document.getElementById('edit-code').value = item.code;
                    document.getElementById('edit-name').value = item.name;
                    document.getElementById('edit-description').value = item.description || '';
                    document.getElementById('edit-image-url').value = item.image_url || '';
                    document.getElementById('edit-category-id').value = item.category_id || '';
                    const statusCheckbox = document.getElementById('edit-status');
                    if (statusCheckbox) statusCheckbox.checked = (item.status == 0);
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
                        let res = await fetch(`{{ route('subcategory-delete', ':id') }}`.replace(':id', id) +
                            `?_token=${csrfToken}`, {
                                method: 'GET',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken
                                }
                            });

                        if (!res.ok) {
                            this.fetchSubCategories();
                        }
                    } catch (e) {
                        console.error('Delete error:', e);
                        this.fetchSubCategories();
                    }

                    this.itemToDelete = null;
                },

                refreshList() {
                    this.fetchSubCategories();
                }
            }
        };
    </script>
@endsection
