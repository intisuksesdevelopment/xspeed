<?php $page = 'sales-detail'; ?>
@extends('pages.layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        @component('pages.components.breadcrumb')
            @slot('title')
                Detail Penjualan
            @endslot
            @slot('li_1')
                Penjualan
            @endslot
            @slot('li_2')
                Detail
            @endslot
        @endcomponent

        @if(isset($sale) && $sale)
        <div class="row">
            <div class="col-lg-8">
                {{-- Sale Info --}}
                <div class="card">
                    <div class="card-header">
                        <h5>Informasi Penjualan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" style="color: #9ca3af;">ID Transaksi</label>
                                    <p class="mb-0 fw-bold">{{ $sale->trx_id ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" style="color: #9ca3af;">Tanggal</label>
                                    <p class="mb-0">{{ $sale->created_at ? $sale->created_at->format('d M Y H:i') : '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" style="color: #9ca3af;">Customer</label>
                                    <p class="mb-0">{{ $sale->cust_name ?? 'Walk-in Customer' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" style="color: #9ca3af;">Status Pembayaran</label>
                                    @if($sale->payment_status == 0)
                                        <span class="badge badge-linesuccess">Lunas</span>
                                    @elseif($sale->payment_status == 1)
                                        <span class="badge badge-linedanger">Piutang</span>
                                    @else
                                        <span class="badge badge-linepending">Hold</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Items --}}
                <div class="card">
                    <div class="card-header">
                        <h5>Item Penjualan</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-end">Qty</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-end">Diskon</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($saleData as $item)
                                    <tr>
                                        <td>
                                            <p class="mb-0">{{ $item->item_name ?? '-' }}</p>
                                            <small class="text-white-50">{{ $item->item_code ?? '' }}</small>
                                        </td>
                                        <td class="text-end">{{ $item->item_unit ?? 0 }}</td>
                                        <td class="text-end">{{ \App\Services\UtilService::formatCurrency($item->item_price ?? 0, 'IDR') }}</td>
                                        <td class="text-end">{{ $item->item_disc ?? 0 }}%</td>
                                        <td class="text-end fw-bold">{{ \App\Services\UtilService::formatCurrency($item->item_total ?? 0, 'IDR') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center" style="color: #9ca3af;">Tidak ada item</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                {{-- Payment Summary --}}
                <div class="card">
                    <div class="card-header">
                        <h5>Ringkasan Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: #9ca3af;">Sub Total</span>
                            <span>{{ \App\Services\UtilService::formatCurrency($sale->sub_total ?? 0, 'IDR') }}</span>
                        </div>
                        @if($sale->disc_total > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: #9ca3af;">Diskon</span>
                            <span class="text-danger">-{{ \App\Services\UtilService::formatCurrency($sale->disc_total ?? 0, 'IDR') }}</span>
                        </div>
                        @endif
                        @if($sale->tax_total > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: #9ca3af;">Pajak</span>
                            <span>{{ \App\Services\UtilService::formatCurrency($sale->tax_total ?? 0, 'IDR') }}</span>
                        </div>
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold text-primary">{{ \App\Services\UtilService::formatCurrency($sale->final_total ?? 0, 'IDR') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: #9ca3af;">Dibayar</span>
                            <span class="text-success">{{ \App\Services\UtilService::formatCurrency($sale->payment_amount ?? 0, 'IDR') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: #9ca3af;">Kembalian</span>
                            <span>{{ \App\Services\UtilService::formatCurrency($sale->payment_change ?? 0, 'IDR') }}</span>
                        </div>
                        @if($sale->payment_remaining > 0)
                        <div class="d-flex justify-content-between">
                            <span style="color: #9ca3af;">Sisa</span>
                            <span class="text-danger fw-bold">{{ \App\Services\UtilService::formatCurrency($sale->payment_remaining ?? 0, 'IDR') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Actions --}}
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('sales-list') }}" class="btn btn-outline-secondary w-100 mb-2">
                            <i data-feather="arrow-left" class="feather-16 me-1"></i> Kembali
                        </a>
                        <a href="{{ route('sales-invoices') }}?id={{ $sale->uuid ?? $sale->id }}" class="btn btn-outline-primary w-100">
                            <i data-feather="printer" class="feather-16 me-1"></i> Cetak Invoice
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i data-feather="inbox" class="feather-64 mb-3" style="color: #6b7280;"></i>
                <h5 style="color: #9ca3af;">Data penjualan tidak ditemukan</h5>
                <a href="{{ route('sales-list') }}" class="btn btn-outline-secondary mt-3">
                    <i data-feather="arrow-left" class="feather-16 me-1"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
