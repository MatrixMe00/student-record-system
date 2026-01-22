# Project Context - Student Record System

## Overview

This is a **multi-tenant Student Record Management System** built with Laravel, designed to manage student records, grades, payments, and academic activities for multiple schools. The system supports role-based access control with different user types: developers, superadmins, school admins, teachers, and students.

## Application Version

**Current Version**: 1.0.0 (as of 2026)

## Technology Stack

### Backend
- **Framework**: Laravel 12.48.1 (latest stable)
- **PHP**: 8.2+ (compatible with 8.2-8.4)
- **Database**: SQLite (default), supports MySQL/PostgreSQL
- **Authentication**: Laravel Breeze 2.3.8 with Sanctum 4.2.4
- **API**: RESTful API with Sanctum token authentication

### Frontend
- **Build Tool**: Vite 7.3.1
- **CSS Framework**: Tailwind CSS 3.4.17
- **JavaScript**: Alpine.js 3.15.4
- **HTTP Client**: Axios 1.13.2
- **PDF Generation**: Puppeteer 24.36.0 (via Browsershot 5.2.0)

### Key Packages
- **Excel Export**: Maatwebsite/Excel 3.1.67
- **QR Code Generation**: SimpleSoftwareIO/Simple-QrCode 4.2.0
- **PDF Generation**: Spatie/Browsershot 5.2.0
- **Database Abstraction**: Doctrine DBAL 3.10.4
- **HTTP Client**: Guzzle 7.10.0

## Architecture

### Multi-Tenancy
The system implements **school-based multi-tenancy** where:
- Each school operates as an independent tenant
- Data is isolated per school using `school_id` foreign keys
- Session-based school context (`session('school_id')`)
- Middleware enforces school context (`school.check`)

### User Roles & Access Control

1. **Developer** (role_id: 1, access_value: 5)
   - Full system access
   - Can manage all schools

2. **Superadmin** (role_id: 2, access_value: 4)
   - System-wide administration
   - Can manage schools, view all results
   - BECE candidate management

3. **Admin** (role_id: 3, access_value: 3)
   - School-level administration
   - User management, subject/program management
   - Payment configuration

4. **Teacher** (role_id: 4, access_value: 3)
   - Grade entry and approval
   - Teacher remarks
   - Subject assignment

5. **Student** (role_id: 5, access_value: 3)
   - View own results
   - Payment management
   - Profile management

### Core Models & Relationships

#### User Model
- Central authentication model
- Polymorphic relationship to role-specific models (Student, Teacher, Admin, SchoolAdmin)
- Uses `UserModelTrait` for dynamic model resolution
- Activity logging support

#### School Model
- Primary tenant entity
- Has many: Students, Teachers, Programs, Subjects, SchoolAdmins
- Encrypted ID for secure URL generation
- Cascading deletes for associated users

#### Student Model
- Extends User model (user_id as primary key)
- Belongs to: Program, School
- Has many: Grades, Results, ActivityLogs
- Soft delete support (`is_deleted` flag)
- Automatic school context filtering

#### Program Model (Classes)
- Represents academic classes/grade levels
- Belongs to: School
- Has many: Students
- Supports multiple programs per school

#### Subject Model
- Academic subjects taught in schools
- Belongs to: School
- Many-to-many with Teachers (via TeacherClass)

#### Grades Model
- Individual subject grades for students
- Links: Student → Subject → Result
- Status workflow: pending → accepted/rejected
- Supports class marks and exam marks

#### ApproveResults Model
- Approved/consolidated results
- Groups grades by result_token
- Supports term-based results
- Academic year tracking

### Key Features

#### 1. Student Management
- Student registration with index number generation
- Student promotion between programs
- Student status management (active/inactive)
- Soft delete support

#### 2. Grade Management
- Grade entry by teachers
- Grade approval workflow
- Result consolidation
- Term-based result organization
- Academic year tracking (format: "YYYY / YYYY")

#### 3. Payment System
- Integration with Paystack payment gateway
- Student bill management
- Debtor tracking
- Payment information management
- Payment type configuration

#### 4. BECE (Basic Education Certificate Examination)
- BECE candidate preparation
- Candidate result management
- Index number generation

#### 5. Teacher Remarks
- Teacher remarks per student
- Remark options configuration
- Term-based remarks
- Printable remark slips

#### 6. Reporting & History
- Historical result viewing
- Subject-wise result analysis
- Class result summaries
- Student result printing
- Excel export capabilities

#### 7. Activity Logging
- Comprehensive activity tracking
- User action logging
- Log type categorization
- Readable activity descriptions

### File Structure

```
app/
├── Constants/          # Application constants (LogType)
├── Console/            # Artisan commands
├── Exceptions/         # Exception handlers
├── Exports/            # Excel export classes
├── Http/
│   ├── Controllers/   # 41 controllers
│   ├── Middleware/    # 18 middleware classes
│   └── Requests/      # 42 form request validators
├── Jobs/               # Background jobs
├── Models/             # 28 Eloquent models
├── Policies/           # 17 authorization policies
├── Providers/         # Service providers
├── Traits/             # Reusable traits
└── View/               # View components

database/
├── factories/          # 18 model factories
├── migrations/         # 33 database migrations
└── seeders/            # 17 database seeders

resources/
├── css/                # Tailwind CSS
├── js/                 # Alpine.js + Axios
└── views/              # 169 Blade templates

routes/
├── web.php             # Web routes
├── api.php             # API routes
└── auth.php            # Authentication routes
```

