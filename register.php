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

                        header("Location: index.php");
                        exit();
                    } catch (Exception $e) {
                        $conn->rollback(); // Undo both inserts
                        header("Location: register.php?error=Failed to create account");
                        exit();
                    }
                }
            }
        } while (false);
    } 
?>
<?php
// ... existing PHP code remains exactly the same ...
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>DBMS Project</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .registration-container {
                max-width: 600px;
                margin: 2rem auto;
                padding: 2rem;
                background: #ffffff;
                border-radius: 8px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            }
            .form-label {
                font-weight: 500;
                color: #495057;
            }
            .error-message {
                color: #dc3545;
                background: #f8d7da;
                padding: 0.75rem;
                border-radius: 4px;
                margin-bottom: 1rem;
                border: 1px solid #f5c6cb;
            }
            .form-control {
                border-radius: 4px;
                padding: 0.75rem;
                border: 1px solid #ced4da;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }
            .form-control:focus {
                border-color: #80bdff;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }
            .btn-primary {
                background-color: #0d6efd;
                border: none;
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
                transition: background-color 0.15s ease-in-out;
            }
            .btn-primary:hover {
                background-color: #0b5ed7;
            }
            .login-link {
                color: #0d6efd;
                text-decoration: none;
            }
            .login-link:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body style="background-color: #f8f9fa;">
        <div class="registration-container">
            <h1 class="text-center mb-4">Student Registration</h1>
            <form method="post">
                <?php if (isset($_GET['error'])): ?>
                    <div class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>
                
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="number" class="form-label">Student Number</label>
                    <input type="text" class="form-control" id="number" name="number" placeholder="Enter student number" value="<?php echo htmlspecialchars($number); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="year" class="form-label">Year of Study</label>
                    <input type="number" class="form-control" id="year" name="year" placeholder="Enter year of study" value="<?php echo htmlspecialchars($year); ?>" required min="1" max="5">
                </div>
                <div class="mb-3">
                    <label for="major" class="form-label">Major</label>
                    <input type="text" class="form-control" id="major" name="major" placeholder="Enter your major" value="<?php echo htmlspecialchars($major); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
                <div class="text-center mt-3">
                    Already have an account? <a href="index.php" class="login-link">Login here</a>
                </div>
            </form>
        </div>
    </body>
</html>