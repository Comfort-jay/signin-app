# Sign-In Authentication System

## Overview
A complete authentication system built with HTML, CSS, and PHP featuring user registration, login, password reset functionality, and session management.

## Project Structure
```
.
├── index.php              # Login page (main entry point)
├── signup.php             # User registration page
├── forgot-password.php    # Password reset request page
├── reset-password.php     # Password reset form page
├── dashboard.php          # Protected user dashboard
├── logout.php             # Logout handler
├── config.php             # Configuration settings
├── db.php                 # Database connection and initialization
├── auth.php               # Authentication helper functions
├── style.css              # Responsive CSS styling
├── users.db               # SQLite database (auto-generated)
└── .gitignore            # Git ignore file
```

## Features Implemented
- ✅ User Registration with email/password validation
- ✅ Secure password hashing using PHP's password_hash()
- ✅ User Login with session management
- ✅ Forgot Password functionality with token-based reset
- ✅ Password Reset with expiring tokens (1-hour validity)
- ✅ Protected Dashboard accessible only to logged-in users
- ✅ Logout functionality
- ✅ Responsive design for mobile and desktop
- ✅ Form validation (client-side and server-side)
- ✅ SQLite database for user storage

## Technology Stack
- **Backend**: PHP 8.2
- **Database**: SQLite
- **Frontend**: HTML5, CSS3, Vanilla JavaScript
- **Security**: Password hashing, session management, CSRF protection

## Database Schema

### users table
- id (INTEGER PRIMARY KEY)
- email (TEXT UNIQUE)
- password (TEXT - hashed)
- name (TEXT)
- created_at (DATETIME)

### password_resets table
- id (INTEGER PRIMARY KEY)
- email (TEXT)
- token (TEXT)
- created_at (DATETIME)
- expires_at (DATETIME)

## How It Works

### Registration Flow
1. User fills out signup form (name, email, password, confirm password)
2. Server validates input (email format, password length, matching passwords)
3. Password is hashed using PHP's password_hash() function
4. User data is stored in SQLite database
5. Success message displayed, user can now login

### Login Flow
1. User enters email and password
2. Server retrieves user from database
3. Password verified using password_verify()
4. Session created with user data
5. User redirected to dashboard

### Password Reset Flow
1. User requests password reset with email
2. Server generates unique token and expiration time
3. Reset link displayed (in production, would be emailed)
4. User clicks link and enters new password
5. Token verified and password updated
6. Old token deleted from database

## Security Features
- **Password Hashing**: Passwords hashed using bcrypt (PASSWORD_DEFAULT)
- **Session Management**: Session-based authentication with session fixation prevention
- **Session Regeneration**: Session ID regenerated on login and logout to prevent session fixation attacks
- **Protected Routes**: Routes that require authentication
- **Token Security**: Password reset tokens hashed with SHA-256 before database storage
- **Token Expiration**: Password reset tokens expire after 1 hour
- **SQL Injection Prevention**: PDO prepared statements used throughout
- **XSS Prevention**: All user input sanitized with htmlspecialchars()
- **Account Enumeration Prevention**: Identical responses for password reset regardless of email existence
- **Error Handling**: display_errors disabled, log_errors enabled for production security
- **Password Strength Validation**: Minimum 6 characters required

## Recent Changes
- **November 1, 2025**: 
  - Initial project setup with complete authentication system
  - Security hardening: Added session regeneration on login/logout
  - Security hardening: Implemented SHA-256 hashing for password reset tokens
  - Security hardening: Fixed account enumeration vulnerability in password reset
  - Security hardening: Disabled display_errors and enabled log_errors
  - All critical security issues resolved and approved by security review

## User Preferences
None specified yet.

## Development Notes
- The application uses PHP's built-in development server on port 5000
- SQLite database is auto-created on first run
- For security, password reset no longer displays links on-screen
- To test password reset in demo mode, check the users.db database directly:
  - Query: `SELECT * FROM password_resets ORDER BY created_at DESC LIMIT 1;`
  - Use the token value from database to construct reset URL manually
- **Production Deployment**: 
  - Integrate a mail service (PHPMailer, SendGrid, etc.) for sending reset emails
  - Ensure log_errors points to a secure location
  - Review all security settings before going live

## Testing the Application

### Creating a New Account
1. Navigate to the signup page
2. Fill in your name, email, and password (minimum 6 characters)
3. Confirm your password
4. Click "Sign Up"

### Logging In
1. Use your registered email and password
2. Click "Sign In"
3. You'll be redirected to the dashboard

### Testing Password Reset (Demo Mode)
1. Click "Forgot Password?" on the login page
2. Enter a registered email address
3. Submit the form (you'll see a generic success message)
4. To get the actual reset link, query the database:
   ```bash
   sqlite3 users.db "SELECT token FROM password_resets ORDER BY created_at DESC LIMIT 1;"
   ```
5. Use the token to construct the URL: `http://localhost:5000/reset-password.php?token=YOUR_TOKEN`
6. Set your new password

**Note**: In production, the reset link would be emailed automatically.
