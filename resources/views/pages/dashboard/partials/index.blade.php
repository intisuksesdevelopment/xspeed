
<!-- HERO SECTION -->
<section id="home" class="hero-new" x-data="heroApp()" x-init="init()">

    <!-- BG OVERLAY + IMAGE -->
    <div class="hero-bg-overlay" aria-hidden="true"></div>
    <div class="hero-bg-img" aria-hidden="true"></div>

    <div class="container">
        <div class="hero-inner">

            <!-- ===== LEFT: TEXT ===== -->
            <div class="hero-left">

                <!-- BRAND TAG -->
                <div class="hero-brand-tag">
                    <span class="hero-brand-dot"></span>
                    <span>Genuine & Performance Parts</span>
                </div>

                <!-- HEADLINE -->
                <h1 class="hero-headline">
                    <span class="hl-line">XSPEED</span>
                    <span class="hl-line"><span class="hl-accent">MOTOPARTS</span></span>
                </h1>

                <!-- KEYWORD TAGS -->
                <div class="hero-tags">
                    <span class="hero-tag">BERKUALITAS</span>
                    <span class="hero-tag">PERFORMA</span>
                    <span class="hero-tag hl-tag-active">TANPA BATAS</span>
                </div>

                <!-- SUBTITLE -->
                <p class="hero-desc">
                    Suku cadang asli dan berkualitas untuk motor kesayangan Anda.
                </p>

                <!-- CTA -->
                <div class="hero-cta-row">
                    <a href="{{ route('all-product') }}" class="btn-hero-cta">
                        BELI SEKARANG
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <!-- FEATURES -->
                <div class="hero-features">
                    <div class="hero-feature">
                        <div class="hf-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF9F43" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
                        </div>
                        <div class="hf-text">
                            <strong>100% ORIGINAL</strong>
                            <span>Produk asli terjamin</span>
                        </div>
                    </div>
                    <div class="hero-feature">
                        <div class="hf-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF9F43" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                        </div>
                        <div class="hf-text">
                            <strong>PENGIRIMAN CEPAT</strong>
                            <span>Same day & next day</span>
                        </div>
                    </div>
                    <div class="hero-feature">
                        <div class="hf-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF9F43" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/><path d="M22 12a10 10 0 0 1-10 10M2 12a10 10 0 0 0 10 10"/><path d="M12 2v4M12 18v4"/></svg>
                        </div>
                        <div class="hf-text">
                            <strong>PILIHAN LENGKAP</strong>
                            <span>10.000+ item ready</span>
                        </div>
                    </div>
                    <div class="hero-feature">
                        <div class="hf-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF9F43" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/></svg>
                        </div>
                        <div class="hf-text">
                            <strong>CUSTOMER SUPPORT</strong>
                            <span>Respon cepat 24/7</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ===== RIGHT: IMAGE ===== -->
            <div class="hero-right" aria-hidden="true">
                <div class="hero-moto-wrap none" >
                    <img src="{{ asset('build/img/hero-bg.jpg') }}" alt="" class="hero-moto-img" loading="eager" decoding="async">
                    <div class="hero-moto-glow"></div>
                </div>
            </div>

        </div>
    </div>

    <!-- BOTTOM STRIP -->
    <div class="hero-bottom-strip">
        <div class="container">
            <div class="hero-stats-bar gap-4 gap-md-5">
                <div class="hsb-item">
                    <span class="hsb-num" x-text="stats.products">0</span>
                    <span class="hsb-label">{{ __("hero.stats_products") }}</span>
                </div>
                <div class="hsb-sep"></div>
                <div class="hsb-item">
                    <span class="hsb-num" x-text="stats.customers">0</span>
                    <span class="hsb-label">{{ __("hero.stats_customers") }}</span>
                </div>
                <div class="hsb-sep"></div>
                <div class="hsb-item">
                    <span class="hsb-num" x-text="stats.brands">0</span>
                    <span class="hsb-label">{{ __("hero.stats_brands") }}</span>
                </div>
                <div class="hsb-sep"></div>
                <div class="hsb-item">
                    <span class="hsb-num" x-text="stats.rating">0</span>
                    <span class="hsb-label">{{ __("hero.stats_rating") }}</span>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- BRAND SECTION (AUTO SLIDER) -->
