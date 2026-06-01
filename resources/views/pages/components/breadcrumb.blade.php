{{-- Routes with back button (no PDF/Excel/Print actions) --}}
{{-- @if (Route::is(['product-add', 'product-list', 'product-edit']))
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>{{ $title }}</h4>
                <h6>{{ $li_1 }}</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <div class="page-btn">
                    <a href="{{ $li_2 }}" class="btn btn-secondary"><i data-feather="arrow-left"
                            class="me-2"></i>{{ $li_3 }}</a>
                </div>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                        data-feather="chevron-up" class="feather-chevron-up"></i></a>
            </li>
        </ul>
    </div>
@endif --}}

@php
    $chartFormRoutes = [
        'chart-apex',
        'chart-c3',
        'chart-flot',
        'chart-js',
        'chart-morris',
        'chart-peity',
        'data-tables',
        'tables-basic',
        'form-basic-inputs',
        'form-checkbox-radios',
        'form-input-groups',
        'form-grid-gutters',
        'form-select',
        'form-mask',
        'form-fileupload',
        'form-horizontal',
        'form-vertical',
        'form-floating-labels',
        'form-validation',
        'form-select2',
        'form-wizard',
        'icon-fontawesome',
        'icon-feather',
        'icon-ionic',
        'icon-material',
        'icon-pe7',
        'icon-simpleline',
        'icon-themify',
        'icon-weather',
        'icon-typicon',
        'icon-flag',
        'ui-clipboard',
        'ui-counter',
        'ui-drag-drop',
        'ui-rating',
        'ui-ribbon',
        'ui-scrollbar',
        'ui-stickynote',
        'ui-text-editor',
        'ui-timeline',
    ];
    $addUnitsRoutes = [
        'warranty',
        'warehouses',
        'varriant-attributes',
        'units',
        'suppliers',
        'stock-adjustment',
        'stock-transfer',
        'states',
        'shift',
        'quotation-list',
        'payroll-list',
        'manage-stocks',
        'leaves-employee',
        'leave-types',
        'expense-list',
        'expense-category',
        'attendance-admin',
        'users',
        'roles-permissions',
        'customers',
        'coupons',
        'countries',
    ];
@endphp

@if (!Route::is([...['product-add', 'product-edit'], ...$chartFormRoutes]))
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>{{ $title }}</h4>
                <h6>{{ $li_1 }}</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" id="pdf-btn" title="Pdf"><img
                        src="{{ asset('build/img/icons/pdf.svg') }}" alt="img"></a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" id="excel-btn" title="Excel"><img
                        src="{{ asset('build/img/icons/excel.svg') }}" alt="img"></a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" id="print-btn" title="Print"><i
                        data-feather="printer" class="feather-rotate-ccw"></i></a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" id="refresh-btn" title="Refresh"><i
                        data-feather="rotate-ccw" class="feather-rotate-ccw"></i></a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                        data-feather="chevron-up" class="feather-chevron-up"></i></a>
            </li>
        </ul>

        {{-- Routes using #add-units modal --}}
        @if (Route::is($addUnitsRoutes))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i>{{ $li_2 ?? 'Add New' }}</a>
            </div>
        @endif

        @if (Route::is(['racks']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-rack"><i
                        data-feather="plus-circle" class="me-2"></i>{{ $li_2 ?? 'Add Rack' }}</a>
            </div>
        @endif
        @if (Route::is(['subracks']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-sub-rack"><i
                        data-feather="plus-circle" class="me-2"></i>{{ $li_2 ?? 'Add Sub Rack' }}</a>
            </div>
        @endif
        @if (Route::is(['subcategory']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-sub-category"><i
                        data-feather="plus-circle" class="me-2"></i>Add Sub Category</a>
            </div>
        @endif
        @if (Route::is(['store-list']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-stores"><i
                        data-feather="plus-circle" class="me-2"></i>Add Store</a>
            </div>
        @endif
        @if (Route::is(['stock-list']))
            <div class="page-btn">
                <a href="{{ route('stock-add') }}" class="btn btn-added"><i data-feather="plus-circle"
                        class="me-2"></i>Add Stock Opname</a>
            </div>
            <div class="page-btn import">
                <a href="#" class="btn btn-added color" data-bs-toggle="modal" data-bs-target="#view-notes"><i
                        data-feather="download" class="me-2"></i>Import Stock Opname</a>
            </div>
        @endif
        @if (Route::is(['sales-returns']))
            <div class="page-btn">
                <a href="{{ url('createsalesreturn') }}" class="btn btn-added" data-bs-toggle="modal"
                    data-bs-target="#add-sales-new"><i data-feather="plus-circle" class="me-2"></i>Add New Sales
                    Return</a>
            </div>
        @endif
        @if (Route::is(['sales-list']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-sales-new"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Sales</a>
            </div>
        @endif
        @if (Route::is(['purchase-returns']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-sales-new">
                    <i data-feather="plus-circle" class="me-2"></i>Add Purchase Return
                </a>
            </div>
        @endif
        @if (Route::is(['leaves-admin']))
            <div class="page-btn">
                <a href="{{ url('leave-types') }}" class="btn btn-added">Leave type</a>
            </div>
        @endif
        @if (Route::is(['holidays']))
            <div class="page-btn">
                <a href="" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-department"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Holiday</a>
            </div>
        @endif
        @if (Route::is(['employees-grid']))
            <div class="page-btn">
                <a href="{{ url('add-employee') }}" class="btn btn-added"><i data-feather="plus-circle"
                        class="me-2"></i>Add New Employee</a>
            </div>
        @endif
        @if (Route::is(['designation']))
            <div class="page-btn">
                <a href="" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-department"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Designation</a>
            </div>
        @endif
        @if (Route::is(['department-grid']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-department"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Department</a>
            </div>
        @endif
        @if (Route::is(['category']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-category"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Category</a>
            </div>
        @endif
        @if (Route::is(['brands']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-brand"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Brand</a>
            </div>
        @endif
        @if (Route::is(['product-list']))
            <div class="page-btn">
                <a href="{{ $li_2 }}" class="btn btn-added"><i data-feather="plus-circle"
                        class="me-2"></i>{{ $li_3 }}</a>
            </div>
        @endif
        @if (Route::is(['order', 'order-add-form']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-order-item"><i
                        data-feather="plus-circle" class="me-2"></i>Add Product</a>
            </div>
        @endif
    </div>
@endif

@if (Route::is($chartFormRoutes))
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">{{ $title }}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('index') }}">{{ $li_1 }}</a></li>
                    <li class="breadcrumb-item active">{{ $li_2 }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
@endif
