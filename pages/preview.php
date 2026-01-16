<?php
include("../config/conn.php");
if (!empty($_POST['preview'])) {
    $share_code = $_POST['preview'];
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


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview page</title>
    <link rel="stylesheet" href="../assets/css/quiz.css">
</head>

<body>
    <?php
    echo "<div class='online-container'>";
    echo "<form>";
    echo "<div class='quizBox' id='quizBox'>";
    echo "<h2>$title</h2>";
    echo "<p>$description</p>";
    if (!empty($quizzes)) {
        foreach ($quizzes as $qno => $question) {
            echo "<h3>" . $qno . ". " . $question['question_text'] . "</h3>";
            echo "<label class='option'>A.<input type='radio' name = 'answer[$qno]' value = 'A'>&nbsp;" . $question['option_a'] . "</label>";
            echo "<label class='option'>B.<input type='radio' name = 'answer[$qno]' value = 'B'>&nbsp;" . $question['option_b'] . "</label>";
            echo "<label class='option'>C.<input type='radio' name = 'answer[$qno]' value = 'C'>&nbsp;" . $question['option_c'] . "</label>";
            echo "<label class='option'>D.<input type='radio' name = 'answer[$qno]' value = 'D'>&nbsp;" . $question['option_d'] . "</label>";
        }
    }
    echo "<button type='button'>Submit Quiz</button>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
    ?>
    <script>

    </script>
</body>


</html>