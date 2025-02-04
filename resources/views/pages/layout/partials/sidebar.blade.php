<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Main</h6>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);"
                                class="{{ Request::is('index', '/', 'sales-dashboard') ? 'active subdrop' : '' }}"><i
                                    data-feather="grid"></i><span>Dashboard</span><span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ url('index') }}"
                                        class="{{ Request::is('index', '/') ? 'active' : '' }}">Admin Dashboard</a></li>
                                <li><a href="{{ url('sales-dashboard') }}"
                                        class="{{ Request::is('sales-dashboard') ? 'active' : '' }}">Sales Dashboard</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Inventory</h6>
                    <ul>
                        <li class="{{ Request::is('product-list','product-details') ? 'active' : '' }}"><a
                                href="{{ route('product-list') }}"><i data-feather="box"></i><span>Products</span></a>
                        </li>
                        <li class="{{ Request::is('add-product','edit-product') ? 'active' : '' }}"><a
                                href="{{ route('product-add') }}"><i data-feather="plus-square"></i><span>Create
                                    Product</span></a></li>
                        <li class="{{ Request::is('expired-products') ? 'active' : '' }}"><a
                                href="{{ url('expired-products') }}"><i data-feather="codesandbox"></i><span>Expired
                                    Products</span></a></li>
                        <li class="{{ Request::is('low-stocks') ? 'active' : '' }}"><a
                                href="{{ url('low-stocks') }}"><i data-feather="trending-down"></i><span>Low
                                    Stocks</span></a></li>
                        <li class="{{ Request::is('category') ? 'active' : '' }}"><a
                                href="{{ url('category') }}"><i
                                    data-feather="codepen"></i><span>Category</span></a></li>
                        <li class="{{ Request::is('subcategory') ? 'active' : '' }}"><a
                                href="{{ url('subcategory') }}"><i data-feather="speaker"></i><span>Sub
                                    Category</span></a></li>
                        <li class="{{ Request::is('brands') ? 'active' : '' }}"><a
                                href="{{ url('brands') }}"><i data-feather="tag"></i><span>Brands</span></a></li>
                        <li class="{{ Request::is('units') ? 'active' : '' }}"><a href="{{ url('units') }}"><i
                                    data-feather="speaker"></i><span>Units</span></a></li>
                        <li class="{{ Request::is('varriant-attributes') ? 'active' : '' }}"><a
                                href="{{ url('varriant-attributes') }}"><i data-feather="layers"></i><span>Variant
                                    Attributes</span></a></li>
                        <li class="{{ Request::is('racks') ? 'active' : '' }}"><a
                                href="{{ url('racks') }}"><i data-feather="layers"></i><span>Racks</span></a></li>
                        <li class="{{ Request::is('warranty') ? 'active' : '' }}"><a href="{{ url('warranty') }}"><i
                                    data-feather="bookmark"></i><span>Warranties</span></a>
                        </li>
                        <li class="{{ Request::is('barcode') ? 'active' : '' }}"><a href="{{ url('barcode') }}"><i
                                    data-feather="align-justify"></i><span>Print
                                    Barcode</span></a></li>
                        <li class="{{ Request::is('qrcode') ? 'active' : '' }}"><a href="{{ url('qrcode') }}"><i
                                    data-feather="maximize"></i><span>Print QR Code</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Stock</h6>
                    <ul>
                        <li class="{{ Request::is('manage-stocks') ? 'active' : '' }}"><a
                                href="{{ url('manage-stocks') }}"><i data-feather="package"></i><span>Manage
                                    Stock</span></a></li>
                        <li class="{{ Request::is('stock-adjustment') ? 'active' : '' }}"><a
                                href="{{ url('stock-adjustment') }}"><i data-feather="clipboard"></i><span>Stock
                                    Adjustment</span></a></li>
                        <li class="{{ Request::is('stock-transfer') ? 'active' : '' }}"><a
                                href="{{ url('stock-transfer') }}"><i data-feather="truck"></i><span>Stock
                                    Transfer</span></a></li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Sales</h6>
                    <ul>
                        <li class="{{ Request::is('sales-list') ? 'active' : '' }}"><a
                                href="{{ url('sales-list') }}"><i
                                    data-feather="shopping-cart"></i><span>Sales</span></a></li>
                        <li class="{{ Request::is('invoice-report') ? 'active' : '' }}"><a
                                href="{{ url('invoice-report') }}"><i
                                    data-feather="file-text"></i><span>Invoices</span></a></li>
                        <li class="{{ Request::is('sales-returns') ? 'active' : '' }}"><a
                                href="{{ url('sales-returns') }}"><i data-feather="copy"></i><span>Sales
                                    Return</span></a></li>
                        <li class="{{ Request::is('quotation-list') ? 'active' : '' }}"><a
                                href="{{ url('quotation-list') }}"><i
                                    data-feather="save"></i><span>Quotation</span></a>
                        </li>
                        <li class="{{ Request::is('pos') ? 'active' : '' }}"><a href="{{ url('pos') }}"><i
                                    data-feather="hard-drive"></i><span>POS</span></a></li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Promo</h6>
                    <ul>
                        <li class="{{ Request::is('coupons') ? 'active' : '' }}"><a href="{{ url('coupons') }}"><i
                                    data-feather="shopping-cart"></i><span>Coupons</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Purchases</h6>
                    <ul>
                        <li class="{{ Request::is('purchase-list') ? 'active' : '' }}"><a
                                href="{{ url('purchase-list') }}"><i
                                    data-feather="shopping-bag"></i><span>Purchases</span></a></li>
                        <li class="{{ Request::is('purchase-order-report') ? 'active' : '' }}"><a
                                href="{{ url('purchase-order-report') }}"><i
                                    data-feather="file-minus"></i><span>Purchase Order</span></a></li>
                        <li class="{{ Request::is('purchase-returns') ? 'active' : '' }}"><a
                                href="{{ url('purchase-returns') }}"><i data-feather="refresh-cw"></i><span>Purchase
                                    Return</span></a></li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Finance & Accounts</h6>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);"
                                class="{{ Request::is('expense-list', 'expense-category') ? 'active subdrop' : '' }}"><i
                                    data-feather="file-text"></i><span>Expenses</span><span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ url('expense-list') }}"
                                        class="{{ Request::is('expense-list') ? 'active' : '' }}">Expenses</a></li>
                                <li><a href="{{ url('expense-category') }}"
                                        class="{{ Request::is('expense-category') ? 'active' : '' }}">Expense
                                        Category</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Peoples</h6>
                    <ul>
                        <li class="{{ Request::is('customers') ? 'active' : '' }}"><a
                                href="{{ url('customers') }}"><i data-feather="user"></i><span>Customers</span></a>
                        </li>
                        <li class="{{ Request::is('suppliers') ? 'active' : '' }}"><a
                                href="{{ url('suppliers') }}"><i data-feather="users"></i><span>Suppliers</span></a>
                        </li>
                        <li class="{{ Request::is('store-list') ? 'active' : '' }}"><a
                                href="{{ url('store-list') }}"><i data-feather="home"></i><span>Stores</span></a>
                        </li>
                        <li class="{{ Request::is('warehouses') ? 'active' : '' }}"><a
                                href="{{ url('warehouses') }}"><i
                                    data-feather="archive"></i><span>Warehouses</span></a>
                        </li>
                    </ul>
                </li>

                <li class="submenu-open">
                    <h6 class="submenu-hdr">Reports</h6>
                    <ul>
                        <li class="{{ Request::is('sales-report') ? 'active' : '' }}"><a
                                href="{{ url('sales-report') }}"><i data-feather="bar-chart-2"></i><span>Sales
                                    Report</span></a></li>
                        <li class="{{ Request::is('purchase-report') ? 'active' : '' }}"><a
                                href="{{ url('purchase-report') }}"><i data-feather="pie-chart"></i><span>Purchase
                                    report</span></a></li>
                        <li class="{{ Request::is('inventory-report') ? 'active' : '' }}"><a
                                href="{{ url('inventory-report') }}"><i data-feather="inbox"></i><span>Inventory
                                    Report</span></a></li>
                        <li class="{{ Request::is('invoice-report') ? 'active' : '' }}"><a
                                href="{{ url('invoice-report') }}"><i data-feather="file"></i><span>Invoice
                                    Report</span></a></li>
                        <li class="{{ Request::is('supplier-report') ? 'active' : '' }}"><a
                                href="{{ url('supplier-report') }}"><i data-feather="user-check"></i><span>Supplier
                                    Report</span></a></li>
                        <li class="{{ Request::is('customer-report') ? 'active' : '' }}"><a
                                href="{{ url('customer-report') }}"><i data-feather="user"></i><span>Customer
                                    Report</span></a></li>
                        <li class="{{ Request::is('expense-report') ? 'active' : '' }}"><a
                                href="{{ url('expense-report') }}"><i data-feather="file"></i><span>Expense
                                    Report</span></a></li>
                        <li class="{{ Request::is('income-report') ? 'active' : '' }}"><a
                                href="{{ url('income-report') }}"><i data-feather="bar-chart"></i><span>Income
                                    Report</span></a></li>
                        <li class="{{ Request::is('tax-reports') ? 'active' : '' }}"><a
                                href="{{ url('tax-reports') }}"><i data-feather="database"></i><span>Tax
                                    Report</span></a></li>
                        <li class="{{ Request::is('profit-and-loss') ? 'active' : '' }}"><a
                                href="{{ url('profit-and-loss') }}"><i data-feather="pie-chart"></i><span>Profit &
                                    Loss</span></a></li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">User Management</h6>
                    <ul>
                        <li class="{{ Request::is('users') ? 'active' : '' }}"><a href="{{ url('users') }}"><i
                                    data-feather="user-check"></i><span>Users</span></a>
                        </li>
                        <li class="{{ Request::is('roles-permissions','permissions') ? 'active' : '' }}"><a
                                href="{{ url('roles-permissions') }}"><i data-feather="shield"></i><span>Roles &
                                    Permissions</span></a></li>
                        <li class="{{ Request::is('delete-account') ? 'active' : '' }}"><a
                                href="{{ url('delete-account') }}"><i data-feather="lock"></i><span>Delete Account
                                    Request</span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
