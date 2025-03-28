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
    <!--html code here-->
    <head>
        <title>DBMS Project</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="text-center content-section">
            <h1>Department Management Page</h1>
        </div>
        <div class="text-center content-section">
            <div>
            <form id="searchInput" method="post">
            </form>
            </div>
            <div>
            <a href="createDepartment.php">Create Department</a>
            </div>
            <a href="home.php">Back</a>
        </div>
    </body>
</html>