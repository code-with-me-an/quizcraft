<?php
include("../config/conn.php");
session_start();
if (!isset($_SESSION['username'])) {
    header("Location:login.php");
    exit();
}
$name = $_SESSION['name'] ?? '';
$username = $_SESSION['username'] ?? '';
$scoreFlag = false;
$error = '';
if (!empty($_POST['search'])) {
    $share_code = $_POST['shareCode'] ?? '';
    $share_code = trim($share_code);
    if (!empty($share_code)) {
        if (preg_match("/^[A-Z0-9]+/", $share_code)) {
            $share_code = mysqli_real_escape_string($conn, $share_code);

            $sql = "SELECT * FROM quizzes WHERE share_code = '$share_code'";
            $table = mysqli_query($conn, $sql);
            if (!$table) {
                die("error in the query " . mysqli_error($conn));
            } else {
                if (mysqli_num_rows($table) == 1) {
                    $quizRow = mysqli_fetch_assoc($table);
                    $quiz_id = $quizRow['quiz_id'] ?? '';
                    $id = $quizRow['user_id'] ?? '';
                    $sql = "SELECT * FROM users WHERE username = '$username'";
                    $row = mysqli_query($conn, $sql);
                    if (!$row) {
                        die("query creation failed " . mysqli_error($conn));
                    } else {
                        $array = mysqli_fetch_assoc($row);
                        $user_id = $array['user_id'] ?? '';
                    }
                    if ($user_id == $id) {
                        $sql = "SELECT * FROM results WHERE quiz_id = '$quiz_id'";
                        $scoreTable = mysqli_query($conn, $sql);

                        if (!$scoreTable) {
                            die("query creation failed " . mysqli_error($conn));
                        } else {
                            if (mysqli_num_rows($scoreTable) > 0) {
                                while ($row = mysqli_fetch_assoc($scoreTable)) {
                                    $results[$row['result_id']] = array(
                                        'name' => $row['examinee'] ?? '',
                                        'score' => $row['score'] ?? '',
                                        'date' => $row['date'] ?? '',
                                        'time' => $row['time'] ?? ''
                                    ) ?? '';
                                }
                                $scoreFlag = true;
                            } else {
                                $error = "No one submitted the Quiz";
                            }
                        }
                    } else {
                        $error = "Share code is not correct";
                    }
                } else {
                    $error = "invalid quiz entry";
                }
            }
        } else {
            $error = "invalid share code";
        }
    } else {
        $error = "please enter the share code";
    }
}
?>
<?php
if (isset($_REQUEST['logout'])) {
    echo "<script>window.alert('Logout successfully');
        window.location.href='logout.php';
        </script>";
    exit();
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>User Profile</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assets/favicon/site.webmanifest">
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>

<body>
    <?php
    $quizzes = [];
    $result = [];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $row = mysqli_query($conn, $sql);
    if (!$row) {
        die("query creation failed " . mysqli_error($conn));
    } else {
        $array = mysqli_fetch_assoc($row);
        $user_id = $array['user_id'] ?? '';
    }

    $sql = "SELECT * FROM quizzes WHERE user_id = '$user_id'";
    $table = mysqli_query($conn, $sql);
    if (!$table) {
        die("query creation failed " . mysqli_error($conn));
    } else {
        if (mysqli_num_rows($table) > 0) {
            while ($row = mysqli_fetch_assoc($table)) {
                $quizzes[$row['quiz_id']] = array(
                    'title' => $row['title'] ?? '',
                    'share_code' => $row['share_code'] ?? '',
                    'date' => $row['date'] ?? '',
                    'time' => $row['time'] ?? ''
                ) ?? '';
            }
        }
    }

    ?>
    <div class="container">
        <div class="profile">
            <div class="profile-icon">
                <img src="../assets/images/profile.png" alt="profile" width="20">
            </div>
            <div class="name">
                <h2><?php echo $name; ?></h2>
                <p><?php echo $username; ?></p>
            </div>
            <div class="logout">
                <form action="profile.php">
                    <button type="submit" name="logout" value="do">logout</button>
                </form>
            </div>
        </div>

        <h3>Latest Quizzes</h3>
        <div class="quiz-list">
            <div class="quiz-row header">
                <div>Quiz Title</div>
                <div>Preview</div>
                <div>Share Code</div>
                <div>Date</div>
                <div>Time</div>
            </div>
            <?php
            if (mysqli_num_rows($table) > 0) {
                foreach ($quizzes as $quiz_id => $quiz) { ?>
                    <div class="quiz-row">
                        <div class="title"><?php echo $quiz['title']; ?></div>
                        <div><?php
                                $share_code = $quiz['share_code'];
                                echo "<form action='preview.php' method='post'><button type='submit' name='preview' value='$share_code'>Link</button></form>"; ?>
                        </div>
                        <div><?php echo $quiz['share_code']; ?></div>
                        <div><?php echo $quiz['date']; ?></div>
                        <div><?php echo $quiz['time']; ?></div>
                    </div>
            <?php }
            } ?>
        </div>
        <div class="share-container">
            <form onsubmit="return linkGenerator()">
                <label for="shareCode">For Link:</label>
                <div>
                    <input type="text" name="shareCode" placeholder="Share Code" id="shareCode" required>
                    <button type="submit">Generate</button>
                </div>
            </form>
        </div>
        <div class="link-container" id="link-container">
            
        </div>
        <div class="search-container">
            <form action="profile.php" method="post">
                <label for="shareCode">For Result:</label>
                <div>
                    <input type="text" name="shareCode" placeholder="Share Code" id="shareCode" required>
                    <button type="submit" name="search" value="do">Search</button>
                </div>
            </form>
        </div>
        <?php echo "<p class='error-message'>$error</p>"; ?>
        <h3>Quiz Results</h3>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Score</th>
                    <th>Submitted At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($scoreFlag) {
                    foreach ($results as $result_id => $result) { ?>
                        <tr>
                            <td><?php echo $result['name']; ?></td>
                            <td><?php echo $result['score']; ?></td>
                            <td>
                                <?php echo "&nbsp; Date: " . $result['date']; ?>
                                <?php echo "&nbsp; Time: " . $result['time']; ?>
                            </td>
                        </tr>
                <?php }
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        flag=true;
        function linkGenerator() {
            if(flag == false) return false;
            flag = false;
            let code = document.getElementById("shareCode").value.trim();
            const link = document.createElement("a");
            let url = "localhost/quizcraft/pages/joinQuiz.php?code=" + code;
            link.href = "http://" + url;
            link.textContent = url;
            link.target = "_blank";
            document.getElementById("link-container").appendChild(link);
            document.getElementById("link-container").innerHTML += "<div><button onclick='shareQuiz()'><img src='assets/images/share.svg' height='40' ><span>Share</span></button><button onclick='copyLink()'><img src='assets/images/link.svg' height='40' ><span>Copy</span></button></div>";
            return false;
        }

        function shareQuiz() {
            let code = document.getElementById("shareCode").value.trim();
            let link = "http://localhost/quizcraft/pages/joinQuiz.php?code=" + code;
            if (navigator.share) {
                navigator.share({
                    title: "Check this out!",
                    text: "visit my quiz",
                    url: link
                });
            }
        }
        function copyLink() {
            let code = document.getElementById("shareCode").value.trim();
            let link = "http://localhost/quizcraft/pages/joinQuiz.php?code=" + code;
            navigator.clipboard.writeText(link);
        }
    </script>
</body>

</html>