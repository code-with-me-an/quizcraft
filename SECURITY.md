# Security Policy

### Authentication & Password Security

- **Password Hashing:** All user passwords are hashed using PHP's `password_hash()` with `PASSWORD_DEFAULT` algorithm (bcrypt)
- **Password Verification:** Passwords are verified using `password_verify()` for secure comparison
- **Session Management:** User sessions are properly managed to prevent unauthorized access
- **Minimum Password Length:** Passwords must be at least 8 characters long

### Database Security

- **SQL Injection Prevention:** User inputs are sanitized using `mysqli_real_escape_string()` to prevent SQL injection attacks
- **Prepared Statements:** Database queries use parameterized queries where applicable
- **Connection Security:** Database credentials are stored in configuration files and never exposed in code
- **Sensitive Credentials:** Database passwords and API keys are excluded from version control via `.gitignore`

### Input Validation & Sanitization

- **Input Validation:** All user inputs are validated before processing
- **Input Sanitization:** User inputs are sanitized to remove potentially dangerous characters
- **Data Type Validation:** Proper validation of data types for all form submissions

### Code Standards & Best Practices

- **Error Handling:** Proper error handling to prevent information disclosure
- **Code Quality:** Following PSR-2 coding standards when applicable
- **Code Comments:** Complex logic includes comments for maintainability and security review
- **Dependency Management:** Regular updates of dependencies and libraries

### User Privacy & Data Protection

- **Session Security:** Sessions are managed securely to maintain user privacy
- **User Profile Management:** Users can manage their profile information securely
- **Data Integrity:** User data is protected against unauthorized modification

### Access Control

- **Authentication Checks:** Proper authentication and authorization checks are implemented
- **User Roles:** Session-based access control for different user roles (Students/Teachers)
- **Protected Routes:** Protected pages require valid user authentication

---

## Security Development Practices

When contributing to QuizCraft, please follow these security guidelines:

1. **Validate All Inputs:** Never trust user input; always validate and sanitize
2. **Use Prepared Statements:** Use parameterized queries to prevent SQL injection
3. **Never Commit Sensitive Data:** Keep passwords, API keys, and credentials out of version control
4. **Implement Authentication:** Always check user authentication before sensitive operations
5. **Error Handling:** Handle errors gracefully without exposing sensitive information
6. **Code Review:** Submit all changes for review before merging

---

## Configuration Security

### Database Configuration

```php
// Ensure config files are properly secured
$servername = "localhost";
$username = "root";
$password = "your_secure_password"; // Use strong passwords
$dbname = "quizcraft";

$conn = mysqli_connect($servername, $username, $password, $dbname);
```

### File Permissions

- Ensure configuration files have restricted read permissions
- Use `.gitignore` to prevent committing sensitive files
- Keep example configuration files (`conn.example.php`) without real credentials

---

## Security Recommendations for Deployment

1. **Use HTTPS:** Always use HTTPS/SSL certificates in production
2. **Environment Variables:** Store sensitive configuration in environment variables
3. **Regular Updates:** Keep PHP, MySQL, and all dependencies updated
4. **Firewall:** Configure proper firewall rules for database access
5. **Backup:** Regular database and code backups
6. **Monitoring:** Monitor logs for suspicious activities
7. **Rate Limiting:** Implement rate limiting on login and sensitive endpoints

---

## Known Security Considerations

- Always test security changes thoroughly before deployment
- Maintain regular code reviews for security vulnerabilities
- Keep all dependencies and frameworks updated
- Use strong, unique passwords for database and admin accounts

---

## Security Audit & Testing

- Regular security audits are recommended for production deployments
- Penetration testing should be conducted before major releases
- Security vulnerabilities are treated with highest priority

---

## Contact & Support

For security inquiries or vulnerability reports, please contact the security team. For general support and questions, please use the GitHub issues page.

---

**Last Updated:** January 19, 2026
