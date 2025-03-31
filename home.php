<?php
    session_start();   

    require "connect.php";

    if (!isset($_SESSION['username']) || !isset($_SESSION['password']) || !isset($_SESSION['role'])){
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
        <style>
            .main-container {
                max-width: 100%;
                margin: 2rem auto;
                padding: 2rem;
                background: #f8f9fa;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
            .search-form {
                margin: 2rem 0;
            }
            .action-buttons {
                margin-top: 1.5rem;
            }
            .action-buttons a {
                margin: 0.5rem;
                min-width: 150px;
            }
        </style>
    </head>
    <body>
        <div class="main-container">
            <iframe src="heading.php" width="100%" height="140"></iframe>
            <div class="text-center">
                <h1 class="mb-4">University Course Prerequisite Database</h1>
                
                <form id="searchInput" action="search.php" method="get" class="search-form">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="searchInput" name="searchInput" placeholder="Search courses..." aria-label="Search courses">
                        <select class="form-select" id="filter" name="filter" style="max-width: 150px;">
                            <option value="name">Name</option>
                            <option value="id">Course ID</option>
                            <option value="department">Department</option>
                            <option value="prereq">Prerequisite</option>
                            <?php
                                if ($_SESSION['role'] === 'student'){
                                    echo "<option value='enrolled'>Enrolled</option>";
                                }
                            ?>
                        </select>
                        <button class="btn btn-primary" type="submit" id="searchButton">Search</button>
                    </div>
                </form>

                <div class="action-buttons">
                    <?php
                        if ($_SESSION['role'] === 'admin' || $_SESSION['role'] == 'd_admin'){
                            echo '<div class="d-grid gap-2">';
                            echo '<a href="manageUsers.php" class="btn btn-outline-primary">Manage Users</a>';
                            echo '<a href="manageCourses.php" class="btn btn-outline-primary">Manage Courses</a>';
                            echo '<a href="manageDepartments.php" class="btn btn-outline-primary">Manage Departments</a>';
                            echo '</div>';
                        }
                    ?>
                    <div class="mt-3">
                        <a href="logout.php" class="btn btn-danger">Log Out</a>
                    </div>
                </div>
            </div>
            <iframe src="footing.php" width="100%" height="10%">
        </div>
    </body>
</html>