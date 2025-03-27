<?php
$host = 'localhost';
$user = 'course_db_user'; 
$pass = '1234';
$dbname = 'UCPRDB';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>