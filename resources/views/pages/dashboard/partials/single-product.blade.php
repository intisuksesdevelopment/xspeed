<link rel="stylesheet" href="{{ url('build/css/dashboard-single-product.css') }}">

<div class="product-page">



    <!-- PRODUCT DETAIL -->

    <section x-data="productDetail()" x-init="init()">
        <!-- BREADCRUMB -->
        <div class="product-breadcrumb">
            <div class="container">

                <a href="/">Dashboard</a>
                <span>/</span>

                <a x-show="product.category" :href="'/category/' + product.category_code" x-text="product.category"></a>

                <span x-show="product.category">/</span>

                <span class="active" x-text="product.name"></span>

            </div>
        </div>
        <div class="product-container container">

            <!-- 🔥 SHIMMER LEFT -->
            <div class="product-gallery" x-show="loading">

                <div class="product-main-image shimmer"></div>

                <div class="product-thumbs">
                    <template x-for="i in 4">
                        <div class="thumb-shimmer shimmer"></div>
                    </template>
                </div>

            </div>

            <!-- LEFT: GALLERY -->
            <div class="product-gallery" x-show="!loading">

                <img :src="mainImage" class="product-main-image">

                <div class="product-thumbs">
                    <template x-for="img in images" :key="img">
                        <img :src="img" @click="mainImage = img">
                    </template>
                </div>

            </div>

            <!-- RIGHT: INFO -->
            <div class="product-info" x-show="!loading">

                <div class="product-meta">
                    <span x-text="product.category"></span>
                    <span>•</span>
                    <span x-text="product.brand"></span>
                </div>

                <h1 class="product-title" x-text="product.name"></h1>

                <div class="product-sku" x-text="product.barcode"></div>

                <div class="product-price" x-text="formatPrice(product.price)"></div>

                <!-- GRID INFO -->
                <div class="product-grid-info">

                    <div>
                        <label>Stock</label>
                        <span x-text="product.stock"></span>
                    </div>

                    <div>
                        <label>SKU</label>
                        <span x-text="product.sku"></span>
                    </div>

                    <div>
                        <label>Unit</label>
                        <span x-text="product.unit"></span>
                    </div>

                    <div>
                        <label>Price</label>
                        <span x-text="formatPrice(product.price)"></span>
                    </div>

                </div>

                <p class="product-desc" x-text="product.description"></p>


                <!-- CTA -->
                <div class="product-actions">

                    <!-- PRIMARY CTA -->
                    <a :href="whatsappLink" class="btn-buy-primary">
                        Pesan Sekarang
                    </a>

                    <!-- MARKETPLACE -->
                    <div class="marketplace-row">
                        <template x-for="link in product.links" :key="link.link">
                            <a :href="link.link" target="_blank" class="btn-market"
                                :class="getMarketplaceClass(link.name)">
                                <span x-text="'Beli di ' + link.name"></span>
                            </a>
                        </template>
                    </div>

                </div>

            </div>

            <!-- 🔥 SHIMMER RIGHT -->
            <div class="product-info" x-show="loading">

                <div class="shimmer-line shimmer"></div>
                <div class="shimmer-line short shimmer"></div>

                <div class="shimmer-line shimmer"></div>
                <div class="shimmer-line shimmer"></div>

                <div class="product-grid-info">
                    <template x-for="i in 4">
                        <div class="shimmer-card shimmer"></div>
                    </template>
                </div>

            </div>

        </div>

    </section>

    <!-- RELATED PRODUCTS -->
    <section>
        <div class="product-related container" x-data="relatedProducts()" x-init="init()">

            <div class="section-title">RELATED PRODUCTS</div>

            <!-- SHIMMER -->
            <div class="related-grid" x-show="loading">
                <template x-for="i in 8" :key="i">
                    <div class="product-card">
                        <div class="related-img shimmer"></div>
                        <div class="related-info">
                            <div class="shimmer-line shimmer"></div>
                            <div class="shimmer-line short shimmer"></div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- ERROR -->
            <div x-show="error" class="text-center text-danger">
                Failed to load products
            </div>

            <!-- GRID -->
            <div class="related-grid" x-show="!loading">

                <template x-for="product in products" :key="product.uuid">

                    <a :href="'/product/' + product.uuid" class="product-card">

                        <div class="related-img">
                            <img :src="product.image_url" />
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
    const uuid = this.getUUIDFromURL();
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
                        price: data.sell_price,
                        description: data.description,
                        stock: data.stock,
                        sku: data.sku,
                        unit: data.unit,
                        links: JSON.parse(data.link_url || '[]')
                    };

                    this.images = [
                        data.image_url,
                        ...(data.images?.map(i => i.path) || [])
                    ];

                    this.mainImage = this.images[0];

                    this.whatsappLink =
                        `https://wa.me/628123456789?text=` +
                        encodeURIComponent(`Saya ingin pesan: ${data.name}`);

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

                return 'mkt-default';
            }
        }
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
                    const res = await fetch(API_PRODUCT_PAGED_URL + "?per_page=8");

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
