# myKitchen Database Schema

## Overview
Single-kitchen food ordering system using **Independent Order History** pattern - orders are snapshots that preserve data even when menu items are deleted.

---

## Tables Summary

| Table | Purpose | Key Fields |
|-------|---------|------------|
| **users** | Customer accounts | phone (unique), email, status (vip/regular/new), address |
| **owner** | Restaurant admin | email, phone, password |
| **categories** | Menu grouping | name, emoji |
| **dishes** | Menu items | name, price, image, category_id, rating, badge |
| **orders** | Order history (snapshot) | customer_phone, customer_name, status, total_price, promotion_value |
| **dish_order** | Order items (snapshot) | quantity, dish_price_at_order, dish_name_at_order, promotion_value |
| **promotions** | Discount campaigns | title, value (%), apply_to, start_date, end_date, is_active |
| **dish_promotion** | Promo ↔ Dish link | dish_id, promotion_id, dish_name_at_promotion |
| **category_promotion** | Promo ↔ Category link | category_id, promotion_id |
| **order_user** | User ↔ Order link | user_id, order_id (for registered customers) |
| **reviews** | Customer feedback | dish_name (snapshot), rating, content, user_id |
| **ingredients** | Inventory | name, quantity, unit, price_per_unit, low_stock_alert |

---

## Design Patterns

### 1. Snapshot Pattern
Fields ending in `_at_order` or `_at_promotion` preserve historical data:
- `dish_name_at_order` → dish name when ordered
- `dish_price_at_order` → price at order time
- `promotion_value` → discount applied (even if promo deleted)

**Why?** Menu changes shouldn't corrupt past orders.

### 2. No FK Constraints on Deletable Relations
Tables like `orders` and `dish_order` reference dishes/promotions **without foreign key constraints**.

**Why?** Allows free deletion of menu items without orphaning historical records.

### 3. Phone-Based Auth
Primary login via `phone` (unique) instead of email.

**Why?** More common in food delivery systems.

---

## Key Relationships

```
categories → dishes (1:many)
dishes ↔ orders (many:many via dish_order)
dishes ↔ promotions (many:many via dish_promotion)
categories ↔ promotions (many:many via category_promotion)
users ↔ orders (many:many via order_user)
users → reviews (1:many)
```

---

## Order Workflow

1. Customer browses `dishes`
2. Applies `promotion` if available
3. Creates `order` → snapshots saved in `orders` + `dish_order`
4. Status: `pending` → `in_progress` → `ready` → `delivered`
5. Data preserved forever (even if dish/promo deleted)

---

## Promotion Types

| apply_to | Scope |
|----------|-------|
| `all_menu` | Entire order discount |
| `categories` | Via `category_promotion` (all dishes in category) |
| `dishes` | Via `dish_promotion` (specific dishes only) |

---

## Status Enums

**User Status**: `new`, `regular`, `vip`  
**Order Status**: `pending`, `in_progress`, `ready`, `delivered`, `cancelled`  
**Dish Badge**: `special`, `featured`, `new`, `recommended`  
**Ingredient Unit**: `kg`, `g`, `L`, `ml`, `pcs`

---

## Running Migrations

```bash
php artisan migrate:fresh  # Fresh start
php artisan migrate         # Apply migrations
php artisan migrate:rollback # Undo last batch
```

---

**Version**: 1.0 | **Framework**: Laravel 12 | **Last Updated**: 2026-01-23
