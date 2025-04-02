<?php
    session_start();   

    require "connect.php";

    if (!isset($_SESSION['username']) || !isset($_SESSION['password']) || !isset($_SESSION['role']) || (!$_SESSION['role'] === 'admin' && !$_SESSION['role'] === 'd_admin')){
        header("Location: index.php");
        exit();
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
            <div class="text-center">
                <h1>User Management Page</h1>
            </div>

            <!-- Search Bar -->
            <div class="mb-3">
                <form method="post" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search users by username or role...">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>

            <!-- Action Buttons -->
            <div class="mb-3">
                <a href="createUser.php" class="btn btn-success">Create User</a>
                <a href="home.php" class="btn btn-secondary">Back</a>
            </div>

            <!-- User List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Existing Users</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM user";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <td>" . htmlspecialchars($row['user_name']) . "</td>
                                            <td>" . htmlspecialchars($row['user_role']) . "</td>
                                            <td>
                                                <a href='editUser.php?id=" . $row['user_id'] . "' class='btn btn-sm btn-primary'>Edit</a>
                                                <a href='deleteUser.php?id=" . $row['user_id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>No users found.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>