let itemOrderList = [];
document.addEventListener('DOMContentLoaded', function() {
    const items = JSON.parse(atob(encodedItems));
    const brands = JSON.parse(atob(encodedBrands));
    const categories = JSON.parse(atob(encodedCategories));
    const subcategories = JSON.parse(atob(encodedSubcategories));

 
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

            // Clear existing options
            brandList.empty();

            // Populate the dropdown
            brands.forEach(function (brand) {
                brandList.append(new Option(brand.name, brand.id));
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
                    <td class="sorting_1">
                        <label class="checkboxs">
                            <input type="checkbox">
                            <span class="checkmarks"></span>
                        </label>
                    </td>
                    <td>${item.name }</td>
                    <td>${item.sku }</td>
                    <td>${item.stock}</td>
                    <td>${item.currency}</td>
                    <td>${item.sell_price}</td>
                    <td>${item.stock*item.sell_price}</td>
                `;
        
                // Tambahkan baris baru ke dalam tabel
                tableBody.appendChild(row);
            });
        
            console.log('Tabel berhasil diisi dengan data items');
        }
        
        
      
            $('#supplier-select').on('change', function (event) {
                const supplierId = this.value; // Get the selected supplier UUID
                const contactSelect = document.getElementById('contact-select');
        
                // Clear existing options
                contactSelect.innerHTML = '';
        
                if (supplierId) {
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
    setBrandsList();
    initItems();

});



