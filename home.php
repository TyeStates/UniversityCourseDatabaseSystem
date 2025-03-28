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
    <!--html code here-->
    <head>
        <title>DBMS Project</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="text-center content-section">
            <h1>University Course Prerequisite Database</h1>
        </div>
        <div class="text-center content-section">
            <form id="searchInput" action="search.php" method="get">
                <label for="searchInput">Course Search:</label>
                <input type="text" id="searchInput" name="searchInput" placeholder="Search">
                <input id="searchButton" type="submit" value="Search">
                <select id="filter" name="filter" placeholder="Filter By..">
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
            </form>
            <a href="logout.php">Log Out</a>
            <?php
                if ($_SESSION['role'] === 'admin' || $_SESSION['role'] == 'd_admin'){
                    echo "<div>
                        <div>
                            <a href='manageUsers.php'>Manage Users</a>
                        </div>
                        <div>
                            <a href='manageCourses.php'>Manage Courses</a>
                        </div>
                        <div>
                            <a href='manageDepartments.php'>Manage Departments</a>
                        </div>
                    </div>";
                }
            ?>
        </div>
    </body>
</html>