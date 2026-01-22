# Superadmin User Guide

Welcome to the Superadmin Guide. This guide covers system-wide administration functions for managing multiple schools.

## 📋 Table of Contents
1. [Getting Started](#getting-started)
2. [Dashboard Overview](#dashboard-overview)
3. [School Management](#school-management)
4. [System-Wide Results](#system-wide-results)
5. [BECE Management](#bece-management)
6. [System Settings](#system-settings)
7. [Payment Configuration](#payment-configuration)
8. [Troubleshooting](#troubleshooting)

---

## Getting Started

### Logging In

1. Navigate to the login page
2. Enter your **superadmin credentials**
3. Click **Login**

> **Note:** Superadmin accounts have system-wide access to all schools.

### Initial System Setup

If setting up the system for the first time:

1. **System Initialization**
   - Access `/setup` to initialize the system
   - Create the first superadmin account
   - Configure basic system settings

2. **Payment Gateway Setup**
   - Configure Paystack or other payment gateways
   - Set up bank information
   - Test payment processing

---

## Dashboard Overview

Your **Dashboard** provides:
- **System Statistics** - Total schools, users, students across all schools
- **School Overview** - List of all schools in the system
- **Recent Activities** - System-wide activity log
- **Quick Actions** - Common administrative tasks
- **Payment Overview** - System-wide payment statistics

### Navigation Menu

Available menu items:
- **Dashboard** - System overview
- **School Management** - Manage all schools
- **Payment Accounts** - System-wide payment configuration
- **System Settings** - Global system configuration

---

## School Management

### Viewing All Schools

1. Navigate to **School Management** or **Admin Schools**
2. View list of all schools in the system
3. See school status (Active/Inactive)
4. View school statistics

### School Details

1. Go to **School Management**
2. Click on a school
3. View **School Menu** with:
   - School information
   - School statistics
   - Quick access to school data

### Managing School Status

#### Activating/Deactivating Schools

1. Navigate to **School Management**
2. Find the school
3. Click **Status Change** or **Activate/Deactivate**
4. Confirm the action

> **Note:** Deactivated schools cannot access the system, but data is retained.

### Deleting Schools

1. Go to **School Management**
2. Find the school to delete
3. Click **Delete**
4. Confirm deletion

> **Warning:** School deletion may cascade delete associated users and data. Use with caution.

### School Registration

New schools can register through:
1. **Public Registration** - Schools register themselves
2. **Manual Creation** - Superadmin creates school accounts

---

## System-Wide Results

### Viewing All School Results

1. Navigate to **School Results** or **School-Result**
2. Select a **School**
3. Choose **Academic Year**
4. Select **Class/Program** and **Term**
5. View results across all schools

### Result Analysis

You can analyze:
- **School Performance** - Compare results across schools
- **Subject Performance** - Subject-wise analysis
- **Class Performance** - Class-level comparisons
- **Student Performance** - Individual student tracking

### Exporting System Reports

1. Navigate to any results page
2. Click **Export**
3. Choose format (Excel, PDF)
4. Download system-wide reports

---

## BECE Management

### Managing BECE Candidates Across Schools

1. Navigate to **BECE Candidates** or **School Candidates**
2. Select a **School**
3. View all BECE candidates for that school
4. Manage candidate information

### BECE Results Management

1. Go to **BECE Results**
2. Select **School**
3. View and manage BECE results
4. Export results if needed

### Updating Candidate Information

1. Navigate to **BECE Candidates**
2. Select school and candidate
3. Edit candidate details
4. Update index numbers if needed
5. Save changes

---

## System Settings

### Accessing System Settings

1. Navigate to **System Settings**
2. View all configurable system options

### Configuring System Settings

You can configure:
- **System Name** - Application name
- **Default Settings** - Default values for new schools
- **Feature Access** - Which features are available
- **Role Permissions** - System-wide role configurations
- **Payment Settings** - Global payment configuration

### Creating System Settings

1. Go to **System Settings**
2. Click **Create Setting**
3. Enter:
   - **Setting Key** - Unique identifier
   - **Setting Value** - Configuration value
   - **Description** - What this setting controls
4. Click **Save**

### Updating System Settings

1. Navigate to **System Settings**
2. Find the setting to update
3. Click **Edit**
4. Update the value
5. Click **Save**

---

## Payment Configuration

### Payment Gateway Setup

1. Navigate to **Payment Accounts**
2. Configure payment gateway settings:
   - **Paystack Public Key**
   - **Paystack Secret Key**
   - **Merchant Email**
3. Test payment processing
4. Save configuration

### Bank Information

#### Initializing Banks (Paystack)

1. Go to **Payment Accounts** → **Paystack Banks**
2. Click **Initialize Banks**
3. System fetches and stores bank information
4. Banks are now available for payment configuration

### Payment Account Management

1. Navigate to **Payment Accounts**
2. View all payment accounts
3. Add, edit, or remove payment accounts
4. Configure payment methods per school

---

## User Management (System-Wide)

### Viewing All Users

1. Navigate to **Users** (if available system-wide)
2. View users across all schools
3. Filter by school, role, or status

### Managing System Users

- **Create Users** - Add system-level users
- **Edit Users** - Update user information
- **Activate/Deactivate** - Control user access
- **Reset Passwords** - Reset user passwords

---

## Activity Monitoring

### Viewing System Activity

1. Navigate to **Activity Logs** (if available)
2. View system-wide activities
3. Filter by:
   - School
   - User
   - Action type
   - Date range

### Audit Trail

Monitor:
- **User Actions** - All user activities
- **System Changes** - Configuration changes
- **Data Modifications** - Important data updates
- **Security Events** - Login attempts, access changes

---

## Best Practices

### School Management
✅ **Regular Reviews** - Periodically review all schools  
✅ **Status Monitoring** - Monitor school activity and status  
✅ **Data Backup** - Ensure regular backups of school data  
✅ **Communication** - Maintain communication with school administrators  

### System Settings
✅ **Document Changes** - Document all system setting changes  
✅ **Test Before Apply** - Test settings in development first  
✅ **Backup Settings** - Keep backups of configuration  
✅ **Version Control** - Track setting changes over time  

### Security
✅ **Access Control** - Regularly review user access  
✅ **Password Policies** - Enforce strong password requirements  
✅ **Activity Monitoring** - Regularly review activity logs  
✅ **Updates** - Keep system updated with security patches  

---

## Troubleshooting

### School Access Issues

**Problem:** School cannot access system

**Solution:**
- Check school status (Active/Inactive)
- Verify school registration is complete
- Check school administrator account status
- Review system logs for errors

### Payment Gateway Issues

**Problem:** Payments not processing

**Solution:**
- Verify payment gateway configuration
- Check API keys are correct
- Test payment gateway connection
- Review payment logs
- Contact payment provider if needed

### System Settings Not Applying

**Problem:** Settings changes not taking effect

**Solution:**
- Clear system cache
- Verify setting key is correct
- Check if setting requires restart
- Review system logs

### Data Access Issues

**Problem:** Cannot access school data

**Solution:**
- Verify school exists and is active
- Check database connectivity
- Review access permissions
- Check system logs for errors

---

## Quick Reference

### Common Tasks
- **View All Schools** → School Management
- **Check School Status** → School Management → Select School
- **View System Results** → School Results → Select School
- **Configure Payments** → Payment Accounts
- **System Settings** → System Settings

### Important URLs
- **School Management** - `/admin-schools`
- **School Results** - `/school-results/{school_id}`
- **System Settings** - `/system-settings`
- **Payment Accounts** - `/payment/accounts`

---

## Need Help?

For system-level support:
- Review system documentation
- Check system logs
- Contact development team
- Review activity logs for error details

---

**Last Updated:** 2026-01-22
