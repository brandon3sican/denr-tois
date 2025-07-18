# Database Schema Documentation

## Overview
This document describes the database schema for the DENR Travel Order Information System (TOIS). The system uses MySQL/MariaDB as its database management system.

## Tables

### 1. users
Stores user account information for system access.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| username | string | Unique username for login |
| password | string | Hashed password |
| is_admin | boolean | Whether the user has admin privileges |
| employee_id | bigint | Foreign key to employees table |
| remember_token | string | Used for "remember me" functionality |
| created_at | timestamp | When the record was created |
| updated_at | timestamp | When the record was last updated |

### 2. employees
Stores employee information.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| first_name | string | Employee's first name |
| middle_name | string | Employee's middle name (optional) |
| last_name | string | Employee's last name |
| position_id | bigint | Foreign key to positions table |
| employment_status_id | bigint | Foreign key to employment_statuses table |
| div_sec_unit_id | bigint | Foreign key to div_sec_units table |
| created_at | timestamp | When the record was created |
| updated_at | timestamp | When the record was last updated |

### 3. positions
Stores position information.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | Position title |
| salary | decimal(10,2) | Monthly salary for the position |
| description | text | Optional description |
| created_at | timestamp | When the record was created |
| updated_at | timestamp | When the record was last updated |

### 4. employment_statuses
Stores employment status types.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | Status name (e.g., Permanent, Contractual, etc.) |
| created_at | timestamp | When the record was created |
| updated_at | timestamp | When the record was last updated |

### 5. div_sec_units
Stores division/section/unit information.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | Division/Section/Unit name |
| created_at | timestamp | When the record was created |
| updated_at | timestamp | When the record was last updated |

### 6. travel_orders
Stores travel order information.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| purpose | text | Purpose of travel |
| destination | string | Travel destination |
| start_date | date | Start date of travel |
| end_date | date | End date of travel |
| status | string | Current status of the travel order |
| user_id | bigint | Foreign key to users table (requester) |
| created_at | timestamp | When the record was created |
| updated_at | timestamp | When the record was last updated |

### 7. travel_order_signatories
Stores signatory information for travel orders.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| travel_order_id | bigint | Foreign key to travel_orders table |
| user_id | bigint | Foreign key to users table (signatory) |
| user_type | string | Type of signatory (e.g., Recommending, Approving) |
| status | string | Approval status |
| remarks | text | Optional remarks |
| created_at | timestamp | When the record was created |
| updated_at | timestamp | When the record was last updated |

## Relationships

- A `user` belongs to one `employee` (one-to-one)
- An `employee` has one `position` (many-to-one)
- An `employee` has one `employment_status` (many-to-one)
- An `employee` belongs to one `div_sec_unit` (many-to-one)
- A `travel_order` belongs to a `user` (requester) (many-to-one)
- A `travel_order` has many `travel_order_signatories` (one-to-many)
- A `travel_order_signatory` belongs to a `user` (signatory) (many-to-one)

## Indexes

- All tables have primary key indexes on `id`
- Foreign key constraints are properly indexed
- `username` in `users` table is unique
- `email` in `users` table is unique

## Seed Data

The database includes seed data for:
- Default admin user (username: admin, password: admin123)
- Reference data for positions with corresponding salary grades
- Division/Section/Units
- Employment statuses

## Migrations

All database changes are managed through Laravel migrations, which are version controlled and can be run using:

```bash
php artisan migrate
```

To seed the database with initial data:

```bash
php artisan db:seed
```
