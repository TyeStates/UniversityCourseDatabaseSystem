<?php
    session_start();

    require "connect.php";

    $c_name = "";
    $c_id = "";
    $d_name = "";
    $c_sharedwith = "";
    $c_connectedlab= "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $c_name = $_POST['c_name'];
        $c_id = $_POST['c_id'];
        $d_name = $_POST['d_name'];
        $c_sharedwith = $_POST['c_sharedwith'];
        $c_connectedlab = $_POST['c_connectedlab'];

        do{
            if (empty($c_name)) {
                header("Location: createCourse.php?error=Course Name is required");
                exit();
            } 
            if (empty($c_id)) {
                header("Location: createCourse.php?error=Department Code is required");
                exit();
            } 
            if (empty($d_name)) {
                header("Location: createCourse.php?error=Email is required");
                exit();
            } 
            if (empty($c_sharedwith)) {
                $c_sharedwith = NULL;
            } 
            if (empty($c_connectedlab)) {
                $c_connectedlab = NULL;
            }
            $sql = "SELECT * FROM department WHERE d_name = '$d_name'";
            $result = $conn->query($sql);
            if (($result->num_rows) === 0){
                header("Location: createCourse.php?error=No department by that name");
                exit();
            } else{
                $row = $result->fetch_assoc();
                $c_department = $row['d_id'];
            }
            $sql = "SELECT * FROM course WHERE c_id = '$c_id'";
            $result = $conn->query($sql);
            if (($result->num_rows) != 0){
                header("Location: createCourse.php?error=Course with this id already exists");
                exit();
            } else {
                $sql = "INSERT INTO course (c_name, c_id, c_department, c_sharedwith, c_connectedlab) VALUES ('$c_name', '$c_id', $c_department,'$c_sharedwith', '$c_connectedlab')";
                $result = $conn->query($sql);
                if (!$result){
                    header("Location: createCourse.php?error=Failed to create course");
                    exit();
                } else {
                    header("Location: manageCourses.php");
                    exit();
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
        <h1 class="text-center">Create Course Page</h1>
        <div class="text-center">
            <form method="post">
                <?php
                    if (isset($_GET['error'])){
                        echo "<div class='error'>" . $_GET['error'] . "</div>";
                    }
                ?>
                <div class="mb-3">
                    <label for="c_name" class="form-label"><strong>Course Name</strong></label>
                    <input type="text" id="c_name" name="c_name" placeholder="Course Name" value="<?php echo $c_name; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="c_id" class="form-label"><strong>Course ID</strong></label>
                    <input type="text" id="c_id" name="c_id" placeholder="Course ID" value="<?php echo $c_id; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="d_name" class="form-label"><strong>Department Name</strong></label>
                    <input type="text" id="d_name" name="d_name" placeholder="Demartment Name" value="<?php echo $d_name; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="c_sharedwith" class="form-label"><strong>Shared With</strong></label>
                    <input type="text" id="c_sharedwith" name="c_sharedwith" placeholder="Shared With" value="<?php echo $c_sharedwith; ?>">
                </div>
                <div class="mb-3">
                    <label for="c_connectedlab" class="form-label"><strong>Connected Lab</strong></label>
                    <input type="text" id="c_connectedlab" name="c_connectedlab" placeholder="c_connectedlab" value="<?php echo $c_connectedlab; ?>">
                </div>
                <div class="mb-3 justify-content-center">
                    <input id="submit" type="submit" value="Submit">
                </div>
                <div class="mb-3">
                    <a href='manageCourses.php'>Back</a>
                </div>
            </form>
        </div>  
    </body>
</html>