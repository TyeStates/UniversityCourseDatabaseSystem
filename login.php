<?php

    session_start();

    require "connect.php";

    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['loginFilter'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['loginFilter'];

        if (empty($username)) {
            header("Location: index.php?error=Username is required");
            exit();
        } else if (empty($password)) {
            header("Location: index.php?error=Password is required");
            exit();
        } else if (empty($role)) {
            header("Location: index.php?error=User Type is required");
            exit();
        } else {
            $sql = "SELECT * FROM user WHERE user_name = '$username' AND user_role = '$role'";
            $result = $conn->query($sql);
            if (($row = $result->fetch_assoc()) < 1){
                header("Location: index.php?error=Username Not Recognized");
                exit();
            } else {
                if ($row['user_pass'] != $password){
                    header("Location: index.php?error=Incorrect Password");
                    exit();
                } else {
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    $_SESSION['role'] = $role;
                    $_SESSION['id'] = $row['user_id'];
                    header("Location: home.php");
                    exit();
                }
            }
        }
    } else {
        header("Location: index.php");
        exit();
    }
?>