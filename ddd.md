# NJ-Car-Rentals Data Flow Diagram (DFD)

## System Overview

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                         NJ-CAR-RENTALS SYSTEM                              │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## Level 0: System Context Diagram

```
┌──────────────┐          ┌──────────────────┐          ┌──────────────┐
│   Admin      │          │                  │          │   Customer   │
│  (Vehicle    │◄────────►│  NJ-CAR-RENTALS  │◄────────►│  (Browsing,  │
│  Management) │          │     SYSTEM       │          │  Renting)    │
└──────────────┘          │                  │          └──────────────┘
                          │                  │
┌──────────────┐          │                  │          ┌──────────────┐
│    Staff     │◄────────►│                  │◄────────►│   Public     │
│   (Rentals)  │          │                  │          │  (Vehicle    │
└──────────────┘          └──────────────────┘          │   Listing)   │
                                                        └──────────────┘
```

---

## Level 1: Main Data Flows

### 1. AUTHENTICATION & USER MANAGEMENT

```
┌─────────────────────────────────────────────────────────────────┐
│                    AUTHENTICATION FLOW                          │
└─────────────────────────────────────────────────────────────────┘

User Input (Email/Password)
    │
    ▼
┌──────────────────────────────┐
│  Determine User Type:        │
│  - Admin                     │
│  - Staff                     │
│  - Customer                  │
└──────────────────────────────┘
    │
    ▼
┌──────────────────────────────┐
│  Validate Credentials        │
│  (Against respective table)  │
│  - admins                    │
│  - staff                     │
│  - customers                 │
└──────────────────────────────┘
    │
    ▼
┌──────────────────────────────┐
│  Create Session/Token        │
│  (Guard-specific)            │
└──────────────────────────────┘
    │
    ▼
  Redirect to Dashboard
```

### 2. VEHICLE MANAGEMENT FLOW (Admin)

```
┌─────────────────────────────────────────────────────────────────┐
│              VEHICLE MANAGEMENT DATA FLOW                        │
└─────────────────────────────────────────────────────────────────┘

┌────────────────┐         ┌────────────────┐         ┌────────────────┐
│ Create Vehicle │         │  Edit Vehicle  │         │ Delete Vehicle │
└────────────────┘         └────────────────┘         └────────────────┘
    │                           │                           │
    ▼                           ▼                           ▼
┌────────────────────────────────────────────────────────────────┐
│           Vehicle Data Input (Admin Panel)                     │
│  - Type (Rental/Sale)                                          │
│  - Make, Model, Year                                           │
│  - Plate Number, Transmission, Seats, Fuel                     │
│  - Price (Per Day / Sale Price)                                │
│  - Image Upload                                                │
│  - GPS Settings                                                │
└────────────────────────────────────────────────────────────────┘
    │
    ▼
┌────────────────────────────────────────────────────────────────┐
│           Validate Input                                        │
│  - Required fields check                                        │
│  - Unique plate number                                         │
│  - File size/type (images)                                     │
└────────────────────────────────────────────────────────────────┘
    │
    ▼
┌────────────────────────────────────────────────────────────────┐
│           Process Image Upload                                 │
│  - Store in: storage/app/public/images/vehicles/               │
│  - Generate path: storage/images/vehicles/{filename}           │
│  - Create symlink: public/storage → storage/app/public         │
└────────────────────────────────────────────────────────────────┘
    │
    ▼
┌────────────────────────────────────────────────────────────────┐
│           Save to Database (vehicles table)                    │
│  - Store all vehicle details                                   │
│  - Store image_path                                            │
│  - Set default status: 'available'                             │
└────────────────────────────────────────────────────────────────┘
    │
    ▼
┌────────────────────────────────────────────────────────────────┐
│           Trigger Visibility                                   │
│  - If type='rental' & status='available'                       │
│    → Show on /vehicles/rental page                             │
│  - If type='sale' & status='available'                         │
│    → Show on /vehicles/sale page                               │
└────────────────────────────────────────────────────────────────┘
```

### 3. CUSTOMER REGISTRATION & BROWSING FLOW

