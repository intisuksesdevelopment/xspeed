@include('pages.dashboard.partials.header')

<div class="container pt-5" style="padding-top: 100px !important;">
    <div class="row g-4">
        <!-- LEFT: Thumbnail + Main Image -->
        <div class="col-md-7 row">
            <!-- Thumbnail column -->
            <div class="col-3 d-flex flex-column align-items-end">
                @php
                $allImages = $data['product']['images']->toArray();
                @endphp
                @foreach($allImages as $image)
                <div class="mb-2">
                    <img src="{{ $image['path'] }}" class="border rounded thumbnail-img" onclick="changePreview(this)"
                        style="width: 90px; height: 90px; object-fit: cover;cursor: pointer;">
                </div>
                @endforeach
            </div>

            <!-- Preview image column -->
            <div class="col-9">
                <div class="border rounded overflow-hidden position-relative preview-container"
                    style="width: 100%; aspect-ratio: 1/1;">
                    <img id="preview-image" src="{{ $data['product']['image_url'] }}" class="img-fluid w-100 h-100"
                        style="object-fit: cover; transition: transform 0.2s ease;" alt="Main Product">
                </div>
            </div>
        </div>



        <!-- RIGHT: Product Info -->
        <div class="col-md-5">
            <p class="text-muted text-left mb-1">{{ ucwords($data['product']['category']['name']) }}</p>
            <h2 class="fw-bold">{{ ucwords($data['product']['name']) }}</h2>
            <small class="text-muted ms-1">{{ strtoupper($data['product']['sku']) }}</small>


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
                <div class="input-group mr-2" style="width: 120px;">
                    <button class="btn btn-outline-secondary">-</button>
                    <input type="text" class="form-control text-center" value="1">
                    <button class="btn btn-outline-secondary">+</button>
                </div>
                <button class="btn btn-dark fw-bold mr-2">+ ADD TO CART</button>
                <button class="btn btn-success fw-bold mr-2">BUY NOW</button>
            </div>



            <!-- Wishlist / Compare -->
            <div class="mb-3">
                <a href="#" class="me-3 text-muted"><i class="bi bi-heart"></i> Add to wishlist</a>
                <a href="#" class="text-muted"><i class="bi bi-shuffle"></i> Add to compare</a>
            </div>

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

<script>
    const previewContainer = document.querySelector('.preview-container');
    const previewImage = document.getElementById('preview-image');

    previewContainer.addEventListener('mousemove', function (e) {
        const rect = this.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / rect.width) * 100;
        const y = ((e.clientY - rect.top) / rect.height) * 100;

        previewImage.style.transformOrigin = `${x}% ${y}%`;
        previewImage.style.transform = "scale(1.5)"; // zoom 1.5x
    });

    previewContainer.addEventListener('mouseleave', function () {
        previewImage.style.transformOrigin = "center center";
        previewImage.style.transform = "scale(1)";
    });
    function changePreview(element) {
    const preview = document.getElementById('preview-image');

    if (!preview) return; // jaga-jaga kalau element tidak ada

    // Tambahkan efek fade-out dulu biar lebih smooth
    preview.style.opacity = 0;

    setTimeout(() => {
        preview.src = element.src; // ganti gambar
        preview.style.opacity = 1; // fade-in
    }, 150);
}

</script>

<style>
    #preview-image {
        transition: opacity 0.3s ease-in-out;
    }
</style>