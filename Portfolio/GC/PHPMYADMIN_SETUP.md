# phpMyAdmin Setup Instructions

## Step-by-Step Guide to Set Up Database for Registration/Login System

### Prerequisites
- XAMPP must be installed and running
- Apache and MySQL services must be started in XAMPP Control Panel

---

## Step 1: Access phpMyAdmin

1. Open your web browser
2. Go to: `http://localhost/phpmyadmin`
3. You should see the phpMyAdmin interface

---

## Step 2: Create the Database

1. Click on **"New"** in the left sidebar (or click "Databases" tab)
2. In the **"Database name"** field, enter: `AmberSS15`
3. In the **"Collation"** dropdown, select: `utf8mb4_unicode_ci`
4. Click **"Create"** button

---

## Step 3: Import the Database Structure

### Option A: Using SQL File (Recommended)

1. Click on the **"AmberSS15"** database in the left sidebar
2. Click on the **"Import"** tab at the top
3. Click **"Choose File"** button
4. Navigate to: `C:\xampp\htdocs\GC\database.sql`
5. Select the file and click **"Open"**
6. Scroll down and click **"Go"** button
7. You should see a success message: "Import has been successfully finished"

### Option B: Manual SQL Execution

1. Click on the **"AmberSS15"** database in the left sidebar
2. Click on the **"SQL"** tab at the top
3. Copy and paste the entire content from `database.sql` file
4. Click **"Go"** button

---

## Step 4: Verify Database Setup

1. In the left sidebar, expand **"AmberSS15"** database
2. You should see two tables:
   - ✅ **users** - Stores user registration data
   - ✅ **user_sessions** - Stores session information (optional)

3. Click on the **"users"** table to view its structure
4. You should see these columns:
   - `id` (Primary Key, Auto Increment)
   - `username` (Unique)
   - `email` (Unique)
   - `phone`
   - `password` (Hashed)
   - `otp_code` (Can be NULL)
   - `otp_expires_at` (Can be NULL)
   - `email_verified`
   - `phone_verified`
   - `created_at`
   - `updated_at`

---

## Step 5: Test Database Connection

1. Make sure your `config.php` file has the correct database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');  // Empty for default XAMPP
   define('DB_NAME', 'amberss15');
   ```

2. If you changed the MySQL root password in XAMPP, update `DB_PASS` in `config.php`

---

## Step 6: Test Registration

1. Open your browser and go to: `http://localhost/GC/register.php`
2. Fill in the registration form:
   - **Username**: (3-20 characters, letters, numbers, underscores only)
   - **Email**: (valid email format)
   - **Password**: Must meet all requirements:
     - At least 8 characters
     - One uppercase letter
     - One lowercase letter
     - One number
     - One special character (!@#$%^&*)
   - **Confirm Password**: Must match password
3. Click **"Register"** button
4. If successful, you'll see a success message and be redirected to login

---

## Step 7: Verify Data in phpMyAdmin

1. Go back to phpMyAdmin: `http://localhost/phpmyadmin`
2. Click on **"AmberSS15"** database
3. Click on **"users"** table
4. Click on **"Browse"** tab
5. You should see your registered user data:
   - Username, email
   - Password (hashed - you won't see the actual password)
   - Created timestamp

---

## Step 8: Test Login

1. Go to: `http://localhost/GC/login.php`
2. Enter your registered email and password
3. Click **"Login"**
4. If successful, you'll be redirected to `home.html`

---

## Troubleshooting

### Issue: "Connection failed" error
- **Solution**: Make sure MySQL service is running in XAMPP Control Panel

### Issue: "Access denied" error
- **Solution**: Check `config.php` - default XAMPP MySQL password is empty (blank)

### Issue: "Database doesn't exist" error
- **Solution**: Make sure you created the database `AmberSS15` in phpMyAdmin

### Issue: "Table doesn't exist" error
- **Solution**: Import the `database.sql` file to create the tables

### Issue: Button is disabled even after filling all fields
- **Solution**: Make sure your password meets ALL requirements:
  - ✅ At least 8 characters
  - ✅ Contains uppercase letter (A-Z)
  - ✅ Contains lowercase letter (a-z)
  - ✅ Contains number (0-9)
  - ✅ Contains special character (!@#$%^&*)
  - ✅ Passwords match

---

## Database Structure Overview

### users Table
Stores all registered user information:
- **id**: Unique identifier (auto-incremented)
- **username**: Unique username
- **email**: Unique email address
- **password**: Hashed password (using PHP password_hash)
- **email_verified**: Flag for email confirmation (defaults to 0)
- **created_at**: Registration timestamp
- **updated_at**: Last update timestamp

### user_sessions Table (Optional)
Stores active user sessions for session management.

---

## Security Notes

- Passwords are automatically hashed using PHP's `password_hash()` function
- Never store plain text passwords
- The database uses prepared statements to prevent SQL injection
- All user inputs are sanitized before database insertion

---

## Next Steps

After successful setup:
1. ✅ Users can register (data saved to database)
2. ✅ Users can login (verified against database)
3. ✅ All data is stored securely in phpMyAdmin
4. ✅ Sessions are created on successful login

Your registration and login system is now fully functional!

