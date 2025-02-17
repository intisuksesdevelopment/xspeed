let itemSalesList = [];
document.addEventListener('DOMContentLoaded', function() {
    const productElements = document.querySelectorAll('.product-info');
    const selectElement = document.getElementById('item-select');
    const items = JSON.parse(atob(encodedItems));
    const sales = JSON.parse(atob(encodedSales));

    const salesList = document.getElementById('sales-list');

    const shippingCost = 40.21; // Fixed shipping cost
    const taxRate = 0.05; // 5% GST
    const discountRate = 0.10; // 10% discount

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

        $(selectElement).select2();

        // Event listener for Select2 change event
        $(selectElement).on('change', function() {
            const selectedItemSku = $(this).val();
            const selectedItem =items.find(item => item.sku === selectedItemSku);
            if (selectedItem) {
                addProductToSalesList(selectedItem);
            }
        });
        function calculateTotals() {
            let subtotal = 0;
            const productItems = salesList.querySelectorAll('.product-list');

            productItems.forEach(function(productItem) {
                const qty = parseFloat(productItem.querySelector('input[name="qty"]').value);
                const price = parseFloat(productItem.querySelector('.info p').innerText.replace('$', ''));
                subtotal += qty * price;
            });

            const tax = subtotal * taxRate;
            const discount = subtotal * discountRate;
            const total = subtotal + tax + shippingCost - discount;

            const options = { minimumFractionDigits: 2, maximumFractionDigits: 2 };
            document.getElementById('subtotal').innerText = subtotal.toLocaleString('de-DE', options);
            document.getElementById('tax').innerText = tax.toLocaleString('de-DE', options);
            document.getElementById('shipping').innerText = shippingCost.toLocaleString('de-DE', options);
            document.getElementById('discount').innerText = `-${discount.toLocaleString('de-DE', options)}`;
            document.getElementById('total').innerText = total.toLocaleString('de-DE', options);
            document.getElementById('grandtotal').innerText = total.toLocaleString('de-DE', options);

        }
        sales.forEach(function(sale) {
            var saleDiv = `
                <div class="default-cover p-4 mb-4">
                    <span class="badge bg-secondary d-inline-block mb-4">Order ID : #${sale.trx_id}</span>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 record mb-3">
                            <table>
                                <tr class="mb-3">
                                    <td>Cashier</td>
                                    <td class="colon">:</td>
                                    <td class="text">${sale.created_by}</td>
                                </tr>
                                <tr>
                                    <td>Customer</td>
                                    <td class="colon">:</td>
                                    <td class="text">${sale.cust_name}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-12 col-md-6 record mb-3">
                            <table>
                                <tr>
                                    <td>Total</td>
                                    <td class="colon">:</td>
                                    <td class="text">${sale.final_total} ${sale.currency.toUpperCase()}</td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td class="colon">:</td>
                                    <td class="text">${convertTimestamp(sale.created_at)}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <p class="p-4">${sale.description}</p>
                    <div class="btn-row d-sm-flex align-items-center justify-content-between">
                        <a href="javascript:void(0);" class="btn btn-info btn-icon flex-fill">Open</a>
                        <a href="javascript:void(0);" class="btn btn-danger btn-icon flex-fill">Products</a>
                        <a href="javascript:void(0);" class="btn btn-success btn-icon flex-fill">Print</a>
                    </div>
                </div>
            `;

            if (sale.payment_status === 2) {
                document.getElementById('sales-hold-list').innerHTML += saleDiv;
            } else if (sale.payment_status === 1) {
                document.getElementById('sales-unpaid-list').innerHTML += saleDiv;
            } else if (sale.payment_status === 0) {
                document.getElementById('sales-paid-list').innerHTML += saleDiv;
            }
        });
        function generateTransactionID() {
            const unixTimestamp = Math.floor(Date.now() / 1000);
            const randomNumber = Math.floor(100000 + Math.random() * 900000);
            return `${unixTimestamp}${randomNumber}`;
        }
        function updateSalesItemCount() {
            const itemCount = salesList.querySelectorAll('.product-list').length;
            document.getElementById('sales-item-count').innerText = itemCount;
            calculateTotals();
        }
        window.removeSalesItem = function(itemId) {
            const salesItem = document.getElementById(`sales-item-${itemId}`);
            if (salesItem) {
                salesItem.remove();
                removeItem(itemId);
                updateSalesItemCount();
            }            
        };
        document.getElementById('transaction-id').innerText = generateTransactionID();

        productElements.forEach(function(productElement) {
            productElement.addEventListener('click', function() {
                const itemId = this.id.split('-')[1];
                const selectedItem = items.find(item => item.sku === itemId);
                addProductToSalesList(selectedItem);
            });
        });
        selectElement.addEventListener('change', function() {
            const selectedItemSku = this.value;
            const selectedItem = items.find(item => item.sku === selectedItemSku);
            if (selectedItem) {
                addProductToSalesList(selectedItem);
            }
        });
        function addProductToSalesList(item) {
            const itemId = item.sku;
            let itemQty = 1;
            const itemName = item.name;
            const itemImage = item.image_url;
            const itemPrice = item.sell_price;
            const itemStock = item.stock;

            let existingProduct = salesList.querySelector(`.product-info[data-item="${itemId}"]`);
            if (existingProduct) {
                let qtyInput = document.getElementById("qty-" + itemId);
                itemQty = parseInt(qtyInput.value) + 1;
                qtyInput.value = itemQty; // Update the quantity input value
            } else {
                let productHtml = `
                    <div class="product-list d-flex align-items-center justify-content-between" id="sales-item-${itemId}">
                        <div class="d-flex align-items-center product-info" data-item="${itemId}">
                            <a href="javascript:void(0);" class="img-bg">
                                <img src="${itemImage}" alt="Products">
                            </a>
                            <div class="info">
                                <span>PT0005</span>
                                <h6><a href="javascript:void(0);">${itemName}</a></h6>
                                <p>${itemPrice}</p>
                            </div>
                        </div>
                        <div class="qty-item text-center">
                            <div class="d-none">
                                <span id="sales-stock-${itemId}">${itemStock}</span>
                                <span id="sales-price-${itemId}">${itemPrice}</span>
                            </div>
                            <a href="javascript:void(0);" class="dec d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="minus"><i data-feather="minus-circle" class="feather-14"></i></a>
                            <input type="text" class="form-control text-center" id="qty-${itemId}" name="qty" value="${itemQty}">
                            <a href="javascript:void(0);" class="inc d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="plus"><i data-feather="plus-circle" class="feather-14"></i></a>
                        </div>
                        <div class="d-flex align-items-center action">
                            <a class="btn-icon edit-icon me-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-product">
                                <i data-feather="edit" class="feather-14"></i>
                            </a>
                            <a class="btn-icon delete-icon confirm-text" href="javascript:void(0);" onclick="removeSalesItem('${itemId}')">
                                <i data-feather="trash-2" class="feather-14"></i>
                            </a>
                        </div>
                    </div>
                `;
                salesList.innerHTML += productHtml;
                feather.replace();
            }
            updateSalesItemCount();
            addItem(item);
        }
        function addItem(item) {
            let existingItem = itemSalesList.find(i => i.id === item.id);
        
            if (existingItem) {
                // Update the existing item and increment the quantity
                existingItem.qty += 1;
                console.log(`Item updated:`, existingItem);
            } else {
                // Add the new item and set quantity to 1
                item.qty = 1;
                itemSalesList.push(item);
                console.log('Item added:', itemSalesList);
            }
        }
        
        // Function to remove an item by ID
        function removeItem(id) {
            itemSalesList = itemSalesList.filter(item => item.id !== id);
            console.log('Item removed:', itemSalesList);
        }
        function updateQty(id, qty) {
            // Find the index of the item with the specified id
            let itemIndex = itemSalesList.findIndex(item => item.id === id);
            if (itemIndex !== -1) {
                // Update the quantity of the found item
                itemSalesList[itemIndex].qty = qty;
                console.log('Item updated:', itemSalesList[itemIndex]);
            } else {
                console.error(`Item with ID ${id} does not exist.`);
            }
        }
        document.getElementById('sales-list').addEventListener("click", function (event) {
            let target = event.target;
            let qtyItem = target.closest(".qty-item");

            if (!qtyItem) return; // If not clicking inside qty-item, do nothing

            let inputField = qtyItem.querySelector("input");
            let itemId = inputField.id.replace("qty-", ""); // Extract itemId
            let stock = parseInt(document.getElementById(`sales-stock-${itemId}`).textContent, 10);
            let price = parseFloat(document.getElementById(`sales-price-${itemId}`).textContent);
            let infoDiv = qtyItem.closest(".product-list").querySelector(".info p"); // Get price display
            let qty = parseInt(inputField.value, 10);

            // Handle decrement (-)
            if (target.closest(".dec")) {
                if (qty > 1) {
                    qty--;
                    inputField.value = qty;
                    infoDiv.textContent = (price * qty).toFixed(2); // Update total price
                }
            }

            // Handle increment (+)
            if (target.closest(".inc")) {
                if (qty < stock) {
                    qty++;
                    inputField.value = qty;
                    infoDiv.textContent = (price * qty).toFixed(2); // Update total price
                } else {
                    alert("Stock limit reached!");
                }
            }
        });
        document.getElementById('posAddForm').addEventListener('submit', function(event) {
            event.preventDefault();
        
            let form = this;
            let formData = new FormData(form);
            let submitButton = document.getElementById('submit-button-id');
            submitButton.disabled = true;
        
            // Include itemSalesList in the form data
            formData.append('itemSalesList', JSON.stringify(itemSalesList));
        
            Swal.fire({
                title: "Processing...",
                text: "Please wait.",
                icon: "info",
                showConfirmButton: false,
                allowOutsideClick: false
            });
        
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                Swal.close();
                submitButton.disabled = false;
        
                const modalId = data.success ? 'success-alert-modal' : 'danger-alert-modal';
                const messageId = data.success ? 'success-message' : 'danger-message';
                let modalMessage = data.success ? data.message : 'Submission failed';
        
                // Handle nested error messages
                if (!data.success && data.message) {
                    if (typeof data.message === 'object') {
                        modalMessage = Object.values(data.message).flat().join(', ');
                    } else {
                        modalMessage = data.message;
                    }
                }
        
                document.getElementById(messageId).textContent = modalMessage;
                new bootstrap.Modal(document.getElementById(modalId)).show();
        
                console.error(modalMessage, data.error);
        
                document.getElementsByName('cancel-button').forEach(button => button.click());
        
                if (data.success) {
                    setTimeout(() => {
                        if (redirect) {
                            window.location.href = redirect;
                        } else {
                            window.location.reload();
                        }
                    }, 2000);
                }
            })
            .catch(error => {
                Swal.close();
                submitButton.disabled = false;
                document.getElementById('error-message').textContent = error.message || 'An error occurred';
                new bootstrap.Modal(document.getElementById('danger-alert-modal')).show();
                console.error('Submission failed:', error);
            });
        });
});
