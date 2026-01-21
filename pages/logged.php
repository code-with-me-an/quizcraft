<?php
include("../config/conn.php");
session_start();

$sql = "SELECT Count(*) as total_users FROM users";
$table = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($table);
$userCount = $row["total_users"] ?? 100;
if (empty($_SESSION['username'])) {
    header("Location:login.php");
    exit();
}
date_default_timezone_set('Asia/Kolkata');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correct_option = $_POST['correct_option'] ?? [];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc =  mysqli_real_escape_string($conn, $_POST['desc']);
    $share_code = strtoupper(bin2hex(random_bytes(3)));

    $username = $_SESSION['username'] ?? '';
    $table = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
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
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-touch-icon.png">
    <link rel="shortcut icon" href="../assets/favicon/favicon.ico">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="../assets/css/home.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <a href="index.php"><img src="../assets/images/logo.png" alt="Logo"></a>
            </div>
            <div class="profile">
                <a href="profile.php"><img src="../assets/images/profile.png" alt="profile" width="20"></a>
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
                    <a href="help.html">Help</a>
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
        <div class="quizboxes" id="quizboxes">
            <div class="generate-container">
                <form action="logged.php" method="post" id="form" onsubmit="return checkValid()">
                    <div class="quizBox active" id="quizBox1">
                        <h2>Generate Quiz</h2>
                        <span id="emptyError1"></span>
                        <input type="text" name="title" id="name" placeholder="Quiz title">
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

        function nextBox(quizBox) {
            document.getElementById("emptyError1").innerText = "";
            document.getElementById("emptyError2").innerText = "";
            quizName = document.getElementById("name").value.trim();
            quizDesc = document.getElementById("desc").value.trim();
            if (quizBox == 1) {
                if ((quizName != "" && quizName != null) && (quizDesc != "" && quizDesc != null)) {
                    document.getElementById("quizBox" + quizBox).classList.remove("active");
                    document.getElementById("quizBox" + (quizBox + 1)).classList.add("active");
                } else {
                    document.getElementById("emptyError1").innerText = "empty input field";
                }
            } else if (quizBox == 2) {
                num = document.getElementById("numQues").value.trim();
                if (num != null && num != "") {
                    if (isNaN(num)) {
                        document.getElementById("emptyError2").innerText = "not a number";
                    } else {
                        document.getElementById("quizBox" + quizBox).classList.remove("active");
                        document.getElementById("quizBox" + (quizBox + 1)).classList.add("active");

                        container = document.getElementById("quizBox3");
                        if (num <= 50) {
                            console.log("hi");
                            container.innerHTML = '';
                            for (let i = 1; i <= num; i++) {
                                container.innerHTML += `
                        <h3>Question ${i}</h3>
                        <textarea name="question_text[${i}]" placeholder="Question ${i}" required></textarea>
                        <input type="text" name="option_a[${i}]" placeholder="Option A" required>
                        <input type="text" name="option_b[${i}]" placeholder="Option B" required>
                        <input type="text" name="option_c[${i}]" placeholder="Option C" required>
                        <input type="text" name="option_d[${i}]" placeholder="Option D" required>
                        Correct Option (A/B/C/D):
                        <input type="text" name="correct_option[${i}]" maxlength="1" required>
                        `;
                            }
                            container.innerHTML += "<div class='buttons'><button type='button' onclick='prevBox(3)'>Previous</button><button type='submit'>Publish</button></div>"
                        } else {
                            alert('you can create upto 50 quizzes');
                        }
                    }
                } else {
                    document.getElementById("emptyError2").innerText = "empty input field";
                }
            }
        }

        function prevBox(quizBox) {
            document.getElementById("quizBox" + quizBox).classList.remove("active");
            document.getElementById("quizBox" + (quizBox - 1)).classList.add("active");
        }

        function checkValid() {
            let num = document.getElementById("numQues").value.trim();
            let str = "ABCD";
            let submitFlag = true;

            for (let i = 1; i <= num; i++) {
                let val = document.getElementsByName('correct_option[' + i + ']')[0].value.trim();
                if (!str.includes(val) || val == '') {
                    alert('Please enter a valid correct option (A, B, C, or D) for question ' + i);
                    submitFlag = false;
                    break;
                }
            }
            if (num == 0) {
                alert("No questions Added");
                submitFlag = false;
            }
            return submitFlag;
        }
    </script>
    <script src="../assets/js/scriptHome.js"></script>
</body>

</html>