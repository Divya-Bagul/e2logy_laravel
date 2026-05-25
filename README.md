# Employee Management System

A Laravel 10 web application for managing employees with departments and managers. The UI uses Blade templates and Bootstrap 5, with server-side search, filters, pagination, and modal-based create/edit forms.

## Features

- **Employee list** — Paginated table (10 per page) with department and manager names
- **Search & filters** — Filter by name, department, manager, and joining date range
- **CRUD operations** — Create, update, and delete employees via Bootstrap modals
- **Validation** — Form requests with unique employee codes and foreign key checks
- **Lookup data** — Departments and managers as related tables with seed data
- **Data integrity** — Foreign keys restrict deleting departments/managers that still have employees

## Tech Stack

| Layer        | Technology                          |
| ------------ | ----------------------------------- |
| Framework    | Laravel 10.x                        |
| Language     | PHP 8.1+                            |
| Database     | MySQL                               |
| Frontend     | Blade, Bootstrap 5 (CDN)            |
| HTTP client  | Guzzle (Laravel default)            |

## Prerequisites

- PHP >= 8.1 with extensions: `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`
- [Composer](https://getcomposer.org/)
- MySQL 5.7+ or MariaDB (e.g. via XAMPP, WAMP, or standalone)
- Git (optional)

## Installation

### 1. Clone the repository

```bash
git clone <repository-url>
cd E2logy_laravel
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Environment setup

```bash
copy .env.example .env   # Windows
# cp .env.example .env   # macOS / Linux

php artisan key:generate
```

Edit `.env` and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e2logy_laravel
DB_USERNAME=root
DB_PASSWORD=
```

Create the MySQL database before migrating:

```sql
CREATE DATABASE e2logy_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Run migrations and seeders

```bash
php artisan migrate --seed
```

To reset the database and reload sample data:

```bash
php artisan migrate:fresh --seed
```

### 5. Start the development server

```bash
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000) — the home URL redirects to the employee list.

## Sample Data

After seeding, the application includes:

| Type         | Count | Examples                                      |
| ------------ | ----- | --------------------------------------------- |
| Departments  | 6     | Sales, HR, IT, Marketing, Finance, Operations |
| Managers     | 4     | Michael Lee, Sarah Miller, David Chen, …      |
| Employees    | 10    | E001–E010 with varied joining dates           |

## Routes

| Method | URI                    | Action   | Description              |
| ------ | ---------------------- | -------- | ------------------------ |
| GET    | `/`                    | redirect | Redirects to `/employees` |
| GET    | `/employees`           | index    | List with filters        |
| POST   | `/employees`           | store    | Create employee          |
| PUT    | `/employees/{employee}`| update   | Update employee          |
| DELETE | `/employees/{employee}`| destroy  | Delete employee          |

Query parameters on `GET /employees`: `search`, `department_id`, `manager_id`, `joining_from`, `joining_to`, `page`.

## Database Schema

```
departments (id, name [unique])
    └── employees.department_id

managers (id, name)
    └── employees.manager_id

employees (
    id, full_name, employee_code [unique],
    department_id, manager_id, joining_date,
    email, phone, address, timestamps
)
```

**Foreign keys:** `department_id` and `manager_id` use `restrictOnDelete()` so related lookup rows cannot be removed while employees still reference them.

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── EmployeeController.php
│   └── Requests/
│       ├── StoreEmployeeRequest.php
│       └── UpdateEmployeeRequest.php
└── Models/
    ├── Department.php
    ├── Employee.php
    └── Manager.php

database/
├── migrations/
│   ├── 2026_05_25_000001_create_departments_table.php
│   ├── 2026_05_25_000002_create_managers_table.php
│   └── 2026_05_25_000003_create_employees_table.php
└── seeders/
    ├── DatabaseSeeder.php
    ├── DepartmentSeeder.php
    ├── ManagerSeeder.php
    └── EmployeeSeeder.php

resources/views/
├── layouts/app.blade.php
└── employees/
    ├── index.blade.php
    └── partials/form-modal.blade.php

routes/web.php
```

## Validation Rules

| Field           | Rules                                                                 |
| --------------- | --------------------------------------------------------------------- |
| `full_name`     | Required, 2–15 characters                                             |
| `employee_code` | Required, 1–6 alphanumeric characters, unique among active employees (soft-deleted rows ignored) |
| `email`         | Required, valid email format (regex), unique among active employees |
| `phone`         | Required, exactly 10 digits, unique among active employees |
| `department_id` | Required, exists in `departments`                                     |
| `manager_id`    | Required, exists in `managers`                                        |
| `joining_date`  | Required, valid date                                                  |
| `address`       | Required, max 500 characters                                          |

## Useful Commands

```bash
# Clear application cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run tests (if configured)
php artisan test

# Code style (Laravel Pint)
./vendor/bin/pint
```

## Troubleshooting

| Issue | Solution |
| ----- | -------- |
| `SQLSTATE[HY000] [1049] Unknown database` | Create the database in MySQL and verify `DB_DATABASE` in `.env` |
| `Access denied for user` | Check `DB_USERNAME` and `DB_PASSWORD` in `.env` |
| `No application encryption key` | Run `php artisan key:generate` |
| Empty employee list | Run `php artisan migrate --seed` |
| 419 Page Expired on form submit | Refresh the page; session may have expired |

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
