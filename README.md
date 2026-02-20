# 📦 Laravel Courier Management System

A comprehensive **Laravel 11** courier management application with shipment tracking, branch management, customer ledger, HRMS, and a full REST API.

---

## Features

- **Shipment Management** — Book, track, and manage shipments with auto-generated AWB numbers
- **Multi-Branch Support** — Manage multiple branches with per-branch shipment tracking
- **Customer Management** — Customer accounts with credit limits and ledger entries
- **Real-Time Tracking** — Public shipment tracking by AWB number (no auth required)
- **Rate Calculator** — Configurable courier rates by branch, weight, and service type
- **HRMS Module** — Employee management, attendance, leaves, salary, and assets
- **Task Management** — Branch-level task assignment and tracking
- **Role-Based Access Control** — Powered by Spatie Laravel Permission (7 roles)
- **REST API** — Full JSON API with Laravel Sanctum token authentication
- **Web UI** — Blade-based admin dashboard and public-facing website
- **PDF Labels & Invoices** — Shipment labels and invoices via barryvdh/laravel-dompdf
- **Bulk Operations** — Bulk shipment status updates and CSV/Excel uploads
- **QR Codes** — Per-shipment QR code generation

---

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 11 |
| Language | PHP 8.2+ |
| Auth | Laravel Sanctum (API tokens) |
| Permissions | Spatie Laravel Permission |
| Database | MySQL 8.0 (SQLite for tests) |
| Cache/Queue | Redis |
| PDF | barryvdh/laravel-dompdf |
| Excel | maatwebsite/excel |
| QR Codes | simplesoftwareio/simple-qrcode |
| Frontend | Blade + Tailwind CSS CDN |
| Container | Docker + nginx:alpine |

---

## Quick Start

### Local Development

```bash
# 1. Clone and install
git clone <repo-url> laravel-courier
cd laravel-courier
composer install

# 2. Configure environment
cp .env.example .env
php artisan key:generate

# 3. Set database credentials in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=courier_db
DB_USERNAME=root
DB_PASSWORD=secret

# 4. Run migrations and seed
php artisan migrate --seed

# 5. Start development server
php artisan serve
```

App will be available at `http://localhost:8000`.

### Docker

```bash
# Start all services (app, nginx, mysql, redis, queue worker)
docker-compose up -d

# Run migrations inside the container
docker exec courier_app php artisan migrate --seed
```

App will be available at `http://localhost:8000`.

---

## Environment Configuration

Key `.env` variables:

```dotenv
APP_NAME="Courier Management System"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=db          # Use 'db' for Docker, '127.0.0.1' for local
DB_PORT=3306
DB_DATABASE=courier_db
DB_USERNAME=courier_user
DB_PASSWORD=secret

REDIS_HOST=redis    # Use 'redis' for Docker, '127.0.0.1' for local
REDIS_PORT=6379

CACHE_STORE=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
```

---

## Database Setup

```bash
# Fresh migration with all seed data
php artisan migrate:fresh --seed

# Run individual seeders
php artisan db:seed --class=RolesAndPermissionsSeeder
php artisan db:seed --class=BranchSeeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=CustomerSeeder
php artisan db:seed --class=CourierRateSeeder
php artisan db:seed --class=ShipmentSeeder
```

---

## Default Credentials

| Role | Email | Password |
|---|---|---|
| Super Admin | superadmin@courier.com | password |
| Admin | admin@courier.com | password |
| Manager | manager@courier.com | password |
| Operator | operator@courier.com | password |
| Customer | customer@courier.com | password |

---

## API Documentation

All API endpoints are prefixed with `/api`. Authenticated routes require a Bearer token from the login endpoint.

### Authentication

#### Login
```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "admin@courier.com",
  "password": "password"
}
```
Response:
```json
{
  "user": { "id": 1, "name": "Admin User", "email": "admin@courier.com" },
  "token": "1|abc123..."
}
```

#### Register
```http
POST /api/auth/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```

#### Get Current User
```http
GET /api/auth/user
Authorization: Bearer {token}
```

#### Logout
```http
POST /api/auth/logout
Authorization: Bearer {token}
```

---

### Shipments

#### Create Shipment
```http
POST /api/shipments
Authorization: Bearer {token}
Content-Type: application/json

{
  "branch_id": 1,
  "sender_name": "John Sender",
  "sender_phone": "9876543210",
  "sender_address": "123 Main St",
  "sender_city": "Mumbai",
  "sender_state": "Maharashtra",
  "sender_pincode": "400001",
  "receiver_name": "Jane Receiver",
  "receiver_phone": "9876543211",
  "receiver_address": "456 Park Ave",
  "receiver_city": "Delhi",
  "receiver_state": "Delhi",
  "receiver_pincode": "110001",
  "weight": 1.5,
  "service_type": "standard",
  "payment_mode": "prepaid"
}
```

`service_type`: `standard` | `express` | `same_day`
`payment_mode`: `prepaid` | `cod` | `credit`

#### List Shipments
```http
GET /api/shipments?status=booked&branch_id=1&awb=HQ24
Authorization: Bearer {token}
```

