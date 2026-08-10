<?php
$host = "localhost"; // Will be updated to AWS RDS Endpoint during deployment
$user = "admin";
$pass = "password123";
$dbname = "student_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
