# Travel Order Management

## Overview
This document outlines the travel order management system in the DENR TOIS application, including creation, approval workflows, and status tracking.

## Features
- Create and manage travel orders
- Multi-step approval workflow
- Status tracking
- Document generation
- Email notifications
- Search and filtering

## Workflow

### 1. Travel Order Creation
- Employee fills out travel order form
- System validates inputs
- Draft is saved
- Email notification to submitter

### 2. Submission for Recommendation
- Employee submits for recommendation
- Status changes to "For Recommendation"
- Email notification to recommender

### 3. Recommendation
- Recommender reviews travel order
- Can approve or request changes
- If approved, status changes to "For Approval"
- Email notification to approver

### 4. Approval
- Approver reviews travel order
- Can approve, disapprove, or request changes
- If approved, status changes to "Approved"
- Email notification to employee

### 5. Completion
- Employee marks travel as completed
- Status changes to "Completed"
- Option to upload supporting documents

## Database Schema

### Tables
- `travel_orders` - Main travel order data
- `travel_order_statuses` - Status definitions
- `travel_order_signatories` - Approval chain
- `travel_order_documents` - Attached documents

### Key Fields
- `travel_order_no` - Unique identifier
- `employee_id` - Requesting employee
- `purpose` - Purpose of travel
- `destination` - Travel destination
- `start_date` - Travel start date
- `end_date` - Travel end date
- `status_id` - Current status
- `remarks` - Additional notes

## API Endpoints

### Travel Orders
- `GET /api/travel-orders` - List travel orders
- `POST /api/travel-orders` - Create new travel order
- `GET /api/travel-orders/{id}` - Get travel order details
- `PUT /api/travel-orders/{id}` - Update travel order
- `DELETE /api/travel-orders/{id}` - Delete travel order

### Workflow Actions
- `POST /api/travel-orders/{id}/submit` - Submit for recommendation
- `POST /api/travel-orders/{id}/recommend` - Recommend travel order
- `POST /api/travel-orders/{id}/approve` - Approve travel order
- `POST /api/travel-orders/{id}/reject` - Reject travel order
- `POST /api/travel-orders/{id}/complete` - Mark as completed

## User Interface

### Pages
1. **Travel Order List**
   - Filterable and sortable table
   - Status indicators
   - Quick actions

2. **Create/Edit Form**
   - Multi-step form
   - Field validation
   - Save as draft

3. **View Details**
   - Travel order summary
   - Status history
   - Document attachments
   - Approval chain

### Components
- StatusBadge - Displays status with appropriate colors
- DocumentUploader - For attaching supporting documents
- ApprovalTimeline - Visual representation of approval process
- CommentSection - For internal communication

## Security
- Role-based access control
- Data validation
- Audit logging
- CSRF protection
- Input sanitization

## Performance Considerations
- Pagination of lists
- Eager loading of relationships
- Caching of frequently accessed data
- Background processing for emails and document generation

## Testing
- Unit tests for models and services
- Feature tests for workflows
- Browser tests for UI interactions
- Performance testing for large datasets

## Dependencies
- Laravel Excel - For exports
- Barryvdh DomPDF - For PDF generation
- Spatie Media Library - For document management
- Laravel Notifications - For email notifications

## Future Enhancements
- Mobile app integration
- Real-time updates with WebSockets
- Advanced reporting
- Integration with calendar applications
- Multi-language support
