let itemOrderList = [];
document.addEventListener('DOMContentLoaded', function() {
    const items = JSON.parse(atob(encodedItems));
    const contacts = JSON.parse(atob(encodedContacts));
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
    //INITIALIZE
    document.getElementById('transaction-id').innerText = generateTransactionID('ORD');
    setBrandsList();

});