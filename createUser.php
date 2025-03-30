<?php
    session_start();

    require "connect.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $select = $_POST["CreateFilter"];
        if($select === "student"){
            header("location: createStudent.php");
            exit();
        }
        else if ($select === "professor"){
            header('location: createProfessor.php');
            exit();
        }
    }
?>

<html>
    <head>
        <title>DBMS Project</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <h1 class="text-center">Create User</h1>
        <div class="text-center">
            <form action="createUser.php" method="post">
                <?php
                    if (isset($_GET['error'])){
                        echo "<div class='error'>" . $_GET['error'] . "</div>";
                    }
                ?>
                <div class="mb-3">
                    <label for="CreateFilter" class="form-label"><strong>User Type</strong></label>
                    <select id="CreateFilter" name="CreateFilter" placeholder="User Type" required>
                        <option value="student">Student</option>
                        <option value="professor">Professor</option>
                    </select>
                </div>
                <div class="mb-3 justify-content-center">
                    <input id="submit" type="submit" value="Submit">
                </div>
            </form>
            <div>
                <a href="manageUsers.php" class="btn btn-warning">back</a>
            </div>
        </div>  
    </body>
    
</html>
