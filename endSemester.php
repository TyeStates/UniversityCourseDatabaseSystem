<?php
    session_start();
    require "connect.php";
    $sql = "INSERT INTO coursesTaken
            SELECT * FROM enrolled;";
    header("home.php");
?>