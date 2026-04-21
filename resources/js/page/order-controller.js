import { state } from './order-state.js';
import { renderOrderTable, renderTotals } from './order-ui.js';

export function addItemToOrder(item) {
    const existing = state.orderItems.find(i => i.sku === item.sku);

    if (existing) {
        existing.qty++;
    } else {
        state.orderItems.push({ ...item, qty: 1 });
    }

    recalc();
}

export function updateQty(sku, qty) {
    const item = state.orderItems.find(i => i.sku === sku);
    if (item) item.qty = qty;

    recalc();
}

export function removeItem(sku) {
    state.orderItems = state.orderItems.filter(i => i.sku !== sku);
    recalc();
}

function recalc() {
    let subtotal = 0;

    state.orderItems.forEach(item => {
        subtotal += item.qty * item.sell_price;
    });

    const discountRate = 0.1; // contoh
    const discount = subtotal * discountRate;

    state.totals = {
        subtotal,
        discount,
        total: subtotal - discount
    };

    renderOrderTable();
    renderTotals();
}