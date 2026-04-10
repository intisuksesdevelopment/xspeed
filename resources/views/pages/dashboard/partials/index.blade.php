    <link rel="stylesheet" href="{{ url('build/assets/dashboard/assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <nav class="navbar navbar-expand-lg fixed-top custom-navbar px-3 px-md-4">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div>
                <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                    ⚡ <span class="fw-bold text-white">XSPEED <span class="text-accent">MOTOSHOP</span></span>
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">

                    <span class="custom-toggler"></span>
                </button>
            </div>


            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav align-items-lg-center gap-lg-4 mt-3 mt-lg-0 ms-auto">
                    <li><a class="nav-link" href="#">Home</a></li>
                    <li><a class="nav-link" href="#">Products</a></li>
                    <li><a class="nav-link" href="#">Gallery</a></li>
                    <li><a class="nav-link" href="#">Testimonials</a></li>
                    <li><a class="nav-link" href="#">About</a></li>
                    <li><a class="nav-link" href="#">Contact</a></li>
                    <li>
                        <a href="#" class="btn btn-admin btn-sm ms-lg-2">Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6">
                    <div class="badge-custom">Premium Motorcycle Parts</div>

                    <h1 class="text-start font-rajdhani">
                        Upgrade Your <br>
                        <span>Ride Performance</span>
                    </h1>

                    <p class="mt-3 text-start font-rajdhani">
                        High-quality spare parts for all motorcycle brands. Trusted by thousands of riders across
                        Indonesia.
                    </p>

                    <div class="d-flex gap-3 mt-4 justify-content-center justify-content-lg-start">
                        <a href="#" class="btn btn-yellow">Shop Now →</a>
                        <a href="#" class="btn btn-outline">Learn More</a>
                    </div>

                    <div class="features d-flex gap-3 mt-4">
                        <div class="feature-item">✔ Genuine Parts</div>
                        <div class="feature-item">✔ Fast Delivery</div>
                        <div class="feature-item">✔ Expert Support</div>
                    </div>
                </div>

                <div class="col-lg-6 d-none d-lg-block">
                    <!-- Optional image for desktop -->
                </div>

            </div>
        </div>
    </section>
    <!-- BRAND SECTION (AUTO SLIDER) -->
    <section
        style="background: linear-gradient(to right, #0b1220, #0f1a2e); padding: 60px 0; border-top: 1px solid rgba(255,255,255,0.05);">
        <div class="container text-center">
            <p style="letter-spacing: 3px; color: #9ca3af; font-size: 12px; margin-bottom: 40px;">
                TRUSTED BRANDS WE CARRY
            </p>

            <!-- Swiper -->
            <div class="swiper brandSwiper">
                <div class="swiper-wrapper align-items-center">
                    <div class="swiper-slide brand-item">Honda</div>
                    <div class="swiper-slide brand-item">Yamaha</div>
                    <div class="swiper-slide brand-item">Suzuki</div>
                    <div class="swiper-slide brand-item">Kawasaki</div>
                    <div class="swiper-slide brand-item">KTM</div>
                    <div class="swiper-slide brand-item">Ducati</div>
                    <div class="swiper-slide brand-item">BMW</div>
                    <div class="swiper-slide brand-item">Triumph</div>
                </div>
            </div>
        </div>
    </section>
    <!-- PRODUCT SHOWCASE -->
    <section style="background:#0b1220; padding:80px 0;">
        <div class="container">
            <div class="container py-5" x-data="productApp()" x-init="init()">

                <!-- TITLE -->
                <div class="text-center mb-4">
                    <h2 class="font-orbitron text-warning">Our Products</h2>
                    <p class="text-secondary">Explore premium motorcycle parts</p>
                </div>

                <!-- SEARCH -->
                <div class="row justify-content-center mb-4">
                    <div class="col-md-6">
                        <input type="text" x-model="search" class="form-control search-box"
                            placeholder="Search products...">
                    </div>
                </div>

                <!-- LOADING -->
                <div class="text-center" x-show="loading" x-cloak>
                    Loading products...
                </div>

                <!-- ERROR -->
                <div class="text-center text-danger" x-show="error">
                    Failed to load products
                </div>
                <!-- SHIMMER LOADING -->
                <div class="row g-4" x-show="loading">
                    <template x-for="i in 8" :key="i">
                        <div class="col-6 col-md-3">
                            <div class="shimmer-card">
                                <div class="shimmer-img shimmer"></div>
                                <div class="shimmer-line shimmer"></div>
                                <div class="shimmer-line short shimmer"></div>
                            </div>
                        </div>
                    </template>
                </div>
                <!-- GRID -->
                <div class="row g-4 align-items-stretch" x-show="!loading">

                    <template x-for="product in filteredProducts()" :key="product.uuid">

                        <div class="col-6 col-md-3">

                            <a :href="'/product/' + product.uuid" class="product-card">

                                <div class="product-image">
                                    <img :src="product.image_url ||
                                        '{{ asset('/build/assets/dashboard/assets/img/image-not-found.jpg') }}'"
                                        class="img-fluid">
                                </div>

                                <div class="product-info">
                                    <h6 x-text="product.name"></h6>
                                    <span x-text="'Rp ' + Number(product.sell_price).toLocaleString()"></span>
                                </div>

                            </a>

                        </div>

                    </template>

                </div>

            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        const API_PRODUCT_PAGED_URL = "{{ route('api-product-paged') }}";

        function productApp() {
            return {
                products: [],
                search: '',
                loading: false,
                error: false,

                async init() {
                    await this.loadProducts();
                },

                async loadProducts() {
                    this.loading = true;
                    this.error = false;

                    try {
                        const res = await fetch(API_PRODUCT_PAGED_URL + "?per_page=8");

                        if (!res.ok) {
                            throw new Error("HTTP Error: " + res.status);
                        }

                        const json = await res.json();

                        if (!json.success) {
                            throw new Error("API returned false success");
                        }

                        this.products = json.data.data;

                    } catch (e) {
                        console.error("LOAD PRODUCT ERROR:", e);
                        this.error = true;
                    } finally {
                        this.loading = false;
                    }
                },

                filteredProducts() {
                    if (!this.products) return [];

                    return this.products
                        .filter(p =>
                            p.name.toLowerCase().includes(this.search.toLowerCase())
                        )
                        .slice(0, 8);
                }
            }
        }
        const swiper = new Swiper('.brandSwiper', {
            slidesPerView: 2,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 1500,
                disableOnInteraction: false,
            }
        });
    </script>
