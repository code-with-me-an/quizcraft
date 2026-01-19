# Contributing to Quizcraft

First off, thanks for taking the time to contribute! We love your input!

---

## Table of Contents

- [Getting Started](#getting-started)
- [Database Setup](#database-setup)
- [Configuration](#configuration)
- [The Workflow](#the-workflow)
- [Found a Bug?](#found-a-bug)
- [Coding Guidelines](#coding-guidelines)

---

## Getting Started

To work on Quizcraft, you need to set it up on your local machine using XAMPP, WAMP, or AMPPS.

### Fork and Clone

- Fork this repository to your GitHub account
- Clone it to your local server directory (e.g., `htdocs` or `www`)

   ```bash
   git clone https://github.com/code-with-me-an/quizcraft.git
   cd quizcraft
   ```

---

## Database Setup

Follow these steps to set up the database:
1. Navigate to the `config/` folder
2. Locate the file named `database.example.php`
3. Rename it to `database.php`
4. Open `database.php` and enter your local database credentials:
   - Host: `localhost` (typically)
   - Username: `root` (typically for XAMPP)
   - Password: (empty by default for XAMPP)
   - Database: `quizcraft`
5. Open database.php file in your browser 
   `http://localhost/quizcraft/config/database.php`
6. open phpmyadmin in your browser
   `http://localhost/phpmyadmin/index.php`
7. Verify the database & tables are created successfully


---

## Configuration

To configure the application:

1. Navigate to the `config/` folder
2. Locate the file named `conn.example.php`
3. Rename it to `conn.php`
4. Open `conn.php` update your local database credentials:
   - Host: `localhost` (typically)
   - Username: `root` (typically for XAMPP)
   - Password: (empty by default for XAMPP)
   - Database: `quizcraft`

**⚠️ Important:** `conn.php` and `database.php`is ignored by Git to keep your passwords safe. Never commit your real credentials!

---


## The Workflow

### 1. Create a Feature Branch

Create a new branch for your specific task:

```bash
git checkout -b feature/my-new-feature
```

Branch naming convention:
- `feature/` for new features
- `bugfix/` for bug fixes
- `docs/` for documentation updates

### 2. Make Your Changes

Develop your feature or fix while keeping commits focused and logical.

### 3. Test Your Changes

Ensure the quiz works correctly for both:
- admin
- user

### 4. Commit Your Work

Use clear, descriptive commit messages:

```bash
git commit -m "<---add your commit details--->"
```

### 5. Push to Your Fork

Upload your branch to GitHub:

```bash
git push origin feature/my-new-feature
```

### 6. Submit a Pull Request

1. Go to the original repository
2. Click "Compare & pull request"
3. Provide a clear description of your changes
4. Reference any related issues
5. Wait for review and feedback

---

## Found a Bug?

If you find a bug, please create a GitHub Issue. Be sure to include:

- **Description:** A clear description of the bug
- **Steps to Reproduce:** Detailed steps (e.g., "Login as student → Click Start → Error appears")
- **Expected Behavior:** What should happen
- **Actual Behavior:** What actually happens
- **Screenshots:** If applicable
- **Environment:** Browser, OS, or server information

### Before Creating an Issue

- Check existing issues to avoid duplicates
- Test the bug on the latest version
- Gather as much information as possible

---

## Coding Guidelines

### PHP Code

- Keep logic separate from HTML where possible
- Use proper error handling and validation
- Follow PSR-2 coding standards when applicable
- Add comments for complex logic

### Indentation and Formatting

- Use 4 spaces (or configure to your preference, but be consistent)
- Keep lines reasonably sized for readability
- Use meaningful variable and function names


### Security

- Always sanitize and validate user inputs
- Use prepared statements for database queries
- Never commit sensitive information (passwords, API keys)
- Implement proper authentication and authorization checks

### Testing

- Test your code in different browsers
- Ensure no existing functionality is broken
- Validate forms and database operations

---

## Questions?

If you have questions about contributing, feel free to open an issue or contact the maintainers.

---

Thanks for helping us build a better quiz platform! 🎓