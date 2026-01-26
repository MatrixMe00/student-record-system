# Student Record System

**Version 1.0.0**

A comprehensive multi-tenant student record management system built with Laravel, designed for schools to efficiently manage students, grades, payments, and academic activities.

---

## 📋 Overview

The Student Record System is a powerful, multi-tenant web application that enables schools to manage their entire academic operations from a single platform. With support for multiple schools, role-based access control, and comprehensive features for student management, grading, payments, and reporting.

### Key Highlights

- 🏫 **Multi-School Support** - Manage multiple schools on one platform
- 👥 **Role-Based Access** - Five distinct user roles with appropriate permissions
- 📊 **Complete Grade Management** - From entry to approval and reporting
- 💰 **Payment Integration** - Paystack integration for seamless payments
- 📈 **Comprehensive Reporting** - Historical records, exports, and analytics
- 🔐 **Secure & Isolated** - School-level data isolation and security

---

## 🚀 Quick Start

### Requirements

- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- SQLite (default) or MySQL/PostgreSQL
- Web server (Apache/Nginx) or PHP built-in server

### Installation

1. **Clone or extract the project**
   ```bash
   cd student-record-system
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure Database**
   
   Edit `.env` file and set your database configuration:
   ```env
   DB_CONNECTION=sqlite
   # Or for MySQL/PostgreSQL:
   # DB_CONNECTION=mysql
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=student_records
   # DB_USERNAME=root
   # DB_PASSWORD=
   ```

6. **Run Migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed Database (Optional)**
   ```bash
   php artisan db:seed
   ```

8. **Build Frontend Assets**
   ```bash
   npm run build
   # Or for development:
   npm run dev
   ```

9. **Start Development Server**
   ```bash
   php artisan serve
   ```

   The application will be available at `http://localhost:8000`

---

## ⚙️ Configuration

### Initial Setup

1. **Access the setup page**
   - Navigate to `/setup` to create the first system administrator
   - This will activate the system

2. **School Registration**
   - After setup, register your first school
   - Complete school information and settings

3. **Configure Payment Gateway (Optional)**
   - Add Paystack API keys in system settings if using payment features
   - Configure payment accounts for schools

### Environment Variables

Key environment variables to configure:

```env
APP_NAME="Student Record System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=sqlite

# Payment Gateway (Paystack)
PAYSTACK_PUBLIC_KEY=your_public_key
PAYSTACK_SECRET_KEY=your_secret_key
PAYSTACK_MERCHANT_EMAIL=your_email
```

---

## 📚 Features

For a complete list of features, see [FEATURES.md](FEATURES.md)

### Core Features Include:

- **Student Management** - Registration, profiles, promotion
- **Grade Management** - Entry, approval, consolidation
- **Payment System** - Paystack integration, billing, debt tracking
- **Academic Management** - Classes, subjects, programs
- **Reporting** - Historical records, exports (Excel, PDF), analytics
- **BECE Management** - Candidate preparation and results
- **Teacher Remarks** - Comments and reports
- **Activity Logging** - Comprehensive audit trails

---

## 👥 User Roles

The system supports five user roles:

1. **Developer** - Full system access
2. **Superadmin** - System-wide administration
3. **School Admin** - School-level management
4. **Teacher** - Grade entry and remarks
5. **Student** - View results and manage payments

---

## 🛠️ Technology Stack

- **Backend:** Laravel 12.48.1
- **Frontend:** Tailwind CSS 3.4, Alpine.js 3.15
- **Build Tool:** Vite 7.3
- **Database:** SQLite (default), MySQL, PostgreSQL
- **Payment:** Paystack Integration
- **Export:** Excel, PDF, QR Code generation

---

## 📖 Documentation

- [Setup Guide](docs/setup-guide.md) - Complete software installation and setup instructions
- [User Documentation](docs/README.md) - Complete user guides and documentation
- [Getting Started Guide](docs/getting-started.md) - Initial setup and first steps after installation
- [Features List](FEATURES.md) - Complete feature documentation
- [Project Context](.ai/PROJECT_CONTEXT.md) - Technical architecture details

### User Guides
- [Student Guide](docs/user-guides/student-guide.md)
- [Teacher Guide](docs/user-guides/teacher-guide.md)
- [School Admin Guide](docs/user-guides/school-admin-guide.md)
- [Superadmin Guide](docs/user-guides/superadmin-guide.md)
- [Developer Guide](docs/user-guides/developer-guide.md)

---

## 🔒 Security

- Role-based access control (RBAC)
- School-level data isolation
- Password hashing (bcrypt)
- CSRF protection
- Encrypted identifiers
- Activity logging and audit trails

---

## 📝 License

This project is licensed under the MIT License.

---

## 🤝 Support

For issues, questions, or contributions, please refer to the project documentation or contact the development team.

---

## 🎯 Getting Started Guide

1. Complete installation steps above
2. Run migrations and seeders
3. Access `/setup` to create first admin
4. Register your school
5. Start adding users, classes, and students
6. Configure payment settings if needed
7. Begin using the system!

---

**Built with ❤️ using Laravel**
