<div class="productimgname">
    @if ($row->image_url)
        <a href="javascript:void(0);" class="product-img stock-img">
            <img src="{{ $row->image_url ?? URL::asset('/build/img/products/product15.jpg') }}" alt="product" class="img-fluid rounded">
        </a>
    @elseif (!empty($row->images) && isset($row->images[0]['path']))
        <a href="javascript:void(0);" class="product-img stock-img">
            <img src="{{ $row->images[0]['path'] }}" alt="product" class="img-fluid rounded">
        </a>
    @elseif($row->image_url===null)
        <a href="javascript:void(0);" class="product-img stock-img">
            <img src="{{ URL::asset('/build/img/products/product15.jpg') }}" alt="product" class="img-fluid rounded">
        </a>
    @endif
    <a href="javascript:void(0);">{{ $row->name }}</a>
</div>
