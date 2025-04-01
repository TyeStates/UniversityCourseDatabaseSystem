<?php
    session_start();
    require "connect.php";
    $db = mysqli_connect("localhost", "course_db_user", "1234", "ucprdb");
    mysqli_query($db, "INSERT INTO coursesTaken
                SELECT * FROM enrolled;");
    mysqli_query($db, "TRUNCATE TABLE enrolled;");
    header("location: home.php");
?>