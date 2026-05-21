function paymentMethodChange() {
    const paymentSelect = document.getElementById("payment-method-select");
    const selectedOption = paymentSelect.options[paymentSelect.selectedIndex];
    const methodType = selectedOption.dataset.method;

    // Hide all conditional payment divs
    document.getElementById("div-cash").style.display = "none";
    document.getElementById("div-bank").style.display = "none";
    document.getElementById("div-account").style.display = "none";
    document.getElementById("div-credit").style.display = "none";
    document.getElementById("div-duedate").style.display = "none";

    // Reset all payment-related fields
    document.getElementById("payment_change").value = 0;
    document.getElementById("bank-select").value = 0;
    document.getElementById("account_number").value = "";
    document.getElementById("account_name").value = "";
    document.getElementById("due-date").value = "";
    document.getElementById("card_number").value = "";
    document.getElementById("installment-select").innerHTML = "";

    // Show appropriate div and handle based on method type
    switch (methodType) {
        case "Cash":
            document.getElementById("div-cash").style.display = "block";
            document.getElementById("div-payment").style.display = "block";
            break;
        case "Debit":
            document.getElementById("div-bank").style.display = "block";
            document.getElementById("div-account").style.display = "block";
            document.getElementById("div-payment").style.display = "block";
            break;
        case "Bank Transfer":
            document.getElementById("div-bank").style.display = "block";
            document.getElementById("div-account").style.display = "block";
            document.getElementById("div-payment").style.display = "block";
            break;
        case "Due Date":
            document.getElementById("div-duedate").style.display = "block";
            document.getElementById("div-payment").style.display = "block";
            break;
        default: {
            // Credit card / other payment methods with installments
            const installmentSelect = document.getElementById("installment-select");
            try {
                const installmentsData = selectedOption.dataset.installments;
                if (installmentsData) {
                    const methods = JSON.parse(installmentsData);
                    installmentSelect.innerHTML = "";
                    methods.forEach(function (method) {
                        const option = document.createElement("option");
                        option.value = method;
                        option.text = method;
                        installmentSelect.appendChild(option);
                    });
                }
            } catch (e) {
                console.error("Error parsing installment methods:", e);
            }
            document.getElementById("div-bank").style.display = "block";
            document.getElementById("div-credit").style.display = "block";
            document.getElementById("div-payment").style.display = "block";
            break;
        }
    }
}

// Sales items state (shared with blade)
let salesItems = [];

function renderSalesList() {
    const container = document.getElementById('sales-list');
    if (!container) return;

    let html = '';
    salesItems.forEach((item, index) => {
        html += `
            <div class="sales-item" data-index="${index}">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">${item.name}</h6>
                        <small class="text-muted">${formatCurrency(item.price)} x ${item.qty}</small>
                    </div>
                    <div class="text-end">
                        <strong>${formatCurrency(item.price * item.qty)}</strong>
                        <button type="button" class="btn btn-sm btn-danger ms-2" onclick="removeSalesItem(${index})">
                            <i data-feather="trash-2" class="feather-16"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
    document.getElementById('sales-item-count').textContent = salesItems.length;

    // Reinitialize feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}

function removeSalesItem(index) {
    salesItems.splice(index, 1);
    renderSalesList();
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(amount || 0);
}

$(document).ready(function () {
    document.getElementById("transaction-id").innerText =
        generateTransactionID("ORD");
});
