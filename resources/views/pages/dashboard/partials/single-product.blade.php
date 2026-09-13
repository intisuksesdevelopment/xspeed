<link rel="stylesheet" href="{{ url('build/css/single-product.css') }}">

<div class="product-page">

    <!-- PRODUCT DETAIL -->
    <section x-data="productDetail()" x-init="init()">

        <!-- BREADCRUMB -->
        <div class="product-breadcrumb">
            <div class="container">

                <a href="/" class="crumb-home">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                    Dashboard
                </a>

                <span class="crumb-sep">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
                </span>

                <a x-show="product.category" :href="'/category/' + product.category_code" x-text="product.category" class="crumb-link"></a>

                <span class="crumb-sep" x-show="product.brand">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
                </span>

                <a x-show="product.brand" :href="'/brand/' + (product.brand || '').toLowerCase().replace(/\s+/g, '-')" x-text="product.brand" class="crumb-link"></a>

                <span class="crumb-sep" x-show="product.name">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
                </span>

                <span class="crumb-active" x-text="product.name"></span>

            </div>
        </div>

        <!-- PROMO BAR — di bawah breadcrumb -->
        <div class="product-promo-bar" x-show="promos && promos.length">
            <div class="container">
                <template x-for="(ad, idx) in (promos || [])" :key="ad.id || idx">
                    <div class="promo-bar-item" x-show="!hiddenPromos.includes(ad.id)" x-transition>
                        <div class="promo-bar-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#111" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>
                            </svg>
                        </div>
                        <div class="promo-bar-text">
                            <span class="promo-bar-highlight" x-text="ad.content || ad.title"></span>
                            <span class="promo-bar-code" x-show="ad.code">
                                Gunakan kode: <strong x-text="ad.code"></strong>
                            </span>
                        </div>
                        <button class="promo-bar-close" @click="hiddenPromos.push(ad.id)" aria-label="Tutup">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <div class="product-container container">

            <!-- 🔥 SHIMMER LEFT -->
            <div class="product-gallery" x-show="loading">

                <div class="shimmer-img product-main-image"></div>

                <div class="product-thumbs">
                    <template x-for="i in 4" :key="i">
                        <div class="shimmer-img thumb-shimmer"></div>
                    </template>
                </div>

            </div>

            <!-- LEFT: GALLERY -->
            <div class="product-gallery" x-show="!loading">

                <img :src="mainImage" class="product-main-image" :alt="product.name">

                <div class="product-thumbs">
                    <template x-for="img in images" :key="img">
                        <img :src="img" @click="mainImage = img" :class="img === mainImage ? 'active' : ''" :alt="product.name">
                    </template>
                </div>

            </div>

            <!-- RIGHT: INFO -->
            <div class="product-info" x-show="!loading && !error">

                <div class="product-meta">
                    <span x-text="product.category || '-'"></span>
                    <span>•</span>
                    <span x-text="product.brand || '-'"></span>
                </div>

                <h1 class="product-title" x-text="product.name"></h1>

                <div class="product-sku" x-text="'SKU: ' + (product.barcode || product.sku || '-')"></div>

                <div class="product-price" x-text="formatPrice(product.sell_price)"></div>

                <!-- GRID INFO -->
                <div class="product-grid-info">

                    <div>
                        <label>Stok Tersedia</label>
                        <span :class="product.stock > 0 ? 'stock-ok' : 'stock-empty'" x-text="product.stock > 0 ? product.stock + ' Unit' : 'Stok Habis'"></span>
                    </div>

                    <div>
                        <label>SKU / Barcode</label>
                        <span style="font-size:11px; color: rgba(255,255,255,0.5);" x-text="product.sku || product.barcode || '-'"></span>
                    </div>

                    <div>
                        <label>Unit</label>
                        <span style="font-size:12px; color: rgba(255,255,255,0.7);" x-text="product.unit || '-'"></span>
                    </div>

                    <div>
                        <label>Harga Jual</label>
                        <span style="font-size:14px; font-weight:700; color:#FFCC00;" x-text="formatPrice(product.sell_price)"></span>
                    </div>

                </div>

                <!-- SHIPPING INFO -->
                <div class="shipping-info">
                    <div class="shipping-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                        <span>Pengiriman</span>
                        <strong>Same Day / Next Day</strong>
                    </div>
                    <div class="shipping-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <span>Garansi</span>
                        <strong>100% Original</strong>
                    </div>
                    <div class="shipping-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span>Respon</span>
                        <strong>± 30 Menit</strong>
                    </div>
                </div>

                <p class="product-desc" x-show="product.description" x-text="product.description"></p>

                <!-- CTA -->
                <div class="product-actions" x-show="!loading && !error">

                    <!-- PRIMARY CTA -->
                    <a :href="product.stock > 0 ? whatsappLink : null" :class="product.stock <= 0 ? 'btn-buy-primary disabled' : 'btn-buy-primary'" @click.prevent="product.stock <= 0 ? null : window.open(whatsappLink, '_blank')" x-text="product.stock > 0 ? 'Pesan Sekarang' : 'Stok Habis'"></a>

                    <!-- MARKETPLACE -->
                    <div class="marketplace-row" x-show="product.links && product.links.length">
                        <template x-for="(link, idx) in (product.links || [])" :key="(link.url || link.link || '') + '-' + idx">
                            <a :href="link.url || link.link || '#'" target="_blank" class="btn-market"
                                :class="getMarketplaceClass(link.platform || link.name || '')">
                                <span x-text="link.platform || link.name || 'Marketplace'"></span>
                            </a>
                        </template>
                    </div>

                </div>

            </div>

            <!-- 🔥 SHIMMER RIGHT -->
            <div class="product-info" x-show="loading">

                <div class="shimmer-line"></div>
                <div class="shimmer-line short"></div>

                <div class="shimmer-title"></div>
                <div class="shimmer-line short"></div>

                <div class="product-grid-info">
                    <template x-for="i in 4" :key="i">
                        <div class="shimmer-card"></div>
                    </template>
                </div>

                <div class="shimmer-desc"></div>

            </div>

        </div>

    </section>

    <!-- ADS SECTION (slider + banners) — di atas RELATED PRODUCTS -->
    <section class="product-ads-section" x-data="adsBannerSection()" x-init="init()">
        <div class="product-ads-inner">

            <!-- SECTION DIVIDER -->
            <div class="ads-section-divider">
                <span class="ads-divider-line"></span>
                <span class="ads-divider-label">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>
                    </svg>
                    IKLAN & PENAWARAN
                </span>
                <span class="ads-divider-line"></span>
            </div>

            <!-- ADS SLIDER -->
            <div x-show="ads && ads.length">
                <div class="ads-slider">
                <div class="ads-slide-track">
                    <template x-for="(ad, idx) in (ads || [])" :key="'ads-' + (ad.id || idx)">
                        <a :href="ad.link || '#'" target="_blank" class="ads-slide-card"
                           x-show="idx === adsIndex">
                            <div class="ads-slide-inner">
                                <div class="ads-slide-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>
                                    </svg>
                                </div>
                                <div class="ads-slide-text">
                                    <div class="ads-slide-title" x-text="ad.title"></div>
                                    <div class="ads-slide-desc" x-text="ad.content"></div>
                                </div>
                                <div class="ads-slide-arrow">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="9 18 15 12 9 6"/>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </template>
                </div>
                <div class="ads-slider-nav" x-show="ads.length > 1">
                    <button class="ads-nav-btn" @click="prevAd()" aria-label="Sebelumnya">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
                    </button>
                    <div class="ads-dots">
                        <template x-for="(ad, idx) in (ads || [])" :key="'dot-' + (ad.id || idx)">
                            <button class="ads-dot" :class="idx === adsIndex ? 'active' : ''"
                                    @click="adsIndex = idx; resetAdTimer()" :aria-label="'Iklan ' + (idx + 1)"></button>
                        </template>
                    </div>
                    <button class="ads-nav-btn" @click="nextAd()" aria-label="Berikutnya">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- ADS BANNERS -->
        <div x-show="banners && banners.length" style="margin-top: 10px;">
            <div class="container">
            <template x-for="(banner, idx) in (banners || [])" :key="'banner-' + (banner.id || idx)">
                <a :href="banner.link || '#'" target="_blank" class="ads-banner">
                    <div class="ads-banner-content">
                        <div class="ads-banner-badge">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span x-text="banner.type === 'announcement' ? 'ANNONSEMENT' : banner.title || 'PENAWARAN'"></span>
                        </div>
                        <div class="ads-banner-title" x-text="banner.title"></div>
                        <div class="ads-banner-desc" x-text="banner.content"></div>
                    </div>
                    <div class="ads-banner-cta">
                        <span x-text="banner.code ? 'Kode: ' + banner.code : 'Selengkapnya'"></span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </div>
                </a>
            </template>
            </div>
        </div>

        </div><!-- .product-ads-inner -->
    </section>

    <!-- RELATED PRODUCTS -->
    <section>
        <div class="product-related container" x-data="relatedProducts()" x-init="init()">

            <div class="section-title">RELATED PRODUCTS</div>

            <!-- SHIMMER -->
            <div class="related-grid" x-show="loading">
                <template x-for="i in 8" :key="i">
                    <div class="product-card">
                        <div class="related-img shimmer-img"></div>
                        <div class="related-info">
                            <div class="shimmer-line"></div>
                            <div class="shimmer-line short"></div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- ERROR -->
            <div x-show="error" class="text-center text-danger">
                Failed to load products
            </div>

            <!-- GRID 6 KOLOM -->
            <div class="related-grid" x-show="!loading">

                <template x-for="product in products" :key="product.uuid">

                    <a :href="'{{ route('single-product') }}?uuid=' + product.uuid" class="product-card">

                        <div class="related-img">
                            <img :src="product.image_url || '{{ asset('/build/img/image-not-found.jpg') }}'" :alt="product.name" />
                        </div>

                        <div class="related-info">
                            <div class="related-name" x-text="product.name"></div>
                            <div class="related-price" x-text="'Rp ' + Number(product.sell_price).toLocaleString()">
                            </div>
                        </div>

                    </a>

                </template>

            </div>

        </div>
    </section>
