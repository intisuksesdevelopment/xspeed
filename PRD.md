# XSpeed - Inventory Management & Point of Sale (POS) System

## Product Requirements Document (PRD)

---

## 1. Project Overview

### Project Name
**XSpeed** - Inventory Management & POS System

### Project Type
Full-stack web application (Laravel + Blade templates + Alpine.js/jQuery)

### Core Functionality
A comprehensive inventory management system with integrated Point of Sale (POS) functionality for managing products, stocks, warehouses, suppliers, customers, and sales transactions.

### Target Users
- **Store Owners/Managers**: Manage inventory, view sales reports
- **Cashiers**: Process sales transactions via POS
- **Warehouse Staff**: Manage stock levels, receiving goods
- **Administrators**: Full system access including user management

---

## 2. Technology Stack

### Backend
- **Framework**: Laravel 10.x (PHP 8.x)
- **Database**: MySQL/MariaDB
- **Authentication**: Session-based with custom middleware

### Frontend
- **Templates**: Blade (Laravel)
- **JavaScript**: Alpine.js, jQuery
- **CSS**: Custom styling with Bootstrap 5 base
- **Icons**: Feather Icons, Font Awesome, Boxicons
- **UI Components**: Owl Carousel, DataTables, Select2

### Key Libraries
- Spatie Laravel Permission (implied)
- Maatwebsite Excel (exports/imports)
- Bootstrap 5.x modals & components

---

## 3. Module Structure

### 3.1 Inventory Management Modules

#### Products (`/product`)
- [x] Product List (with pagination, search, filters by warehouse/brand/sort)
- [x] Product Add Form (multi-section accordion)
- [x] Product Edit Form
- [x] Product Details View
- [x] Product Delete (with confirmation modal)
- [ ] Product Barcode Generation
- [ ] Product Column View
- [ ] Product Import/Export

#### Stock Management (`/stock`)
- [ ] Stock List View
- [ ] Add Stock
- [ ] Stock Adjustment History
- [ ] Low Stock Alerts
- [ ] Stock Opname (Stocktake)

#### Warehouse Management (`/warehouse`)
- [x] Warehouse List
- [ ] Warehouse Details
- [ ] Assign racks to warehouse

#### Rack Management (`/rack`)
- [x] Rack List
- [ ] Rack Assignment to Products

#### Categories (`/category`)
- [x] Category List
- [x] Sub-categories
- [ ] Category CRUD with image upload

#### Brands (`/brand`)
- [x] Brands List
- [ ] Brand CRUD with image upload

#### Units (`/unit`)
- [x] Units List
- [ ] Unit CRUD

#### Suppliers (`/supplier`)
- [x] Suppliers List
- [ ] Supplier Details & Purchase History

#### Store Settings (`/store`)
- [x] Store Settings View
- [ ] Store Configuration (name, address, logo)

---

### 3.2 Point of Sale (POS) Module

#### POS Interface (`/pos`)
- [x] Category-based product browsing (Owl Carousel tabs)
- [x] Product grid display with images, stock, prices
- [x] Order cart sidebar
- [x] Real-time transaction ID generation
- [x] Reset transaction
- [x] View recent orders
- [ ] Payment method selection
- [ ] Discount application
- [ ] Tax calculation
- [ ] Multiple payment split
- [ ] Receipt generation/print
- [ ] Customer assignment to order
- [ ] Quick search products

#### Sales Management (`/sales`)
- [x] Sales List View
- [x] Sales Add Form
- [x] Sales Invoices View
- [ ] Sales Return/Refund
- [ ] Daily/Period Reports

#### Orders (`/order`)
- [x] Order List
- [x] Order Add Form
- [ ] Order Status Tracking

---

### 3.3 Customer Management (`/customer`)

- [x] Customer List
- [ ] Customer Add/Edit/Delete
- [ ] Customer Profile
- [ ] Customer Purchase History
- [ ] Customer Points/Rewards

---

### 3.4 User Management (`/user`)

- [x] User List
- [ ] User Add/Edit/Delete
- [ ] Role Assignment
- [ ] User Permissions

---

### 3.5 Dashboard & Reporting

#### Admin Dashboard (`/admin/dashboard`)
- [ ] Sales Overview Cards
- [ ] Recent Orders
- [ ] Top Products Chart
- [ ] Low Stock Alerts
- [ ] Daily/Weekly/Monthly Sales

#### Sales Dashboard (`/sales/dashboard`)
- [ ] Today's Sales
- [ ] Transaction Count
- [ ] Payment Methods Breakdown
- [ ] Quick Actions

---

## 4. UI/UX Features

### Global UI Components
- [x] Main Layout with sidebar navigation
- [x] Header with user menu and theme settings
- [x] Breadcrumb navigation
- [x] Dark/Light mode toggle
- [x] Collapsible sidebar
- [x] Responsive design (Bootstrap 5)

