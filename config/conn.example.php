<?php
// config/conn.example.php
// Rename this file to "conn.php" and add your settings
$servername = "localhost";
$username = "root";
$password = ""; // Leave empty or generic
$database = "quizcraft";

$conn = mysqli_connect($servername, $username, $password, $database);
?>