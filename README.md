# Task Management System (Laravel + Inertia + React)

A small but production-minded Laravel application demonstrating clean architecture, authorization, background jobs, and pragmatic frontend integration using Inertia.js and React with TypeScript.

This project is intentionally scoped to showcase **how the system is designed**, not to be a full-featured product.

---

## Overview

The application allows a project owner to view a project and manage the status of its tasks.  
When a task is completed, a background job is dispatched to handle post-completion work.

The focus of this project is:
- Clear separation of concerns
- Explicit domain logic
- Correct authorization
- Safe background processing
- Meaningful tests

---

## Tech Stack

**Backend**
- Laravel 12
- PHP Enums
- Policies for authorization
- Laravel Queues
- Pest for testing

**Frontend**
- Inertia.js
- React
- TypeScript
- Tailwind CSS (minimal usage)

---

## Architecture Highlights

### Thin Controllers
Controllers are intentionally thin and act only as HTTP boundaries.  
They handle request validation and authorization, then delegate business logic to domain actions.

### Explicit Domain Actions
Core business logic is encapsulated in action classes (e.g. `UpdateTaskStatus`) instead of being embedded in controllers.  
This makes the logic reusable and testable.

### Enum-Driven State
Task status is implemented using PHP Enums to prevent invalid state transitions and eliminate magic strings.

### Authorization via Policies
All sensitive operations are protected using Laravel policies:
- Projects can only be viewed by their owner
- Tasks can only be updated by the project owner

Authorization is enforced at the controller/action boundary, not in the UI.

### Background Jobs (Production-Ready)
When a task is completed, a queued job is dispatched with:
- Explicit retry configuration
- Backoff strategy
- Idempotent execution
- Failure handling

This ensures predictable behavior and safe retries in real-world conditions.

### Testing Strategy
- **Unit tests** for domain actions and business rules
- **Feature tests** for end-to-end workflows (HTTP → policy → action → job)
- Tests focus on behavior rather than framework internals

---

## Example Workflow

1. Authenticated project owner visits `/projects/{id}`
2. Project data and tasks are rendered via Inertia
3. Owner marks a task as completed
4. Authorization is checked via policy
5. Domain action validates the state transition
6. Task status is updated
7. Background job is dispatched safely

---

## Running the Project

### Requirements
- PHP 8.3+
- Composer
- Node.js
- A supported database (SQLite works out of the box)

### Setup

```bash
composer install
npm install
php artisan migrate --seed
npm run dev
php artisan serve
php artisan queue:work

```
### Demo Access
- A demo user and project are seeded automatically.
- Log in using the seeded demo account
- Visit /projects/1
- Update task statuses and observe background job execution