### Middleware Stack

1. **school.check**: Validates school context in session
2. **admin**: Checks admin role (role_id <= 3)
3. **school.admin**: Checks school admin role (role_id = 2)
4. **system.admin**: Checks system admin role (role_id <= 2)
5. **student.payment-***: Payment-related access control

### Helper Functions

Located in `app/helpers.php`, key functions include:
- `get_academic_year()`: Calculate academic year from date
- `grade_value()`: Convert numeric grade to grade value (1-9)
- `grade_description()`: Get grade description (Excellent, Very Good, etc.)
- `generateIndexNumber()`: Generate unique student index numbers
- `create_id()`: Generate unique tokens for results
- `positionFormat()`: Format position numbers (1st, 2nd, etc.)
- `school()`: Get current school context
- `activity_log_icon()`: Get icon for activity types

### Database Schema Highlights

- **users**: Central user table with role-based access
- **schools**: Multi-tenant school entities
- **students**: Student-specific data (extends users)
- **teachers**: Teacher-specific data (extends users)
- **programs**: Academic classes/grade levels
- **subjects**: Academic subjects
- **grades**: Individual subject grades
- **approve_results**: Consolidated results
- **payments**: Payment transactions
- **student_bills**: Student billing information
- **teacher_remarks**: Teacher comments/remarks
- **activity_logs**: System activity tracking
- **settings**: System and school settings

### Security Features

- Role-based access control (RBAC)
- School-level data isolation
- Encrypted school IDs for URLs
- Password hashing (bcrypt)
- CSRF protection
- Sanctum API authentication
- Soft delete for data retention
- Activity logging for audit trails

### Payment Integration

- **Paystack** integration for online payments
- Bank account management
- Payment callback handling
- Payment success tracking
- Debtor list management

### Export Capabilities

- Excel export (Maatwebsite/Excel)
- PDF generation (Browsershot/Puppeteer)
- QR code generation for results
- Class list downloads

## Development Guidelines

### Code Style
- Follow PSR-12 coding standards
- Use Laravel Pint for code formatting
- Follow Laravel naming conventions

### Database
- Use migrations for all schema changes
- Use factories and seeders for testing data
- Foreign key constraints with cascade options

### Testing
- PHPUnit 11.x for unit and feature tests
- Test coverage for critical features

### Version Control
- Semantic versioning
- Feature branches
- Commit messages should be descriptive

## Environment Requirements

- PHP 8.2 or higher
- Composer 2.x
- Node.js 18.x or higher
- npm 9.x or higher
- SQLite/MySQL/PostgreSQL database

## Deployment Notes

- Ensure `.env` is properly configured
- Run migrations: `php artisan migrate`
- Seed initial data: `php artisan db:seed`
- Build assets: `npm run build`
- Optimize: `php artisan optimize`
- Set proper file permissions for storage and cache

## Known Dependencies

### Production Dependencies (composer.json)
- `php`: ^8.2
- `doctrine/dbal`: ^3.10
- `guzzlehttp/guzzle`: ^7.10
- `laravel/breeze`: ^2.0
- `laravel/framework`: ^12.0
- `laravel/sanctum`: ^4.0
- `laravel/tinker`: ^2.9
- `maatwebsite/excel`: ^3.1
- `simplesoftwareio/simple-qrcode`: ^4.2
- `spatie/browsershot`: ^5.0

### Development Dependencies (composer.json)
- `fakerphp/faker`: ^1.23
- `laravel/pint`: ^1.16
- `laravel/sail`: ^1.28
- `mockery/mockery`: ^1.6
- `nunomaduro/collision`: ^8.0
- `phpunit/phpunit`: ^11.0
- `spatie/laravel-ignition`: ^2.4

### Frontend Dependencies (package.json)
- `@tailwindcss/forms`: ^0.5.11
- `alpinejs`: ^3.15.4
- `autoprefixer`: ^10.4.20
- `axios`: ^1.13.2
- `laravel-vite-plugin`: ^2.1.0
- `postcss`: ^8.4.49
- `tailwindcss`: ^3.4.17
- `vite`: ^7.0.0
- `puppeteer`: ^24.36.0

## Future Considerations

- API versioning strategy
- Real-time notifications (Laravel Echo + Pusher/Broadcasting)
- Mobile app API endpoints
- Advanced reporting and analytics
- Bulk operations optimization
- Caching strategy for performance
- Queue system for heavy operations

## Notes

- The system uses session-based school context, not subdomain-based multi-tenancy
- Academic year format: "YYYY / YYYY" (e.g., "2024 / 2025")
- Grade system: 1 (Excellent) to 9 (Fail)
- Index numbers are auto-generated with format: `{school_id}{year}{sequence}`
- Results use token-based identification for security
