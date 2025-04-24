<?php $page = 'product-list'; ?>
@extends('pages.layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        @component('pages.components.breadcrumb')
        @slot('title')
        Product List
        @endslot
        @slot('li_1')
        Manage your products
        @endslot
        @slot('li_2')
        {{ url('product/add') }}
        @endslot
        @slot('li_3')
        Add New Product
        @endslot
        @slot('li_4')
        Import Product
        @endslot
        @endcomponent

        <!-- /product list -->
        <div class="card table-list-card">
            <div class="card-body">
                <div class="table-top" data-select2-id="select2-data-33-eupr">
                    <div class="search-set">
                        <div class="search-input">
                            <a href="javascript:void(0);" id="search-btn" class="btn btn-searchset">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </a>
                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                <label>
                                    <input type="text" id="search-input" class="form-control form-control-sm" placeholder="Search" aria-controls="DataTables_Table_0" />
                                    &nbsp;
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="search-path">
                        <div class="d-flex align-items-center">
                            <a class="btn btn-filter" id="filter_search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-filter filter-icon"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                                <span><img src="https://intisuksesdevelopment.my.id/build/img/icons/closes.svg" alt="img"></span>
                            </a>
                           
                        </div>
                    </div>
                    <div class="form-sort" data-select2-id="select2-data-32-ji6l">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders info-img"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                        <select class="select select2-hidden-accessible" id="sorting" aria-label="Sort by Date">
                            <option disabled>Sort by Date</option>
                            <option value="asc" selected>Newest</option>
                            <option value="desc">Oldest</option>
                        </select>
                        
                        <span class="dropdown-wrapper" aria-hidden="true">
                            </span>
                        </span>
                    </div>
                </div>
                <div class="card" id="filter_inputs">
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="input-blocks">
                                    <i data-feather="archive" class="info-img"></i>
                                    <select class="select" id="filter-warehouse">
                                        <option  value="" selected>Choose Warehouse</option>
                                        @foreach ($warehouses as $warehouse )
                                            <option value="{{ $warehouse['code'] }}">{{ $warehouse['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="input-blocks">
                                    <i data-feather="box" class="info-img"></i>
                                    <select class="select" id="filter-brand">
                                        <option  value="" selected>Choose Brand</option>
                                        @foreach ($brands as $brand )
                                            <option value="{{ $brand['code'] }}">{{ $brand['name'] }}</option>
                                        @endforeach
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
                <div class="table-responsive product-list">
                    <table class="table " id="product-table">
                        <thead>
                            <tr>
                                <th class="no-sort">
                                    <label class="checkboxs">
                                        <input type="checkbox" id="select-all">
                                        <span class="checkmarks"></span>
                                    </label>
                                </th>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Sell Price</th>
                                <th>Unit</th>
                                <th>Qty</th>
                                <th>Created by</th>
                                <th>Created at</th>
                                <th>Status</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach($items as $item)
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>
                                    <div class="productimgname">
                                        @if ($item['image_url']!=null)
                                            <a href="javascript:void(0);" class="product-img stock-img">
                                                <img src="{{ $item['image_url'] }}" alt="product" class="img-fluid rounded">
                                            </a>
                                            <a href="javascript:void(0);">{{$item['name']}}</a>

                                        @else
                                            @foreach($item['images'] as $image)
                                                @if ($loop->index == 0)
                                                    <a href="javascript:void(0);" class="product-img stock-img">
                                                        <img src="{{ $image['path'] }}" alt="product" class="img-fluid rounded">
                                                    </a>
                                                    <a href="javascript:void(0);">{{$item['name']}}</a>

                                                @endif
                                            @endforeach
                                        @endif


                                       
                                    </div>
                                </td>
                                <td>{{ $item['sku']}}</td>
                                <td>{{ $item['category']['code']}}</td>
                                <td>{{ $item['brand']['code']}}</td>
                                <td>{{ $item['sell_price']}}</td>
                                <td>{{ $item['unit']}}</td>
                                <td>{{ $item['stock']}}</td>
                                <td>{{ $item['created_by']}}</td>
                                <td>
                                    @if ($item['status'] == 0)
                                        <span class="badge badge-linesuccess">{{ $item['availability'] }}</span>
                                    @else
                                        <span class="badge badge-linedanger">{{ $item['availability'] }}</span>
                                    @endif
                                </td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 edit-icon p-2" href="{{ route('product-detail', ['uuid' => $item['uuid']]) }}">
                                            <i data-feather="eye" class="action-eye"></i>
                                        </a>                                        
                                        <a class="me-2 p-2" href="{{ route('product-edit-form', ['uuid' => $item['uuid']]) }}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a class="p-2" href="javascript:void(0);" onclick="deleteProduct('{{ $item['uuid']}}')">
                                            <i data-feather="trash-2" class="feather-trash-2"></i>
                                        </a>        
                                    </div>
                                </td>
                            </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /product list -->
    </div>
</div>
<script>
    const filters = {
        name: '#filter-name',
        category: '#filter-category'
    };

    const columns = [
        { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
        { data: 'product', name: 'name' },
        { data: 'sku', name: 'sku' },
        { data: 'category', name: 'category.code' },
        { data: 'brand', name: 'brand.code' },
        { data: 'sell_price', name: 'sell_price' },
        { data: 'unit', name: 'unit' },
        { data: 'stock', name: 'stock' },
        { data: 'created_by', name: 'created_by' },
        { data: 'created_at', name: 'created_at' },
        { data: 'status', name: 'status', searchable: false },
        { data: 'actions', name: 'actions', orderable: false, searchable: false },
    ];

    

    document.addEventListener('DOMContentLoaded', function() {
        window.deleteProduct = function(id) {
                deleteData(`{{ route('product-delete', ':uuid') }}`, id, document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            };
        initDataTable({
            tableId: 'product-table',
            ajaxUrl:  '{{ route("api-product-list") }}',
            filters: {
                searchInput: '#search-input',
                filterWarehouse: '#filter-warehouse',
                filterBrand: '#filter-brand',
            },
            columns,
            order: [[1, $('#sorting').val()]],
            localStorageKey: 'datatable_products',
            exportUrl:  '{{ route("product-excel-export") }}',

        });
    });
</script>
@endsection