<section id="brands" x-data="brandSlider()" x-init="init()"
    style="background: linear-gradient(to right, #0b1220, #0f1a2e); padding: 60px 0;">

    <div class="container text-center">
        <h2 class="heading">Our Brands</h2>
        <p class="sub-heading">TRUSTED BRANDS WE CARRY</p>

        <div class="swiper brandSwiper">
            <div class="swiper-wrapper align-items-center">

                <!-- skeleton (only while loading) -->
                <template x-if="loading">
                    <template x-for="i in skeletons" :key="'sk-' + i">
                        <div class="swiper-slide brand-item">
                            <div class="brand-logo shimmer"></div>
                            <div class="brand-name shimmer-text"></div>
                        </div>
                    </template>
                </template>

                <!-- real data -->
                <template x-for="brand in brands" :key="brand.id">
                    <div class="swiper-slide brand-item">
                        <div class="brand-logo">
                            <img x-bind:src="brand.image_url" x-bind:alt="brand.name" loading="lazy"
                                decoding="async">
                        </div>
                        <div class="brand-name" x-text="brand.name"></div>
                    </div>
                </template>

            </div>
        </div>
    </div>
</section>
<!-- PRODUCT SHOWCASE -->
<section id="products" style="background:#0b1220; padding:80px 0;">
    <div class="container" x-data="productApp()" x-init="init()">

            <!-- TITLE -->
            <div class="text-center mb-4">
                <h2 class="heading">Our Products</h2>
                <p class="sub-heading">Explore premium motorcycle parts</p>
            </div>

            <!-- SEARCH -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    {{-- <input type="text" x-model="search" class="form-control search-box"
                        placeholder="Search products..."> --}}
                </div>
            </div>

            <!-- ERROR -->
            <div class="text-center text-danger" x-show="error" x-cloak>
                Failed to load products
            </div>

            <noscript>
                <div class="text-center text-warning mb-4">
                    Aktifkan JavaScript untuk melihat produk. <a href="{{ route('all-product') }}" class="text-accent-color">Lihat semua produk</a>
                </div>
            </noscript>
            <!-- SHIMMER LOADING (mirror of .product-card, like the brand skeleton mirrors .brand-item) -->
            <div class="row g-4" x-show="loading" x-cloak>

                <template x-for="i in 12" :key="'sk-' + i">
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <div class="product-card h-100" aria-hidden="true">
                            <div class="product-image shimmer"></div>
                            <div class="product-info">
                                <div class="shimmer-line shimmer mb-2"></div>
                                <div class="shimmer-line short shimmer"></div>
                            </div>
                        </div>
                    </div>
                </template>

            </div>
            <!-- GRID -->
            <div class="row g-4 align-items-stretch" x-show="!loading" x-cloak>

                <template x-for="(product, index) in filteredProducts()" :key="product.uuid">

                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">

                        <!-- VIEW MORE CARD -->
                        <template x-if="index === filteredProducts().length - 1">
                            <a href="{{ route('all-product') }}" class="product-card view-more-card">
                                <div class="product-image view-more">
                                    <span>View More →</span>
                                </div>

                                <div class="product-info text-center">
                                    <h6 class="text-accent-color">Explore All Products</h6>
                                </div>
                            </a>
                        </template>

                        <!-- NORMAL PRODUCT -->
                        <template x-if="index !== filteredProducts().length - 1">
                            <a :href="'{{ route('single-product') }}?uuid=' + product.uuid" class="product-card">

                                <div class="product-image">
                                    <img :src="product.image_url ||
                                        '{{ asset('/build/img/image-not-found.jpg') }}'"
                                        :alt="product.name" loading="lazy" decoding="async"
                                        class="img-fluid">
                                </div>

                                <div class="product-info">
                                    <h6 class="text-accent-color" x-text="product.name"></h6>
                                    <span x-text="'Rp ' + Number(product.sell_price).toLocaleString()"></span>
                                </div>

                            </a>
                        </template>

                    </div>

                </template>

            </div>

        </div>
    </div>