#### Update Shipment Status
```http
POST /api/shipments/{id}/track
Authorization: Bearer {token}
Content-Type: application/json

{
  "status": "in_transit",
  "location": "Mumbai Hub",
  "remarks": "Package picked up"
}
```

`status` values: `booked` | `picked` | `in_transit` | `out_for_delivery` | `delivered` | `returned` | `cancelled`

#### Bulk Status Update
```http
POST /api/shipments/bulk-status
Authorization: Bearer {token}
Content-Type: application/json

{
  "awb_numbers": ["HQ2401010001", "HQ2401010002"],
  "status": "picked",
  "location": "Mumbai Hub"
}
```

---

### Public Tracking (No Auth Required)

#### Track by AWB
```http
GET /api/track/{awb_number}
```
Example: `GET /api/track/HQ2401010001`

#### Bulk Track
```http
POST /api/track/bulk
Content-Type: application/json

{ "awb_numbers": ["HQ2401010001", "DEL2401010001"] }
```

---

### Branches

```http
GET    /api/branches              # List active branches
POST   /api/branches              # Create branch
GET    /api/branches/{id}         # Get branch with users & employees
PUT    /api/branches/{id}         # Update branch
DELETE /api/branches/{id}         # Delete branch
```

Create payload:
```json
{
  "name": "Pune Branch",
  "code": "PNE",
  "city": "Pune",
  "state": "Maharashtra",
  "phone": "+91-20-12345678",
  "email": "pune@courier.com"
}
```

---

### Customers

```http
GET    /api/customers             # List customers
POST   /api/customers             # Create customer
GET    /api/customers/{id}        # Get customer
PUT    /api/customers/{id}        # Update customer
DELETE /api/customers/{id}        # Delete customer
GET    /api/customers/{id}/ledger # Get ledger entries
POST   /api/customers/{id}/ledger # Add ledger entry
```

Ledger entry payload:
```json
{
  "type": "debit",
  "amount": 1500.00,
  "reference": "INV-2024-001",
  "remarks": "Shipment charges for January",
  "transaction_date": "2024-01-15"
}
```
`type`: `debit` | `credit`

---

### Rate Calculator

#### Calculate Rate (Public)
```http
POST /api/rates/calculate
Content-Type: application/json

{
  "branch_id": 1,
  "weight": 2.5,
  "service_type": "express"
}
```

```http
GET    /api/rates        # List rates
POST   /api/rates        # Create rate
PUT    /api/rates/{id}   # Update rate
DELETE /api/rates/{id}   # Delete rate
```

---

## Modules

### Shipment Management
AWB numbers are auto-generated as `{BRANCH_CODE}{YYMMDD}{4-digit-sequence}` (e.g., `HQ2401010001`). Each status change creates a tracking entry with timestamp, location, and remarks.

### Branch Management
Each branch has a unique code used as the AWB prefix. Branches link to users, employees, customers, and shipments.

### Customer Ledger
Customers have a credit limit and running balance. Debit entries increase balance (amount owed); credit entries decrease it (payments received).

### HRMS
Employee profiles with attendance tracking, leave management, salary processing, asset allocation, and holiday calendars.

### Roles & Permissions

| Role | Key Capabilities |
|---|---|
| `super_admin` | Full access to everything |
| `admin` | All operations + user/branch management |
| `manager` | Shipments, customers, employees, reports |
| `operator` | Create and update shipments |
| `driver` | View and update shipment status |
| `customer` | Create and view shipments |
| `api_partner` | API shipment creation and tracking |

---

## Testing

```bash
# Run all tests
php artisan test

# Run a specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run a specific test class
php artisan test --filter=ShipmentApiTest
```

### Test Coverage

| Test Class | Tests | Description |
|---|---|---|
| `AuthApiTest` | 4 | Login, logout, user endpoint, invalid credentials |
| `ShipmentApiTest` | 5 | Create, public track, update status, auth guard, AWB generation |
| `BranchApiTest` | 2 | List branches, create branch |
| `CustomerApiTest` | 2 | Create customer, add ledger entry |
| `ShipmentTest` (Unit) | 2 | AWB format, branch code prefix |

Tests use in-memory SQLite with `RefreshDatabase` for full isolation.

---

## Docker Services

| Service | Container | Port |
|---|---|---|
| PHP-FPM | `courier_app` | 9000 (internal) |
| Nginx | `courier_nginx` | 8000 |
| MySQL 8.0 | `courier_db` | 3306 |
| Redis | `courier_redis` | 6379 |
| Queue worker | `courier_queue` | — |

```bash
docker-compose logs -f app              # View app logs
docker exec courier_app php artisan tinker  # Artisan access
docker-compose down                     # Stop services
docker-compose down -v                  # Stop and remove volumes
```

---

## Project Structure

```
app/
├── Http/Controllers/
│   ├── Api/          # REST API controllers (JSON responses)
│   └── Web/          # Web controllers (Blade views)
└── Models/           # Eloquent models
database/
├── factories/        # Model factories for tests
├── migrations/       # Database schema
└── seeders/          # Seed data
docker/
├── nginx/courier.conf
└── php/local.ini
tests/
├── Feature/          # API integration tests
└── Unit/             # Unit tests
resources/views/
├── layouts/          # Shared layouts
├── admin/            # Admin panel views
└── web/              # Public website views
```
