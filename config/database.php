<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "quizcraft";

$conn = mysqli_connect($servername,$username,$password);
if(!$conn){
    die("connection error". mysqli_connect_error());
}else{
    echo "connected successfully<br>";
}


$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if(!mysqli_query($conn,$sql)){
    die("error".mysqli_connect_error());
}else{
    echo "database creaed successfully<br>";
}


mysqli_close($conn);

$conn = mysqli_connect($servername,$username,$password,$dbname);

if(!$conn){
    die("connection error". mysqli_connect_error());
}else{
    echo "database connected successfully<br>";
}

$sql = 'CREATE TABLE IF NOT EXISTS users(
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
)';

if(!mysqli_query($conn,$sql)){
    die("error".mysqli_error($conn));
}else{
    echo "ueser table creaed successfully<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS quizzes (
    quiz_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    user_id INT,
    share_code VARCHAR(50) UNIQUE,
    date DATE ,
    time TIME ,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
)";
if(!mysqli_query($conn,$sql)){
    die("error".mysqli_error($conn));
}else{
    echo "quizzes table creaed successfully<br>";
}


$sql = "CREATE TABLE IF NOT EXISTS questions (
    question_id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT,
    question_text TEXT NOT NULL,
    option_a VARCHAR(255),
    option_b VARCHAR(255),
    option_c VARCHAR(255),
    option_d VARCHAR(255),
    correct_option CHAR(1),
    FOREIGN KEY (quiz_id) REFERENCES quizzes(quiz_id) ON DELETE CASCADE
)";
if(!mysqli_query($conn,$sql)){
    die("error".mysqli_error($conn));
}else{
    echo "questions table creaed successfully<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS answers (
    answer_id INT AUTO_INCREMENT PRIMARY KEY,
    examinee VARCHAR(200) NOT NULL,
    quiz_id INT,
    question_id INT,
    selected_option CHAR(1),
    FOREIGN KEY (quiz_id) REFERENCES quizzes(quiz_id),
    FOREIGN KEY (question_id) REFERENCES questions(question_id)
)";
if(!mysqli_query($conn,$sql)){
    die("error".mysqli_error($conn));
}else{
    echo "answers table creaed successfully<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS results (
    result_id INT AUTO_INCREMENT PRIMARY KEY,
    examinee VARCHAR(200) NOT NULL,
    quiz_id INT,
    score INT,
    date DATE,
    time TIME,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(quiz_id)
)";
if(!mysqli_query($conn,$sql)){
    die("error".mysqli_error($conn));
}else{
    echo "result table creaed successfully<br>";
}



?>