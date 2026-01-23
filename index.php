<?php
include("config/conn.php");
session_start();
$error = '';

$sql = "SELECT Count(*) as total_users FROM users";
$table = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($table);
$userCount = $row["total_users"] ?? 100;

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
                        header("Location: pages/OnlineQuiz.php");
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
    <title>QuizCraft - Create Quizzes completely free (Open Source) </title>
    <meta name="description" content="Online Quiz Website for students and teachers to manage, create, share and learn quizzes. perfects for colleges and schools create quizzes completely free, open source software.">
    <meta name="keywords" content="quiz, online quiz, play quiz, free quiz maker, open source software, online exams, student quizzes, create quiz, quiz maker, quiz website, test knowledge, fun quiz, quiz app">
    <meta name="author" content="students at gec_kkd">

    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
    <link rel="shortcut icon" href="assets/favicon/favicon.ico">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="assets/css/home.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <a href="index.php"><img src="assets/images/logo.png" alt="Logo"></a>
            </div>
            <div class="profile">
                <a href="pages/login.php"><img src="assets/images/profile.png" alt="profile" width="20"></a>
                <div class="menu_bar" id="menu_bar">
                    <svg class="svg_menu" fill="#000000" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M6.001 7.128L6 10.438l19.998-.005L26 7.124zM6.001 21.566L6 24.876l19.998-.006.002-3.308zM6.001 14.341L6 17.65l19.998-.004.002-3.309z"></path>
                        </g>
                    </svg>
                </div>
            </div>
            <div class="dropdown" id="dropdown">
                <div class="dropdown_list">
                    <a href="pages/login.php">Login/SignUp</a>
                </div>
                <div class="dropdown_list">
                    <a href="pages/login.php">Create Quiz</a>
                </div>
                <div class="dropdown_list">
                    <a href="pages/joinQuiz.php">Join Quiz</a>
                </div>
                <div class="dropdown_list">
                    <a href="./pages/help.html">Help</a>
                </div>
                <div class="dropdown_list">
                    <a href="#contact">Contact us</a>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <section class="heading">
            <h1>Design Smarter <span>Quizzes</span> Fast</h1>
            <p>QuizCraft is <span id="changeText"></span> quiz maker</p>
        </section>
        <div class="quizboxes">
            <div class="createBox">
                <div class="createButton" onclick="loginPage('pages/login.php')">
                    <span>
                        Create Quiz
                    </span><svg class="arrow" fill="#000000" viewBox="-3.2 -3.2 38.40 38.40" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0">
                            <rect x="-3.2" y="-3.2" width="38.40" height="38.40" rx="19.2" fill="#f2f2f2" strokewidth="0"></rect>
                        </g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M17.504 26.025l.001-14.287 6.366 6.367L26 15.979 15.997 5.975 6 15.971 8.129 18.1l6.366-6.368v14.291z"></path>
                        </g>
                    </svg>
                </div>
                <div class="clickArrow">
                    <img src="assets/images/arrow1.svg" alt="click arrow">
                </div>
            </div>
            <div class="join-container">
                <form action="index.php" method="post" id="form" onsubmit="return submitForm()">
                    <div class="quizBox" id="quizBox">
                        <h2>Join Quiz</h2>
                        <?php echo "<p class='error-message'>$error</p>"; ?>
                        <input type="text" placeholder="Paste share code here" name="link">
                        <input type="text" placeholder="Enter name" name="examinee">
                        <button type="submit" name="submit" value="do">Join Quiz</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="howtomakeBox" id="help">
            <h2 class="heading">How to make a quiz</h2>
            <div class="card_container">
                <div class="card_1">
                    <h2>1</h2>
                    <div id="card_1">
                        <span>Add Quiz Title</span>
                        To start creating your quiz, first log in to the portal.
                        After logging in, add an appropriate title and description for the quiz,
                        then click the Next button at the bottom.
                    </div>
                </div>
                <div class="card_2">
                    <h2>2</h2>
                    <div id="card_2">
                        <span>Add questions</span>
                        Add the number of questions you want to create, then click the Next button.
                        This creates the question skeleton. Now you can add detailed question text,
                        options and the correct option, after click the Generate button to continue.. (maximum of 50 questions).
                    </div>
                </div>
                <div class="card_3">
                    <h2>3</h2>
                    <div id="card_3">
                        <span>Share quiz</span>
                        After the quiz is created, a unique share code and a preview are generated.
                        The share code is provided to students to attend the created quiz.
                    </div>
                </div>
            </div>
        </div>
        <div class="peoplecount">
            <p><span id="people_number">0</span>+ People Used</p>
        </div>
    </main>
    <footer>
        <div class="footer">
            <div class="company">
                <h2>QuizCraft</h2>
                <p>Quizcraft is a free and open source website provides
                    Unlimited quiz Creation, Sharing and Join. Created for students
                    and teachers to make online exams simple and fast.
                </p>
            </div>
            <div class="quicklink">
                <h2>Quick Links</h2>
                <a href="">create</a>
                <a href="">login</a>
                <a href="">Join quiz</a>
                <a href="">Create quiz</a>
            </div>
            <div class="contact" id="contact">
                <h2>Contact Us</h2>
                <p>GECK computer science student</p>
                <p>Email: code.with.me.an@gmail.com</p>
                <P>linkedin: <a href="https://www.linkedin.com/in/adithyan-kkd/" target="_blank"> adithyan-kkd</a></p>
            </div>
        </div>
        <div class="followLinks">
            <h2>Follow Us</h2>
            <div class="icons">
                <a href="https://github.com/code-with-me-an" target="_blank"><i class="fa-brands fa-square-github"></i></a>
                <a href=""><i class="fa-brands fa-square-instagram"></i></a>
                <a href=""><i class="fa-brands fa-x-twitter"></i></a>
            </div>
        </div>
        <div class="last-footer">
            <p>&copy; 2026 Quizcraft, All Rights Reserved. | Made with in India</p>
            <p><a href="https://github.com/code-with-me-an/quizcraft">Visit our GitHub Repository</a></p>
        </div>
    </footer>
    <script>
        const userCount = <?php echo $userCount; ?>;

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
    <script src="assets/js/scriptHome.js"></script>
</body>

</html>