</section>
<!-- GALLERY -->
<section id="gallery" style="background:#0b1220; padding:80px 0;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="heading">Gallery</h2>
            <p class="sub-heading">See our latest products & builds</p>
        </div>

        <div class="swiper gallerySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="{{ asset('/build/img/gallery1.jpg') }}" class="gallery-img"
                        alt="Galeri produk XSPEED - contoh 1" loading="lazy" decoding="async" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/build/img/gallery2.jpg') }}" class="gallery-img"
                        alt="Galeri produk XSPEED - contoh 2" loading="lazy" decoding="async" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/build/img/gallery3.png') }}" class="gallery-img"
                        alt="Galeri produk XSPEED - contoh 3" loading="lazy" decoding="async" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/build/img/gallery4.jpg') }}" class="gallery-img"
                        alt="Galeri produk XSPEED - contoh 4" loading="lazy" decoding="async" />
                </div>
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<!-- TESTIMONIALS -->
<section id="testimonials" class="testimonials">
    <div class="overlay"></div>

    <div class="container position-relative">

        <div class="text-center mb-5">
            <h2 class="heading">Customer Testimonials</h2>
            <p class="sub-heading">What our customers say about us</p>
        </div>

        <div class="swiper testimonialsSwiper">
            <div class="swiper-wrapper">

                <!-- CARD -->
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <img src="https://i.pravatar.cc/300" class="testimonial-img" alt="Foto John Doe"
                            loading="lazy" decoding="async">

                        <p class="testimonial-text">
                            Excellent quality and fast delivery! My motorcycle runs like new!
                        </p>

                        <div class="testimonial-footer">
                            <h6 class="testimonial-name">John Doe</h6>
                            <span class="testimonial-role">Motorcycle Enthusiast</span>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <img src="https://i.pravatar.cc/301" class="testimonial-img" alt="Foto Jane Smith"
                            loading="lazy" decoding="async">

                        <p class="testimonial-text">
                            Best online store for motorcycle parts, I always trust XSPEED.
                        </p>

                        <div class="testimonial-footer">
                            <h6 class="testimonial-name">Jane Smith</h6>
                            <span class="testimonial-role">Professional Rider</span>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <img src="https://i.pravatar.cc/302" class="testimonial-img" alt="Foto Sandy Nguyen"
                            loading="lazy" decoding="async">

                        <p class="testimonial-text">
                            Great customer service and top-notch products. Highly recommend!
                        </p>

                        <div class="testimonial-footer">
                            <h6 class="testimonial-name">Sandy Nguyen</h6>
                            <span class="testimonial-role">Rider & Blogger</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>

        </div>
    </div>
</section>
<!-- CONTACT -->
<section id="contact" class="contact-us" style="background-color: #0b1220; padding: 80px 0; color: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="heading">Contact Us</h2>
            <p class="sub-heading">We'd love to hear from you. Feel free to drop a message!</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-md-8">

                <div class="contact-cards d-flex flex-column flex-md-row gap-4 justify-content-center align-items-stretch">

                    <!-- WhatsApp CTA -->
                    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer"
                        class="contact-card contact-card--wa flex-fill text-decoration-none">
                        <div class="contact-card-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="#25D366">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </div>
                        <div class="contact-card-body">
                            <h5>Chat WhatsApp</h5>
                            <p>Respon cepat, lebih personal</p>
                            <span class="contact-card-cta">Hubungi Kami <span aria-hidden="true">→</span></span>
                        </div>
                    </a>

                    <!-- Phone / Email CTA -->
                    <a href="mailto:info@xspeedmotorshop.com" class="contact-card contact-card--email flex-fill text-decoration-none">
                        <div class="contact-card-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ffcc00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </div>
                        <div class="contact-card-body">
                            <h5>Email Kami</h5>
                            <p>info@xspeedmotorshop.com</p>
                            <span class="contact-card-cta">Kirim Email <span aria-hidden="true">→</span></span>
                        </div>
                    </a>

                    <!-- Location CTA -->
                    <a href="#about" class="contact-card contact-card--location flex-fill text-decoration-none">
                        <div class="contact-card-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ffcc00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                        </div>
                        <div class="contact-card-body">
                            <h5>Kunjungi Toko</h5>
                            <p>Bandung, Indonesia</p>
                            <span class="contact-card-cta">Lihat di Peta <span aria-hidden="true">→</span></span>
                        </div>
                    </a>

                </div>

            </div>
        </div>
    </div>
