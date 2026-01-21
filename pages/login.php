<?php
include("../config/conn.php");
session_start();
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    if (preg_match('/^[a-zA-Z0-9_]{5,15}$/', $username)) {
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['name'] = $user['name'];
                $_SESSION['username'] = $user['username'];
                echo "<script>window.alert('Login successfully');
                window.location.href='logged.php';
                </script>";
                exit();
            } else {
                $error = 'Incorrect username or password';
            }
        } else {
            $error = 'Incorrect username or password';
        }
    } else {
        $error = 'Incorrect username Formate';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>

    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-touch-icon.png">
    <link rel="shortcut icon" href="../assets/favicon/favicon.ico">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/RegisLogin.css">
</head>

<body>
    <div class="container">
        <div class="form-box">
            <form action="login.php" method="post" id="form">
                <h2>Login</h2>
                <?php echo "<p class='error-message'>$error</p>"; ?>
                <input type="username" name="username" placeholder="user_name" required>
                <label id="password">
                    <input type="password" name="password" id="pwd" placeholder="Password" required>
                    <button id="viewPassword" type="button" onclick="view_password()">
                        <i class="fa-regular fa-eye eye"></i>
                        <i class="fa-regular fa-eye-slash eye-slash"></i>
                    </button>
                </label>
                <button type="submit">Login</button>
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </form>
        </div>
    </div>
    <script>
        function view_password() {
            const pwd = document.getElementById("pwd");
            const viewPassword = document.getElementById("viewPassword");
            if (pwd.type === "password") {
                pwd.type = "text";
                viewPassword.classList.add("active");
            } else {
                pwd.type = "password";
                viewPassword.classList.remove("active");
            }
        }
    </script>
</body>

</html>