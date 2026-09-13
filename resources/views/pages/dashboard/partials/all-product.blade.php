<link rel="stylesheet" href="{{ url('build/css/all-product.css') }}">

<div class="product-list-page" x-data="productListApp()" x-init="init()">

    <div class="container">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-md-3">
                <div class="category-sidebar">

                    <h5 class="sidebar-title">Categories</h5>
                    <!-- ALL CATEGORY -->
                    <div class="category-group">
                        <div class="category-item" :class="{ active: !selectedCategory && !selectedSubCategory }"
                            @click="selectAll()">
                            <span>All Categories</span>
                        </div>
                    </div>
                    <template x-if="loadingCategory">
                        <div class="sidebar-shimmer">
                            <div class="shimmer-line shimmer"></div>
                            <div class="shimmer-line shimmer"></div>
                            <div class="shimmer-line shimmer"></div>
                            <div class="shimmer-line shimmer short"></div>
                        </div>
                    </template>

                    <template x-for="cat in categories" :key="cat.code">

                        <div class="category-group">

                            <!-- MAIN CATEGORY -->
                            <div class="category-item" :class="{ active: selectedCategory === cat.id }"
                                @click="toggleCategory(cat)">

                                <span x-text="cat.name"></span>

                                <!-- arrow -->
                                <span x-show="(cat.subcategories || []).length">
                                    <span x-text="isOpen(cat.code) ? '▲' : '▼'"></span>
                                </span>

                            </div>

                            <!-- SUB CATEGORY (COLLAPSE) -->
                            <div class="subcategory-list" x-show="isOpen(cat.code)" x-transition>

                                <template x-for="sub in (cat.subcategories || [])" :key="sub.code">

                                    <div class="subcategory-item" :class="{ active: selectedSubCategory === sub.id }"
                                        @click.stop="selectSubCategory(sub)">

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
                    <h3 class="text-accent-color font-rajdhani">
                        <span x-text="selectedCategoryName || 'All Products'"></span>
                    </h3>
                </div>
                <div class="product-toolbar">

                    <!-- LEFT -->
                    <div class="toolbar-left">
                        <span class="label">Sort by</span>

                        <button @click="setSort('popular')" :class="{ active: sort === 'popular' }">Popular</button>
                        <button @click="setSort('latest')" :class="{ active: sort === 'latest' }">Latest</button>
                        <button @click="setSort('sales')" :class="{ active: sort === 'sales' }">Top Sales</button>

                        <div class="dropdown">
                            <select @change="setSort('price', $event.target.value)">
                                <option value="">Price</option>
                                <option value="asc">Lowest</option>
                                <option value="desc">Highest</option>
                            </select>
                        </div>
                    </div>

                    <!-- RIGHT -->
                    <div class="toolbar-right">
                        <span x-text="page + '/' + lastPage"></span>

                        <button @click="prevPage()" :disabled="page <= 1">‹</button>
                        <button @click="nextPage()" :disabled="page >= lastPage">›</button>
                    </div>

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

                            <a :href="'{{ route('single-product') }}?uuid=' + product.uuid" class="product-card">

                                <div class="product-image">
                                    <img :src="product.image_url || '{{ asset('/build/img/image-not-found.jpg') }}'">
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
    const API_SUBCATEGORY_URL = "{{ route('api-subcategory-all') }}";

    function productListApp() {
        return {
            categories: [],
            products: [],

            page: 1,
            lastPage: 1,

            sort: 'latest',
            sortDirection: 'desc',

            selectedCategory: null, // category id
            selectedSubCategory: null, // subcategory id
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

            toggleCategory(cat) {
                // select category
                this.selectedCategory = cat.id;
                this.selectedSubCategory = null;
                this.selectedCategoryName = cat.name || 'Products';

                // toggle collapse
                const code = cat.code;
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

            async selectSubCategory(sub) {
                this.selectedSubCategory = sub.id;
                this.selectedCategory = sub.category_id;
                this.selectedCategoryName = sub.category?.name || sub.name || 'Products';

                await this.loadProducts();
            },

            async loadCategories() {
                this.loadingCategory = true;

                try {
                    const [catRes, subRes] = await Promise.all([
                        fetch(API_CATEGORY_URL),
                        fetch(API_SUBCATEGORY_URL),
                    ]);

                    const [catJson, subJson] = await Promise.all([catRes.json(), subRes.json()]);

                    const subcategories = subJson.data || [];

                    this.categories = (catJson.data || []).map(cat => ({
                        ...cat,
                        subcategories: subcategories.filter(sub => sub.category_id === cat.id),
                    }));

                } finally {
                    this.loadingCategory = false;
                }
            },
            selectAll() {
                this.selectedCategory = null;
                this.selectedSubCategory = null;
                this.selectedCategoryName = 'All Products';

                this.loadProducts();
            },
            async loadProducts() {
                this.loadingProduct = true;

                try {
                    let url = API_PRODUCT_URL + `?per_page=12&page=${this.page}`;

                    // 🔥 FILTER
                    if (this.selectedSubCategory) {
                        url += "&subcategory=" + this.selectedSubCategory;
                    } else if (this.selectedCategory) {
                        url += "&category=" + this.selectedCategory;
                    }

                    // 🔥 SORTING
                    if (this.sort === 'latest') {
                        url += "&sortBy=created_at&sortDirection=desc";
                    }
                    if (this.sort === 'popular') {
                        url += "&sortBy=views&sortDirection=desc";
                    }
                    if (this.sort === 'sales') {
                        url += "&sortBy=sold&sortDirection=desc";
                    }
                    if (this.sort === 'price') {
                        url += "&sortBy=sell_price&sortDirection=" + this.sortDirection;
                    }

                    const res = await fetch(url);
                    const json = await res.json();

                    this.products = json.data.data || [];
                    this.page = json.data.current_page;
                    this.lastPage = json.data.last_page;

                } catch (e) {
                    console.error(e);
                } finally {
                    this.loadingProduct = false;
                }
            },

            setSort(type, direction = 'asc') {
                this.sort = type;

                if (type === 'price') {
                    this.sortDirection = direction;
                }

                this.page = 1;
                this.loadProducts();
            },

            nextPage() {
                if (this.page < this.lastPage) {
                    this.page++;
                    this.loadProducts();
                }
            },

            prevPage() {
                if (this.page > 1) {
                    this.page--;
                    this.loadProducts();
                }
            }
        }
    }
</script>
