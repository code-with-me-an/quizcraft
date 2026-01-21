# QuizCraft   [![License](https://img.shields.io/badge/License-MIT-yellow.svg)](./LICENSE.md) ![Maintained](https://img.shields.io/badge/Maintained%3F-yes-green.svg)

**Quizcraft** is a web-based application designed for Students and Teachers to make **online exams** simple and fast. It built with PHP and MySQL that allows Teachers to create, manage, take
online quizzes and share to students with a simple interface to attend.

---
## 🎥 Demo Video

https://github.com/user-attachments/assets/4a44382b-101d-47df-a9fe-8e2551500b81

## Features

- User registration and login system
- Create and manage quizzes
- Take online quizzes
- User profile management
- Session management
- Quiz preview functionality

---

## Project Structure

```
quizcraft/
├── index.php
├── README.md
│
├── assets/
│   ├── css/
│   │   ├── home.css
│   │   ├── profile.css
│   │   ├── quiz.css 
│   │   └── RegisLogin.css
│   │
│   ├── images/
│   │
│   └── js/
│       └── scriptHome.js
│
├── config/
│   ├── conn.php
│   └── database.php
│
└── pages/
    ├── login.php
    ├── register.php
    ├── logged.php
    ├── logout.php
    ├── profile.php
    ├── joinQuiz.php
    ├── OnlineQuiz.php
    └── preview.php

```

---

## Tech Stack

- **Frontend:** HTML/CSS/JS 
- **Backend:** PHP logic
- **Database:** MySQL
- **Environment & Tools** AMPPS or XAMPP provides `Apache & phpmyadmin`

---

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/code-with-me-an/quizcraft.git
   cd quizcraft
   ```
2. **Set up the database**
   - Update database credentials in `config/database.example.php`

3. **Configure the connection**
   - Update `config/conn.example.php` with your database connection details

4. **Place project in web server**
   - Copy the entire folder to your web server's root directory (e.g., `htdocs/` for XAMPP, `www/` for AMPPS)

## Configuration

Edit `config/database.php` to configure your database connection:
```php
$host = 'localhost';
$username = 'root';
$password = 'your_password';
$database = 'quizcraft_db';
```

## Usage

1. **Access the application**
   - Navigate to `http://localhost/quizcraft/index.php` in your browser

2. **Register a new account**
   - Click "Register" and fill in the registration form

3. **Login**
   - Use your credentials to login

4. **Create or take quizzes**
   - Navigate through the dashboard to create or join quizzes

5. **Manage profile**
   - Visit your profile page to check informations and results
   - preview the created quiz

6. **Generate link & check Result**
   - copy the share code to generate sharing link
   - copy the share code to check submitted results
> for detailed explanation
[ CONTRIBUTING](./CONTRIBUTING.md)
## File Descriptions

| File | Purpose |
|------|---------|
| `index.php` | Main landing page and entry point |
| `config/conn.php` | Database connection initialization |
| `config/database.php` | Database configuration and credentials |
| `pages/login.php` | User authentication and login |
| `pages/register.php` | New user registration |
| `pages/profile.php` | User profile management |
| `pages/OnlineQuiz.php` | Quiz taking interface |
| `pages/joinQuiz.php` | Quiz joining functionality |
| `pages/preview.php` | Quiz preview before taking |
| `assets/css/*.css` | Styling for different pages |
| `assets/js/scriptHome.js` | Client-side JavaScript functionality |

---

## Contributing

We welcome contributions!

Steps:

1. Fork the repository
2. Create a new branch (`feature/my-feature`)
3. Commit changes
4. Open a Pull Request

Read more in [`CONTRIBUTING.md`](./CONTRIBUTING.md)

---
## License

This project is open source and available under the [`MIT License`](./LICENSE)

## Support

For issues or questions, please open an issue in the repository [`issues`](https://github.com/code-with-me-an/quizcraft/issues) [discussions](https://github.com/code-with-me-an/quizcraft/discussions)
