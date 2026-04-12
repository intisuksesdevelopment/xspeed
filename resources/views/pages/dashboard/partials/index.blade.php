<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />


<!-- HERO SECTION -->
<section id="home" class="hero"
    style="background-image: url('{{ asset('storage/assets/dashboard/assets/img/hero-bg.jpg') }}'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="badge-custom text-accent-color">Premium Motorcycle Parts</div>
                <h1 class="hero-title font-rajdhani text-lg-start text-center text-lg-start">
                    Upgrade Your <br>
                    <span>Ride Performance</span>
                </h1>
                <p class="mt-3 font-rajdhani text-lg-start text-center">
                    High-quality spare parts for all motorcycle brands. Trusted by thousands of riders across
                    Indonesia.
                </p>
                <div class="hero-buttons d-flex gap-3 mt-4 flex-wrap justify-content-center justify-content-lg-start">
                    <a href="#" class="btn btn-yellow">Shop Now</a>
                </div>
                <div class="features d-flex gap-3 mt-4 flex-wrap justify-content-center justify-content-lg-start">
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
<section id="brands" x-data="brandSlider()" x-init="init()"
    style="background: linear-gradient(to right, #0b1220, #0f1a2e); padding: 60px 0;">

    <div class="container text-center">
        <p style="letter-spacing: 3px; color: #9ca3af; font-size: 12px; margin-bottom: 40px;">
            TRUSTED BRANDS WE CARRY
        </p>

        <div class="swiper brandSwiper">
            <div class="swiper-wrapper align-items-center">

                <!-- skeleton -->
                <template x-for="i in skeletons" :key="'sk-' + i">
                    <div class="swiper-slide brand-item">
                        <div class="brand-logo shimmer"></div>
                        <div class="brand-name shimmer-text"></div>
                    </div>
                </template>

                <!-- real data -->
                <template x-for="brand in brands" :key="brand.id">
                    <div class="swiper-slide brand-item">
                        <div class="brand-logo">
                            <img x-bind:src="brand.image_url" x-bind:alt="brand.name">
                        </div>
                        <div class="brand-name" x-text="brand.name"></div>
                    </div>
                </template>

            </div>
        </div>
    </div>
</section>
<!-- PRODUCT SHOWCASE -->
<section id="products"style="background:#0b1220; padding:80px 0;">
    <div class="container">
        <div class="container py-5" x-data="productApp()" x-init="init()">

            <!-- TITLE -->
            <div class="text-center mb-4">
                <h2 style="font-family: Orbitron; font-weight:700;" class="text-accent-color">Our Products</h2>
                <p class="text-secondary">Explore premium motorcycle parts</p>
            </div>

            <!-- SEARCH -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    {{-- <input type="text" x-model="search" class="form-control search-box"
                        placeholder="Search products..."> --}}
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

                <template x-for="i in 12" :key="i">
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <div class="shimmer-card h-100">
                            <div class="shimmer-img shimmer"></div>
                            <div class="shimmer-line shimmer"></div>
                            <div class="shimmer-line short shimmer"></div>
                        </div>
                    </div>
                </template>

            </div>
            <!-- GRID -->
            <div class="row g-4 align-items-stretch" x-show="!loading">

                <template x-for="(product, index) in filteredProducts()" :key="product.uuid">

                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">

                        <!-- VIEW MORE CARD -->
                        <template x-if="index === filteredProducts().length - 1">
                            <a href="/products" class="product-card view-more-card">
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
                                        '{{ asset('storage/assets/dashboard/assets/img/image-not-found.jpg') }}'"
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
            <h2 style="font-family: Orbitron; font-weight:700;" class="text-accent-color">Gallery</h2>
            <p style="color:#9ca3af;">See our latest products & builds</p>
        </div>

        <div class="swiper gallerySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="{{ asset('storage/assets/dashboard/assets/img/gallery1.jpg') }}" class="gallery-img" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('storage/assets/dashboard/assets/img/gallery2.jpg') }}" class="gallery-img" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('storage/assets/dashboard/assets/img/gallery3.png') }}" class="gallery-img" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('storage/assets/dashboard/assets/img/gallery4.jpg') }}" class="gallery-img" />
                </div>
            </div>
        </div>
    </div>
</section>
<!-- TESTIMONIALS -->
<section id="testimonials" class="testimonials">
    <div class="overlay"></div>

    <div class="container position-relative">

        <div class="text-center mb-5">
            <h2 class="font-orbitron text-accent-color">Customer Testimonials</h2>
            <p class="text-light opacity-75">What our customers say about us</p>
        </div>

        <div class="swiper testimonialsSwiper">
            <div class="swiper-wrapper">

                <!-- CARD -->
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <img src="https://i.pravatar.cc/300" class="testimonial-img">

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
                        <img src="https://i.pravatar.cc/301" class="testimonial-img">

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
                        <img src="https://i.pravatar.cc/302" class="testimonial-img">

                        <p class="testimonial-text">
                            Great customer service and top-notch products. Highly recommend!
                        </p>

                        <div class="testimonial-footer">
                            <h6 class="testimonial-name">Sandy Nguyen</h6>
                            <span class="testimonial-role">Rider & Blogger</span>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <img src="https://i.pravatar.cc/300" class="testimonial-img">

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
                        <img src="https://i.pravatar.cc/301" class="testimonial-img">

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
                        <img src="https://i.pravatar.cc/302" class="testimonial-img">

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

        </div>
    </div>
</section>
<!-- CONTACT -->
<section id="contact" class="contact-us" style="background-color: #0b1220; padding: 80px 0; color: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="font-orbitron text-warning">Contact Us</h2>
            <p class="text-secondary">We'd love to hear from you. Feel free to drop a message!</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <form action="#" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter your name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter your email">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Your Message</label>
                        <textarea class="form-control" id="message" rows="5" placeholder="Enter your message"></textarea>
                    </div>
                    <button type="submit" class="btn btn-yellow">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- ABOUT US -->
<section class="about"
    style="background: url('{{ asset('storage/assets/dashboard/assets/img/detail-product-bg.jpg') }}') no-repeat center center fixed; background-size: cover;">
    <div class="overlay"></div>
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="font-orbitron text-warning">About Us</h2>
            <p class="text-secondary">Your Trusted Moto Partner</p>
        </div>
        <div class="row align-items-center">
            <!-- Left Column (Text) -->
            <div class="col-lg-6">
                <div class="about-content">
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
                        <a href="#products" class="btn btn-warning">Browse Products</a>
                        <a href="#contact" class="btn btn-outline-warning">Contact Us</a>
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
    });
</script>
<script>
    const API_PRODUCT_PAGED_URL = "{{ route('api-product-paged') }}";
    const API_BRAND_ALL_URL = "{{ route('api-brand-all') }}";

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
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
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

        loop: true,

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