</div>

<script>
    const FALLBACK_IMG = "{{ asset('/build/img/image-not-found.jpg') }}";
    const API_PRODUCT_DETAIL_URL = "/api/product/detail";
    const API_PRODUCT_PAGED_URL = "{{ route('api-product-paged') }}";

    function changePreview(el) {
        const main = document.getElementById('mainImage');
        main.style.opacity = 0;

        setTimeout(() => {
            main.src = el.src;
            main.style.opacity = 1;
        }, 120);
    }

    function productDetail() {
        return {
            product: {},
            images: [],
            mainImage: '',
            loading: true,
            error: false,
            whatsappLink: '',
            promos: [],
            hiddenPromos: [],

            async init() {
                if (this.loaded) return; // 🔥 anti duplicate
                this.loaded = true;

                const uuid = getUUIDFromURL();

                if (!uuid) {
                    this.error = true;
                    this.loading = false;
                    return;
                }

                await this.fetchDetail(uuid);
            },
            async fetchDetail(uuid) {
                this.loading = true;
                this.error = false;

                try {
                    const res = await fetch(`${API_PRODUCT_DETAIL_URL}/${uuid}`);

                    if (!res.ok) throw new Error("API error");

                    const json = await res.json();
                    const data = json.data;

                    this.product = {
                        name: data.name,
                        category: data.category?.name,
                        category_code: data.category?.code,
                        brand: data.brand?.name,
                        barcode: data.barcode,
                        sell_price: data.sell_price,
                        description: data.description,
                        stock: data.stock,
                        sku: data.sku,
                        unit: data.unit,
                        links: data.link_url || []
                    };

                    this.images = [
                        data.image_url,
                        ...(data.images?.map(i => i.path) || [])
                    ].filter(Boolean);

                    if (this.images.length === 0) {
                        this.images = [FALLBACK_IMG];
                    }

                    this.mainImage = this.images[0];

                    this.whatsappLink =
                        `https://wa.me/628123456789?text=` +
                        encodeURIComponent(`Saya ingin pesan: ${data.name}`);

                    // Load promos from database
                    try {
                        const promoRes = await fetch('/api/ads?position=product_top');
                        const promoData = await promoRes.json();
                        this.promos = promoData.data || [];
                    } catch (e) {
                        console.warn('Failed to load promos:', e);
                    }

                } catch (e) {
                    console.error(e);
                    this.error = true;
                } finally {
                    this.loading = false;
                }
            },

            formatPrice(val) {
                return "Rp " + Number(val || 0).toLocaleString();
            },
            getMarketplaceClass(name) {
                if (!name) return 'mkt-default';

                name = name.toLowerCase();

                if (name.includes('tokopedia')) return 'mkt-tokopedia';
                if (name.includes('shopee')) return 'mkt-shopee';
                if (name.includes('blibli')) return 'mkt-blibli';
                if (name.includes('lazada')) return 'mkt-lazada';
                if (name.includes('bukalapak')) return 'mkt-bukalapak';
                if (name.includes('tiktok')) return 'mkt-tiktok';

                return 'mkt-default';
            }
        }
    }

    function adsBannerSection() {
        return {
            ads: [],
            banners: [],
            adsIndex: 0,
            adsTimer: null,

            async init() {
                await this.loadAds();
            },
            async loadAds() {
                try {
                    const [adsRes, bannerRes] = await Promise.all([
                        fetch('/api/ads?position=product_ads'),
                        fetch('/api/ads?position=product_bottom'),
                    ]);
                    const [adsData, bannerData] = await Promise.all([
                        adsRes.json(),
                        bannerRes.json(),
                    ]);
                    this.ads = adsData.data || [];
                    this.banners = bannerData.data || [];
                    this.adsIndex = 0;
                    this.resetAdTimer();
                } catch (e) {
                    console.warn('Failed to load ads:', e);
                }
            },
            prevAd() {
                if (!this.ads.length) return;
                this.adsIndex = (this.adsIndex - 1 + this.ads.length) % this.ads.length;
                this.resetAdTimer();
            },
            nextAd() {
                if (!this.ads.length) return;
                this.adsIndex = (this.adsIndex + 1) % this.ads.length;
                this.resetAdTimer();
            },
            resetAdTimer() {
                clearInterval(this.adsTimer);
                if (this.ads.length > 1) {
                    this.adsTimer = setInterval(() => {
                        this.adsIndex = (this.adsIndex + 1) % this.ads.length;
                    }, 4000);
                }
            }
        };
    }

    function relatedProducts() {
        return {
            products: [],
            loading: false,
            error: false,
            initialized: false,

            async init() {
                if (this.initialized) return;
                this.initialized = true;

                await this.loadProducts();
            },

            async loadProducts() {
                this.loading = true;
                this.error = false;

                try {
                    const res = await fetch(API_PRODUCT_PAGED_URL + "?per_page=12");

                    if (!res.ok) throw new Error("HTTP Error: " + res.status);

                    const json = await res.json();

                    if (!json.success) throw new Error("API failed");

                    this.products = json.data.data || [];

                } catch (e) {
                    console.error(e);
                    this.error = true;
                } finally {
                    this.loading = false;
                }
            }
        }
    }

    function getUUIDFromURL() {
        const url = new URL(window.location.href);
        return url.searchParams.get("uuid");
    }
</script>
