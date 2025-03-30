<?php
session_start();
require "connect.php";

// Check if user is authorized
if (!isset($_SESSION['username']) || !isset($_SESSION['password']) || !isset($_SESSION['role']) || (!$_SESSION['role'] === 'admin' && !$_SESSION['role'] === 'd_admin')) {
    header("Location: index.php");
    exit();
}

// Get department ID from URL
$d_id = $_GET['id'] ?? null;

if (!$d_id) {
    header("Location: manageDepartments.php?error=Invalid department ID");
    exit();
}

// Check if department exists
$sql = "SELECT * FROM department WHERE d_id = $d_id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    header("Location: manageDepartments.php?error=Department not found");
    exit();
}

// Check if department has associated courses
$sql = "SELECT * FROM course WHERE c_department = $d_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    header("Location: manageDepartments.php?error=Cannot delete department with associated courses");
    exit();
}

// Delete department
$sql = "DELETE FROM department WHERE d_id = $d_id";

if ($conn->query($sql)) {
    header("Location: manageDepartments.php?success=Department deleted successfully");
    exit();
} else {
    header("Location: manageDepartments.php?error=Failed to delete department");
    exit();
}
?>