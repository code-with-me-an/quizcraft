<?php
include("../config/conn.php");
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $checkusername = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_num_rows($checkusername) > 0) {
        $error = 'username is already registered!';
    } else {
        mysqli_query($conn, "INSERT INTO users(name,username,password) VALUES ('$name','$username','$password')");
        echo "<script>window.alert('Register successfully');
                window.location.href='login.php';
                </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register page</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assets/favicon/site.webmanifest">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/RegisLogin.css">
</head>

<body>
    <div class="container">
        <div class="form-box">
            <form action="register.php" method="post" onsubmit="return validate()">
                <h2>Register</h2>
                <?php echo "<p class='error-message'>$error</p>"; ?>
                <input type="text" name="name" placeholder="Name" id="name">
                <span id="nameErr"></span>
                <input type="username" name="username" placeholder="username" id="username">
                <span id="usernameErr"></span>
                <label id="password" >
                    <input type="password" name="password" id="pwd" placeholder="Password" required>
                    <button id="viewPassword" type="button" onclick="view_password()">
                        <i class="fa-regular fa-eye eye"></i>
                        <i class="fa-regular fa-eye-slash eye-slash"></i>
                    </button>
                </label>
                <span id="passErr"></span>
                <button type="submit">Register</button>
                <p>Already have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
    <script>
        function view_password(){
            const pwd = document.getElementById("pwd");
            const viewPassword = document.getElementById("viewPassword");
            if(pwd.type === "password"){
                pwd.type = "text";
                viewPassword.classList.add("active");
            }else{
                pwd.type = "password";
                viewPassword.classList.remove("active");
            }
        }
        function validate() {
            let nameErr = document.getElementById('nameErr');
            let usernameErr = document.getElementById('usernameErr');
            let passErr = document.getElementById('passErr');

            let name = document.getElementById('name').value.trim();
            let username = document.getElementById('username').value.trim();
            let password = document.getElementById('password').value.trim();

            let validateFlag = true;
            nameErr.innerText = '';
            usernameErr.innerText = '';
            passErr.innerText = '';

            if (name == '' || name == null) {
                nameErr.innerText = '*name is required';
                validateFlag = false;
            } else {
                for (let i = 0; i < name.length; i++) {
                    let ch = name[i];
                    if (!(ch >= 'A' && ch <= 'Z') && !(ch >= 'a' && ch <= 'z') && ch !== ' ') {
                        validateFlag = false;
                        nameErr.innerText = '*name only contain alphabets';
                    }
                }
                validateFlag = true;
            }
            let lengthFlag = true;
            let formatFlag = true;
            
            if (username == '' || username == null) {
                usernameErr.innerText = '*Username is required';
                validateFlag = false;
            } else {
                if (username.length < 5 || username.length > 15) {
                    lengthFlag = false;
                }
                for (let i = 0; i < username.length; i++) {
                    let ch = username[i];
                    let isLower = (ch >= 'a' && ch <= 'z');
                    let isUpper = (ch >= 'A' && ch <= 'Z');
                    let isNumber = (ch >= '0' && ch <= '9');
                    let isUnderscore = (ch === '_');
                    if (!isLower && !isUpper && !isNumber && !isUnderscore) {
                        formatFlag = false;
                        break;
                    }
                }
                if (lengthFlag == false) {
                    usernameErr.innerText = '*username must be 5-15 characters';
                    validateFlag = false;
                } else if (formatFlag == false) {
                    usernameErr.innerText = '*only letters, numbers, and _ allowed';
                    validateFlag = false;
                } else {
                    usernameErr.innerText = '';
                    validateFlag = true;
                }
            }


            let spacial = "!@#$%^&*()";
            let spacialFlag = false;
            let alphaFlag = false;
            let lenFlag = true;

            if (password == '' || password == null) {
                passErr.innerText = '*password is required'
                validateFlag = false;
            } else {
                if (password.length < 8) {
                    lenFlag = false;
                } else {
                    for (let i = 0; i < password.length; i++) {
                        let ch = password[i];
                        if ((ch >= 'A' && ch <= 'Z')) {
                            alphaFlag = true;
                        } else if (spacial.includes(ch)) {
                            spacialFlag = true;
                        }
                    }
                }
                if (spacialFlag == false || alphaFlag == false || lenFlag == false) {
                    passErr.innerText = '*password must be 8+ char, 1 spacial & 1 Uppercase';
                    validateFlag = false;
                } else {
                    validateFlag = true;
                }
            }

            if (validateFlag == true) {
                return true;
                console.log('ho');
            } else {
                return false;
            }

        }
    </script>
</body>

</html>