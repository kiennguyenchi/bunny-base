# 🐇 BunnyBase: Rabbitry Management Prototype

This prototype leverages the latest ecosystem features and core concepts of Laravel:

- **Framework:** **Laravel 13** (PHP 8.4+) and **Vue 3**.
- **Multi-Tenancy:** Implemented a single-database tenancy model where data is strictly scoped to a `Tenant` to ensure breeder privacy.
- **Service Container & Pattern:** Used Dependency Injection to decouple the **Pedigree Generation Logic** from the Controllers.
- **Queues & Jobs:** Background processing for PDF generation (conceptual build) to keep the UI snappy for the user.
- **Policies:** Authorization to ensure users can only view rabbits belonging to their specific tenant.
- **Testing:** Comprehensive test suite using **PHPUnit/Pest** covering core CRUD and pedigree recursive logic.

---

## 📋 Core Features

The application focuses on the "brain" of rabbitry management—the pedigree and data integrity.

- **Tenant-Scoped Dashboard:** View and manage rabbits belonging exclusively to your team.
<img width="1242" height="536" alt="Screenshot 2026-03-19 at 7 29 23 PM" src="https://github.com/user-attachments/assets/662450c0-345b-4d5e-bc1b-fcf4da034584" />

- **Rabbit Register Form:** Register rabbit with essential data: **Name, Sex, Tattoo (ID), Sire (Father), and Dam (Mother)**.
<img width="462" height="442" alt="Screenshot 2026-03-19 at 7 29 29 PM" src="https://github.com/user-attachments/assets/d302d947-b74a-4eea-a9e2-1a10eb3cfe77" />

- **Dynamic Pedigree Tree:** A recursive frontend component built in Vue 3 that visualizes ancestral lines.
<img width="1234" height="496" alt="Screenshot 2026-03-19 at 7 29 51 PM" src="https://github.com/user-attachments/assets/b8880459-f344-4563-98ff-eac2d3631483" />

---

## 🚀 Setup Guide

Follow these steps to get the prototype running locally.

### 1. Clone and Install Dependencies

```bash
composer install
```

```bash
npm install
```

### 2. Configure Environment Variables

Copy the example environment file and update your database credentials:

```bash
cp .env.example .env
```

```bash
php artisan key:generate
```

### 3. Database & Seeding

This will create the tables and seed default "Tenant" data and sample rabbits for testing:

```bash
php artisan migrate:fresh --seed
```

### 4. Running the Application

You will need two terminal windows running:

**Terminal 1 (Backend):**

```bash
php artisan serve
```

**Terminal 2 (Frontend):**

```bash
npm run dev
```

**Terminal 3 (Queue Worker - Required for PDF Export):**

```bash
php artisan queue:work
```
