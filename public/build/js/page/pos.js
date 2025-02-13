document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#categoryList li').forEach(function(category) {
        category.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-category-id');
            const url = productCategoryRoute.replace('CATEGORY_ID', categoryId);
            const itemList = document.getElementById('content-' + categoryId);

            if (itemList) {
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        itemList.innerHTML = ''; // Clear previous items

                        data.forEach(item => {
                            let itemElement = document.createElement('div');
                            itemElement.classList.add('col-sm-2', 'col-md-6', 'col-lg-3', 'col-xl-3', 'pe-2');
                            itemElement.innerHTML = `
                                <div class="product-info default-cover card">
                                    <a href="javascript:void(0);" class="img-bg">
                                        <img src="${item.image_url}" alt="Products" style="width: 65px; height: 80px;">
                                        <span><i data-feather="check" class="feather-16"></i></span>
                                    </a>
                                    <h6 class="cat-name"><a href="javascript:void(0);">${item.category.name}</a></h6>
                                    <h6 class="product-name"><a href="javascript:void(0);">${item.name}</a></h6>
                                    <div class="d-flex align-items-center justify-content-between price">
                                        <span>${clearDecimal(item.stock)} ${item.unit}</span>
                                        <p>${item.sell_price}</p>
                                    </div>
                                </div>
                            `;
                            itemList.appendChild(itemElement);
                        });
                    });
            } else {
                console.error('Element not found: content-' + categoryId);
            }
        });
    });
});
