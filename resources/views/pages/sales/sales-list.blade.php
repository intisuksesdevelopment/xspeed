<?php $page = 'sales-list'; ?>
@extends('pages.layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        @component('pages.components.breadcrumb')
            @slot('title') Sales List @endslot
            @slot('li_1') Manage Your Sales @endslot
            @slot('li_2') Add New Sales @endslot
        @endcomponent

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
                                <span><img src="{{ asset('build/img/icons/closes.svg') }}" alt="img"></span>
                            </a>
                        </div>
                    </div>
                </div>

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
                                <th>Customer</th>
                                <th>Reference</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Grand Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Payment</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="sales-list">
                            @forelse($sales as $sale)
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>{{ $sale->cust_name ?? 'Walk-in Customer' }}</td>
                                <td>{{ $sale->trx_id ?? '#' . $sale->id }}</td>
                                <td>{{ $sale->created_at ? $sale->created_at->format('d M Y') : '-' }}</td>
                                <td>
                                    @if($sale->status == 0)
                                        <span class="badge badge-bgsuccess">Completed</span>
                                    @elseif($sale->status == 1)
                                        <span class="badge badge-bgdanger">Deleted</span>
                                    @else
                                        <span class="badge badge-bgyellow">Pending</span>
                                    @endif
                                </td>
                                <td>{{ \App\Services\UtilService::formatCurrency($sale->final_total ?? 0, 'IDR') }}</td>
                                <td>{{ \App\Services\UtilService::formatCurrency($sale->payment_amount ?? 0, 'IDR') }}</td>
                                <td>{{ \App\Services\UtilService::formatCurrency($sale->payment_remaining ?? 0, 'IDR') }}</td>
                                <td>
                                    @if($sale->payment_status == 0)
                                        <span class="badge badge-linesuccess">Paid</span>
                                    @elseif($sale->payment_status == 1)
                                        <span class="badge badge-linedanger">Due</span>
                                    @else
                                        <span class="badge badge-linepending">Hold</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('sales-detail', $sale->uuid ?? $sale->id) }}" class="btn btn-sm btn-outline-primary" title="Detail">
                                            <i data-feather="eye" class="feather-16"></i>
                                        </a>
                                        <a href="{{ route('sales-invoices') }}?id={{ $sale->uuid ?? $sale->id }}" class="btn btn-sm btn-outline-secondary" title="Invoice">
                                            <i data-feather="file-text" class="feather-16"></i>
                                        </a>
                                        <a href="javascript:void(0);" onclick="deleteSale('{{ $sale->uuid ?? $sale->id }}')" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i data-feather="trash-2" class="feather-16"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">Belum ada data penjualan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function deleteSale(id) {
    if (confirm('Yakin ingin menghapus penjualan ini?')) {
        window.location.href = '/admin/sales/delete/' + id;
    }
}
</script>
@endsection