### Modal Patterns (as per design system)
- Custom modal header with `custom-modal-header` class
- Delete confirmation modals with `modal-deletecontent` styling
- Form modals with `custom-modal-body`
- Footer buttons: `btn-cancel` (gray), `btn-submit` (orange #FF9F43)

### Table Features
- DataTables integration for paginated/sorted tables
- Search and filter capabilities
- Bulk actions support
- Column visibility toggle

### Form Components
- Select2 dropdowns for searchable selects
- Accordion sections for multi-step forms
- Image upload with preview
- Date/datetime pickers

---

## 5. API Endpoints

### Products API
```
GET    /api/products (paged)       - Paginated product list
GET    /api/products/{id}          - Product details
POST   /api/products              - Create product
PUT    /api/products/{id}         - Update product
DELETE /api/products/{id}         - Delete product
```

### Categories API
```
GET    /api/categories            - All categories
GET    /api/categories/{id}/items - Items by category
```

### Warehouses API
```
GET    /api/warehouses            - All warehouses
```

### Brands API
```
GET    /api/brands                - All brands
```

### Stocks API
```
GET    /api/stocks                - Stock list
POST   /api/stocks/adjust         - Adjust stock
```

---

## 6. Database Schema

### Core Tables
- `items` - Products/Items
- `categories` - Product categories
- `sub_categories` - Sub-categories
- `brands` - Product brands
- `units` - Measurement units
- `warehouses` - Storage locations
- `racks` - Shelf locations within warehouses
- `stocks` - Stock quantities per item/warehouse
- `stock_data` - Stock movement history

### Transaction Tables
- `orders` - Sales orders
- `order_items` - Order line items
- `sales` - Sales transactions
- `sale_data` - Sale details
- `payments` - Payment records
- `payment_methods` - Available payment types
- `banks` - Bank records
- `bank_accounts` - Bank account records

### Reference Tables
- `customers` - Customer information
- `suppliers` - Supplier information
- `contacts` - Contact information
- `stores` - Store configuration
- `images` - Product/media images
- `discounts` - Discount rules
- `users` - System users
- `configs` - System configuration

---

## 7. Feature Priority

### Phase 1: Core Inventory (MVP)
1. [x] Product CRUD with images
2. [x] Product List with filters
3. [x] Stock tracking per warehouse
4. [x] Category management
5. [x] Brand management
6. [x] Warehouse management
7. [x] Rack management

### Phase 2: POS System
1. [x] POS interface with category tabs
2. [x] Product selection and cart
3. [ ] Payment processing
4. [ ] Receipt generation
5. [ ] Sales recording

### Phase 3: Business Operations
1. [ ] Purchase orders to suppliers
2. [ ] Stock adjustment workflow
3. [ ] Customer loyalty program
4. [ ] Supplier management

### Phase 4: Reporting & Analytics
1. [ ] Sales reports (daily, weekly, monthly)
2. [ ] Inventory valuation
3. [ ] Top selling products
4. [ ] Low stock alerts
5. [ ] Profit margin analysis

### Phase 5: Advanced Features
1. [ ] Multi-store support
2. [ ] Barcode generation
3. [ ] Data import/export (Excel)
4. [ ] User roles & permissions
5. [ ] Audit trail

---

## 8. Current File Structure

```
resources/views/pages/
├── admin/                    # Admin dashboard
├── auth/                     # Login/Register
├── brand/                    # Brand management
├── categories/              # Category management
├── customer/                # Customer management
├── dashboard/               # Main dashboard
├── orders/                  # Order management
├── pos/                      # Point of Sale
├── products/                # Product management
│   ├── product-add.blade.php
│   ├── product-column.blade.php
│   ├── product-details.blade.php
│   ├── product-edit.blade.php
│   └── product-list.blade.php
├── rack/                    # Rack management
├── sales/                   # Sales management
├── store/                   # Store settings
├── stocks/                  # Stock management
├── supplier/                # Supplier management
├── unit/                    # Unit management
├── user/                    # User management
├── warehouse/               # Warehouse management
└── components/              # Reusable components

app/
├── Http/Controllers/
│   ├── ItemController.php
│   ├── PosController.php
│   ├── SalesController.php
│   ├── OrderController.php
│   ├── StockController.php
│   ├── CustomerController.php
│   ├── BrandController.php
│   ├── CategoryController.php
│   ├── WarehouseController.php
│   ├── RackController.php
│   ├── SupplierController.php
│   ├── UnitController.php
│   ├── StoreController.php
│   └── UserController.php
├── Models/
│   ├── Item.php
│   ├── Order.php
│   ├── Sale.php
│   ├── Stock.php
│   ├── Customer.php
│   ├── Brand.php
│   ├── Category.php
│   ├── Warehouse.php
│   └── ...
└── Services/
    ├── ItemService.php
    ├── PosService.php
    ├── SalesService.php
    ├── OrderService.php
    ├── StockService.php
    └── ...
```

---

## 9. Design Tokens (Current Theme)

### Colors
| Token | Hex | Usage |
|-------|-----|-------|
| Primary | `#FF9F43` | Primary buttons, highlights |
| Orange Hover | `#ff8510` | Button hover states |
| Danger | `#FF0000` | Delete actions, alerts |
| Dark Blue | `#092C4C` | Headers, titles |
| Gray | `#67748E` | Cancel buttons, secondary text |
| Light Gray | `#FAFBFE` | Modal headers, backgrounds |
| Subtitle | `#B8BCC9` | Secondary text |

### Typography
- Font: System fonts (San Francisco, Segoe UI, Roboto)
- Headings: 700 weight, 18-20px
- Body: 14-15px, 400-500 weight

### Spacing
- Base unit: 5px
- Modal padding: 24px
- Card padding: 20-24px

---

## 10. Development Notes

### Alpine.js Component Patterns
```javascript
function productTable() {
    return {
        items: [],
        loading: false,
        page: 1,
        perPage: 10,
        filters: { search: '', warehouse: '', brand: '' },
        async fetchProducts() { ... }
    }
}
```

### Blade Component Usage
```blade
@component('pages.components.breadcrumb')
    @slot('title') Page Title @endslot
    @slot('li_1') Breadcrumb Item @endslot
@endcomponent
```

### Modal Confirmation Pattern
- Use `modal-deletecontent` for delete confirmations
- Include warning icon and centered text
- Actions: Cancel (`btn-cancel`), Confirm (`btn-submit` or themed danger button)

---

*Document Version: 1.0*
*Last Updated: 2026-05-25*