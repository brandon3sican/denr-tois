# Database Schema Documentation

## Overview
This document describes the database schema for the DENR Travel Order Information System (TOIS). The system uses MySQL/MariaDB as its database management system.

## Key Relationships

### Employee Relationships
- Each employee can have **exactly one** user account
- Each employee belongs to one **position**
- Each employee belongs to one **division/section/unit**
- Each employee has one **employment status**
- Employee relationships are enforced at both the database and application levels

### Reference Data Relationships
- **Positions** can be assigned to multiple employees
- **Divisions/Sections/Units** can contain multiple employees
- **Employment Statuses** can be assigned to multiple employees

## Sorting and Querying

### Employee Listings
- Default sort: `created_at DESC` (newest first)
- Sortable columns:
  - `first_name` - Employee's first name
  - `last_name` - Employee's last name
  - `position_id` - Sorts by position name
  - `div_sec_unit_id` - Sorts by division/section/unit name
  - `employment_status_id` - Sorts by employment status name
  - `created_at` - Date of record creation
  - `updated_at` - Date of last update

### User Listings
- Default sort: `created_at DESC` (newest first)
- Sortable columns:
  - `username` - Login username
  - `employee_id` - Sorts by employee's name (shows 'N/A' for admin)
  - `is_admin` - Sorts by admin status
  - `created_at` - Date of account creation

## Tables

## Reference Data Tables

### 1. positions
Stores job positions within the organization.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | Position name (e.g., 'Environmental Management Specialist II') |
| salary_grade | integer | Salary grade for the position |
| description | text | Detailed description of the position |
| created_at | timestamp | When the record was created |
| updated_at | timestamp | When the record was last updated |

**Relationships:**
- Has many `employees`

### 2. div_sec_units
Stores organizational units (Divisions, Sections, Units).

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | Unit name (e.g., 'Technical Services Division') |
| description | text | Additional details about the unit |
| created_at | timestamp | When the record was created |
| updated_at | timestamp | When the record was last updated |

**Relationships:**
- Has many `employees`

### 3. employment_statuses
Stores employment status types.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | Status name (e.g., 'Permanent', 'Contract of Service') |
| description | text | Additional details about the status |
| is_active | boolean | Whether this status is currently active |
| created_at | timestamp | When the record was created |
| updated_at | timestamp | When the record was last updated |

**Relationships:**
- Has many `employees`

### 4. users
Stores user account information for system access.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| username | string | Unique username for login |
| password | string | Hashed password using Laravel's bcrypt |
| is_admin | boolean | Whether the user has admin privileges |
| employee_id | bigint | Foreign key to employees table (unique, nullable for admin) |
| remember_token | string | Used for "remember me" functionality |
| created_at | timestamp | When the record was created |
| updated_at | timestamp | When the record was last updated |

**Indexes:**
- Unique index on `username`
- Unique index on `employee_id`
- Unique index on `employee_id` (allows one null for admin)

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
- Default admin user (username: `admin`, password: `admin123`)
- 10 sample employees with corresponding user accounts (passwords: `password123`)
- Reference data for positions, divisions/units, and employment statuses

### Sample User Accounts
- **Admin User**
  - Username: `admin`
  - Password: `admin123`
  - Employee: System Administrator

- **Regular Users**
  - Username format: first initial + last name (e.g., `jdelacruz`)
  - Default password: `password123`
  - Each user is linked to a unique employee record

### Employee Data
- Realistic names and positions
- Randomly generated contact information
- Balanced distribution across divisions/units
- Mix of employment statuses (Permanent, Contractual, Job Order)
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
