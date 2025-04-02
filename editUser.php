<?php
    session_start();

    require "connect.php";

    // Check if the user is authorized (admin or department admin)
    if (!isset($_SESSION['username']) || !isset($_SESSION['password']) || !isset($_SESSION['role']) || (!$_SESSION['role'] === 'admin' && !$_SESSION['role'] === 'd_admin')) {
        header("Location: index.php");
        exit();
    }

    // Fetch user details based on the ID passed in the URL
    $user_id = $_GET['id'] ?? null;
    if (!$user_id) {
        header("Location: manageUsers.php?error=User ID is required");
        exit();
    }

    $sql = "SELECT * FROM user WHERE user_id = '$user_id'";
    $result = $conn->query($sql);
    if ($result->num_rows === 0) {
        header("Location: manageUsers.php?error=User not found");
        exit();
    }
    $user = $result->fetch_assoc();

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        if (empty($username) || empty($password) || empty($role)) {
            header("Location: editUser.php?id=$user_id&error=All fields are required");
            exit();
        }

        // Update the user in the database
        $sql = "UPDATE user SET user_name = '$username', user_pass = '$password', user_role = '$role' WHERE user_id = '$user_id'";
        if ($conn->query($sql)) {
            header("Location: manageUsers.php?success=User updated successfully");
            exit();
        } else {
            header("Location: editUser.php?id=$user_id&error=Failed to update user");
            exit();
        }
    }
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>DBMS Project</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-4">
            <h1 class="text-center">Edit User</h1>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form method="post">
                        <!-- Error Display -->
                        <?php
                            if (isset($_GET['error'])) {
                                echo "<div class='alert alert-danger'>" . htmlspecialchars($_GET['error']) . "</div>";
                            }
                        ?>
                        <!-- Username Input -->
                        <div class="mb-3">
                            <label for="username" class="form-label"><strong>Username</strong></label>
                            <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($user['user_name']); ?>" required>
                        </div>
                        <!-- Password Input -->
                        <div class="mb-3">
                            <label for="password" class="form-label"><strong>Password</strong></label>
                            <input type="password" id="password" name="password" class="form-control" value="<?php echo htmlspecialchars($user['user_pass']); ?>" required>
                        </div>
                        <!-- Role Input -->
                        <div class="mb-3">
                            <label for="role" class="form-label"><strong>Role</strong></label>
                            <select id="role" name="role" class="form-control" required>
                                <option value="student" <?php echo $user['user_role'] === 'student' ? 'selected' : ''; ?>>Student</option>
                                <option value="professor" <?php echo $user['user_role'] === 'professor' ? 'selected' : ''; ?>>Professor</option>
                                <option value="d_admin" <?php echo $user['user_role'] === 'd_admin' ? 'selected' : ''; ?>>Department Admin</option>
                                <option value="admin" <?php echo $user['user_role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            </select>
                        </div>
                        <!-- Submit Button -->
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </div>
                        <!-- Back Button -->
                        <div class="mb-3 text-center">
                            <a href="manageUsers.php" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>