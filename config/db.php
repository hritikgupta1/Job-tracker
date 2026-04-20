<?php
$conn = new mysqli("localhost", "root", "", "job_tracker");

if ($conn->connect_error) {
    die("DB Error: " . $conn->connect_error);
}
?>