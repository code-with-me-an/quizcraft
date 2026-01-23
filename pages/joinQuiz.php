<?php
include("../config/conn.php");
session_start();
$error = '';
$ShareCode = $_GET["code"] ?? '';

if (!empty($_POST['submit'])) {
    $link = $_POST['link'] ?? '';
    $examinee = $_POST['examinee'] ?? '';
    $link = trim($link);
    $examinee = trim($examinee);

    if (preg_match("/^[A-Z0-9]+/", $link) && preg_match("/^[A-z]+/", $examinee)) {

        $link = mysqli_real_escape_string($conn, $link);
        $examinee = mysqli_real_escape_string($conn, $examinee);

        $sql = "SELECT * FROM quizzes WHERE share_code = '$link'";
        $table = mysqli_query($conn, $sql);
        if (!$table) {
            die("error in the query " . mysqli_error($conn));
        } else {
            if (mysqli_num_rows($table) == 1) {
                $row = mysqli_fetch_assoc($table);
                $quiz_id = $row['quiz_id'] ?? '';

                $sql = "SELECT * FROM answers WHERE examinee = '$examinee' AND quiz_id = '$quiz_id'";
                $checkSubmit = mysqli_query($conn, $sql);
                if (!$checkSubmit) {
                    die("error in the query " . mysqli_error($conn));
                } else {
                    if (mysqli_num_rows($checkSubmit) > 0) {
                        $error = "Already submitted";
                    } else {
                        $_SESSION['share_code'] = $link;
                        $_SESSION['examinee'] = $examinee;
                        header("Location: OnlineQuiz.php");
                        exit();
                    }
                }
            } else {
                $error = "invalid share code";
            }
        }
    } else {
        $error = "invalid input field";
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join quiz page</title>

    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-touch-icon.png">
    <link rel="shortcut icon" href="../assets/favicon/favicon.ico">
    
    <link rel="stylesheet" href="../assets/css/quiz.css">
    <style>

    </style>
</head>

<body>
    <div class="join-container">
        <form action="joinQuiz.php" method="post" id="form" onsubmit="return submitForm()">
            <div class="quizBox" id="quizBox">
                <h2>Join Quiz</h2>
                <?php
                echo "<p class='error-message'>$error</p>";
                echo "<input type='text' placeholder='Paste share code here' name='link' value=$ShareCode>";
                ?>
                <input type="text" placeholder="Enter name" name="examinee">
                <button type="submit" name='submit' value='do'>Join Quiz</button>
            </div>
        </form>

    </div>
    <script>
        function submitForm() {
            link = document.getElementsByName('link')[0].value.trim();
            examinee = document.getElementsByName('examinee')[0].value.trim();
            if ((link == null || link == '') || (examinee == null || examinee == '')) {
                window.alert("Please fill the options");
                return false;
            } else {
                return true;
            }
        }
    </script>
</body>

</html>