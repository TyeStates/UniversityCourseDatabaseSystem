<?php
    session_start();

    require "connect.php";

    $username = "";
    $password = "";
    $p_name = "";
    $p_dep = "";
    $email = "";
    $p_office = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $role = 'professor';

        $username = $_POST['username'];
        $password = $_POST['password'];
        $p_name = $_POST["name"];
        $p_dep = $_POST["department"];
        $email = $_POST["email"];
        $p_office = $_POST["office"];
        
        do{
            if (empty($username)) {
                header("Location: register.php?error=Username is required");
                exit();
            } else if (empty($password)) {
                header("Location: register.php?error=Password is required");
                exit();
            } else if (empty($p_name)) {
                header("Location: register.php?error=Name is required");
                exit();
            } else if (empty($p_dep)) {
                header("Location: register.php?error=department is required");
                exit();
            } else if (empty($email)) {
                header("Location: register.php?error=Email is required");
                exit();
            } else if (empty($p_office)){
                header("Location: register.php?error=office is required");
                exit();
            } else {
                $sql = "SELECT * FROM user WHERE user_name = '$username' AND user_role = '$role'";
                $result = $conn->query($sql);
                if (($result->fetch_assoc()) != 0){
                    header("Location: register.php?error=Username Taken");
                    exit();
                } else {
                    $conn->begin_transaction();
                    try {
                        // Insert into User
                        $stmt = $conn->prepare("INSERT INTO user (user_name, user_pass, user_role) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss", $username, $password, $role);
                        $stmt->execute();
                        $id = $conn->insert_id;

                        // Insert into Student
                        $stmt = $conn->prepare("INSERT INTO professor (p_name, p_email, p_department, p_office) VALUES (?, ?, ?, ?, ?)");
                        $stmt->bind_param("isisis", $p_name, $email, $p_dep, $p_office);
                        $stmt->execute();

                        $conn->commit(); // All good

                        $username = "";
                        $password = "";
                        $p_name = "";
                        $p_dep = "";
                        $email = "";
                        $p_office = "";

                        header("Location: createUser.php");
                        exit();
                    } catch (Exception $e) {
                        $conn->rollback(); // Undo both inserts
                        header("Location: createProfessor.php?error=Failed to create account");
                        exit();
                    }
                }
            }
        }while (false);
    }
?>
<html>
<head>
        <title>DBMS Project</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <h1 class="text-center">Registration Page</h1>
        <div class="text-center">
            <form method="post">
                <?php
                    if (isset($_GET['error'])){
                        echo "<div>" . $_GET['error'] . "</div>";
                    }
                ?>
                <div class="mb-3">
                    <label for="username" class="form-label"><strong>Username</strong></label>
                    <input type="text" id="username" name="username" placeholder="Username" value="<?php echo $username; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"><strong>Password</strong></label>
                    <input type="text" id="password" name="password" placeholder="Password" value="<?php echo $password; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label"><strong>Name</strong></label>
                    <input type="text" id="name" name="name" placeholder="Name" value="<?php echo $name; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="department" class="form-label"><strong>department id</strong></label>
                    <input type="text" id="department" name="department" placeholder="department" value="<?php echo $number; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="office" class="form-label"><strong>Major</strong></label>
                    <input type="text" id="office" name="office" placeholder="office" value="<?php echo $major; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label"><strong>Email</strong></label>
                    <input type="text" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" $requiredFor>
                </div>
                <div class="mb-3 justify-content-center">
                    <input id="submit" type="submit" value="Submit">
                </div>
            </form>
            <a href="createUser.php" class="btn btn-warning">back</a>
        </div>  
    </body>
    
</html>