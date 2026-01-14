<?php
include("conn.php");
session_start();
if (empty($_SESSION['email'])) {
    header("Location:login.php");
    exit();
}
date_default_timezone_set('Asia/Kolkata');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correct_option = $_POST['correct_option'] ?? [];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc =  mysqli_real_escape_string($conn, $_POST['desc']);
    $share_code = strtoupper(bin2hex(random_bytes(3)));

    $email = $_SESSION['email'] ?? '';
    $table = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    $array = mysqli_fetch_assoc($table);
    $user_id = $array['user_id'] ?? '';

    $date = date('Y-m-d');
    $time = date('H:i:s');

    $sql = "INSERT INTO quizzes (title,description,user_id,share_code,date,time)
        VALUES ('$title','$desc','$user_id','$share_code','$date','$time')";

    $check_query = mysqli_query($conn, $sql);
    if (!$check_query) {
        die("query creation failed " . mysqli_error($conn));
    } else {
        $table = mysqli_query($conn, "SELECT * FROM quizzes WHERE share_code = '$share_code'");
        if (!$table) {
            die("error" . mysqli_error($conn));
        }
        $array = mysqli_fetch_assoc($table);
        $quiz_id = $array['quiz_id'];

        $questions = $_POST['question_text'] ?? [];
        $option_a = $_POST['option_a'] ?? [];
        $option_b = $_POST['option_b'] ?? [];
        $option_c = $_POST['option_c'] ?? [];
        $option_d = $_POST['option_d'] ?? [];
        $correct_option = $_POST['correct_option'] ?? [];
        foreach ($questions as $i => $question_text) {
            $q = mysqli_real_escape_string($conn, $question_text) ?? 'Null';
            $a = mysqli_real_escape_string($conn, $option_a[$i]) ?? 'Null';
            $b = mysqli_real_escape_string($conn, $option_b[$i]) ?? 'Null';
            $c = mysqli_real_escape_string($conn, $option_c[$i]) ?? 'Null';
            $d = mysqli_real_escape_string($conn, $option_d[$i]) ?? 'Null';
            $ans = mysqli_real_escape_string($conn, $correct_option[$i]) ?? '';
            if (preg_match("/^[ABCD]$/i", $ans)) {
                $error = true;
                $sql = "INSERT INTO questions (quiz_id,question_text,option_a,option_b,option_c,option_d,correct_option)
                     VALUES ('$quiz_id','$q','$a','$b','$c','$d','$ans')";

                $check_query = mysqli_query($conn, $sql);
                if (!$check_query) {
                    die("query creation failed " . mysqli_error($conn));
                }
            }
        }
        echo "<script>
        alert('Quiz created successfully');
        window.location.href='profile.php';
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
    <title>QuizCraft</title>
    <meta name="description" content="Online Quiz Website for Fun and Learning">
    <meta name="keywords" content="quiz, online quiz, play quiz, create quiz, quiz maker, quiz website, test knowledge, fun quiz, quiz app">
    <meta name="author" content="students at gec_kkd">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="style/home.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <a href="index.php"><img src="photo/logo.png" alt="Logo"></a>
            </div>
            <div class="profile">
                <a href="profile.php"><img src="photo/profile.png" alt="profile" width="20"></a>
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
                    <a href="login.php">Login/SignUp</a>
                </div>
                <div class="dropdown_list">
                    <a href="#quizboxes">Create Quiz</a>
                </div>
                <div class="dropdown_list">
                    <a href="joinQuiz.php">Join Quiz</a>
                </div>
                <div class="dropdown_list">
                    <a href="#help">Help</a>
                </div>
                <div class="dropdown_list">
                    <a href="#contact">Contact us</a>
                </div>
                <div class="dropdown_list">
                    <a href="#">Privacy & Security</a>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <section class="heading">
            <h1>Design Smarter <span>Quizzes</span> Fast</h1>
            <p>QuizCraft is the <span id="changetext">easiest</span> quiz maker</p>
        </section>
        <div class="quizboxes" id="quizboxes">
            <div class="generate-container">
                <form action="logged.php" method="post" id="form" onsubmit="return checkValid()">
                    <div class="quizBox active" id="quizBox1">
                        <h2>Generate Quiz</h2>
                        <span id="emptyError1"></span>
                        <input type="text" name="title" id = "name" placeholder="Quiz title">
                        <textarea name="desc" id="desc" placeholder="Quiz Description" rows="5"></textarea>
                        <div class="buttons">
                            <button type="button" onclick="nextBox(1)">Next</button>
                        </div>
                    </div>
                    <div class="quizBox" id="quizBox2">
                        <h2>Add Questions</h2>
                        <label for="numQues">Enter number of questions : <span id="max">(max 50)</span></label>
                        <span id="emptyError2"></span>
                        <input type="text" name="num_ques" id="numQues" placeholder="Number">
                        <div class="buttons">
                            <button type="button" onclick="prevBox(2)">Previous</button>
                            <button type="button" onclick="nextBox(2)" id="addQues">Next</button>
                        </div>
                    </div>
                    <div class="quizBox" id="quizBox3">
                        <span id="emptyError3"></span>
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
                <a href="https://www.instagram.com/v1be_code?" target="_blank"><i class="fa-brands fa-square-instagram"></i></a>
                <a href=""><i class="fa-brands fa-x-twitter"></i></a>
            </div>
        </div>
        <p>&copy; 2026 Quizcraft, All Rights Reserved. | Made with in India</p>
    </footer>
    <script>

    </script>
    <script src="script.js"></script>
    <script src="scriptHome.js"></script>
</body>

</html>