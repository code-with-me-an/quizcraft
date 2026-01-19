<?php
include('../config/conn.php');
session_start();
$title = $description = '';
$error = '';
date_default_timezone_set('Asia/Kolkata');



if (!empty($_SESSION['share_code'])) {
    $share_code =  $_SESSION['share_code'] ?? '';
    $sql = "SELECT * FROM quizzes WHERE share_code = '$share_code'";
    $table = mysqli_query($conn, $sql);
    if (!$table) {
        die("error in the query " . mysqli_error($conn));
    } else {
        if (mysqli_num_rows($table) > 0) {
            $row = mysqli_fetch_assoc($table);

            $title = $row['title'] ?? '';
            $description = $row['description'] ?? '';
            $quiz_id = $row['quiz_id'] ?? '';

            $sql = "SELECT * FROM questions WHERE quiz_id = '$quiz_id'";
            $table = mysqli_query($conn, $sql);
            if (!$table) {
                die("error in the query " . mysqli_error($conn));
            } else {
                if (mysqli_num_rows($table) > 0) {
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($table)) {
                        $quizzes[$i] = array(
                            'question_text' => $row['question_text'] ?? '',
                            'option_a' => $row['option_a'] ?? '',
                            'option_b' => $row['option_b'] ?? '',
                            'option_c' => $row['option_c'] ?? '',
                            'option_d' => $row['option_d'] ?? '',
                        ) ?? '';
                        $question_id[$i] = $row['question_id'] ?? '';
                        $i++;
                    }
                }
            }
        }
    }
}


if (!empty($_POST['submit'])) {
    if (empty($_SESSION['examinee'])) {
        echo "<script>window.alert('Already submitted');
        window.close();
        </script>";
    } else {
        $examinee = $_SESSION['examinee'] ?? '';
        $ans = $_POST['answer'] ?? [];
        $total = count($ans);
        $score = 0;
        if ($total == 0) {
            $error = "Please answer the questions";
        } else {
            foreach ($ans as $qno => $option_selected) {
                if (preg_match("/^[ABCD]$/", $option_selected)) {
                    $selected = mysqli_real_escape_string($conn, $option_selected);

                    $sql = "INSERT INTO answers (examinee,quiz_id,question_id,selected_option)
                    VALUES ('$examinee','$quiz_id','$question_id[$qno]','$selected')";
                    $check_query = mysqli_query($conn, $sql);
                    if (!$check_query) {
                        die("error in the insertion " . mysqli_error($conn));
                    }

                    $sql = "SELECT correct_option FROM questions WHERE question_id = '$question_id[$qno]'";
                    $table = mysqli_query($conn, $sql);
                    if (!$table) {
                        die("error in the insertion " . mysqli_error($conn));
                    } else {
                        $checkScore = mysqli_fetch_assoc($table);
                        if ($selected == strtoupper($checkScore['correct_option'])) {
                            $score++;
                        }
                    }
                } else {
                    $error = "Invalid operation";
                }
            }
            $date = date('Y-m-d');
            $time = date('H:i:s');

            $sql = "INSERT INTO results (examinee,quiz_id,score, date, time) VAlUES ('$examinee','$quiz_id','$score','$date','$time')";
            $check_query = mysqli_query($conn, $sql);
            if (!$check_query) {
                die("error in the insertion " . mysqli_error($conn));
            }
            $scoreTotal = $score;
            echo "<script>window.alert('Submitted successfully');</script>";
            unset($_SESSION['share_code'], $_SESSION['examinee']);
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Page</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assets/favicon/site.webmanifest">

    <link rel="stylesheet" href="../assets/css/quiz.css">
    <style>
        

        
    </style>
</head>

<body>
    <?php
    echo "<div class='online-container'>";
    echo "<form action='OnlineQuiz.php' method='post'>";
    echo "<div class='quizBox' id='quizBox'>";
    echo "<h2>$title</h2>";
    echo "<p>$description</p>";
    echo "<p class='error-message'>$error</p>";
    echo isset($scoreTotal) ? "<p class='score-message'>Your Score $scoreTotal / $total</p>" : '';
    if (!empty($quizzes)) {
        foreach ($quizzes as $qno => $question) {
            echo "<h3>" . $qno . ". " . $question['question_text'] . "</h3>";
            echo "<label class='option'>A.<input type='radio' name = 'answer[$qno]' value = 'A'>&nbsp;" . $question['option_a'] . "</label>";
            echo "<label class='option'>B.<input type='radio' name = 'answer[$qno]' value = 'B'>&nbsp;" . $question['option_b'] . "</label>";
            echo "<label class='option'>C.<input type='radio' name = 'answer[$qno]' value = 'C'>&nbsp;" . $question['option_c'] . "</label>";
            echo "<label class='option'>D.<input type='radio' name = 'answer[$qno]' value = 'D'>&nbsp;" . $question['option_d'] . "</label>";
        }
    }
    echo "<button type='submit' name='submit' value='do'>Submit Quiz</button>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
    ?>
    <script>

    </script>
</body>


</html>