```
┌─────────────────────────────────────────────────────────────────┐
│        CUSTOMER REGISTRATION & VEHICLE BROWSING FLOW            │
└─────────────────────────────────────────────────────────────────┘

┌──────────────────────────┐
│ Customer Registration    │
│ (Name, Email, Phone...)  │
└──────────────────────────┘
    │
    ▼
┌──────────────────────────────────────────┐
│ Validate Email (Not Exists)              │
│ Hash Password (bcrypt)                   │
└──────────────────────────────────────────┘
    │
    ▼
┌──────────────────────────────────────────┐
│ Save to customers table                  │
│ - Set loyalty_points = 0                 │
│ - Set default address = null             │
└──────────────────────────────────────────┘
    │
    ▼
┌──────────────────────────────────────────┐
│ Auto-login (auth:customer guard)         │
└──────────────────────────────────────────┘
    │
    ▼
┌─────────────────────────────────────────────────────────────────┐
│             VEHICLE BROWSING FLOW                               │
└─────────────────────────────────────────────────────────────────┘
    │
    ▼
┌──────────────────────────────────────────┐
│ Request: /vehicles/rental                │
│ Query: WHERE type='rental'               │
│        AND status='available'            │
│        AND deleted_at IS NULL            │
└──────────────────────────────────────────┘
    │
    ▼
┌──────────────────────────────────────────┐
│ Apply Filters (Optional)                 │
│ - Price range                            │
│ - Transmission                           │
│ - Seats                                  │
└──────────────────────────────────────────┘
    │
    ▼
┌──────────────────────────────────────────┐
│ Retrieve image_url via accessor          │
│ Convert: storage/images/... → /assets/.. │
│ Use symlink: public/storage/...          │
└──────────────────────────────────────────┘
    │
    ▼
┌──────────────────────────────────────────┐
│ Display Vehicle Cards with Images        │
│ - Paginate (12 per page)                 │
│ - Show: Image, Name, Price, Features     │
│ - "View Details" button                  │
└──────────────────────────────────────────┘
    │
    ▼
┌──────────────────────────────────────────┐
│ View Vehicle Details (/vehicles/{id})    │
│ - Full specs, features, description      │
│ - Rental/Sale pricing                    │
│ - GPS & availability status              │
└──────────────────────────────────────────┘
```

### 4. RENTAL MANAGEMENT FLOW

```
┌─────────────────────────────────────────────────────────────────┐
│              RENTAL MANAGEMENT DATA FLOW                         │
└─────────────────────────────────────────────────────────────────┘

Admin View Rentals
    │
    ▼
┌──────────────────────────────────────────┐
│ Query rentals table with:                │
│ - relationships: vehicle, user           │
│ - Filter by status (optional)            │
│ - Paginate: 15 per page                  │
└──────────────────────────────────────────┘
    │
    ▼
┌──────────────────────────────────────────┐
│ Display Rental List:                     │
│ - Vehicle (year, make, model, plate)     │
│ - Customer (name, email)                 │
│ - Status badge (pending/confirmed/...)   │
│ - Start date, End date                   │
│ - Total price                            │
│ - View Details button                    │
└──────────────────────────────────────────┘
    │
    ▼
┌──────────────────────────────────────────┐
│ View Rental Details (admin/rentals/{id}) │
│ - All rental data                        │
│ - Vehicle specs                          │
│ - Customer info                          │
│ - Dates & pricing breakdown              │
└──────────────────────────────────────────┘
    │
    ▼
┌──────────────────────────────────────────┐
│ Update Rental Status:                    │
│ - Pending                                │
│ - Confirmed                              │
│ - Ongoing                                │
│ - Completed                              │
│ - Cancelled                              │
└──────────────────────────────────────────┘
    │
    ▼
┌──────────────────────────────────────────┐
│ Save status to rentals.status            │
│ Update updated_at timestamp              │
└──────────────────────────────────────────┘
```

### 5. CUSTOMER MANAGEMENT FLOW

```
┌─────────────────────────────────────────────────────────────────┐
│         CUSTOMER MANAGEMENT DATA FLOW                            │
└─────────────────────────────────────────────────────────────────┘

Admin View Customers
    │
    ▼
┌──────────────────────────────────────────┐
│ Query customers table                    │
│ - Retrieve all active customers          │
│ - Paginate: 15 per page                  │
└──────────────────────────────────────────┘
    │
    ▼
┌──────────────────────────────────────────┐
│ Display Customer List:                   │
│ - Name                                   │
│ - Email (clickable to mail)              │
│ - Phone (clickable to call)              │
│ - Number of rentals (currently: 0)       │
│ - Loyalty points                         │
│ - Join date                              │
│ - Actions: View, Email                   │
└──────────────────────────────────────────┘
    │
    ▼
┌──────────────────────────────────────────┐
│ View Customer Details (admin/customers/) │
│ - Personal info (name, email, phone)     │
│ - Address                                │
│ - Account info (join date, loyalty pts)  │
│ - Rental history (empty currently)       │
│ - Vehicle inquiries                      │
└──────────────────────────────────────────┘
```

