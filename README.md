# Sign-In Authentication System

A secure, full-featured authentication system built with PHP, HTML, and CSS.

## Features

✅ **User Registration** - Create new accounts with email/password  
✅ **Secure Login** - Session-based authentication  
✅ **Password Reset** - Token-based password recovery  
✅ **User Dashboard** - Protected area for authenticated users  
✅ **Security Hardened** - Multiple layers of protection  
✅ **Responsive Design** - Works on mobile and desktop  

## Security Features

- **Session Fixation Prevention** - Session IDs regenerated on login/logout
- **Password Hashing** - bcrypt encryption for all passwords
- **Token Security** - SHA-256 hashed password reset tokens
- **Account Enumeration Prevention** - Identical responses for forgot password
- **SQL Injection Prevention** - PDO prepared statements
- **XSS Protection** - Input sanitization throughout
- **Secure Error Handling** - Production-safe error logging

## Quick Start

1. The application runs automatically on port 5000
2. Open your browser and navigate to the application
3. Click "Sign Up" to create an account
4. Log in with your credentials
5. Access your protected dashboard

## Project Structure

```
├── index.php              # Login page
├── signup.php             # Registration page
├── forgot-password.php    # Password reset request
├── reset-password.php     # Password reset form
├── dashboard.php          # User dashboard
├── logout.php             # Logout handler
├── auth.php               # Authentication logic
├── db.php                 # Database connection
├── config.php             # Configuration
└── style.css              # Styling
```

## Testing Password Reset

Since this is a demo without email configured, password reset works differently:

1. Request a password reset (you'll get a generic success message)
2. Check the database for the reset token:
   ```bash
   sqlite3 users.db "SELECT token FROM password_resets ORDER BY created_at DESC LIMIT 1;"
   ```
3. Visit: `http://localhost:5000/reset-password.php?token=YOUR_TOKEN`
4. Set your new password

**In production**, integrate an email service to automatically send reset links.

## Database Schema

### users
- id (Primary Key)
- email (Unique)
- password (Hashed)
- name
- created_at

### password_resets
- id (Primary Key)
- email
- token (SHA-256 hashed)
- created_at
- expires_at (1 hour from creation)

## Technology Stack

- PHP 8.2
- SQLite Database
- HTML5 & CSS3
- Vanilla JavaScript

## Security Notes

All critical security vulnerabilities have been addressed:
- ✅ Session fixation prevention implemented
- ✅ Account enumeration vulnerability fixed
- ✅ Password reset tokens properly hashed
- ✅ Error display disabled in production mode
- ✅ Comprehensive input validation

## Production Deployment

Before deploying to production:

1. **Email Configuration**: Set up PHPMailer or similar service
2. **Database**: Consider upgrading to MySQL/PostgreSQL for production
3. **HTTPS**: Enable SSL/TLS encryption
4. **Error Logs**: Configure secure log file location
5. **Rate Limiting**: Add protection against brute force attacks
6. **CSRF Tokens**: Implement CSRF protection for forms

## License

This is a demo authentication system for educational purposes.
