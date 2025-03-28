<!DOCTYPE HTML>
<html>
    <!--html code here-->
    <head>
        <title>DBMS Project</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <h1 class="text-center">Login Page</h1>
        <div class="text-center">
            <form action="login.php" method="post">
                <?php
                    if (isset($_GET['error'])){
                        echo "<div class='error'>" . $_GET['error'] . "</div>";
                    }
                ?>
                <div class="mb-3">
                    <label for="username" class="form-label"><strong>Username</strong></label>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"><strong>Password</strong></label>
                    <input type="text" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="mb-3">
                    <label for="loginFilter" class="form-label"><strong>User Type</strong></label>
                    <select id="loginFilter" name="loginFilter" placeholder="User Type" required>
                        <option value="student">Student</option>
                        <option value="professor">Professor</option>
                        <option value="d_admin">Department Admin</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="mb-3 justify-content-center">
                    <input id="submit" type="submit" value="Submit">
                </div>
                <div class="mb-3">
                    <a href='register.php'>Register</a>
                </div>
            </form>
        </div>  
    </body>
</html>
