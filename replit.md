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
- Passwords hashed using bcrypt (PASSWORD_DEFAULT)
- Session-based authentication
- Protected routes that require login
- Password reset tokens expire after 1 hour
- SQL injection prevention using PDO prepared statements
- XSS prevention using htmlspecialchars()
- Password strength validation (minimum 6 characters)

## Recent Changes
- **November 1, 2025**: Initial project setup with complete authentication system

## User Preferences
None specified yet.

## Development Notes
- The application uses PHP's built-in development server on port 5000
- SQLite database is auto-created on first run
- Password reset emails are displayed on-screen (for demo purposes)
- In production, integrate a mail service for sending reset emails
