# 🔒 Security Policy

## Protecting Sensitive Information

This project uses several security measures to protect sensitive data:

### 1. Database Credentials

**Never commit database credentials to Git!**

-  ✅ `php/connexion.php` is **excluded** from version control (listed in `.gitignore`)
-  ✅ Use `php/connexion.example.php` as a template
-  ✅ Alternatively, use `.env.example` for environment variables

### 2. Files Excluded from Git

The following files contain sensitive information and are automatically ignored:

-  `php/connexion.php` - Database connection credentials
-  `.env` - Environment variables
-  `*.log` - Error logs that may contain sensitive data
-  `.env.local`, `.env.production` - Environment-specific configs

### 3. Setup for New Developers

When setting up this project:

1. **Copy the connection template:**

   ```bash
   cp php/connexion.example.php php/connexion.php
   ```

2. **Edit with your credentials:**

   -  Open `php/connexion.php`
   -  Replace placeholder values with your actual database credentials
   -  NEVER commit this file

3. **Alternative: Use environment variables:**
   ```bash
   cp .env.example .env
   ```
   -  Edit `.env` with your credentials
   -  NEVER commit this file

### 4. Security Best Practices

-  ✅ All passwords are hashed using `bcrypt` (via `password_hash()`)
-  ✅ SQL queries use prepared statements (via `mysqli`)
-  ✅ Session-based authentication
-  ✅ Input validation on both client and server side
-  ⚠️ **TODO**: Implement CSRF protection
-  ⚠️ **TODO**: Add rate limiting for login attempts
-  ⚠️ **TODO**: Implement HTTPS in production

### 5. Production Deployment

When deploying to production:

1. Use strong, unique passwords
2. Enable HTTPS/SSL
3. Set appropriate file permissions (644 for files, 755 for directories)
4. Keep PHP and MySQL versions updated
5. Use environment variables instead of hardcoded credentials
6. Enable error logging but disable `display_errors` in production

### 6. Reporting Security Issues

If you discover a security vulnerability, please email:
**rayen.drira04@gmail.com**

Do NOT open a public GitHub issue for security vulnerabilities.

---

## 🔐 Credentials Template

### Local Development (XAMPP)

```php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "memora";
```

### Production

```php
$servername = "your-host.com";
$username = "your-db-username";
$password = "your-secure-password";
$dbname = "your-database-name";
```

**Remember**: The actual `php/connexion.php` file should NEVER be committed to Git!
