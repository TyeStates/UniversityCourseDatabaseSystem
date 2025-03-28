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
    <!--html code here-->
    <head>
        <title>DBMS Project</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <h1 class="text-center">Create Department Page</h1>
        <div class="text-center">
            <form method="post">
                <?php
                    if (isset($_GET['error'])){
                        echo "<div class='error'>" . $_GET['error'] . "</div>";
                    }
                ?>
                <div class="mb-3">
                    <label for="d_name" class="form-label"><strong>Department Name</strong></label>
                    <input type="text" id="d_name" name="d_name" placeholder="Department Name" value="<?php echo $d_name; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="d_code" class="form-label"><strong>Department Code</strong></label>
                    <input type="text" id="d_code" name="d_code" placeholder="Department Code" value="<?php echo $d_code; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="d_email" class="form-label"><strong>Email</strong></label>
                    <input type="text" id="d_email" name="d_email" placeholder="Email" value="<?php echo $d_email; ?>" require>
                </div>
                <div class="mb-3">
                    <label for="d_phone" class="form-label"><strong>Phone Number</strong></label>
                    <input type="text" id="d_phone" name="d_phone" placeholder="Phone Number" value="<?php echo $d_phone; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="d_address" class="form-label"><strong>Address</strong></label>
                    <input type="text" id="d_address" name="d_address" placeholder="Address" value="<?php echo $d_address; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="d_school" class="form-label"><strong>School</strong></label>
                    <input type="text" id="d_school" name="d_school" placeholder="School" value="<?php echo $d_school; ?>" required>
                </div>
                <div class="mb-3 justify-content-center">
                    <input id="submit" type="submit" value="Submit">
                </div>
                <div class="mb-3">
                    <a href='manageDepartments.php'>Back</a>
                </div>
            </form>
        </div>  
    </body>
</html>