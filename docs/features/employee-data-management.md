# Employee Data Management

## Overview
This document covers the management of employee-related reference data including Divisions/Sections/Units, Positions, and Employment Statuses.

## Divisions/Sections/Units

### Features
- Create, Read, Update, and Delete (CRUD) operations for organizational units
- Hierarchical structure support
- Description fields for additional details
- Sortable and searchable listings
- Pagination for large datasets

### Database Schema
- **Table**: `div_sec_units`
  - `id` - Primary key
  - `name` - Name of the division/section/unit
  - `description` - Additional details
  - `created_at` - Timestamp of creation
  - `updated_at` - Timestamp of last update

## Positions

### Features
- CRUD operations for job positions
- Salary grade tracking
- Position descriptions
- Employee count per position
- Sortable and searchable listings

### Database Schema
- **Table**: `positions`
  - `id` - Primary key
  - `name` - Job title/position name
  - `salary_grade` - Salary grade number
  - `description` - Job description and requirements
  - `created_at` - Timestamp of creation
  - `updated_at` - Timestamp of last update

## Employment Statuses

### Features
- CRUD operations for employment statuses
- Active/Inactive status tracking
- Employee count per status
- Sortable and searchable listings

### Database Schema
- **Table**: `employment_statuses`
  - `id` - Primary key
  - `name` - Status name (e.g., Permanent, Contract of Service)
  - `description` - Additional details
  - `is_active` - Boolean flag for active status
  - `created_at` - Timestamp of creation
  - `updated_at` - Timestamp of last update

## User Interface

### Common UI Elements
- Responsive tables with sortable columns
- Pagination controls
- Search and filter functionality
- Action buttons with tooltips
- Confirmation dialogs for destructive actions
- Form validation and error handling

### Navigation
- Sidebar menu items under "Employee Management"
- Breadcrumb navigation
- Quick action buttons

## API Endpoints

### Divisions/Sections/Units
- `GET /div-sec-units` - List all units
- `POST /div-sec-units` - Create new unit
- `GET /div-sec-units/{id}` - Show unit details
- `PUT/PATCH /div-sec-units/{id}` - Update unit
- `DELETE /div-sec-units/{id}` - Delete unit

### Positions
- `GET /positions` - List all positions
- `POST /positions` - Create new position
- `GET /positions/{id}` - Show position details
- `PUT/PATCH /positions/{id}` - Update position
- `DELETE /positions/{id}` - Delete position

### Employment Statuses
- `GET /employment-statuses` - List all statuses
- `POST /employment-statuses` - Create new status
- `GET /employment-statuses/{id}` - Show status details
- `PUT/PATCH /employment-statuses/{id}` - Update status
- `DELETE /employment-statuses/{id}` - Delete status

## Security
- All endpoints require authentication
- Role-based access control for modifications
- CSRF protection on forms
- Input validation and sanitization
- Protection against mass assignment vulnerabilities
