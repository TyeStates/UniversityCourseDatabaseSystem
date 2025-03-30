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
    <head>
        <title>DBMS Project</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5">
            <h1 class="text-center mb-4">Create Course</h1>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <form method="post" onsubmit="return confirm('Are you sure you want to create this course?')">
                        <?php
                            if (isset($_GET['error'])){
                                echo "<div class='alert alert-danger mb-3'>" . htmlspecialchars($_GET['error']) . "</div>";
                            }
                        ?>
                        <div class="mb-3">
                            <label for="c_name" class="form-label"><strong>Course Name</strong></label>
                            <input type="text" class="form-control" id="c_name" name="c_name" 
                                   placeholder="Enter course name" value="<?php echo htmlspecialchars($c_name); ?>" 
                                   maxlength="100" required>
                            <div class="form-text">Maximum 100 characters</div>
                        </div>
                        <div class="mb-3">
                            <label for="c_id" class="form-label"><strong>Course ID</strong></label>
                            <input type="text" class="form-control" id="c_id" name="c_id" 
                                   placeholder="Enter course ID" value="<?php echo htmlspecialchars($c_id); ?>" 
                                   maxlength="10" required>
                            <div class="form-text">Maximum 10 characters</div>
                        </div>
                        <div class="mb-3">
                            <label for="d_name" class="form-label"><strong>Department</strong></label>
                            <select class="form-select" id="d_name" name="d_name" required>
                                <option value="">Select Department</option>
                                <?php
                                    $sql = "SELECT d_name FROM department";
                                    $result = $conn->query($sql);
                                    while ($row = $result->fetch_assoc()) {
                                        $selected = ($row['d_name'] === $d_name) ? 'selected' : '';
                                        echo "<option value='".htmlspecialchars($row['d_name'])."' $selected>".htmlspecialchars($row['d_name'])."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="c_sharedwith" class="form-label"><strong>Shared With</strong></label>
                            <input type="text" class="form-control" id="c_sharedwith" name="c_sharedwith" 
                                   placeholder="Enter shared department(s)" value="<?php echo htmlspecialchars($c_sharedwith); ?>" 
                                   maxlength="100">
                            <div class="form-text">Comma separated department names</div>
                        </div>
                        <div class="mb-3">
                            <label for="c_connectedlab" class="form-label"><strong>Connected Lab</strong></label>
                            <input type="text" class="form-control" id="c_connectedlab" name="c_connectedlab" 
                                   placeholder="Enter connected lab" value="<?php echo htmlspecialchars($c_connectedlab); ?>" 
                                   maxlength="50">
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                            <button type="submit" class="btn btn-primary me-md-2">Create Course</button>
                            <a href="manageCourses.php" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>