<?php

    session_start();

    require 'connect.php';

    $id = $_POST['id'];
    $student = $_POST['student'];

    $sql = "SELECT * FROM enrolled WHERE std_id = " . $student;
    $result = $conn->query($sql);
    if ($result->num_rows > 6){
        header("Location: search.php?searchInput=" . urlencode($id) . "&filter=enrolled&error=" . urlencode("Can't take more than 6 courses"));
        exit();
    }
    while ($row = $result->fetch_assoc()){
        if ($row['c_id'] === $id){
            header("Location: search.php?searchInput=" . urlencode($id) . "&filter=enrolled&error=" . urlencode("Already enrolled in this course"));
            exit();
        }
    }

    // only register if student has prerequisites
    $sql = "SELECT pr_id
            FROM prerequisites
            LEFT JOIN coursesTaken
            ON prerequisites.pr_id = coursesTaken.c_id
            AND coursesTaken.std_id = 2
            WHERE prerequisites.c_id = 'COMP-3753'
            AND coursesTaken.c_id IS NULL";

    $result = $conn->query($sql);

    if ($result->num_rows > 0){
        header("Location: search.php?searchInput=" . urlencode($id) . "&filter=enrolled&error=" . urlencode("Pre-requisites not satisfied"));
        exit();
    }

    $sql = "INSERT INTO enrolled (std_id, c_id) VALUES ($student, '$id')";
    $result = $conn->query($sql);
    if ($result){
        header("Location: search.php?searchInput=" . urlencode($id) . "&filter=enrolled");
        exit();
    } else {
        header("Location: search.php?searchInput=" . urlencode($id) . "&filter=enrolled&error=" . urlencode("Failed to enroll"));
        exit();
    }
?>