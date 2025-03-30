<?php
    session_start();

    require "connect.php";

    $username = "";
    $password = "";
    $id = "";
    $name = "";
    $number = "";
    $year = "";
    $major = "";
    $email = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $role = 'student';

        $username = $_POST['username'];
        $password = $_POST['password'];
        $name = $_POST["name"];
        $number = $_POST["number"];
        $year = $_POST["year"];
        $major = $_POST["major"];
        $email = $_POST["email"];

        do{
            if (empty($username)) {
                header("Location: register.php?error=Username is required");
                exit();
            } else if (empty($password)) {
                header("Location: register.php?error=Password is required");
                exit();
            } else if (empty($name)) {
                header("Location: register.php?error=Name is required");
                exit();
            } else if (empty($number)) {
                header("Location: register.php?error=Number is required");
                exit();
            } else if (empty($year)) {
                header("Location: register.php?error=Year of Study is required");
                exit();
            } else if (empty($major)) {
                header("Location: register.php?error=Major is required");
                exit();
            } else if (empty($email)) {
                header("Location: register.php?error=Email is required");
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
                        $stmt = $conn->prepare("INSERT INTO student (std_id, std_name, std_number, std_major, std_yearofstudy, std_email) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param("isisis", $id, $name, $number, $major, $year, $email);
                        $stmt->execute();

                        $conn->commit(); // All good

                        $username = "";
                        $password = "";
                        $id = "";
                        $name = "";
                        $number = "";
                        $year = "";
                        $major = "";
                        $email = "";

                        header("Location: createUser.php");
                        exit();
                    } catch (Exception $e) {
                        $conn->rollback(); // Undo both inserts
                        header("Location: createStudent.php?error=Failed to create account");
                        exit();
                    }
                }
            }
        } while (false);
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
                    <label for="number" class="form-label"><strong>Student Number</strong></label>
                    <input type="text" id="number" name="number" placeholder="Student Number" value="<?php echo $number; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="year" class="form-label"><strong>Year of Study</strong></label>
                    <input type="text" id="year" name="year" placeholder="Year of Study" value="<?php echo $year; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="major" class="form-label"><strong>Major</strong></label>
                    <input type="text" id="major" name="major" placeholder="Major" value="<?php echo $major; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label"><strong>Email</strong></label>
                    <input type="text" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" $requiredFor>
                </div>
                <div class="mb-3 justify-content-center">
                    <input id="submit" type="submit" value="Submit">
                </div>
            </form>
            <a href="createUser.php">back</a>
        </div>  
    </body>
</html>