<?php $page = 'order-list'; ?>
@extends('pages.layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            @component('pages.components.breadcrumb')
                @slot('title')
                    Order List
                @endslot
                @slot('li_1')
                    Manage Your Orders
                @endslot
                @slot('li_2')
                    Add New Orders
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
                                    <span><img src="{{ asset('build/img/icons/closes.svg') }}"
                                            alt="img"></span>
                                </a>

                            </div>

                        </div>
                        <div class="form-sort">
                            <i data-feather="sliders" class="info-img"></i>
                            <select class="select">
                                <option>Sort by Date</option>
                                <option>07 09 23</option>
                                <option>21 09 23</option>
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
                                            <option>Choose Customer Name</option>
                                            <option>Macbook pro</option>
                                            <option>Orange</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <i data-feather="stop-circle" class="info-img"></i>
                                        <select class="select">
                                            <option>Choose Status</option>
                                            <option>Computers</option>
                                            <option>Fruits</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <i data-feather="file-text" class="info-img"></i>
                                        <input type="text" placeholder="Enter Reference" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <i data-feather="stop-circle" class="info-img"></i>
                                        <select class="select">
                                            <option>Choose Payment Status</option>
                                            <option>Computers</option>
                                            <option>Fruits</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
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
                                    <th>Supplier Name</th>
                                    <th>Reference</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Grand Total</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Payment Status</th>
                                    <th>Biller</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="sales-list">
                                @forelse($orders as $order)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $order->supplier_name ?? '-' }}</td>
                                        <td>{{ $order->trx_id ?? '-' }}</td>
                                        <td>{{ $order->created_at ? $order->created_at->format('d M Y') : '-' }}</td>
                                        <td>
                                            @if($order->status == 0)
                                                <span class="badge badge-bgwarning">Pending</span>
                                            @elseif($order->status == 1)
                                                <span class="badge badge-bgsuccess">Completed</span>
                                            @else
                                                <span class="badge badge-bgdanger">Cancelled</span>
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format($order->final_total ?? 0, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($order->payment_amount ?? 0, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($order->payment_remaining ?? 0, 0, ',', '.') }}</td>
                                        <td>
                                            @if($order->payment_status == 0)
                                                <span class="badge badge-linesuccess">Paid</span>
                                            @elseif($order->payment_status == 1)
                                                <span class="badge badge-linewarning">Partial</span>
                                            @else
                                                <span class="badge badge-linedanger">Unpaid</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->created_by ?? 'System' }}</td>
                                        <td class="text-center">
                                            <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#order-details-{{ $order->id }}"><i data-feather="eye"
                                                            class="info-img"></i>Order Detail</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item"><i
                                                            data-feather="download" class="info-img"></i>Download pdf</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item confirm-text mb-0"
                                                        onclick="deleteOrder('{{ $order->uuid }}')"><i
                                                            data-feather="trash-2" class="info-img"></i>Delete Order</a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No orders found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} entries
                        </div>
                        <div>
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>
    </div>

    <!-- Order Detail Modal -->
    @foreach($orders as $order)
        <div class="modal fade" id="order-details-{{ $order->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Order Details - {{ $order->trx_id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Order Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold">Order Information</h6>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td width="40%">Transaction ID</td>
                                        <td>: {{ $order->trx_id }}</td>
                                    </tr>
                                    <tr>
                                        <td>Supplier</td>
                                        <td>: {{ $order->supplier_name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Date</td>
                                        <td>: {{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>: 
                                            @if($order->status == 0)
                                                <span class="badge badge-bgwarning">Pending</span>
                                            @elseif($order->status == 1)
                                                <span class="badge badge-bgsuccess">Completed</span>
                                            @else
                                                <span class="badge badge-bgdanger">Cancelled</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold">Payment Information</h6>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td width="40%">Payment Status</td>
                                        <td>: 
                                            @if($order->payment_status == 0)
                                                <span class="badge badge-linesuccess">Paid</span>
                                            @elseif($order->payment_status == 1)
                                                <span class="badge badge-linewarning">Partial</span>
                                            @else
                                                <span class="badge badge-linedanger">Unpaid</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Payment Date</td>
                                        <td>: {{ $order->payment_date ? \Carbon\Carbon::parse($order->payment_date)->format('d M Y') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Created By</td>
                                        <td>: {{ $order->created_by ?? 'System' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <h6 class="fw-bold mb-3">Order Items</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item Name</th>
                                        <th>SKU</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $orderItems = \App\Models\OrderItem::where('order_id', $order->id)->get();
                                    @endphp
                                    @forelse($orderItems as $item)
                                        <tr>
                                            <td>{{ $item->item_name }}</td>
                                            <td>{{ $item->sku }}</td>
                                            <td class="text-end">Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}</td>
                                            <td class="text-center">{{ $item->qty }}</td>
                                            <td class="text-end">Rp {{ number_format($item->total ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No items found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Order Summary -->
                        <div class="row mt-3">
                            <div class="col-md-6 ms-auto">
                                <table class="table table-sm">
                                    <tr>
                                        <td>Subtotal</td>
                                        <td class="text-end">Rp {{ number_format($order->sub_total ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tax ({{ $order->tax_percent ?? 0 }}%)</td>
                                        <td class="text-end">Rp {{ number_format($order->tax_total ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Discount ({{ $order->disc_percent ?? 0 }}%)</td>
                                        <td class="text-end">- Rp {{ number_format($order->disc_total ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td>Grand Total</td>
                                        <td class="text-end">Rp {{ number_format($order->final_total ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="text-success">
                                        <td>Paid</td>
                                        <td class="text-end">Rp {{ number_format($order->payment_amount ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="text-danger">
                                        <td>Due</td>
                                        <td class="text-end">Rp {{ number_format($order->payment_remaining ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="downloadOrderPDF('{{ $order->uuid }}')">
                            <i data-feather="download"></i> Download PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        function deleteOrder(uuid) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // TODO: Implement delete API call
                    fetch(`/api/order/delete/${uuid}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'Order has been deleted.', 'success')
                                .then(() => window.location.reload());
                        } else {
                            Swal.fire('Error!', data.message || 'Failed to delete order', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'An error occurred', 'error');
                    });
                }
            });
        }

        function downloadOrderPDF(uuid) {
            // TODO: Implement PDF download
            window.location.href = `/api/order/pdf/${uuid}`;
        }
    </script>
@endsection
