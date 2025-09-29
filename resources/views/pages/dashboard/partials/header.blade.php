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
    <!-- ====== SIDEBAR CATEGORIES ====== -->
    <div id="sidebarCategories" class="sidebar">
        <div class="sidebar-header">
            <span class="fw-bold text-white">SHOP BY CATEGORIES</span>
            <button id="closeSidebar" class="btn-close btn-close-white" aria-label="Close sidebar"></button>
        </div>


        {{-- @foreach ($data["categories"] as $category)
        <div class="sidebar-item">
            <div class="d-flex justify-content-between align-items-center sidebar-toggle px-2"
                data-target="#{{ $category->code }}-sub">
                @if($category->subcategories->isEmpty())
                <div>
                    <a href="{{ route('all-product-category', ['categoryCode' => $category->code]) }}"
                        style="sidebar-link color: inherit; text-decoration: none;">{{ $category->name }} ({{
                        $category->countItems }})</a>
                </div>
                @else
                <div>{{ $category->name }} <span class="text-muted">({{ $category->countItems }})</span></div>
                @endif
                @if($category->subcategories->isNotEmpty())
                <i class="bi bi-caret-right-fill collapse-icon"></i>
                @endif
            </div>
            @if($category->subcategories->isNotEmpty())
            <div class="subcategory-list collapse-manual px-3" id="{{ $category->code }}-sub">
                @foreach ($category->subcategories as $subcategory)
                <a href="{{ route('all-product-category', ['categoryCode' => $category->code]) }}"
                    class="sidebar-link ms-3">{{ $subcategory->name }} ({{ $subcategory->countItems }})</a>
                @endforeach
            </div>
            @endif
        </div>
        @endforeach --}}

        <ul class="list-unstyled m-0 p-0">
            @foreach ($data["categories"] as $category)
            <li>
                @if($category->subcategories->isEmpty())
                <a href="{{ route('all-product-category', ['categoryCode' => $category->code]) }}"
                    class="sidebar-link"><i class="bi bi-shirt me-2"></i> {{ $category->name }} ({{
                    $category->countItems }})</a>
                @else
                <a class="sidebar-link"> {{ $category->name }} ({{
                    $category->countItems }})
                    @if($category->subcategories->isNotEmpty())
                    <ul class="list-unstyled " id="{{ $category->code }}-sub">
                        @foreach ($category->subcategories as $subcategory)
                        <li>
                            <a href="{{ route('all-product-category', ['categoryCode' => $category->code]) }}"
                                class="sidebar-link ms-3">{{ $subcategory->name }} ({{ $subcategory->countItems }})</a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </a>
                @endif
            </li>
            @endforeach



            <li><a href="#" class="sidebar-link"><i class="bi bi-shirt me-2"></i> Fashion</a></li>
            <li><a href="#" class="sidebar-link"><i class="bi bi-phone me-2"></i> Phone & Tablet</a></li>
            <li><a href="#" class="sidebar-link"><i class="bi bi-laptop me-2"></i> Laptop & Computer</a></li>
            <li><a href="#" class="sidebar-link"><i class="bi bi-speaker me-2"></i> TV, Audio – Video</a></li>
            <li><a href="#" class="sidebar-link"><i class="bi bi-camera me-2"></i> Camera & Photo</a></li>
            <li><a href="#" class="sidebar-link"><i class="bi bi-house-door me-2"></i> Home & Decor</a></li>
            <li><a href="#" class="sidebar-link"><i class="bi bi-heart-pulse me-2"></i> Beauty & Health</a></li>
            <li><a href="#" class="sidebar-link"><i class="bi bi-controller me-2"></i> Game Accessories</a></li>
            <li><a href="#" class="sidebar-link"><i class="bi bi-gear me-2"></i> Autopart</a></li>
        </ul>
    </div>

    <!-- ====== BACKDROP ====== -->
    <div id="sidebarBackdrop" class="sidebar-backdrop"></div>


    <!-- ====== STYLING ====== -->
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: -300px;
            width: 300px;
            height: 100vh;
            background: #fff;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
            z-index: 1050;
            transition: left 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar.active {
            left: 0;
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
            color: #000;
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s;
        }

        .sidebar-link:hover {
            background: #f8f9fa;
        }

        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease;
        }

        .sidebar-backdrop.active {
            opacity: 1;
            visibility: visible;
        }

        /* Add custom style for btn-no-style if not defined elsewhere */
        .btn-no-style {
            background: none;
            border: none;
            padding: 0.5rem 1rem;
            cursor: pointer;
        }

        /* Divider custom */
        .custom-breadcrumb {
            --bs-breadcrumb-divider: '>';
        }

        /* Style link */
        .custom-breadcrumb a {
            text-decoration: none;
            color: #000;
            /* hitam */
            font-weight: 500;
            font-size: 0.95rem;
        }

        /* Hover efek */
        .custom-breadcrumb a:hover {
            text-decoration: underline;
            color: #000;
        }

        /* Active (halaman terakhir) */
        .custom-breadcrumb .breadcrumb-item.active {
            color: #6c757d;
            /* abu-abu */
            font-weight: 400;
        }

        /* Jarak antar item biar lega */
        .custom-breadcrumb .breadcrumb-item+.breadcrumb-item {
            padding-left: 0.5rem;
        }

        .custom-breadcrumb {
            --bs-breadcrumb-divider: '>';
        }

        .collapse-icon {
            transition: transform 0.2s ease;
        }

        a[aria-expanded="true"] .collapse-icon {
            transform: rotate(90deg);
        }
    </style>

    <!-- ====== SCRIPT ====== -->
    <script>
        // Sidebar Toggle
    const sidebar = document.getElementById('sidebarCategories');
    const backdrop = document.getElementById('sidebarBackdrop');
    const toggleBtn = document.getElementById('toggleCategories');
    const closeBtn = document.getElementById('closeSidebar');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.add('active');
        backdrop.classList.add('active');
    });

    closeBtn.addEventListener('click', () => {
        sidebar.classList.remove('active');
        backdrop.classList.remove('active');
    });

    backdrop.addEventListener('click', () => {
        sidebar.classList.remove('active');
        backdrop.classList.remove('active');
    });

    // Placeholder Language Switch Function
    function switchLanguage(lang) {
        // Example: Set cookie and reload, or redirect to /en/ or /id/
        document.cookie = `lang=${lang}; path=/`;
        location.reload(); // Or window.location.href = `/${lang}/`;
        // In a real app, integrate with i18next or Laravel localization.
    }
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