@include('pages.dashboard.partials.header')

<div class="container pt-5" style="padding-top: 100px !important;">
    <div class="row g-4">
        <!-- LEFT: Thumbnail + Main Image -->
        <div class="col-md-6 d-flex gap-3">
            <div class="d-flex flex-column mx-3">
                @php
                $allImages = array_merge(
                [ ['path' => $data['product']['image_url']] ],
                $data['product']['images']->toArray()
                );
                @endphp
                @foreach($allImages as $image)
                <div class="col-1">
                    <img src="{{ $image['path'] }}" class="border rounded thumbnail-img" onclick="changePreview(this)"
                        style="width: 90px; height: 90px; object-fit: cover;">

                </div>
                @endforeach
                {{-- <img src="https://merto-be87.kxcdn.com/merto/wp-content/uploads/2024/05/fashion-5-300x300.jpg"
                    class="img-thumbnail mb-2" alt="Thumb 1">
                <img src="https://merto-be87.kxcdn.com/merto/wp-content/uploads/2024/05/fashion-5-300x300.jpg"
                    class="img-thumbnail mb-2" alt="Thumb 2">
                <img src="https://merto-be87.kxcdn.com/merto/wp-content/uploads/2024/05/fashion-5-300x300.jpg"
                    class="img-thumbnail mb-2" alt="Thumb 3">
                <img src="https://merto-be87.kxcdn.com/merto/wp-content/uploads/2024/05/fashion-5-300x300.jpg"
                    class="img-thumbnail" alt="Thumb 4"> --}}
            </div>
            <div class="flex-fill position-relative">
                <span class="badge bg-danger position-absolute top-0 start-0 m-2">HOT</span>
                <img src="https://merto-be87.kxcdn.com/merto/wp-content/uploads/2024/05/fashion-5.jpg"
                    class="img-fluid border rounded" alt="Main Product">
                {{-- <button class="btn btn-light position-absolute top-0 end-0 m-2 border rounded-circle">
                    <i class="bi bi-arrows-fullscreen"></i>
                </button> --}}
            </div>
        </div>


        <!-- RIGHT: Product Info -->
        <div class="col-md-6">
            <p class="text-muted text-left mb-1">{{ ucwords($data['product']['category']['name']) }}</p>
            <h2 class="fw-bold">{{ ucwords($data['product']['name']) }}</h2>

            <!-- Rating -->
            <div class="mb-3">
                <span class="text-warning">
                    ★★★★☆
                </span>
                <small class="text-muted ms-1">(4.50 - 4 Reviews)</small>
                <a href="#" class="ms-2 text-decoration-underline small">Write a review</a>
            </div>

            <!-- Features -->
            <ul class="list-unstyled mb-3">
                <li class="text-success"><i class="bi bi-check2"></i> {{
                    ucwords($data['product']['sub_category']!=null??$data['product']['sub_category']['name']) }}</li>
                <li class="text-success"><i class="bi bi-check2"></i> {{ ucwords($data['product']['description']) }}
                </li>
                <li class="text-success"><i class="bi bi-check2"></i> 14.11 Ounces</li>
            </ul>

            <!-- Price -->
            <h3 class="fw-bold">{{\App\Services\UtilService::formatCurrency($data['product']['sell_price'],
                $data['product']['currency']) }}</h3>
            <span class="badge bg-success text-white mb-3">In stock</span>

            <!-- Quantity + Buttons -->
            <div class="d-flex align-items-center mb-3">
                <div class="input-group me-3" style="width: 120px;">
                    <button class="btn btn-outline-secondary">-</button>
                    <input type="text" class="form-control text-center" value="1">
                    <button class="btn btn-outline-secondary">+</button>
                </div>
                <button class="btn btn-dark fw-bold me-2">+ ADD TO CART</button>
                <button class="btn btn-danger fw-bold">BUY NOW</button>
            </div>

            <!-- Wishlist / Compare -->
            <div class="mb-3">
                <a href="#" class="me-3 text-muted"><i class="bi bi-heart"></i> Add to wishlist</a>
                <a href="#" class="text-muted"><i class="bi bi-shuffle"></i> Add to compare</a>
            </div>

            <!-- SKU & Category -->
            <p class="mb-1"><strong>SKU:</strong> GWV6GFJCTH</p>
            <p><strong>Categories:</strong> <a href="#">Accessories</a>, <a href="#">Shoes</a></p>

            <!-- Social Links -->
            <div class="d-flex gap-3">
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-twitter"></i></a>
                <a href="#"><i class="bi bi-pinterest"></i></a>
                <a href="#"><i class="bi bi-linkedin"></i></a>
            </div>
        </div>
    </div>
</div>