</section>
<!-- ABOUT US -->
<section id="about" class="about">
    <div class="overlay"></div>

    <div class="container">
        <div class="text-center mb-5">
            <h2 class="heading">About Us</h2>
            <p class="sub-heading">Your Trusted Moto Partner</p>
        </div>
        <div class="row align-items-center">
            <!-- Left Column (Text) -->
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="logo-header">
                        <img src="{{ asset('/build/img/logo-exspeed1.png') }}"
                            alt="Xspeed Motoshop Logo" class="main-logo" loading="lazy">
                    </div>
                    <h2 class="about-title">Xspeed<span class="text-accent-color">Motoshop</span> </h2>
                    <p class="about-description">
                        Xspeed Motoshop has been serving motorcycle enthusiasts since 2014. We specialize in
                        providing genuine, high-quality spare parts for all major motorcycle brands.
                    </p>
                    <p class="about-description">
                        Our team of experienced mechanics and parts specialists ensures you get the right parts for
                        your bike, with expert advice and fast, reliable delivery across Indonesia.
                    </p>
                    <div class="cta-buttons">
                        <a href="#products" class="btn btn-yellow">Browse Products</a>
                        <a href="#contact" class="btn btn-outline-yellow">Contact Us</a>
                    </div>
                </div>
            </div>

            <!-- Right Column (Icons and Stats) -->
            <div class="col-lg-6">
                <div class="stats-container">

                    <div class="stat-item" data-count="10">
                        <div class="icon-box">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <div class="counter-wrapper">
                            <h3 class="counter">0</h3>
                            <span class="suffix">++</span>
                        </div>
                        <p>Years Experience</p>
                    </div>
                    <div class="stat-item" data-count="5000">
                        <div class="icon-box">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <div class="counter-wrapper">
                            <h3 class="counter">0</h3>
                            <span class="suffix">++</span>
                        </div>
                        <p>Products Available</p>
                    </div>
                    <div class="stat-item" data-count="1000">
                        <div class="icon-box">
                            <i class="fa-solid fa-users"></i>
                        </div>

                        <div class="counter-wrapper">
                            <h3 class="counter">0</h3>
                            <span class="suffix">++</span>
                        </div>

                        <p>Customers</p>
                    </div>
                    <div class="stat-item" data-count="100">
                        <div class="icon-box">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div class="counter-wrapper">
                            <h3 class="counter">0</h3>
                            <span class="suffix">%</span>
                        </div>
                        <p>Genuine Parts</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const counters = document.querySelectorAll(".counter");
        const statsContainer = document.querySelector(".stats-container");

        let isCounterAnimated = false;

        function animateCounters() {
            if (isCounterAnimated) return;

            counters.forEach(counter => {
                const target = +counter.closest('.stat-item').dataset.count;
                let current = 0;

                const step = () => {
                    current += target / 80;

                    if (current < target) {
                        counter.innerText = Math.floor(current);
                        requestAnimationFrame(step);
                    } else {
                        counter.innerText = target;
                    }
                };

                step();
            });

            isCounterAnimated = true;
        }

        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return rect.top < window.innerHeight * 0.85 && rect.bottom > 0;
        }

        window.addEventListener("scroll", function() {
            if (isElementInViewport(statsContainer)) {
                animateCounters();
            }
        });

        // 🔥 langsung animasi bila section stats sudah terlihat saat halaman dimuat
        if (isElementInViewport(statsContainer)) {
            animateCounters();
        }
    });
