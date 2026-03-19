# 🐇 BunnyBase: Rabbitry Management Prototype

This prototype leverages the latest ecosystem features and core concepts of Laravel:

- **Frameworks:** **Laravel 13** (PHP 8.4+) and **Vue 3**.
- **Multi-Tenancy:** Implemented a single-database tenancy model where data is strictly scoped to a `Tenant` to ensure breeder privacy.
- **Service Container & Pattern:** Used Dependency Injection to decouple the **Pedigree Generation Logic** from the Controllers.
- **Queues & Jobs:** Background processing for PDF generation (conceptual build) to keep the UI snappy for the user.
- **Policies:** Authorization to ensure users can only view rabbits belonging to their specific tenant.
- **Testing:** Comprehensive test suite using **PHPUnit/Pest** covering core CRUD and pedigree recursive logic.

---

## 📋 Core Features

The application focuses on the "brain" of rabbitry management—the pedigree and data integrity.

- **Tenant-Scoped Dashboard:** View and manage rabbits belonging exclusively to your team.
- **Rabbit Register Form:** Register rabbit with essential data: **Name, Sex, Tattoo (ID), Sire (Father), and Dam (Mother)**.
- **Dynamic Pedigree Tree:** A recursive frontend component built in Vue 3 that visualizes ancestral lines.

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