---

## Database Schema & Relationships

```
┌──────────────────────────────────────────────────────────────────┐
│                    USER MANAGEMENT TABLES                        │
└──────────────────────────────────────────────────────────────────┘

┌─────────────┐    ┌─────────────┐    ┌──────────────┐
│   admins    │    │    staff    │    │  customers   │
├─────────────┤    ├─────────────┤    ├──────────────┤
│ id (PK)     │    │ id (PK)     │    │ id (PK)      │
│ name        │    │ name        │    │ name         │
│ email       │    │ email       │    │ email        │
│ password    │    │ password    │    │ password     │
│ admin_level │    │ license_no  │    │ phone        │
│ permissions │    │             │    │ address      │
│ department  │    │             │    │ loyalty_pts  │
└─────────────┘    └─────────────┘    └──────────────┘
      │                  │                   │
      │ (auth:admin)     │ (auth:staff)      │ (auth:customer)
      │                  │                   │
      └──────────────────┴───────────────────┘
                      │
              (Guard-based routing)
```

```
┌──────────────────────────────────────────────────────────────────┐
│                  VEHICLE & RENTAL TABLES                         │
└──────────────────────────────────────────────────────────────────┘

┌─────────────────┐              ┌──────────────────┐
│   vehicles      │◄────────────►│   rentals        │
├─────────────────┤    FK        ├──────────────────┤
│ id (PK)         │              │ id (PK)          │
│ type            │              │ user_id (FK)     │
│ make            │              │ vehicle_id (FK)  │
│ model           │              │ start_date       │
│ year            │              │ end_date         │
│ plate_number    │              │ days             │
│ price_per_day   │              │ total_price      │
│ sale_price      │              │ status           │
│ transmission    │              │ pickup_location  │
│ seats           │              │ dropoff_location │
│ fuel_type       │              │ notes            │
│ features        │              └──────────────────┘
│ image_path      │
│ has_gps         │              ┌──────────────────┐
│ gps_enabled     │◄────────────►│ gps_positions    │
│ status          │    FK        ├──────────────────┤
│ deleted_at      │              │ id (PK)          │
└─────────────────┘              │ vehicle_id (FK)  │
         │                        │ latitude         │
         │                        │ longitude        │
    ┌────┴────┐                  │ timestamp        │
    │          │                  └──────────────────┘
    ▼          ▼
┌──────────┐ ┌────────────┐
│inquiries │ │ messages   │
├──────────┤ ├────────────┤
│ id       │ │ id         │
│ vehicle_ │ │ vehicle_id │
│   id (FK)│ │ customer_  │
│ customer_│ │   id (FK)  │
│   id (FK)│ │ content    │
│ message  │ │ timestamp  │
└──────────┘ └────────────┘
```

```
┌──────────────────────────────────────────────────────────────────┐
│                  ADDITIONAL TABLES                               │
└──────────────────────────────────────────────────────────────────┘

┌─────────────────┐    ┌──────────────────┐
│  transactions   │    │  subscriptions   │
├─────────────────┤    ├──────────────────┤
│ id (PK)         │    │ id (PK)          │
│ user_id (FK)    │    │ email            │
│ amount          │    │ subscribed_at    │
│ type            │    │ status           │
│ description     │    └──────────────────┘
│ status          │
└─────────────────┘
```

---

## Key Data Flow Paths

### Path 1: Vehicle Upload Flow
```
Admin Form → Validation → Image Processing → Storage (public/storage) → DB Save → Customer View
```

### Path 2: Customer Registration Flow
```
Form → Email Validation → Password Hash → DB Save → Auto Login → Dashboard
```

### Path 3: Vehicle Discovery Flow
```
Customer → /vehicles/rental → Query (type + status) → Apply Filters → Retrieve Images → Display Cards
```

