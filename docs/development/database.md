# Database Schema

## Overview
This document describes the database schema for the DENR TOIS application, including tables, relationships, and important fields.

## Tables

### Users
- `id` - Primary key
- `username` - Unique username
- `email` - User's email address
- `password` - Hashed password
- `employee_id` - Foreign key to employees table
- `is_admin` - Boolean flag for admin users
- `remember_token` - For "remember me" functionality
- `created_at`, `updated_at` - Timestamps

### Employees
- `id` - Primary key
- `first_name` - Employee's first name
- `middle_name` - Middle name (optional)
- `last_name` - Last name
- `suffix` - Name suffix (e.g., Jr., Sr., III)
- `position_id` - Foreign key to positions table
- `div_sec_unit_id` - Foreign key to division/section/unit table
- `employment_status_id` - Foreign key to employment statuses
- `created_at`, `updated_at` - Timestamps

### Travel Orders
- `id` - Primary key
- `employee_id` - Foreign key to employees
- `travel_order_no` - Unique travel order number
- `purpose` - Purpose of travel
- `destination` - Travel destination
- `start_date` - Start date of travel
- `end_date` - End date of travel
- `status_id` - Foreign key to travel_order_statuses
- `created_at`, `updated_at` - Timestamps

### Travel Order Statuses
- `id` - Primary key
- `name` - Status name (e.g., "For Recommendation", "Approved")
- `description` - Status description

### Positions
- `id` - Primary key
- `name` - Position title
- `description` - Position description

### Divisions/Sections/Units
- `id` - Primary key
- `name` - Division/section/unit name
- `code` - Short code
- `description` - Description

## Relationships

### User - Employee (One-to-One)
- A user can be associated with one employee
- An employee can have one user account

### Employee - Travel Orders (One-to-Many)
- An employee can have many travel orders
- A travel order belongs to one employee

### Travel Order - Status (Many-to-One)
- A travel order has one status
- A status can be assigned to many travel orders

## Indexes
- Primary keys on all tables
- Foreign key constraints
- Unique constraints on usernames and emails
- Index on frequently queried fields

## Migrations
All database changes are managed through Laravel migrations. To create a new migration:

```bash
php artisan make:migration description_of_changes
```

## Seeders
Database seeders are available for testing and initial setup:
- `DatabaseSeeder` - Main seeder
- `UserSeeder` - Default admin user
- `ReferenceDataSeeder` - Statuses, roles, and other reference data

## Data Integrity
- Foreign key constraints
- Cascade deletes where appropriate
- Soft deletes for important data

## Performance Considerations
- Proper indexing
- Eager loading relationships
- Query optimization
- Database caching

## Backup and Maintenance
- Regular database backups
- Migration rollback capability
- Data export/import functionality
