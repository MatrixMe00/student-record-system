# Software Setup Guide

Complete guide for installing and setting up EduRecordsGH Student Record Management System.

## 📋 Table of Contents

1. [System Requirements](#system-requirements)
2. [Installation Steps](#installation-steps)
3. [Environment Configuration](#environment-configuration)
4. [Database Setup](#database-setup)
5. [Initial System Setup](#initial-system-setup)
6. [Post-Setup Configuration](#post-setup-configuration)
7. [Troubleshooting](#troubleshooting)

---

## System Requirements

### Minimum Requirements

- **PHP**: 8.2 or higher
- **Composer**: 2.x or higher
- **Node.js**: 18.x or higher
- **npm**: 9.x or higher
- **Database**: SQLite (default), MySQL 5.7+, or PostgreSQL 10+
- **Web Server**: Apache 2.4+, Nginx, or PHP built-in server
- **Memory**: 512MB RAM minimum (1GB recommended)
- **Storage**: 100MB free space minimum

### Recommended Requirements

- **PHP**: 8.3 or higher
- **Memory**: 2GB RAM or higher
- **Storage**: 500MB+ for production use
- **Database**: MySQL 8.0+ or PostgreSQL 13+ for production

### PHP Extensions Required

- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PCRE
- PDO
- Tokenizer
- XML

---

## Installation Steps

### Step 1: Download/Clone the Project

If you have the project files:

```bash
cd student-record-system
```

If cloning from a repository:

```bash
git clone <repository-url>
cd student-record-system
```

### Step 2: Install PHP Dependencies

Install all required PHP packages using Composer:

```bash
composer install
```

> **Note:** If you don't have Composer installed, download it from [getcomposer.org](https://getcomposer.org/)

### Step 3: Install Node.js Dependencies

Install all required frontend packages:

```bash
npm install
```

> **Note:** If you don't have Node.js installed, download it from [nodejs.org](https://nodejs.org/)

### Step 4: Environment Configuration

1. **Copy the environment file:**

```bash
cp .env.example .env
```

2. **Generate application key:**

```bash
php artisan key:generate
```

This will automatically generate and set the `APP_KEY` in your `.env` file.

### Step 5: Configure Database

Edit the `.env` file and configure your database connection.

#### Option A: SQLite (Easiest for Development)

```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

Or for a relative path:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Create the database file:

```bash
touch database/database.sqlite
```

#### Option B: MySQL

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=student_records
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Create the database:

```sql
CREATE DATABASE student_records CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Option C: PostgreSQL

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=student_records
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 6: Run Database Migrations

Create all necessary database tables:

```bash
php artisan migrate
```

This will create all required tables for the system.

### Step 7: Seed Initial Data (Optional)

Seed the database with initial roles and settings:

```bash
php artisan db:seed
```

> **Note:** This creates default roles and system settings. You can skip this if you prefer to set up everything manually.

### Step 8: Create Storage Link

Create a symbolic link for public storage:

```bash
php artisan storage:link
```

This allows public access to uploaded files (logos, documents, etc.).

### Step 9: Build Frontend Assets

#### For Production:

```bash
npm run build
```

#### For Development:

```bash
npm run dev
```

> **Note:** For development, keep `npm run dev` running in a separate terminal to watch for changes.

### Step 10: Set File Permissions

Ensure proper permissions for storage and cache directories:

**On Linux/macOS:**

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**On Windows:**

Permissions are usually handled automatically, but ensure the web server has write access to:
- `storage/` directory
- `bootstrap/cache/` directory

### Step 11: Start the Application

#### Development Server:

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

#### Production Server:

Configure your web server (Apache/Nginx) to point to the `public/` directory as the document root.

---

## Environment Configuration

### Essential Environment Variables

Edit the `.env` file with your configuration:

```env
# Application
APP_NAME="EduRecordsGH"
APP_ENV=local
APP_KEY=base64:... (generated automatically)
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database (configure based on your choice above)
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# Mail Configuration (for email notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@edurecordsgh.com"
MAIL_FROM_NAME="${APP_NAME}"

# System Security
SYSTEM_SECRET="I@M$up3r@dM!n"
FILESYSTEM_DISK=public

# Payment Gateway (Paystack - Optional)
PAYSTACK_PUBLIC_KEY=your_public_key
PAYSTACK_SECRET_KEY=your_secret_key
PAYSTACK_MERCHANT_EMAIL=your_email@example.com
```

### Mail Configuration

For email notifications to work, configure your mail settings:

#### Using SMTP (Gmail example):

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@edurecordsgh.com"
MAIL_FROM_NAME="EduRecordsGH"
```

#### Using Mailtrap (for testing):

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
```

---

## Database Setup

### Running Migrations

After configuring your database connection, run migrations:

```bash
php artisan migrate
```

### Resetting Database (Development Only)

If you need to start fresh:

```bash
php artisan migrate:fresh
```

This will drop all tables and recreate them.

### Seeding Database

Seed initial data (roles, settings):

```bash
php artisan db:seed
```

Or run migrations and seed together:

```bash
php artisan migrate --seed
```

---

## Initial System Setup

### Step 1: Access Setup Page

1. Open your web browser
2. Navigate to: `http://your-domain/setup`
   - For local development: `http://localhost:8000/setup`

> **Important:** If the system is not set up, all routes will automatically redirect to `/setup`

### Step 2: Create Super Admin Account

On the setup page, you'll need to:

1. **Enter Personal Information:**
   - Last Name
   - Other Name(s)

2. **Enter Account Information:**
   - Email Address (optional but recommended)
   - Username (this will be your login username)
   - Password (choose a strong password)
   - Confirm Password

3. **Enter Contact Information:**
   - Primary Phone Number (include country code, e.g., +233)
   - Secondary Phone Number (optional)

4. **Enter System Password:**
   - This is the `SYSTEM_SECRET` value from your `.env` file
   - Default: `I@M$up3r@dM!n`
   - **Important:** Change this in production!

5. **Click "Activate System"**

### Step 3: System Activation

After successful setup:

- ✅ System will be automatically activated
- ✅ You'll be logged in automatically
- ✅ You'll be redirected to the homepage
- ✅ A success message will be displayed

> **Note:** The setup can only be performed once. Keep your super admin credentials safe!

### Step 4: Verify Setup

1. Check that you're logged in
2. Verify you can access the dashboard
3. Confirm the system is ready for use

---

## Post-Setup Configuration

### 1. Register Your First School

1. Navigate to **Register School** or use the registration link
2. Enter school information:
   - School Name
   - School Type (Public/Private)
   - District
   - Circuit (if applicable)
   - Contact Information
   - GPS Address (optional)
   - Postal Address
3. Submit the registration

### 2. Configure School Details

1. Log in as the super admin
2. Navigate to your school's settings
3. Complete all school information:
   - Full school name
   - Physical address
   - Contact details
   - School logo (if desired)

### 3. Set Up Payment Gateway (Optional)

If you plan to use payment features:

1. Get Paystack API keys from [paystack.com](https://paystack.com)
2. Add keys to `.env`:
   ```env
   PAYSTACK_PUBLIC_KEY=pk_test_...
   PAYSTACK_SECRET_KEY=sk_test_...
   PAYSTACK_MERCHANT_EMAIL=your_email@example.com
   ```
3. Configure payment accounts in the system

### 4. Configure Mail Settings

For email notifications to work:

1. Update mail configuration in `.env`
2. Test email sending (if needed)
3. Verify super admin email addresses are correct

### 5. Create Additional Users

1. Add school administrators
2. Add teachers
3. Add students (can be done in bulk via Excel import)

---

## Troubleshooting

### Common Issues

#### Issue: "500 Internal Server Error"

**Solutions:**
- Check file permissions: `chmod -R 775 storage bootstrap/cache`
- Clear cache: `php artisan cache:clear`
- Check `.env` file exists and is configured correctly
- Verify `APP_KEY` is set: `php artisan key:generate`

#### Issue: "Database connection error"

**Solutions:**
- Verify database credentials in `.env`
- Ensure database exists (for MySQL/PostgreSQL)
- Check database file exists (for SQLite): `touch database/database.sqlite`
- Verify database user has proper permissions

#### Issue: "Class not found" or "Autoload error"

**Solutions:**
- Run: `composer dump-autoload`
- Clear cache: `php artisan optimize:clear`
- Reinstall dependencies: `composer install`

#### Issue: "Assets not loading (CSS/JS)"

**Solutions:**
- Build assets: `npm run build` (production) or `npm run dev` (development)
- Clear cache: `php artisan cache:clear`
- Verify `public/build` directory exists
- Check Vite configuration

#### Issue: "Setup page not accessible"

**Solutions:**
- Check if `super.txt` file exists in storage
- Delete `storage/app/public/super.txt` to reset (if needed)
- Verify middleware is working correctly
- Check application logs: `storage/logs/laravel.log`

#### Issue: "Email not sending"

**Solutions:**
- Verify mail configuration in `.env`
- Test with Mailtrap or similar service first
- Check mail logs: `storage/logs/laravel.log`
- Verify `MAIL_FROM_ADDRESS` is set correctly

#### Issue: "Permission denied" errors

**Solutions:**
- Set proper permissions:
  ```bash
  chmod -R 775 storage bootstrap/cache
  chown -R www-data:www-data storage bootstrap/cache
  ```
- Ensure web server user has write access

### Getting Help

If you encounter issues not covered here:

1. Check application logs: `storage/logs/laravel.log`
2. Enable debug mode in `.env`: `APP_DEBUG=true`
3. Review error messages carefully
4. Check Laravel documentation: [laravel.com/docs](https://laravel.com/docs)
5. Contact system administrator or support

---

## Quick Setup Checklist

Use this checklist to ensure you've completed all setup steps:

### Pre-Installation
- [ ] PHP 8.2+ installed and verified
- [ ] Composer installed and verified
- [ ] Node.js 18+ and npm installed and verified
- [ ] Database server ready (SQLite/MySQL/PostgreSQL)
- [ ] Web server configured (or using PHP built-in server)

### Installation
- [ ] Project files extracted/cloned
- [ ] `composer install` completed successfully
- [ ] `npm install` completed successfully
- [ ] `.env` file created and configured
- [ ] `APP_KEY` generated
- [ ] Database connection configured
- [ ] Migrations run successfully
- [ ] Storage link created
- [ ] Frontend assets built

### Initial Setup
- [ ] Accessed `/setup` page
- [ ] Created super admin account
- [ ] System activated successfully
- [ ] Logged in and verified access

### Post-Setup
- [ ] Registered first school
- [ ] Configured school details
- [ ] Mail settings configured (if needed)
- [ ] Payment gateway configured (if needed)
- [ ] Tested system functionality

---

## Next Steps

After completing the setup:

1. 📖 Read the [Getting Started Guide](getting-started.md)
2. 📚 Review [User Guides](user-guides/) for your role
3. 🎯 Start adding users, classes, and students
4. ⚙️ Configure school settings and preferences
5. 💰 Set up payment accounts (if needed)

---

**Last Updated:** 2026-01-25  
**System Version:** 1.0.0
