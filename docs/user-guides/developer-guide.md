# Developer Guide

Welcome to the Developer Guide for the Student Record System. This guide covers technical aspects and developer-specific features.

## 📋 Table of Contents
1. [Overview](#overview)
2. [System Architecture](#system-architecture)
3. [Access & Permissions](#access--permissions)
4. [Development Guidelines](#development-guidelines)
5. [Database Structure](#database-structure)
6. [API Documentation](#api-documentation)
7. [Troubleshooting](#troubleshooting)

---

## Overview

### Developer Role

Developers have **full system access** including:
- Access to all schools
- System-wide administration
- All features available to other roles
- Development and debugging tools
- Database access (if configured)

### Key Responsibilities

- System maintenance and updates
- Bug fixes and improvements
- Feature development
- Technical support
- System configuration

---

## System Architecture

### Technology Stack

- **Framework:** Laravel 12.48.1
- **PHP:** 8.2+
- **Database:** SQLite (default), MySQL, PostgreSQL
- **Frontend:** Tailwind CSS 3.4, Alpine.js 3.15
- **Build Tool:** Vite 7.3

### Project Structure

```
app/
├── Http/Controllers/    # Application controllers
├── Models/              # Eloquent models
├── Middleware/          # Custom middleware
├── Requests/            # Form request validation
└── ...

database/
├── migrations/          # Database migrations
├── seeders/            # Database seeders
└── factories/          # Model factories

resources/
├── views/              # Blade templates
├── css/                # Stylesheets
└── js/                 # JavaScript

routes/
├── web.php            # Web routes
└── api.php            # API routes
```

### Multi-Tenancy

The system uses **session-based multi-tenancy**:
- School context stored in `session('school_id')`
- Models automatically scope queries by school
- Middleware enforces school context

---

## Access & Permissions

### Developer Access

Developers (role_id: 1) have:
- **Access Value:** 5 (highest)
- **Full System Access** - All features enabled
- **All Schools** - Can access any school
- **System Settings** - Can modify system configuration
- **User Management** - Can manage all users

### Accessing Schools

1. Navigate to **School Management**
2. Select any school
3. Access school data and settings
4. Switch between schools as needed

---

## Development Guidelines

### Code Standards

- Follow **PSR-12** coding standards
- Use **Laravel Pint** for code formatting
- Follow Laravel naming conventions
- Write clear, documented code

### Database

- Use **migrations** for all schema changes
- Use **seeders** for test data
- Use **factories** for model testing
- Never modify migrations after deployment

### Version Control

- Use semantic versioning
- Create feature branches: `feature/description`
- Create bugfix branches: `bugfix/description`
- Write clear commit messages

### Testing

- Write tests for new features
- Test edge cases
- Verify multi-tenant isolation
- Test role-based access control

---

## Database Structure

### Key Tables

- **users** - Central user authentication
- **schools** - Multi-tenant school entities
- **students** - Student-specific data
- **teachers** - Teacher-specific data
- **programs** - Academic classes
- **subjects** - Academic subjects
- **grades** - Individual grades
- **approve_results** - Consolidated results
- **payments** - Payment transactions
- **activity_logs** - System activity tracking

### Relationships

- Users → Students/Teachers/Admins (polymorphic)
- Schools → Students, Teachers, Programs, Subjects
- Students → Programs, Grades, Results
- Teachers → Subjects (many-to-many)

---

## API Documentation

### Authentication

The system uses **Laravel Sanctum** for API authentication:

```php
// Generate token
$token = $user->createToken('api-token')->plainTextToken;

// Authenticate request
Authorization: Bearer {token}
```

### API Endpoints

API routes are defined in `routes/api.php`. Key endpoints include:
- User management
- School data access
- Results retrieval
- Payment processing

> **Note:** Full API documentation should be generated using tools like Scribe or Swagger.

---

## Common Development Tasks

### Adding a New Feature

1. **Create Branch**
   ```bash
   git checkout -b feature/new-feature
   ```

2. **Create Migration** (if needed)
   ```bash
   php artisan make:migration create_new_table
   ```

3. **Create Model**
   ```bash
   php artisan make:model NewModel
   ```

4. **Create Controller**
   ```bash
   php artisan make:controller NewController
   ```

5. **Create Routes**
   - Add to `routes/web.php` or `routes/api.php`

6. **Create Views** (if needed)
   - Add Blade templates in `resources/views/`

7. **Test**
   - Write tests
   - Test manually
   - Verify multi-tenant isolation

8. **Commit & Merge**
   ```bash
   git add .
   git commit -m "Add new feature"
   git push
   ```

### Debugging

#### Enable Debug Mode

In `.env`:
```env
APP_DEBUG=true
APP_ENV=local
```

#### View Logs

```bash
tail -f storage/logs/laravel.log
```

#### Use Tinker

```bash
php artisan tinker
```

### Clearing Cache

```bash
# Clear all cache
php artisan optimize:clear

# Clear specific cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## Multi-Tenancy Implementation

### School Context

School context is managed via session:
```php
session(['school_id' => $school->id]);
```

### Model Scoping

Models automatically scope queries:
```php
// In Student model
public function newQuery($excludeDeleted = true)
{
    $query = parent::newQuery($excludeDeleted);
    $school_id = session('school_id') ?? null;
    if($school_id){
        $query->where('school_id', $school_id);
    }
    return $query;
}
```

### Middleware

School context is enforced via middleware:
- `school.check` - Validates school context
- Applied to relevant routes

---

## Security Considerations

### Data Isolation

- Always verify school context in queries
- Never allow cross-school data access
- Validate school_id in all operations

### Authentication

- Use Laravel's built-in authentication
- Implement proper password hashing
- Use CSRF protection

### Authorization

- Check role permissions
- Verify user belongs to school
- Use policies for complex authorization

---

## Troubleshooting

### Database Issues

**Problem:** Migrations failing

**Solution:**
- Check database connection
- Verify migration files are correct
- Run `php artisan migrate:fresh` (development only)
- Check foreign key constraints

### Cache Issues

**Problem:** Changes not reflecting

**Solution:**
- Clear cache: `php artisan optimize:clear`
- Clear config: `php artisan config:clear`
- Clear routes: `php artisan route:clear`

### Multi-Tenancy Issues

**Problem:** Data from wrong school showing

**Solution:**
- Verify session has correct school_id
- Check model scoping is working
- Review middleware application
- Check query filters

### Permission Issues

**Problem:** Users can't access features

**Solution:**
- Verify role_id assignments
- Check middleware permissions
- Review policy implementations
- Check access_value in roles table

---

## Useful Commands

```bash
# Development
php artisan serve
php artisan tinker
php artisan route:list

# Database
php artisan migrate
php artisan migrate:fresh --seed
php artisan db:seed

# Cache
php artisan optimize:clear
php artisan config:cache
php artisan route:cache

# Code Quality
./vendor/bin/pint
php artisan test
```

---

## Resources

### Documentation
- [Laravel Documentation](https://laravel.com/docs)
- [Project Context](.ai/PROJECT_CONTEXT.md)
- [Features List](../FEATURES.md)

### Support
- Review code comments
- Check Laravel documentation
- Review activity logs
- Check system error logs

---

**Last Updated:** 2026-01-22
