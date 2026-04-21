import { state } from './order-state.js';

export function renderOrderTable() {
    const tbody = document.querySelector("#order-list tbody");
    tbody.innerHTML = "";

    state.orderItems.forEach(item => {
        tbody.innerHTML += `
            <tr>
                <td>${item.name}</td>
                <td>${item.sku}</td>
                <td>${item.qty}</td>
                <td>${formatRupiah(item.sell_price * item.qty)}</td>
            </tr>
        `;
    });
}

export function renderTotals() {
    document.getElementById("subtotal").innerText =
        formatRupiah(state.totals.subtotal);

    document.getElementById("total").innerText =
        formatRupiah(state.totals.total);
}