<?php $page = 'admin-dashboard'; ?>
@extends('pages.layout.mainlayout')

@section('content')
<style>
    .mini-dashboard {
        background: linear-gradient(135deg, #0f1a2e 0%, #1a2744 100%);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
    }
    .mini-stat-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s;
    }
    .mini-stat-card:hover {
        background: rgba(255,255,255,0.08);
        transform: translateY(-2px);
    }
    .mini-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 20px;
    }
    .mini-stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 4px;
    }
    .mini-stat-label {
        font-size: 12px;
        color: rgba(255,255,255,0.6);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stat-change {
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 20px;
        display: inline-block;
        margin-top: 8px;
    }
    .stat-change.up { background: rgba(40,199,111,0.2); color: #28C76F; }
    .stat-change.down { background: rgba(234,84,85,0.2); color: #EA5455; }
    .stat-change.neutral { background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.5); }

    .mini-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 12px;
        padding: 20px;
        height: 100%;
        overflow: hidden;
    }
    .mini-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }
    .mini-card-title {
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        margin: 0;
    }
    .mini-card-filter {
        font-size: 11px;
        color: rgba(255,255,255,0.5);
        background: rgba(255,255,255,0.05);
        padding: 4px 12px;
        border-radius: 20px;
        border: none;
        cursor: pointer;
    }
    #sales_chart {
        width: 100% !important;
    }
    #sales_chart .apexcharts-canvas {
        width: 100% !important;
    }

    .top-product-item {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .top-product-item:last-child { border-bottom: none; }
    .top-product-rank {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: rgba(255,204,0,0.15);
        color: #FFCC00;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 12px;
        margin-right: 12px;
    }
    .top-product-rank.gold { background: rgba(255,204,0,0.25); }
    .top-product-rank.silver { background: rgba(192,192,192,0.15); color: #C0C0C0; }
    .top-product-rank.bronze { background: rgba(205,127,50,0.15); color: #CD7F32; }
    .top-product-img {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        object-fit: cover;
        margin-right: 12px;
        background: rgba(255,255,255,0.05);
    }
    .top-product-info { flex: 1; }
    .top-product-name {
        font-size: 13px;
        color: #fff;
        margin: 0 0 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .top-product-qty {
        font-size: 11px;
        color: rgba(255,255,255,0.5);
    }
    .top-product-sales {
        text-align: right;
    }
    .top-product-sales-value {
        font-size: 13px;
        font-weight: 600;
        color: #28C76F;
    }
    .top-product-sales-qty {
        font-size: 10px;
        color: rgba(255,255,255,0.4);
    }

    .low-stock-item {
        display: flex;
        align-items: center;
        padding: 10px 12px;
        background: rgba(234,84,85,0.08);
        border: 1px solid rgba(234,84,85,0.2);
        border-radius: 8px;
        margin-bottom: 8px;
    }
    .low-stock-item:last-child { margin-bottom: 0; }
    .low-stock-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(234,84,85,0.2);
        color: #EA5455;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 14px;
    }
    .low-stock-info { flex: 1; }
    .low-stock-name {
        font-size: 12px;
        color: #fff;
        margin: 0 0 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .low-stock-stock {
        font-size: 11px;
        color: #EA5455;
    }
    .low-stock-stock.urgent {
        color: #ff6b6b;
        font-weight: 600;
    }

    .transaction-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .transaction-item:last-child { border-bottom: none; }
    .transaction-info { flex: 1; }
    .transaction-id {
        font-size: 12px;
        color: rgba(255,255,255,0.5);
        margin-bottom: 2px;
    }
    .transaction-items {
        font-size: 13px;
        color: #fff;
    }
    .transaction-amount {
        text-align: right;
    }
    .transaction-amount-value {
        font-size: 13px;
        font-weight: 600;
        color: #28C76F;
    }
    .transaction-status {
        font-size: 10px;
        padding: 2px 8px;
        border-radius: 20px;
        display: inline-block;
        margin-top: 2px;
    }
    .status-lunas { background: rgba(40,199,111,0.15); color: #28C76F; }
    .status-piutang { background: rgba(255,159,67,0.15); color: #FF9F43; }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: rgba(255,255,255,0.4);
    }
    .empty-state i { font-size: 32px; margin-bottom: 12px; }
    .empty-state p { margin: 0; font-size: 13px; }

    @media (max-width: 768px) {
        .mini-dashboard { padding: 16px; }
        .mini-stat-card { padding: 16px; }
        .mini-stat-value { font-size: 20px; }
    }
</style>

<div class="page-wrapper">
    <div class="content">
        {{-- Header --}}
        <div class="page-header mb-4">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div>
                    <h3 class="page-title mb-1" style="color:#fff;">Dashboard Penjualan</h3>
                    <p class="text-muted mb-0" style="font-size:13px;">Suku Cadang Motor</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('product-list') }}" class="btn btn-sm" style="background:rgba(255,255,255,0.05);color:#B8BCC9;border:1px solid rgba(255,255,255,0.1);">
                        <i data-feather="package" class="feather-16 me-1"></i> Produk
                    </a>
                    <a href="{{ url('/pos') }}" class="btn btn-sm" style="background:#FFCC00;color:#000;border:none;">
                        <i data-feather="shopping-cart" class="feather-16 me-1"></i> Kasir
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="mini-dashboard">
            <div class="row g-3">
                <div class="col-xl-3 col-sm-6">
                    <div class="mini-stat-card">
                        <div class="mini-stat-icon" style="background:rgba(40,199,111,0.15);color:#28C76F;">
                            <i data-feather="trending-up"></i>
                        </div>
                        <div class="mini-stat-value">{{ \App\Services\UtilService::formatCurrency($totalSales ?? 0, 'IDR') }}</div>
                        <div class="mini-stat-label">Penjualan</div>
                        @if(($salesChange ?? 0) != 0)
                            <span class="stat-change {{ ($salesChange ?? 0) >= 0 ? 'up' : 'down' }}">
                                {{ ($salesChange ?? 0) >= 0 ? '▲' : '▼' }} {{ abs($salesChange ?? 0) }}%
                            </span>
                        @else
                            <span class="stat-change neutral">vs periode lalu</span>
                        @endif
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="mini-stat-card">
                        <div class="mini-stat-icon" style="background:rgba(100,116,139,0.15);color:#64748B;">
                            <i data-feather="repeat"></i>
                        </div>
                        <div class="mini-stat-value">{{ $totalTransactions ?? 0 }}</div>
                        <div class="mini-stat-label">Transaksi</div>
                        <span class="stat-change neutral">periode ini</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="mini-stat-card">
                        <div class="mini-stat-icon" style="background:rgba(255,204,0,0.15);color:#FFCC00;">
                            <i data-feather="package"></i>
                        </div>
                        <div class="mini-stat-value">{{ number_format($totalProducts ?? 0) }}</div>
                        <div class="mini-stat-label">Total Produk</div>
                        <span class="stat-change neutral">suku cadang</span>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="mini-stat-card" style="{{ ($lowStockCount ?? 0) > 0 ? 'border-color:rgba(234,84,85,0.3);' : '' }}">
                        <div class="mini-stat-icon" style="background:rgba(234,84,85,0.15);color:#EA5455;">
                            <i data-feather="alert-triangle"></i>
                        </div>
                        <div class="mini-stat-value">{{ $lowStockCount ?? 0 }}</div>
                        <div class="mini-stat-label">Low Stock</div>
                        @if(($urgentStockCount ?? 0) > 0)
                            <span class="stat-change down">{{ $urgentStockCount }} urgent</span>
                        @else
                            <span class="stat-change up">semua aman</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter --}}
        <div class="d-flex justify-content-end mb-3">
            <div class="btn-group">
                <a href="?filter=day" class="btn btn-sm {{ ($filter ?? 'month') == 'day' ? 'btn-warning' : 'btn-outline-secondary' }}" style="{{ ($filter ?? 'month') == 'day' ? 'background:#FFCC00;color:#000;border:none;' : '' }}">Hari</a>
                <a href="?filter=week" class="btn btn-sm {{ ($filter ?? 'month') == 'week' ? 'btn-warning' : 'btn-outline-secondary' }}" style="{{ ($filter ?? 'month') == 'week' ? 'background:#FFCC00;color:#000;border:none;' : '' }}">Minggu</a>
                <a href="?filter=month" class="btn btn-sm {{ ($filter ?? 'month') == 'month' ? 'btn-warning' : 'btn-outline-secondary' }}" style="{{ ($filter ?? 'month') == 'month' ? 'background:#FFCC00;color:#000;border:none;' : '' }}">Bulan</a>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="row g-3">
            {{-- Chart --}}
            <div class="col-xl-8">
                <div class="mini-card">
                    <div class="mini-card-header">
                        <h5 class="mini-card-title">Trend Penjualan</h5>
                        <span class="mini-card-filter">{{ $chartDays }} hari terakhir</span>
                    </div>
                    <div id="sales_chart" style="height: 250px;"></div>
                </div>
            </div>

            {{-- Top Products --}}
            <div class="col-xl-4">
                <div class="mini-card">
                    <div class="mini-card-header">
                        <h5 class="mini-card-title">Top Selling</h5>
                    </div>
                    @if($topProducts->count() > 0)
                        @foreach($topProducts as $index => $product)
                            <div class="top-product-item">
                                <div class="top-product-rank @if($index == 0) gold @elseif($index == 1) silver @elseif($index == 2) bronze @endif">
                                    {{ $index + 1 }}
                                </div>
                                <img src="{{ $product->item && $product->item->image_url ? URL::asset($product->item->image_url) : asset('build/img/image-not-found.jpg') }}"
                                     alt="" class="top-product-img">
                                <div class="top-product-info">
                                    <p class="top-product-name" title="{{ $product->item->name ?? 'Unknown' }}">{{ $product->item->name ?? 'Unknown' }}</p>
                                    <span class="top-product-qty">{{ $product->total_qty }} unit terjual</span>
                                </div>
                                <div class="top-product-sales">
                                    <div class="top-product-sales-value">{{ \App\Services\UtilService::formatCurrency($product->total_sales, 'IDR') }}</div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i data-feather="package"></i>
                            <p>Belum ada data penjualan</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Low Stock Alert --}}
            <div class="col-xl-6">
                <div class="mini-card">
                    <div class="mini-card-header">
                        <h5 class="mini-card-title">
                            <i data-feather="alert-circle" class="feather-16" style="color:#EA5455;margin-right:6px;"></i>
                            Low Stock Alert
                        </h5>
                        @if($lowStockCount > 0)
                            <a href="{{ route('product-list') }}?stock=low" class="mini-card-filter" style="text-decoration:none;">Lihat Semua</a>
                        @endif
                    </div>
                    @if($lowStockProducts->count() > 0)
                        @foreach($lowStockProducts->take(5) as $product)
                            <div class="low-stock-item">
                                <div class="low-stock-icon">
                                    <i data-feather="alert-triangle"></i>
                                </div>
                                <div class="low-stock-info">
                                    <p class="low-stock-name">{{ $product->name }}</p>
                                    <span class="low-stock-stock {{ $product->stock <= 0 ? 'urgent' : '' }}">
                                        Stock: {{ $product->stock }} / Min: {{ $product->stock_min }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i data-feather="check-circle"></i>
                            <p>Semua produk stock aman</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Recent Transactions --}}
            <div class="col-xl-6">
                <div class="mini-card">
                    <div class="mini-card-header">
                        <h5 class="mini-card-title">
                            <i data-feather="clock" class="feather-16" style="color:#FFCC00;margin-right:6px;"></i>
                            Transaksi Terakhir
                        </h5>
                        <a href="{{ route('sales-list') }}" class="mini-card-filter" style="text-decoration:none;">Lihat Semua</a>
                    </div>
                    @if($recentSales->count() > 0)
                        @foreach($recentSales as $sale)
                            <div class="transaction-item">
                                <div class="transaction-info">
                                    <div class="transaction-id">{{ $sale->trx_id ?? '#' . $sale->id }}</div>
                                    <div class="transaction-items">
                                        {{ $sale->buyer->name ?? 'Walk-in Customer' }}
                                    </div>
                                </div>
                                <div class="transaction-amount">
                                    <div class="transaction-amount-value">{{ \App\Services\UtilService::formatCurrency($sale->final_total, 'IDR') }}</div>
                                    <span class="transaction-status {{ $sale->payment_status == 0 ? 'status-lunas' : 'status-piutang' }}">
                                        {{ $sale->payment_status == 0 ? '✓ Lunas' : '⏳ Piutang' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i data-feather="file-text"></i>
                            <p>Belum ada transaksi</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart data
    var chartData = @json($chartData ?? []);
    var labels = chartData.map(function(d) { return d.date; });
    var values = chartData.map(function(d) { return d.total; });

    if (document.getElementById('sales_chart')) {
        // Destroy existing chart instance if exists
        var chartEl = document.querySelector("#sales_chart");
        if (chartEl.__chart) {
            chartEl.__chart.destroy();
        }

        var options = {
            series: [{
                name: 'Penjualan',
                data: values.length ? values : [0,0,0,0,0,0,0]
            }],
            colors: ['#FFCC00'],
            chart: {
                type: 'area',
                height: 250,
                toolbar: { show: false },
                sparkline: { enabled: false }
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [0, 100]
                }
            },
            dataLabels: { enabled: false },
            xaxis: {
                categories: labels.length ? labels : ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: { colors: 'rgba(255,255,255,0.4)', fontSize: '11px' }
                }
            },
            yaxis: {
                tickAmount: 4,
                labels: {
                    formatter: function(val) { return 'Rp ' + (val * 1000 / 1000).toLocaleString('id-ID') + 'k'; },
                    style: { colors: 'rgba(255,255,255,0.4)', fontSize: '11px' }
                }
            },
            grid: {
                borderColor: 'rgba(255,255,255,0.05)',
                strokeDashArray: 4
            },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function(val) { return 'Rp ' + (val * 1000).toLocaleString('id-ID'); }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#sales_chart"), options);
        chartEl.__chart = chart;
        chart.render();
    }
});
</script>
@endsection
