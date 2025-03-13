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
            const brandList = document.getElementById("brand-list");
            brandList.innerHTML = '';

            brands.forEach((brand) => {
                const option = document.createElement("option");
                option.value = brand.id; // Nilai yang akan dikirim saat form di-submit
                option.textContent = brand.name; // Teks yang ditampilkan di dropdown
                brandList.appendChild(option);
              });

        }
        document.getElementById('supplier-list').addEventListener("change", function (event) {
            const supplierId = this.value; // Get the selected supplier UUID
            const contactSelect = document.getElementById('contact-select');
        
            // Clear existing options
            contactSelect.innerHTML = '';
        
            if (supplierId) {
                // Fetch contacts based on the selected supplier
                fetch(`/api/contacts?supplier_id=${supplierId}`) // Replace with your API endpoint
                    .then(response => response.json())
                    .then(data => {
                        // Populate the contact-select dropdown
                        data.forEach(contact => {
                            const option = document.createElement('option');
                            option.value = contact.uuid; // Assuming the API returns UUIDs
                            option.textContent = contact.name; // Assuming the API returns names
                            contactSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching contacts:', error));
            }
        });   
    //INITIALIZE
    document.getElementById('transaction-id').innerText = generateTransactionID('ORD');
    setBrandsList();

});