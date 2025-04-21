<?php $page = 'sales-invoices'; ?>
@extends('pages.layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            @component('components.breadcrumb')
                @slot('title')
                    Sales Invoice Report
                @endslot
                @slot('li_1')
                    Manage Your Sales Invoice Report
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

                            </div>

                        </div>
                        <div class="form-sort">
                            <i data-feather="sliders" class="info-img"></i>
                            <select class="select">
                                <option>Sort by Date</option>
                                <option>25 9 23</option>
                                <option>12 9 23</option>
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
                                            <option>Rose</option>
                                            <option>Kaitlin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <i data-feather="stop-circle" class="info-img"></i>
                                        <select class="select">
                                            <option>Choose Status</option>
                                            <option>Paid</option>
                                            <option>Unpaid</option>
                                            <option>Overdue</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <div class="position-relative daterange-wraper">
                                            <input type="text" class="form-control" name="datetimes"
                                                placeholder="From Date - To Date">
                                            <i data-feather="calendar" class="feather-14 info-img"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
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
                                    <th>Invoice No</th>
                                    <th>Customer</th>
                                    <th>Due Date</th>
                                    <th>Amount</th>
                                    <th>Paid</th>
                                    <th>Amount Due</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $sales as $sale )
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>{{ $sale->name }}</td>
                                    <td>{{ $sale->cust_name }}</td>
                                    <td>{{ $sale->created_at }}</td>
                                    <td>{{\App\Services\UtilService::formatCurrency($sale->final_total,$sale->currency) }}</td>
                                    <td>{{\App\Services\UtilService::formatCurrency($sale->payment_amount,$sale->currency) }}</td>
                                    <td>{{\App\Services\UtilService::formatCurrency($sale->payment_remaining,$sale->currency) }}</td>
                                    @if ($sale->payment_status == 0)
                                        <td><span class="badge badge-linesuccess">{{ $sale->getPaymentStatus }}</span></td>
                                    @elseif ($sale->payment_status == 2)
                                        <td><span class="badge badges-warning">{{ $sale->getPaymentStatus }}</span></td>
                                    @elseif ($sale->payment_status == 1)
                                        <td><span class="badge badge-linedanger">{{$sale->getPaymentStatus }}</span></td>
                                    @else
                                        <td><span class="badge badge-lineinfo">{{ $sale->getPaymentStatus }}</span></td>      
                                    @endif
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
@endsection
