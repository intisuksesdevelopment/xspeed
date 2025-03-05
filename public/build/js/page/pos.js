let itemSalesList = [];
document.addEventListener('DOMContentLoaded', function() {
    const productElements = document.querySelectorAll('.product-info');
    const selectElement = document.getElementById('item-select');
    const items = JSON.parse(atob(encodedItems));
    const sales = JSON.parse(atob(encodedSales));
    const customers = JSON.parse(atob(encodedCustomers));

    const salesList = document.getElementById('sales-list');

    const customerSelect = document.getElementById('customer-select');
    const taxSelect = document.getElementById('tax-select');
    const shippingSelect = document.getElementById('shipping-select');
    const discountSelect = document.getElementById('discount-select');
    const paymentSelect = document.getElementById('payment-method-select');



    

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
                                        <p>${formatRupiah(item.sell_price)}</p>
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
            let taxRate = parseFloat(taxSelect.value) / 100 || 0; 
            let shippingCost = parseFloat(shippingSelect.value) || 0;
            let discountRate = parseFloat(discountSelect.value) / 100 || 0;
            let customer = customers.filter(customer => customer.code === customerSelect.value)[0];
            if(discountRate!=parseFloat(customer.discount) / 100){
                if (customer.discount != 0) {
                    discountRate = parseFloat(customer.discount) / 100;
                    $("#discount-select").val(parseFloat(customer.discount).toString()).change();
                    
                }
            }

            
            
        
            const tax = subtotal * taxRate;
            const discount = subtotal * discountRate;
            const total = subtotal + tax + shippingCost - discount;
        
            const options = { minimumFractionDigits: 2, maximumFractionDigits: 2 };
            document.getElementById('tax-value').innerText = taxRate*100;
            document.getElementById('discount-value').innerText = discountRate*100;
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
                        <a href="javascript:void(0);" class="btn btn-info btn-icon flex-fill" onclick="openTransaction(${sale})">Open</a>
                        <a href="javascript:void(0);" class="btn btn-success btn-icon flex-fill" onclick="printTransaction(${sale})">Print</a>
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
        function reset() {
            itemSalesList = [];
            document.getElementById('transaction-id').innerText = generateTransactionID();
            updateSalesItemCount();
            calculateTotals();
            salesList.innerHTML = '';
        }
        function generateTransactionID() {
            const unixTimestamp = Math.floor(Date.now() / 1000);
            const randomNumber = Math.floor(100000 + Math.random() * 900000);
            const transactionId = unixTimestamp+'/SLS/'+randomNumber;
            document.getElementById('trx_id').value = transactionId;
            return transactionId;
        }
        function updateSalesItemCount() {
            const itemCount = salesList.querySelectorAll('.product-list').length;
            document.getElementById('sales-item-count').innerText = itemCount;
            calculateTotals();
        }
        

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
        function updatePaymentChange() {
            // Get the payment total input value
            const paymentTotalInput = document.getElementById('payment_total');
            const totalAmountDue = document.getElementById('total');
            const paymentTotal = parseFloat(paymentTotalInput.value) || 0; // Convert to number, default to 0 if empty
    
            // Calculate the payment change
            const paymentChange = paymentTotal - totalAmountDue.value;
    
            // Update the payment change field
            const paymentChangeInput = document.getElementById('payment_change');
            paymentChangeInput.value = paymentChange >= 0 ? paymentChange.toFixed(2) : '0.00'; // Ensure 2 decimal places
        }
        function paymentMethodChange() {
            const paymentSelect = document.getElementById('payment-method-select');
            const selectedPaymentMethod = paymentSelect.options[paymentSelect.selectedIndex].text;

            document.getElementById('payment-method-select').classList.add('d-none');
            document.getElementById('div-bank').classList.add('d-none');
            document.getElementById('div-cash').classList.add('d-none');
            document.getElementById('div-account').classList.add('d-none');
            document.getElementById('div-credit').classList.add('d-none');
            document.getElementById('div-duedate').classList.add('d-none');
            document.getElementById('payment-method-select').classList.add('d-none');

            document.getElementById('payment_change').value=0;
            document.getElementById('bank-select').value=0;
            document.getElementById('account_number').value=null;
            document.getElementById('account_name').value=null;
            document.getElementById('due-date').value=null;
            document.getElementById('card_number').value=null;
            document.getElementById('installment-select').value=null;



            switch (selectedPaymentMethod) {
                case 'Cash':
                    document.getElementById('div-cash').classList.remove('d-none');
                    break;
                case 'Bank Transfer':
                    document.getElementById('div-account').classList.remove('d-none');
                    document.getElementById('div-bank').classList.remove('d-none');
                    console.log("Payment method: Bank Transfer");
                    break;
                case 'Debit':
                    document.getElementById('div-account').classList.remove('d-none');
                    document.getElementById('div-bank').classList.remove('d-none');

                    console.log("Payment method: Debit");
                    break;
                case 'Due Date':
                    document.getElementById('div-duedate').classList.remove('d-none');
                    console.log("Payment method: Due Date");
                    break;
                case undefined:
                    break;
                default:
                    console.log("Payment method: Credit");

                    const installmentSelect = document.getElementById('installment-select');
                
                    const selectedOption = paymentSelect.options[paymentSelect.selectedIndex];
                    const methods = JSON.parse(selectedOption.getAttribute('data-method'));
                
                    // Kosongkan opsi sebelumnya
                    installmentSelect.innerHTML = '';
                
                    // Tambahkan opsi baru
                    methods.forEach(function(method) {
                        const option = document.createElement('option');
                        option.value = method;
                        option.text = method;
                        installmentSelect.appendChild(option);
                    });
                    document.getElementById('div-bank').classList.remove('d-none');
                    document.getElementById('div-credit').classList.remove('d-none');

                }
        }
        function openTransaction(sale) {
           
        }
        function printTransaction(sale) {
          
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
        function validatePayment() {
            const paymentSelect = document.getElementById('payment-method-select');
            const selectedPaymentMethod = paymentSelect.options[paymentSelect.selectedIndex].text;
            let message = "";
            switch (selectedPaymentMethod) {
                case 'Cash':
                    
                    if(document.getElementById('payment_total').value == ''||
                       document.getElementById('payment_total').value ==0){
                        message = 'Please fill the payment amount';
                    }else{
                        let change = clearAmountFormat(document.getElementById('payment_total').value) - clearAmountFormat(document.getElementById('total').innerText);
                        if(change<0){
                            message = 'Amount paid must be greater than total';

                        }
                    }
                    
                    break;
                case 'Bank Transfer':
                    document.getElementById('div-bank').classList.remove('d-none');
                    console.log("Payment method: Bank Transfer");
                    break;
                case 'Debit':
                    document.getElementById('div-account').classList.remove('d-none');
                    console.log("Payment method: Debit");
                    break;
                case 'Due Date':
                    document.getElementById('div-duedate').classList.remove('d-none');
                    console.log("Payment method: Due Date");
                    break;
                case undefined:
                    break;
                default:
                    return true;
                }
                
                if (message=='')return true;
                showWarning(message);
                
                return false;
        }


        function formatThousandSeparator(input) {
            // Hapus semua karakter non-digit
            let value = input.value.replace(/[^0-9]/g, '');
    
            // Format angka dengan thousand separator
            if (value.length > 3) {
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
    
            // Update nilai input
            input.value = value;
    
            // Panggil fungsi lain jika diperlukan, misalnya updatePaymentChange()
            updatePaymentChange();
        }
        function calculateChange(input) {
            let change = clearAmountFormat(document.getElementById('payment_total').value) - clearAmountFormat(document.getElementById('total').innerText);
            if(change>=0){
                document.getElementById('payment_change').value = formatRupiah(change);
            }else{
                document.getElementById('payment_change').value = 0;

            }
        }

        function submitOrder(status) {
            if(!validatePayment()){return;};
           const form = document.getElementById('posAddForm');
           const formData = new FormData(form);
           formData.append('itemSalesList', JSON.stringify(itemSalesList));
           formData.append('status', status);

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

               const modalId = data.success ? targetModal : 'danger-alert-modal';
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
                       if (data.redirect) {
                           window.location.href = data.redirect;
                       } else {
                           window.location.reload();
                       }
                   }, 2000);
               }
           })
           .catch(error => {
               Swal.close();
               document.getElementById('error-message').textContent = error.message || 'An error occurred';
               new bootstrap.Modal(document.getElementById('danger-alert-modal')).show();
               console.error('Submission failed:', error);
           });
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
            itemSalesList.map(item => {
                if (item.sku === itemId) {
                    item.qty = qty;
                }
                return item;
            });
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

        window.removeSalesItem = function(itemId) {
            const salesItem = document.getElementById(`sales-item-${itemId}`);
            if (salesItem) {
                salesItem.remove();
                removeItem(itemId);
                updateSalesItemCount();
            }            
        };
        window.reset = function() {
            reset();  
        };
        window.calculate = function() {
            calculateTotals();  
        };
        window.paymentMethodChange = function() {
            paymentMethodChange();  
        };
        window.openTransaction = function(sale) {
            paymentMethodChange();  
        };
        window.printTransaction = function(sale) {
            paymentMethodChange();  
        };
        window.updatePaymentChange = function() {
            updatePaymentChange();  
        };
        window.submitOrder = function(id) {
            submitOrder(id);  
        };
        window.formatThousandSeparator = function(input) {
            formatThousandSeparator(input);  
        };
        window.calculateChange = function(input) {
            calculateChange(input);  
        };
        //INIT FUNCTION

        document.getElementById('transaction-id').innerText = generateTransactionID();
        paymentMethodChange();

});
