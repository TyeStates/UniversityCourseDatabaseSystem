<?php
    session_start();

    require "connect.php";

    // Check if the user is authorized (admin or department admin)
    if (!isset($_SESSION['username']) || !isset($_SESSION['password']) || !isset($_SESSION['role']) || (!$_SESSION['role'] === 'admin' && !$_SESSION['role'] === 'd_admin')) {
        header("Location: index.php");
        exit();
    }

    // Fetch user ID from the URL
    $user_id = $_GET['id'] ?? null;
    if (!$user_id) {
        header("Location: manageUsers.php?error=User ID is required");
        exit();
    }

    // Delete the user from the database
    $sql = "DELETE FROM user WHERE user_id = '$user_id'";
    if ($conn->query($sql)) {
        header("Location: manageUsers.php?success=User deleted successfully");
        exit();
    } else {
        header("Location: manageUsers.php?error=Failed to delete user");
        exit();
    }
?>