<div class="bg-red-500 shadow-sm mb-5" style="height: 100px;">
    <div class="container h-100">
        <div class="d-flex align-items-center justify-content-between h-100">

            <!-- Logo -->
            <a href="/" class="d-flex align-items-center text-decoration-none">
                <!-- Blade: <img src="{{ asset('/build/plugins/dashboard/assets/img/logo-exspeed3.png')}}" alt="Logo" class="me-2" style="height: 60px;"> -->
                <img src="/build/plugins/dashboard/assets/img/logo-exspeed3.png" alt="Logo" class="me-2"
                    style="height: 60px;">
            </a>

            <!-- Search Bar -->
            <form method="GET" class="d-flex bg-light rounded overflow-hidden shadow-sm"
                style="height: 50px; max-width: 500px;">

                <!-- Dropdown Categories -->
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle fw-bold h-100 border-0 rounded-0 px-3" type="button"
                        id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        All Categories
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                        <li><a class="dropdown-item" href="#">Category 1</a></li>
                        <li><a class="dropdown-item" href="#">Category 2</a></li>
                        <li><a class="dropdown-item" href="#">Category 3</a></li>
                    </ul>
                </div>

                <!-- Divider -->
                <div class="vr my-2"></div>

                <!-- Search Input -->
                <input type="text" name="q" class="form-control border-0 bg-light ps-3 h-100"
                    placeholder="Search for products..." style="box-shadow: none;">

                <!-- Search Button -->
                <button type="submit"
                    class="btn btn-dark rounded-0 px-4 d-flex align-items-center justify-content-center"
                    aria-label="Search">
                    <i class="fa fa-search text-white"></i>
                </button>

            </form>

            <!-- Language Switch -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="languageDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false" aria-label="Select Language">
                    🌐 Language
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                    <li><a class="dropdown-item" href="#" onclick="switchLanguage('en')">English</a></li>
                    <li><a class="dropdown-item" href="#" onclick="switchLanguage('id')">Bahasa Indonesia</a></li>
                </ul>
            </div>

        </div>
    </div>

    <!-- ====== NAV BAR ====== -->
    <div>
        <nav class="border-top bg-white">
            <div class="container d-flex align-items-center justify-content-between flex-wrap">
                <!-- Added flex-wrap for mobile -->
                <!-- Left Menu -->
                <ul class="nav">
                    <li class="nav-item" id="toggleCategories">
                        <button class="fw-bold text-dark btn-no-style" aria-label="Toggle Categories">
                            SHOP BY CATEGORIES
                        </button>
                    </li>
                    <li class="nav-item"><a href="#" class="nav-link text-dark">Homepages ▾</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-dark">Categories ▾</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-dark">Products ▾</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-dark">Pages ▾</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-dark">About us</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-dark">Blog</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-dark">
                            <i class="bi bi-ticket-perforated me-1"></i> Best Discount
                        </a></li>
                </ul>

                <!-- Right Menu -->
                <ul class="nav">
                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">Recently viewed ▾</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- Overlay -->
    <div id="sidebarOverlay" class="sidebar-overlay"></div>
    <!-- ====== SIDEBAR CATEGORIES ====== -->
    <div id="sidebarCategories" class="sidebar d-flex flex-column">
        <div class="sidebar-header d-flex justify-content-between align-items-center p-3 bg-dark">
            <span class="fw-bold text-white">SHOP BY CATEGORIES</span>
            <button id="closeSidebar" class="btn-close btn-close-white" aria-label="Close sidebar"></button>
        </div>

        <!-- Scrollable body -->
        <div class="sidebar-body flex-grow-1 overflow-auto p-2">
            <ul class="list-unstyled m-0">
                @foreach ($data["categories"] as $category)
                <li>
                    @if($category->subcategories->isEmpty())
                    <a href="{{ route('all-product-category', ['categoryCode' => $category->code]) }}"
                        class="sidebar-link d-block py-2 px-2">
                        {{ $category->name }} ({{ $category->countItems }})
                    </a>
                    @else
                    <a href="{{ '#'.$category->code.'-sub' }}"
                        class="d-flex justify-content-between align-items-center sidebar-link py-2 px-2"
                        data-toggle="collapse" aria-expanded="false" aria-controls="{{ $category->code.'-sub' }}">
                        <span>{{ $category->name }} ({{ $category->countItems }})</span>
                        <i class="fa fa-chevron-right collapse-icon"></i>
                    </a>

                    <ul class="collapse list-unstyled pl-4 mt-1" id="{{ $category->code.'-sub' }}">
                        @foreach ($category->subcategories as $subcategory)
                        <li>
                            <a href="{{ route('all-product-category', ['categoryCode' => $category->code]) }}"
                                class="sidebar-link d-block py-1">
                                {{ $subcategory->name }} ({{ $subcategory->countItems }})
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
    </div>


    <!-- ====== BACKDROP ====== -->
    <div id="sidebarBackdrop" class="sidebar-backdrop"></div>


    <!-- ====== STYLING ====== -->
    <style>
        .sidebar {
            width: 280px;
            height: 100vh;
            background: #fff;
            border-right: 1px solid #ddd;
            position: fixed;
            top: 0;
            left: -280px;
            /* tersembunyi awal */
            z-index: 1051;
            transition: left .3s ease;
        }

        .sidebar.show {
            left: 0;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, .5);
            z-index: 1050;
            display: none;
        }

        .sidebar-overlay.show {
            display: block;
        }

        .sidebar-body {
            max-height: calc(100vh - 60px);
            /* sisakan tinggi header (60px) */
            overflow-y: auto;
        }

        .sidebar-header {
            background: #000;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.9rem 1rem;
            text-decoration: none;
            color: #333;
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s;
        }

        .sidebar-link:hover {
            background: #f8f9fa;
        }

        .collapse-icon {
            transition: transform .2s ease;
        }

        a[aria-expanded="true"] .collapse-icon {
            transform: rotate(90deg);
        }
    </style>

    <!-- ====== SCRIPT ====== -->
    <script>
        // Sidebar Toggle
    document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebarCategories");
    const overlay = document.getElementById("sidebarOverlay");
    const openBtn = document.getElementById("toggleCategories");
    const closeBtn = document.getElementById("closeSidebar");

    function openSidebar() {
        sidebar.classList.add("show");
        overlay.classList.add("show");
    }

    function closeSidebar() {
        sidebar.classList.remove("show");
        overlay.classList.remove("show");
    }

    if (openBtn) openBtn.addEventListener("click", openSidebar);
    if (closeBtn) closeBtn.addEventListener("click", closeSidebar);
    if (overlay) overlay.addEventListener("click", closeSidebar);
});

    </script>
    <div class="container mb-5">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb custom-breadcrumb mb-0" style="--bs-breadcrumb-divider: '>';">

                    <li class="breadcrumb-item">
                        <a href="{{ route('main') }}">{{ __('messages.dashboard') }}</a>
                    </li>

                    <li class="breadcrumb-item">
                        <a
                            href="{{ route('all-product-category', ['categoryCode' => $data['product']['category']['code']]) }}">
                            {{ $data['product']['category']['name'] }}
                        </a>
                    </li>

                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $data['product']['name'] }}
                    </li>
                </ol>
            </nav>

            <style>

            </style>


        </div>
    </div>
</div>