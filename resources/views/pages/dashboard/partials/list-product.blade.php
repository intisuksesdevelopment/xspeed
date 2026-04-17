<link rel="stylesheet" href="{{ url('build/css/product-list.css') }}">

<div class="product-page" x-data="productList()" x-init="init()">

    <div class="container product-layout">

        <!-- SIDEBAR -->
        <aside class="product-sidebar">

            <div class="sidebar-title">KATEGORI</div>

            <!-- SHIMMER -->
            <template x-if="loadingCategory">
                <div>
                    <template x-for="i in 6">
                        <div class="sidebar-item shimmer"></div>
                    </template>
                </div>
            </template>

            <!-- CATEGORY LIST -->
            <template x-for="cat in categories" :key="cat.id">
                <div class="sidebar-item"
                     :class="{active: selectedCategory === cat.code}"
                     @click="selectCategory(cat.id)">
                    
                    <span x-text="cat.name"></span>
                    <small x-text="cat.item_count"></small>
                </div>
            </template>

        </aside>

        <!-- CONTENT -->
        <main class="product-content">

            <div class="content-header">
                <h2 x-text="selectedCategoryName || 'Semua Produk'"></h2>
            </div>

            <!-- SHIMMER -->
            <div class="product-grid" x-show="loadingProducts">
                <template x-for="i in 8">
                    <div class="product-card shimmer-card">
                        <div class="product-image shimmer"></div>
                        <div class="product-info">
                            <div class="shimmer-line shimmer"></div>
                            <div class="shimmer-line short shimmer"></div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- ERROR -->
            <div x-show="error" class="text-center text-danger">
                Gagal load produk
            </div>

            <!-- PRODUCTS -->
            <div class="product-grid" x-show="!loadingProducts">

                <template x-for="product in products" :key="product.uuid">
                    <a :href="'/dashboard/single-product?uuid=' + product.uuid" class="product-card">

                        <div class="product-image">
                            <img :src="product.image_url">
                        </div>

                        <div class="product-info">
                            <div class="product-name" x-text="product.name"></div>
                            <div class="product-price"
                                x-text="'Rp ' + Number(product.sell_price).toLocaleString()">
                            </div>
                        </div>

                    </a>
                </template>

            </div>

        </main>

    </div>

</div>
<script>
const API_PRODUCT_URL = "{{ route('api-product-paged') }}";
const API_CATEGORY_URL = "{{ route('api-category-all') }}";

function productListApp(){
    return {
        categories: [],
        products: [],
        selectedCategory: null,

        loadingCategory: true,
        loadingProduct: true,

        async init(){
            await this.loadCategories();
            await this.loadProducts();
        },

        async loadCategories(){
            this.loadingCategory = true;

            try{
                const res = await fetch(API_CATEGORY_URL);
                const json = await res.json();

                this.categories = json.data || [];

            }catch(e){
                console.error(e);
            }finally{
                this.loadingCategory = false;
            }
        },

        async loadProducts(){
            this.loadingProduct = true;

            try{
                let url = API_PRODUCT_URL + "?per_page=12";

                if(this.selectedCategory){
                    url += "&category=" + this.selectedCategory;
                }

                const res = await fetch(url);
                const json = await res.json();

                this.products = json.data.data;

            }catch(e){
                console.error(e);
            }finally{
                this.loadingProduct = false;
            }
        },

        async selectCategory(code){
            this.selectedCategory = code;
            await this.loadProducts();
        }
    }
}
</script>