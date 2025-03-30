<?php
    session_start();

    require "connect.php";

    $d_name = "";
    $d_code = "";
    $d_email = "";
    $d_phone = "";
    $d_address = "";
    $d_school = "";


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $d_name = $_POST['d_name'];
        $d_code = $_POST['d_code'];
        $d_email = $_POST["d_email"];
        $d_phone = $_POST["d_phone"];
        $d_address = $_POST["d_address"];
        $d_school = $_POST["d_school"];

        do{
            if (empty($d_name)) {
                header("Location: createDepartment.php?error=Department Name is required");
                exit();
            } else if (empty($d_code)) {
                header("Location: createDepartment.php?error=Department Code is required");
                exit();
            } else if (empty($d_email)) {
                header("Location: createDepartment.php?error=Email is required");
                exit();
            } else if (empty($d_phone)) {
                header("Location: createDepartment.php?error=Phone Number is required");
                exit();
            } else if (empty($d_address)) {
                header("Location: createDepartment.php?error=Address is required");
                exit();
            } else if (empty($d_school)) {
                header("Location: createDepartment.php?error=School is required");
                exit();
            } else {
                $sql = "SELECT * FROM department WHERE d_name = '$d_name'";
                $result = $conn->query($sql);
                if (($result->num_rows) != 0){
                    header("Location: createDepartment.php?error=Department Already Exists");
                    exit();
                } else {
                    $sql = "INSERT INTO department (d_name, d_code, d_email, d_phone, d_address, d_school) VALUES ('$d_name', '$d_code', '$d_email', $d_phone, '$d_address', '$d_school')";
                    $result = $conn->query($sql);
                    if (!$result){
                        header("Location: createDepartment.php?error=Failed to create department");
                        exit();
                    } else {
                        header("Location: manageDepartments.php");
                        exit();
                    }
                }
            }
        } while (false);
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
        <div class="container mt-5">
            <h1 class="text-center mb-4">Create Department</h1>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <form method="post" onsubmit="return confirm('Are you sure you want to create this department?')">
                        <?php
                            if (isset($_GET['error'])){
                                echo "<div class='alert alert-danger mb-3'>" . htmlspecialchars($_GET['error']) . "</div>";
                            }
                        ?>
                        <div class="mb-3">
                            <label for="d_name" class="form-label"><strong>Department Name</strong></label>
                            <input type="text" class="form-control" id="d_name" name="d_name" 
                                   placeholder="Enter department name" value="<?php echo htmlspecialchars($d_name); ?>" 
                                   maxlength="100" required>
                            <div class="form-text">Maximum 100 characters</div>
                        </div>
                        <div class="mb-3">
                            <label for="d_code" class="form-label"><strong>Department Code</strong></label>
                            <input type="text" class="form-control" id="d_code" name="d_code" 
                                   placeholder="Enter department code" value="<?php echo htmlspecialchars($d_code); ?>" 
                                   maxlength="10" required>
                            <div class="form-text">Maximum 10 characters</div>
                        </div>
                        <div class="mb-3">
                            <label for="d_email" class="form-label"><strong>Email</strong></label>
                            <input type="email" class="form-control" id="d_email" name="d_email" 
                                   placeholder="Enter email address" value="<?php echo htmlspecialchars($d_email); ?>" 
                                   maxlength="100" required>
                        </div>
                        <div class="mb-3">
                            <label for="d_phone" class="form-label"><strong>Phone Number</strong></label>
                            <input type="tel" class="form-control" id="d_phone" name="d_phone" 
                                   placeholder="Enter phone number" value="<?php echo htmlspecialchars($d_phone); ?>" 
                                   maxlength="15" required>
                            <div class="form-text">Format: +1234567890</div>
                        </div>
                        <div class="mb-3">
                            <label for="d_address" class="form-label"><strong>Address</strong></label>
                            <input type="text" class="form-control" id="d_address" name="d_address" 
                                   placeholder="Enter address" value="<?php echo htmlspecialchars($d_address); ?>" 
                                   maxlength="200" required>
                        </div>
                        <div class="mb-3">
                            <label for="d_school" class="form-label"><strong>School</strong></label>
                            <input type="text" class="form-control" id="d_school" name="d_school" 
                                   placeholder="Enter school name" value="<?php echo htmlspecialchars($d_school); ?>" 
                                   maxlength="100" required>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                            <button type="submit" class="btn btn-primary me-md-2">Create Department</button>
                            <a href="manageDepartments.php" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>