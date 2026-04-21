// service.js

// Fetch all brands
export async function fetchBrands() {
    try {
        const res = await fetch('/api/brand/all');
        const json = await res.json();
        return json.data || [];
    } catch (error) {
        console.error('Error fetching brands:', error);
        return [];
    }
}

// Fetch all categories
export async function fetchCategories() {
    try {
        const res = await fetch('/api/category/all');
        const json = await res.json();
        return json.data || [];
    } catch (error) {
        console.error('Error fetching categories:', error);
        return [];
    }
}

// Fetch subcategories based on categoryId
export async function fetchSubcategories(categoryId) {
    try {
        const res = await fetch(`/api/subcategory/${categoryId}`);
        const json = await res.json();
        return json.data || [];
    } catch (error) {
        console.error('Error fetching subcategories:', error);
        return [];
    }
}

// Fetch all warehouses
export async function fetchWarehouses() {
    try {
        const res = await fetch('/api/warehouse/all');
        const json = await res.json();
        return json.data || [];
    } catch (error) {
        console.error('Error fetching warehouses:', error);
        return [];
    }
}

// Fetch all suppliers
export async function fetchSuppliers() {
    try {
        const res = await fetch('/api/supplier/all');
        const json = await res.json();
        return json.data || [];
    } catch (error) {
        console.error('Error fetching suppliers:', error);
        return [];
    }
}

// Fetch contacts for a specific supplier
export async function fetchContacts(supplierId) {
    try {
        const res = await fetch(`/api/contact/detail/${supplierId}`);
        const json = await res.json();
        return json.data || [];
    } catch (error) {
        console.error('Error fetching contacts:', error);
        return [];
    }
}