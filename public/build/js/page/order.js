let itemOrderList = [];
document.addEventListener('DOMContentLoaded', function() {
    const items = JSON.parse(atob(encodedItems));
    const brands = JSON.parse(atob(encodedBrands));
    const categories = JSON.parse(atob(encodedCategories));
    const subcategories = JSON.parse(atob(encodedSubcategories));
    const suppliers = JSON.parse(atob(encodedSuppliers));

 
        $('#category_id').on('change', function() {
            var selectedCategoryId = $(this).val();
            $('#subcategory_id').empty();
            $.each(subcategories, function(index, subcategory) {
                if (subcategory.category_id == selectedCategoryId) {
                    var option = $('<option>', {
                        value: subcategory.id,
                        text: subcategory.name
                    });
                    $('#subcategory_id').append(option);

                    // Select the first option that is appended
                    if (index === 0) {
                        $('#subcategory_id').val(subcategory.id);
                    }
                }
            });
        });
        function setBrandsList(){
            const brandList = $("#brand-list");
            const formattedBrands = brands.map(brand => ({
                id: brand.id,
                text: brand.name,
            }));

            // Populate select2 with data
            brandList.select2({
                dropdownParent: $("#add-order-item"),
                data: formattedBrands,
                placeholder: '-- Select a Brand --',
                allowClear: true,
            });

        }
        function setCategoryList(){
            const categoryList = $("#category-list");
            const formattedCategories = categories.map(category => ({
                id: category.id,
                text: category.name,
            }));
            categoryList.select2({
                dropdownParent: $("#add-order-item"),
                data: formattedCategories,
                placeholder: '-- Select a Category --',
                allowClear: true,
            });

        }

        function initItems() {
        
            // Cari elemen tabel <tbody> menggunakan id "item-list"
            const tableBody = document.querySelector('#item-list tbody');
        
            // Pastikan tabel body ada sebelum melanjutkan
            if (!tableBody) {
                console.error('Tabel body tidak ditemukan');
                return;
            }
        
            // Hapus baris sebelumnya (jika ada)
            tableBody.innerHTML = '';
        
            // Loop melalui data items dan tambahkan baris ke tabel
            items.forEach(item => {
                const row = document.createElement('tr');
        
                // Tambahkan kolom-kolom ke dalam baris
                row.innerHTML = `
                    <td class="sorting_1" style="cursor: pointer;">
                        <label class="checkboxs">
                            <input type="checkbox">
                            <span class="checkmarks"></span>
                        </label>
                    </td>
                    <td style="cursor: pointer;">${item.name }</td>
                    <td style="cursor: pointer;">${item.sku }</td>
                    <td style="cursor: pointer;">${item.stock}</td>
                    <td style="cursor: pointer;">${item.currency}</td>
                    <td style="cursor: pointer;">${item.sell_price}</td>
                    <td style="cursor: pointer;">${item.stock*item.sell_price}</td>
                `;
        
                // Tambahkan baris baru ke dalam tabel
                tableBody.appendChild(row);
            });
        
            console.log('Tabel berhasil diisi dengan data items');
        }
        function getCheckedData() {
            const checkedData = [];
            const table = $('#item-list').DataTable();
            itemOrderList = [];
            table.rows().nodes().to$().find('input[type="checkbox"]:checked').each(function () {
                const row = $(this).closest('tr');
                addDataItem(row.find('td:nth-child(3)').text().trim());
            });
            table.rows().nodes().to$().find('input[type="checkbox"]:not(:checked)').each(function () {
                const row = $(this).closest('tr');
                removeDataItem(row.find('td:nth-child(3)').text().trim());
            });
            renderOrderList();
        }
        function addDataItem(sku) {
            if (!itemOrderList.some(itemOrder => itemOrder.sku === sku)) { 
                let item = items.filter(item => item.sku === sku)[0];
                itemOrderList.push(item);
            }
            renderOrderList();
        }
        function updateQty(id, qty) {
            // Find the index of the item with the specified id
            let itemIndex = itemOrderList.findIndex(item => item.id === id);
            if (itemIndex !== -1) {
                // Update the quantity of the found item
                itemOrderList[itemIndex].qty = qty;
                console.log('Item updated:', itemOrderList[itemIndex]);
            } else {
                console.error(`Item with ID ${id} does not exist.`);
            }
        }
        function updateQty(event){
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
                    infoDiv.textContent = formatRupiah(price * qty);
                }
            }

            // Handle increment (+)
            if (target.closest(".inc")) {
                if (qty < stock) {
                    qty++;
                    inputField.value = qty;
                    infoDiv.textContent = formatRupiah(price * qty);
                } else {
                    alert("Stock limit reached!");
                }
            }
            itemOrderList.map(item => {
                if (item.sku === itemId) {
                    item.qty = qty;
                    return item;
                }
            });
            calculateTotals();
        }
        function removeDataItem(sku) {
            itemOrderList = itemOrderList.filter(item => item.sku !== sku);
        }
        $(document).on('dblclick', '#item-list tbody tr', function () {
            const clickedRow = $(this);
            const sku = clickedRow.find('td:nth-child(3)').text().trim();
            addDataItem(sku);
            $('#add-order-item').modal('hide');
        });
        function renderOrderList() {
            // Get the table body
            const tableBody = document.querySelector('.table.datanew tbody');
            tableBody.innerHTML = ''; // Clear existing rows
        
            // Loop through items in `itemOrderList` and render each as a table row
            itemOrderList.forEach(function (item) {
                const itemId = item.sku;
                const itemName = item.name;
                const itemCategory = item.category.name || 'N/A';
                const itemBrand = item.brand.code || 'N/A';
                const itemPrice = item.sell_price;
                const itemUnit = item.unit || 'N/A';
                const itemStock = item.stock;
                const itemCreatedBy = item.created_by || 'Unknown';
                const itemStatus = item.availability || 'Unknown';
                const itemQty = item.qty ?? 1;
        
                // Create table row HTML
                let rowHtml = `
                    <tr id="sales-item-${itemId}" class="cursor-pointer">

                        <td>
                            <label class="checkboxs">
                                <input type="checkbox">
                                <span class="checkmarks"></span>
                            </label>
                        </td>
                        <td >${itemName}</td>
                        <td>${itemId}</td>
                        <td>${itemCategory}</td>
                        <td>${itemBrand}</td>
                        <td>${formatRupiah(itemPrice)}</td>
                        <td>${itemUnit}</td>
                        <td>${itemStock}</td>
                        <td>
                            <div     class="row qty-item">
                                <div class="d-none">
                                    <span id="sales-stock-${itemId}">${itemStock}</span>
                                    <span class="price" id="sales-price-${itemId}">${itemPrice}</span>
                                </div>
                                <a href="javascript:void(0);" class="dec col d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="minus"><i data-feather="minus-circle" class="feather-14"></i></a>
                                <input type="text" class="col form-control text-center" id="qty-${itemId}" name="qty" value="${itemQty}">
                                <a href="javascript:void(0);" class="inc col d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="plus"><i data-feather="plus-circle" class="feather-14"></i></a>
                            </div> 
                        </td>
                        <td><div class="info"><p>${formatRupiah(itemPrice*itemQty)}</p></div></td>
                        <td>${itemCreatedBy}</td>
                        <td>${itemStatus}</td>
                        <td>
                            <a class="btn-icon edit-icon me-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-product">
                                <i data-feather="edit" class="feather-14"></i>
                            </a>
                            <a class="btn-icon delete-icon confirm-text" href="javascript:void(0);" onclick="removeSalesItem('${itemId}')">
                                <i data-feather="trash-2" class="feather-14"></i>
                            </a>
                        </td>
                    </tr>
                `;
        
                // Append the row to the table body
                tableBody.innerHTML += rowHtml;
                 feather.replace();
            });
        
            // Update Feather icons after rendering rows
        
            // Update item count
            // updateOrderItemCount();
            calculateTotals();
        }
        function calculateTotals() {
            let subtotal = 0;
            const productItems = document.getElementById('order-list').querySelectorAll('.product-list');

            itemOrderList.forEach(function(item) {
                let itemId = item.sku;
                const price = parseFloat(document.getElementById(`sales-price-${itemId}`).textContent);
                const qty = parseFloat(document.getElementById(`qty-${itemId}`).value);
                subtotal += qty * price;
            });
        
            // productItems.forEach(function(productItem) {
            //     let inputField = productItem.querySelector("input");
            //     let itemId = inputField.id.replace("qty-", ""); // Extract itemId
    
            //     const price = parseFloat(document.getElementById(`sales-price-${itemId}`).textContent);
            //     const qty = parseFloat(productItem.querySelector('input[name="qty"]').value);
            //     subtotal += qty * price;
            // });
            // let taxRate = parseFloat(taxSelect.value) / 100 || 0; 
            // let shippingCost = parseFloat(shippingSelect.value) || 0;
            let discountRate = parseFloat(document.getElementById('discount-value').textContent) / 100 || 0;
            // let customer = customers.filter(customer => customer.code === customerSelect.value)[0];
            // if(discountRate!=parseFloat(customer.discount) / 100){
            //     if (customer.discount != 0) {
            //         discountRate = parseFloat(customer.discount) / 100;
            //         $("#discount-select").val(parseFloat(customer.discount).toString()).change();
                    
            //     }
            // }

            
            
        
            // const tax = subtotal * taxRate;
            const discount = subtotal * discountRate;
            const total = subtotal - discount;
        
            const options = { minimumFractionDigits: 2, maximumFractionDigits: 2 };
            // document.getElementById('tax-value').innerText = taxRate*100;
            document.getElementById('discount-value').innerText = discountRate*100;
            document.getElementById('subtotal').innerText = subtotal.toLocaleString('de-DE', options);
            // document.getElementById('tax').innerText = tax.toLocaleString('de-DE', options);
            // document.getElementById('shipping').innerText = shippingCost.toLocaleString('de-DE', options);
            document.getElementById('discount').innerText = `-${discount.toLocaleString('de-DE', options)}`;
            document.getElementById('total').innerText = total.toLocaleString('de-DE', options);
            document.getElementById('grandtotal').innerText = total.toLocaleString('de-DE', options);
        }
        document.getElementById('order-list').addEventListener("click", function (event) {
            updateQty(event);
        });
        document.getElementById('order-list').addEventListener("input", function (event) {
            updateQty(event);

        });
        $('#select-all-product').on('change', function () {
            const isChecked = $(this).prop('checked');
            const table = $('#item-list').DataTable();

            // Apply to all rows in the table
            table.rows({ search: 'applied' }).nodes().to$().find('input[type="checkbox"]').prop('checked', isChecked);
            getCheckedData();

        });

        $('#item-list tbody').on('change', 'input[type="checkbox"]', function () {
            const allCheckboxes = $('#item-list tbody input[type="checkbox"]');
            const allChecked = allCheckboxes.length === allCheckboxes.filter(':checked').length;
            $('#select-all').prop('checked', allChecked);
            getCheckedData();
        });
            $('#supplier-select').on('change', function (event) {
                const supplierId = this.value; // Get the selected supplier UUID
                const contactSelect = document.getElementById('contact-select');
        
                // Clear existing options
                contactSelect.innerHTML = '';
        
                if (supplierId) {
                    let supplier = suppliers.filter(supplier => supplier.uuid === supplierId)[0];
                    document.getElementById('contact-name').textContent = '';
                    document.getElementById('contact-position').textContent = '';
                    document.getElementById('contact-phone').textContent = '';
                    document.getElementById('supplier-name').textContent = '';
                    document.getElementById('supplier-address').textContent = '';
                    document.getElementById('supplier-email').textContent = '';

                    document.getElementById('discount-value').innerText = supplier.discount;
                    
                    console.log(`Fetching contacts for supplier ID: ${supplierId}`);
                    // Fetch contacts based on the selected supplier
                    fetch(`/contact/${supplierId}`) // Replace with your API endpoint
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! Status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Contacts fetched successfully:', data);
                            // Populate the contact-select dropdown
                            data.forEach(contact => {
                                const option = document.createElement('option');
                                option.value = contact.uuid; // Assuming the API returns UUIDs
                                option.textContent = contact.name; // Assuming the API returns names
                                contactSelect.appendChild(option);
                            });
                            
                        
                            document.getElementById('supplier-name').textContent = data[0].supplier_name || '-';
                            document.getElementById('supplier-address').textContent = data[0].supplier_address || '-';
                            $('#contact-select').trigger('change');
                        })
                        .catch(error => console.error('Error fetching contacts:', error));
                } else {
                    console.log('No supplier selected.');
                }
            });
            $('#contact-select').on('change', function (event) {
                const contactId = this.value; // Get the selected contact UUID
        
                if (contactId) {
                    console.log(`Fetching data for contact ID: ${contactId}`);
        
                    // Fetch contact details based on the selected contact ID
                    fetch(`/contact/${contactId}`) // Replace with your API endpoint
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! Status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(contact => {
                            console.log('Contact details:', contact);
        
                            // Update the div with contact details
                            document.getElementById('contact-name').textContent = contact[0].name || '-';
                            document.getElementById('contact-position').textContent = contact[0].position || '-';
                            document.getElementById('contact-phone').textContent = contact[0].phone || '-';
                            document.getElementById('supplier-email').textContent = contact[0].email || '-';
                        })
                        .catch(error => console.error('Error fetching contact details:', error));
                } else {
                    console.log('No contact selected');
                }
            });
        
        
    //INITIALIZE
    document.getElementById('transaction-id').innerText = generateTransactionID('ORD');
    $('#supplier-select').trigger('change');
    setBrandsList();
    setCategoryList();
    initItems();

});