</script>
<script>
    const API_PRODUCT_PAGED_URL = "{{ route('api-product-paged') }}";
    const API_BRAND_ALL_URL = "{{ route('api-brand-all') }}";

    /* ── Hero: particle canvas + stats counter ── */
    function heroApp() {
        return {
            stats: { products: 0, customers: 0, brands: 0, rating: 0 },
            _counterFrame: null,

            async init() {
                this.initParticles();
                this.animateCounters();
            },

            initParticles() {
                const canvas = document.querySelector('.hero-particles');
                if (!canvas) return;
                const ctx = canvas.getContext('2d');
                let W, H, particles = [];

                const resize = () => {
                    W = canvas.width  = canvas.offsetWidth;
                    H = canvas.height = canvas.offsetHeight;
                };

                class Particle {
                    constructor() { this.reset(); }
                    reset() {
                        this.x  = Math.random() * W;
                        this.y  = Math.random() * H;
                        this.r  = Math.random() * 1.5 + 0.3;
                        this.vx = (Math.random() - 0.5) * 0.3;
                        this.vy = (Math.random() - 0.5) * 0.3;
                        this.a  = Math.random() * 0.5 + 0.1;
                    }
                    update() {
                        this.x += this.vx;
                        this.y += this.vy;
                        if (this.x < 0 || this.x > W) this.vx *= -1;
                        if (this.y < 0 || this.y > H) this.vy *= -1;
                    }
                    draw() {
                        ctx.beginPath();
                        ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
                        ctx.fillStyle = `rgba(255,204,0,${this.a})`;
                        ctx.fill();
                    }
                }

                resize();
                window.addEventListener('resize', resize);
                for (let i = 0; i < 45; i++) particles.push(new Particle());

                const draw = () => {
                    ctx.clearRect(0, 0, W, H);
                    particles.forEach(p => { p.update(); p.draw(); });
                    requestAnimationFrame(draw);
                };
                draw();
            },

            animateCounters() {
                const targets = { products: 2500, customers: 10000, brands: 48, rating: 4.9 };
                const duration = 1800;
                const start = performance.now();

                const tick = (now) => {
                    const t = Math.min((now - start) / duration, 1);
                    const ease = 1 - Math.pow(1 - t, 3); // ease-out cubic
                    Object.keys(targets).forEach(k => {
                        const val = targets[k];
                        this.stats[k] = val < 10
                            ? (t * val).toFixed(1)
                            : Math.floor(t * val).toLocaleString();
                    });
                    if (t < 1) this._counterFrame = requestAnimationFrame(tick);
                };
                this._counterFrame = requestAnimationFrame(tick);
            }
        };
    }

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
                    const res = await fetch(API_PRODUCT_PAGED_URL + "?per_page=12");

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
                    .slice(0, 12);
            }
        }
    }

    function brandSlider() {
        return {
            brands: [],
            loading: true,
            skeletons: Array.from({
                length: 8
            }),

            swiper: null,

            async init() {
                await this.fetchBrands();
                this.loading = false;

                this.$nextTick(() => {
                    requestAnimationFrame(() => {
                        this.initSwiper();
                    });
                });
            },

            async fetchBrands() {
                try {
                    const res = await fetch(API_BRAND_ALL_URL);
                    const data = await res.json();

                    this.brands = Array.isArray(data?.data) ?
                        data.data :
                        (Array.isArray(data) ? data : []);

                } catch (e) {
                    console.error(e);
                    this.brands = [];
                }
            },

            initSwiper() {
                const el = document.querySelector('.brandSwiper');
                if (!el) return;

                if (this.swiper) {
                    this.swiper.destroy(true, true);
                }

                const total = this.brands.length;

                this.swiper = new Swiper(el, {
                    slidesPerView: 2,
                    spaceBetween: 12, // 🔥 lebih rapat di mobile

                    loop: total > 4,

                    autoplay: total > 2 ? {
                        delay: 2500, // 🔥 lebih smooth
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true
                    } : false,

                    speed: 600, // 🔥 animasi lebih halus

                    breakpoints: {
                        480: {
                            slidesPerView: 2.5,
                            spaceBetween: 12
                        },
                        576: {
                            slidesPerView: 3,
                            spaceBetween: 16
                        },
                        768: {
                            slidesPerView: 4,
                            spaceBetween: 20
                        },
                        1024: {
                            slidesPerView: 5,
                            spaceBetween: 24
                        }
                    },

                    // 🔥 penting buat mobile smooth
                    grabCursor: true,
                    freeMode: true,
                    freeModeMomentum: true,

                    observer: true,
                    observeParents: true,
                });

                this.swiper.update();
            }
        }
    }
    const gallerySwiper = new Swiper('.gallerySwiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: false,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.gallerySwiper .swiper-button-next',
            prevEl: '.gallerySwiper .swiper-button-prev',
        },
        pagination: {
            el: '.gallerySwiper .swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            768: {
                slidesPerView: 1
            },
            992: {
                slidesPerView: 1
            }
        }
    });
    const testimonialsSwiper = new Swiper('.testimonialsSwiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        centeredSlides: true,

        // loop enabled only when there are enough slides (min 4 to avoid warning)
        loop: false,

        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },

        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },

        breakpoints: {
            768: {
                slidesPerView: 2
            },
            1024: {
                slidesPerView: 3
            }
        }
    });
</script>
