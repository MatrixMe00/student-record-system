# System Setup Guide

Complete guide for superadmins to set up and configure EduRecordsGH Student Record Management System.

## 📋 Table of Contents

1. [Overview](#overview)
2. [Initial System Setup](#initial-system-setup)
3. [Post-Setup Configuration](#post-setup-configuration)
5. [Payment Gateway Configuration](#payment-gateway-configuration)
6. [System Settings](#system-settings)
7. [Troubleshooting](#troubleshooting)

---

## Overview

This guide is for **Superadmins** setting up the EduRecordsGH system for the first time. The system must be installed and configured by your technical team before you can begin this setup process.

### Prerequisites

Before you begin, ensure:
- ✅ The system has been installed by your technical team
- ✅ The system is accessible via web browser
- ✅ You have the **System Password** (provided by your technical team)
- ✅ You have all necessary school information ready

### What You'll Set Up

1. **Create Super Admin Account** - Your main administrator account
2. **Activate the System** - Enable the system for use
3. **Register Schools** - Add schools to the platform
4. **Configure Payments** - Set up payment gateway (if needed)
5. **System Settings** - Configure global system preferences

---

## Initial System Setup

### Step 1: Access Setup Page

1. Open your web browser
2. Navigate to your system URL followed by `/setup`
   - Example: `https://your-domain.com/setup`
   - Or: `http://localhost:8000/setup` (for local installations)

> **Important:** If the system is not yet set up, all routes will automatically redirect to `/setup`. You cannot access other parts of the system until setup is complete.

### Step 2: Create Super Admin Account

On the setup page, you'll need to complete the following sections:

#### Personal Information
- **Last Name** - Your last name
- **Other Name(s)** - Your first and middle names

#### Account Information
- **Email Address** - Your email (optional but highly recommended)
  - Used for system notifications and password recovery
- **Username** - This will be your login username
  - Choose a username you'll remember
  - Cannot be changed after creation
- **Password** - Choose a strong password
  - Minimum 8 characters recommended
  - Use a combination of letters, numbers, and symbols
- **Confirm Password** - Re-enter your password to confirm

#### Contact Information
- **Primary Phone Number** - Your main contact number
  - Include country code (e.g., +233 for Ghana)
  - Format: +233XXXXXXXXX
- **Secondary Phone Number** - Optional additional contact number

#### System Security
- **System Password** - Enter the system password
  - This is the `SYSTEM_SECRET` provided by your technical team
  - **Important:** Contact your technical team if you don't have this password

### Step 3: Activate System

1. Review all information you've entered
2. Ensure all required fields are completed
3. Click **"Activate System"** button

### Step 4: System Activation Confirmation

After successful setup:

- ✅ System will be automatically activated
- ✅ You'll be logged in automatically
- ✅ You'll be redirected to the homepage/dashboard
- ✅ A success message will be displayed

> **Note:** The setup can only be performed once. Keep your super admin credentials safe and secure!

### Step 5: Verify Setup

1. **Check Login Status** - Verify you're logged in (your username should be visible)
2. **Access Dashboard** - Navigate to the dashboard to confirm access
3. **Test Navigation** - Try accessing different sections of the system
4. **Confirm System Ready** - System should now be ready for school registration

---

## Post-Setup Configuration

After activating the system, you should complete these configuration steps:

### 1. Review Your Profile

1. Navigate to your **Profile** or **Account Settings**
2. Verify all your information is correct
3. Update any missing information
4. Add a profile picture if desired
5. Save changes

### 2. Familiarize Yourself with the Dashboard

Take time to explore:
- **System Statistics** - Overview of schools, users, and students
- **Navigation Menu** - Available sections and features
- **Quick Actions** - Common administrative tasks
- **Recent Activities** - System activity log

---

## Payment Gateway Configuration

The system uses payment features via a Paystack integration, configure the payment gateway:

### Step 1: Get Payment Gateway Credentials

1. **Sign up for Paystack** (if not already done)
   - Visit [paystack.com](https://paystack.com)
   - Create an account or log in
   - Navigate to Settings → API Keys & Webhooks

2. **Obtain API Keys**
   - **Public Key** - Starts with `pk_`
   - **Secret Key** - Starts with `sk_`
   - **Merchant Email** - Your Paystack account email

> **Note:** These payment gateway keys are already available in the system configuration. You only need to check with your technical team to confirm that they're present and correctly set. In some cases, you may also be able to verify or edit them through the system interface if that feature is available.

### Step 2: Configure Payment Accounts

1. Navigate to **Payment Accounts** in the system
2. Click **"Add Payment Account"** or **"Configure Payment"**
3. Enter payment details:
   - **Paystack Public Key**
   - **Paystack Secret Key**
   - **Merchant Email**
4. **Test Payment Processing** (if test mode available)
5. **Save Configuration**

### Step 3: Initialize Banks (Paystack)

1. Go to **Payment Accounts** → **Paystack Banks**
2. Click **"Initialize Banks"**
3. System will fetch and store bank information from Paystack
4. Banks are now available for payment configuration

### Step 4: Configure Payment Settings

Set up payment-related settings:
- **Payment Prices** - Configure result viewing fees
- **Payment Methods** - Enable/disable payment methods
- **Payment Notifications** - Configure email notifications for payments

---

## System Settings

### Accessing System Settings

1. Navigate to **System Settings** in the navigation menu
2. View all configurable system options

### Configurable Settings

You can configure:

- **System Name** - Application name displayed to users
- **Default Settings** - Default values for new schools
- **Feature Access** - Which features are available to schools
- **Role Permissions** - System-wide role configurations
- **Email Settings** - Email notification preferences
- **Payment Settings** - Global payment configuration

### Creating System Settings

1. Go to **System Settings**
2. Click **"Create Setting"** or **"Add Setting"**
3. Enter:
   - **Setting Key** - Unique identifier (e.g., `max_schools`)
   - **Setting Value** - Configuration value
   - **Description** - What this setting controls
4. Click **"Save"**

### Updating System Settings

1. Navigate to **System Settings**
2. Find the setting to update
3. Click **"Edit"**
4. Update the value
5. Click **"Save"**

> **Note:** Some settings may require system restart or cache clearing to take effect. Consult your technical team if unsure.

---

## Troubleshooting

### Common Issues

#### Issue: Cannot Access Setup Page

**Symptoms:**
- Redirected to login page
- Getting 404 error
- Page not loading

**Solutions:**
- Verify the URL is correct: `your-domain.com/setup`
- Check if system has already been set up (try logging in)
- Contact your technical team to verify system installation
- Clear browser cache and cookies
- Try a different browser

#### Issue: "Invalid System Password" Error

**Symptoms:**
- Error message when entering system password
- Cannot proceed with setup

**Solutions:**
- Verify you're using the correct system password
- Check for typos or extra spaces
- Contact your technical team to confirm the `SYSTEM_SECRET` value
- Ensure you're using the password from the system configuration file

#### Issue: Setup Form Errors

**Symptoms:**
- Validation errors on form fields
- Cannot submit the form

**Solutions:**
- Check all required fields are filled
- Verify email format is correct (if provided)
- Ensure password meets requirements (minimum length, etc.)
- Check phone number format includes country code
- Ensure password and confirm password match

#### Issue: System Not Activating

**Symptoms:**
- Setup completes but system doesn't activate
- Still redirected to setup page
- Cannot access dashboard

**Solutions:**
- Refresh the page
- Clear browser cache
- Try logging in with your credentials
- Check browser console for errors
- Contact your technical team to check system logs

#### Issue: Payment Gateway Not Working

**Symptoms:**
- Payment configuration errors
- Payments not processing
- API key errors

**Solutions:**
- Verify API keys are correct (no extra spaces)
- Check if using test keys in production (or vice versa)
- Ensure merchant email matches Paystack account
- Test payment gateway connection
- Contact Paystack support if issues persist

#### Issue: User Role is Invalid

**Symptoms:**
- Error message: "Invalid user role" or similar during setup or login
- Unable to proceed past account creation or access dashboard

**Solution:**
- Report this issue to your technical team. They will update the system configuration to ensure the necessary user roles are available and enabled for setup and use.

### Getting Help

If you encounter issues not covered here:

1. **Check System Logs** - Ask your technical team to review system logs
2. **Contact Technical Support** - Reach out to your technical team
3. **Review Documentation** - Check other user guides for related information
4. **System Status** - Verify system is running and accessible

---

## Quick Setup Checklist

Use this checklist to ensure you've completed all setup steps:

### Initial Setup
- [ ] Accessed `/setup` page successfully
- [ ] Created super admin account with all required information
- [ ] Entered correct system password
- [ ] System activated successfully
- [ ] Logged in and verified access
- [ ] Can access dashboard

### Post-Setup Configuration
- [ ] Reviewed and updated profile information
- [ ] Familiarized with dashboard and navigation
- [ ] Understood system features and capabilities

### Payment Configuration (If Applicable)
- [ ] Obtained Paystack API keys
- [ ] Configured payment gateway in system
- [ ] Initialized banks list
- [ ] Tested payment processing (if test mode available)
- [ ] Configured payment prices and settings

### System Settings
- [ ] Reviewed system settings
- [ ] Configured system name and branding
- [ ] Set default values for new schools
- [ ] Configured email settings (if applicable)

---

## Next Steps

After completing the setup:

1. 📖 Read the [Superadmin Guide](user-guides/superadmin-guide.md) for detailed system management
2. 🏫 Start registering and managing schools
3. 👥 Create school administrators for each school
4. ⚙️ Configure system-wide settings and preferences
5. 💰 Set up payment accounts if using payment features
6. 📊 Monitor system activity and school usage

---

## Important Notes

### Security

- **Keep Credentials Safe** - Never share your superadmin credentials
- **Strong Passwords** - Use strong, unique passwords
- **System Password** - Keep the system password secure and change it periodically
- **Regular Updates** - Ensure system is kept updated by your technical team

### System Access

- **Single Setup** - System setup can only be done once
- **Superadmin Role** - You have full system access
- **School Management** - You can manage all schools in the system
- **System Settings** - You can configure global system settings

### Support

- **Technical Issues** - Contact your technical team for installation/technical problems
- **System Usage** - Refer to user guides for how to use system features
- **Documentation** - Check other documentation files for detailed guides

---

**Last Updated:** 2026-01-25  
**System Version:** 1.0.0  
**For:** Superadmins
