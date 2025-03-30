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

// Fetch department data
$sql = "SELECT * FROM department WHERE d_id = $d_id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    header("Location: manageDepartments.php?error=Department not found");
    exit();
}

$department = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $d_name = $_POST['d_name'];
    $d_code = $_POST['d_code'];
    $d_email = $_POST['d_email'];
    $d_phone = $_POST['d_phone'];
    $d_address = $_POST['d_address'];
    $d_school = $_POST['d_school'];

    // Basic validation
    if (empty($d_name) || empty($d_code) || empty($d_email) || empty($d_phone) || empty($d_address) || empty($d_school)) {
        header("Location: editDepartment.php?id=$d_id&error=All fields are required");
        exit();
    }

    // Update department
    $sql = "UPDATE department SET 
            d_name = '$d_name',
            d_code = '$d_code',
            d_email = '$d_email',
            d_phone = $d_phone,
            d_address = '$d_address',
            d_school = '$d_school'
            WHERE d_id = $d_id";

    if ($conn->query($sql)) {
        header("Location: manageDepartments.php?success=Department updated successfully");
        exit();
    } else {
        header("Location: editDepartment.php?id=$d_id&error=Failed to update department");
        exit();
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Edit Department</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit Department</h1>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>
                
                <form method="post">
                    <div class="mb-3">
                        <label for="d_name" class="form-label">Department Name</label>
                        <input type="text" class="form-control" id="d_name" name="d_name" 
                               value="<?php echo htmlspecialchars($department['d_name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="d_code" class="form-label">Department Code</label>
                        <input type="text" class="form-control" id="d_code" name="d_code" 
                               value="<?php echo htmlspecialchars($department['d_code']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="d_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="d_email" name="d_email" 
                               value="<?php echo htmlspecialchars($department['d_email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="d_phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="d_phone" name="d_phone" 
                               value="<?php echo htmlspecialchars($department['d_phone']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="d_address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="d_address" name="d_address" 
                               value="<?php echo htmlspecialchars($department['d_address']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="d_school" class="form-label">School</label>
                        <input type="text" class="form-control" id="d_school" name="d_school" 
                               value="<?php echo htmlspecialchars($department['d_school']); ?>" required>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <button type="submit" class="btn btn-primary me-md-2">Update Department</button>
                        <a href="manageDepartments.php" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>