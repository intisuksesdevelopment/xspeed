<link rel="stylesheet" href="{{ url('storage/assets/dashboard/assets/css/all-product.css') }}">

<div class="product-list-page" x-data="productListApp()" x-init="init()">

    <div class="container">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-md-3">
                <div class="category-sidebar">

                    <h5 class="sidebar-title">Categories</h5>

                    <template x-if="loadingCategory">
                        <div>
                            <div class="shimmer-line shimmer mb-2"></div>
                            <div class="shimmer-line shimmer mb-2"></div>
                            <div class="shimmer-line shimmer mb-2"></div>
                        </div>
                    </template>

                    <template x-for="cat in categories" :key="cat.code">

                        <div class="category-group">

                            <!-- MAIN CATEGORY -->
                            <div class="category-item" :class="{ active: selectedCategory === cat.code }"
                                @click="toggleCategory(cat.code)">

                                <span x-text="cat.name"></span>

                                <!-- arrow -->
                                <span x-show="cat.subcategories.length">
                                    <span x-text="isOpen(cat.code) ? '▲' : '▼'"></span>
                                </span>

                            </div>

                            <!-- SUB CATEGORY (COLLAPSE) -->
                            <div class="subcategory-list" x-show="isOpen(cat.code)" x-transition>

                                <template x-for="sub in cat.subcategories" :key="sub.code">

                                    <div class="subcategory-item" :class="{ active: selectedSubCategory === sub.code }"
                                        @click.stop="selectSubCategory(sub.code)">

                                        <span x-text="sub.name"></span>
                                    </div>

                                </template>

                            </div>

                        </div>

                    </template>

                </div>
            </div>

            <!-- PRODUCT -->
            <div class="col-md-9">

                <div class="mb-4">
                    <h3 class="text-accent-color">
                        <span x-text="selectedCategoryName || 'All Products'"></span>
                    </h3>
                </div>

                <!-- SHIMMER -->
                <div class="row g-4" x-show="loadingProduct">
                    <template x-for="i in 8">
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="product-card shimmer-card">
                                <div class="product-image shimmer"></div>
                                <div class="product-info">
                                    <div class="shimmer-line shimmer"></div>
                                    <div class="shimmer-line short shimmer"></div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- GRID -->
                <div class="row g-4" x-show="!loadingProduct">

                    <template x-for="product in products" :key="product.uuid">
                        <div class="col-6 col-md-4 col-lg-3">

                            <a :href="'/product/' + product.uuid" class="product-card">

                                <div class="product-image">
                                    <img :src="product.image_url">
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
    </div>

</div>

<script>
    const API_PRODUCT_URL = "{{ route('api-product-paged') }}";
    const API_CATEGORY_URL = "{{ route('api-category-all') }}";

    function productListApp() {
        return {
            categories: [],
            products: [],

            selectedCategory: null,
            selectedSubCategory: null,
            selectedCategoryName: null,

            openCategories: [], // 🔥 collapse state

            loadingCategory: true,
            loadingProduct: true,

            initialized: false,

            async init() {
                if (this.initialized) return;
                this.initialized = true;

                await this.loadCategories();
                await this.loadProducts();
            },

            toggleCategory(code) {
                // select category
                this.selectedCategory = code;
                this.selectedSubCategory = null;

                const cat = this.categories.find(c => c.code === code);
                this.selectedCategoryName = cat?.name || 'Products';

                // toggle collapse
                if (this.openCategories.includes(code)) {
                    this.openCategories = this.openCategories.filter(c => c !== code);
                } else {
                    this.openCategories.push(code);
                }

                this.loadProducts();
            },

            isOpen(code) {
                return this.openCategories.includes(code);
            },

            async selectSubCategory(code) {
                this.selectedSubCategory = code;
                await this.loadProducts();
            },

            async loadCategories() {
                this.loadingCategory = true;

                try {
                    const res = await fetch("{{ route('api-category-all') }}");
                    const json = await res.json();

                    this.categories = json.data || [];

                } finally {
                    this.loadingCategory = false;
                }
            },

            async loadProducts() {
                this.loadingProduct = true;

                try {
                    let url = "{{ route('api-product-paged') }}" + "?per_page=12";

                    if (this.selectedSubCategory) {
                        url += "&subcategory=" + this.selectedSubCategory;
                    } else if (this.selectedCategory) {
                        url += "&category=" + this.selectedCategory;
                    }

                    const res = await fetch(url);
                    const json = await res.json();

                    this.products = json.data.data || [];

                } finally {
                    this.loadingProduct = false;
                }
            }
        }
    }
</script>
