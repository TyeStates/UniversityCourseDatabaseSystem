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
                <h1>Course Management Page</h1>
            </div>

            <!-- Search Bar -->
            <div class="mb-3">
                <form method="post" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search courses by name or ID...">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>

            <!-- Action Buttons -->
            <div class="mb-3">
                <a href="createCourse.php" class="btn btn-success">Create Course</a>
                <a href="createSection.php" class="btn btn-info">Create Section</a>
                <a href="createPrerequisite.php" class="btn btn-warning">Create Prerequisite</a>
                <a href="home.php" class="btn btn-secondary">Back</a>
            </div>

            <!-- Course List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Existing Courses</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Course ID</th>
                                <th>Course Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM course";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <td>" . htmlspecialchars($row['c_id']) . "</td>
                                            <td>" . htmlspecialchars($row['c_name']) . "</td>
                                            <td>
                                                <a href='editCourse.php?id=" . $row['c_id'] . "' class='btn btn-sm btn-primary'>Edit</a>
                                                <a href='deleteCourse.php?id=" . $row['c_id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this course?\")'>Delete</a>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>No courses found.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>