### Path 4: Rental Status Update Flow
```
Admin Form → Validation → DB Update → Updated Timestamp → Email/Notification (future)
```

### Path 5: Authentication Flow
```
Login Form → Guard Detection (admin/staff/customer) → Credential Check → DB Lookup → Session Creation → Redirect
```

---

## File Storage Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                  STORAGE STRUCTURE                              │
└─────────────────────────────────────────────────────────────────┘

Storage Directory:
  └── storage/
      └── app/
          └── public/
              └── images/
                  └── vehicles/
                      ├── 2t5mWLdqyoZUFTAM48hE76xo1j1W1YVZx9rJ870X.jpg
                      ├── dtvlmHlXe51xkpJ207KcgGtJZhRU0tqH6yCYj15G.webp
                      └── ... (other vehicle images)

Public Symlink:
  public/storage/ ─► (symlink) ──► storage/app/public/

Image URL Path:
  storage/images/vehicles/{filename}
  ↓
  asset("storage/images/vehicles/{filename}")
  ↓
  http://127.0.0.1:8000/storage/images/vehicles/{filename}
  ↓
  Served via: public/storage/images/vehicles/{filename}
```

---

## Data Validation Rules

```
┌──────────────────────────────────────────────────────────────────┐
│              VALIDATION FLOW                                     │
└──────────────────────────────────────────────────────────────────┘

VEHICLES:
  ✓ type: required, in:rental,sale
  ✓ make: required, max:255
  ✓ model: required, max:255
  ✓ year: required, 1900-{currentYear+1}
  ✓ plate_number: required, unique, max:255
  ✓ transmission: required, in:manual,automatic
  ✓ seats: required, 1-20
  ✓ fuel_type: required, in:gasoline,diesel,electric,hybrid
  ✓ price_per_day: required_if:type,rental
  ✓ sale_price: required_if:type,sale
  ✓ image: nullable, image, max:2048

CUSTOMERS:
  ✓ name: required
  ✓ email: required, unique, email
  ✓ password: required, min:8, confirmed
  ✓ phone: nullable
  ✓ address: nullable

RENTALS:
  ✓ user_id: required, exists:users
  ✓ vehicle_id: required, exists:vehicles
  ✓ start_date: required, date
  ✓ end_date: required, date, after:start_date
  ✓ status: in:pending,confirmed,ongoing,completed,cancelled
```

---

## Data Security

```
┌──────────────────────────────────────────────────────────────────┐
│              SECURITY MEASURES                                   │
└──────────────────────────────────────────────────────────────────┘

Authentication:
  ├─ Guard-based system (admin, staff, customer)
  ├─ Password hashing (bcrypt)
  ├─ CSRF protection (Form tokens)
  └─ Session management

Authorization:
  ├─ Route middleware: auth:admin, auth:staff, auth:customer
  ├─ Role-based route protection
  └─ Resource authorization (future)

Database:
  ├─ Foreign key constraints
  ├─ Soft deletes for data recovery
  ├─ Encrypted sensitive fields (future)
  └─ Transaction support

File Storage:
  ├─ Image validation (type, size)
  ├─ Symlink protection (public/storage)
  ├─ File access control
  └─ Old image cleanup on update
```

---

## Data Flow Summary Table

| Flow | Input | Process | Output | Storage |
|------|-------|---------|--------|---------|
| Vehicle Upload | Admin Form | Validate → Store Image → Hash → Insert | Vehicle Created | vehicles table + public/storage |
| Customer Registration | Registration Form | Validate Email → Hash Password → Insert | Customer Created | customers table |
| Vehicle Browse | GET /vehicles/rental | Query DB → Filter → Retrieve Images | Vehicle List | Retrieved from DB + images |
| Rental Status Update | Status Dropdown | Validate Status → Update → Save | Status Updated | rentals table updated_at |
| Customer View | GET /admin/customers | Query All → Paginate → Display | Customer List | Retrieved from DB |

---

## Future Data Flows (Not Yet Implemented)

```
- Rental Creation by Customer
- Payment Processing (Transactions)
- GPS Tracking (Real-time location updates)
- Notification System (Email/SMS)
- Reviews & Ratings
- Loyalty Points System
- Reports & Analytics Dashboard
```

---

**Document Generated**: January 27, 2026
**System**: NJ-Car-Rentals
**Framework**: Laravel 12
**Database**: MySQL
