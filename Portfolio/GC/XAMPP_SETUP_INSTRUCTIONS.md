# XAMPP Setup Instructions for GC Project

This guide will help you set up the database and PHP backend for your login/register system.

## Prerequisites
- XAMPP installed on your computer
- Your project files in the XAMPP `htdocs` folder

## Step 1: Start XAMPP Services

1. Open **XAMPP Control Panel**
2. Start **Apache** (click the "Start" button)
3. Start **MySQL** (click the "Start" button)
4. Both should show green "Running" status

## Step 2: Access phpMyAdmin

1. Open your web browser
2. Go to: `http://localhost/phpmyadmin`
3. You should see the phpMyAdmin interface

## Step 3: Create the Database

1. In phpMyAdmin, click on the **"SQL"** tab at the top
2. Open the file `database.sql` from your project folder
3. Copy the entire contents of `database.sql`
4. Paste it into the SQL query box in phpMyAdmin
5. Click **"Go"** button
6. You should see a success message and the database `AmberSS15` will be created

**OR** you can do it manually:
1. Click on **"New"** in the left sidebar
2. Enter database name: `AmberSS15`
3. Select collation: `utf8mb4_unicode_ci`
4. Click **"Create"**
5. Select the `AmberSS15` database
6. Click on the **"SQL"** tab
7. Copy and paste the table creation queries from `database.sql` (starting from `CREATE TABLE IF NOT EXISTS users`)
8. Click **"Go"**

## Step 4: Move Your Project to XAMPP

1. Copy your entire `GC` folder to: `C:\xampp\htdocs\`
2. Your project should now be at: `C:\xampp\htdocs\GC\`

## Step 5: Configure Database Connection (if needed)

1. Open `config.php` in your project
2. Check these settings (usually default XAMPP settings work):
   - `DB_HOST`: `localhost` (default)
   - `DB_USER`: `root` (default)
   - `DB_PASS`: `` (empty by default in XAMPP)
   - `DB_NAME`: `AmberSS15`

If you changed your MySQL password in XAMPP, update `DB_PASS` in `config.php`.

## Step 6: Test Your Setup

1. Open your web browser
2. Go to: `http://localhost/GC/login.html`
3. You should see your login page

## Step 7: Test Registration

1. Click on "Register" or "Don't have an account? Register"
2. Fill in the registration form:
   - Username
   - Email
   - Phone Number
   - Click "Send" to get OTP (check browser console for OTP in development mode)
   - Enter the 6-digit OTP
   - Password (must meet requirements)
   - Confirm Password
3. Click "Register"
4. You should see a success message

## Step 8: Test Login

1. After successful registration, go back to login form
2. Enter your email and password
3. Optionally check "Remember me"
4. Click "Login"
5. You should be redirected to `home.html`

## Troubleshooting

### Error: "Connection failed"
- Make sure MySQL is running in XAMPP Control Panel
- Check that `config.php` has correct database credentials
- Verify database `AmberSS15` exists in phpMyAdmin

### Error: "Access denied for user"
- Check your MySQL username and password in `config.php`
- Default XAMPP MySQL user is `root` with no password

### Error: "Table doesn't exist"
- Make sure you ran the SQL queries from `database.sql`
- Check in phpMyAdmin that the `users` table exists

### PHP files not working
- Make sure Apache is running in XAMPP
- Check that your files are in `C:\xampp\htdocs\GC\`
- Access via `http://localhost/GC/` not `file:///`

### OTP not working
- In development mode, check browser console (F12) for the OTP code
- In production, you'll need to integrate with an SMS service (Twilio, AWS SNS, etc.)

## Next Steps

1. **For Production**: 
   - Remove OTP display from `send_otp.php` (the `'otp' => $otp` in response)
   - Integrate with a real SMS service for OTP delivery
   - Add email verification
   - Implement password reset functionality

2. **Security Enhancements**:
   - Use HTTPS in production
   - Add CSRF protection
   - Implement rate limiting for login attempts
   - Add CAPTCHA for registration

3. **Additional Features**:
   - User profile management
   - Session management
   - Remember me functionality (already partially implemented)

## File Structure

Your project should look like this:
```
C:\xampp\htdocs\GC\
├── config.php              (Database configuration)
├── database.sql            (Database schema)
├── login.php               (Login endpoint)
├── register.php            (Registration endpoint)
├── send_otp.php            (OTP sending endpoint)
├── verify_otp.php          (OTP verification endpoint)
├── logout.php              (Logout endpoint)
├── check_session.php       (Session check endpoint)
├── login.html              (Login/Register page)
├── login.js                (Frontend JavaScript)
└── ... (other HTML/CSS files)
```

## Need Help?

If you encounter any issues:
1. Check XAMPP error logs: `C:\xampp\apache\logs\error.log`
2. Check MySQL error logs: `C:\xampp\mysql\data\*.err`
3. Enable PHP error display in `php.ini` (for development only)
4. Check browser console (F12) for JavaScript errors

