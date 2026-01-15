<?php
include("conn.php");
session_start();
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    if(preg_match('/^[a-zA-Z0-9_]{5,15}$/', $username)){
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
        }else{
             $error = 'Incorrect username or password';
        }
    }else{
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
    <link rel="stylesheet" href="style/RegisLogin.css">
</head>

<body>
    <div class="container">
        <div class="form-box">
            <form action="login.php" method="post" id="form">
                <h2>Login</h2>
                <?php echo "<p class='error-message'>$error</p>"; ?>
                <input type="username" name="username" placeholder="user_name" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </form>
        </div>
    </div>
    <script>
    </script>
</body>

</html>