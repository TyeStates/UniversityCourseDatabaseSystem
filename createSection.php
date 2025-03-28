<?php
    session_start();

    require "connect.php";

    $s_id = "";
    $s_course = "";
    $s_loc = "";
    $s_professor = "";
    $s_days = "";
    $s_start = "";
    $s_duration = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $s_id = $_POST['s_id'];
        $s_course = $_POST['s_course'];
        $s_loc = $_POST['s_loc'];
        $s_professor = $_POST['s_professor'];
        $s_days = $_POST['s_days'];
        $s_start = $_POST['s_start'];
        $s_duration = $_POST['s_duration'];
    
        do{
            if (empty($s_id)) {
                header("Location: createSection.php?error=Section ID is required");
                exit();
            } 
            if (empty($s_course)) {
                header("Location: createSection.php?error=Course ID is required");
                exit();
            } 
            if (empty($s_loc)) {
                $s_loc = NULL; 
            } 
            if (empty($s_professor)) {
                $s_professor = NULL;
            } 
            if (empty($s_days)) {
                $s_days = NULL;
            } 
            if (empty($s_start)) {
                $s_start = NULL;
            }
            if (empty($s_duration)) {
                $s_duration = NULL;
            } 
            $sql = "SELECT * FROM course WHERE c_id = '$s_course'";
            $result = $conn->query($sql);
            if (($result->num_rows) === 0){
                header("Location: createSection.php?error=Can't find course with this id");
                exit();
            } 
            $sql = "SELECT * FROM  courseSection WHERE s_course = '$s_course'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()){
                if ($row['s_id'] === $s_id){
                    header("Location: createSection.php?error=Section already exists");
                    exit();
                }
            } 
            if ($s_professor != NULL){
                $sql = "SELECT * FROM professor WHERE p_name = '$s_professor'";
                $result = $conn->query($sql);
                if (($result->num_rows) === 0){
                    header("Location: createSection.php?error=No Professor by that name");
                    exit();
                } 
            }
            $sql = "INSERT INTO courseSection (s_id, s_course, s_loc, s_professor, s_days, s_start, s_duration) VALUES ('$s_id', '$s_course', '$s_loc', '$s_professor', '$s_days', '$s_start', '$s_duration')";
            $result = $conn->query($sql);
            if (!$result){
                header("Location: createSection.php?error=Failed to create section");
                exit();
            } else {
                header("Location: manageCourses.php");
                exit();
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
                    <label for="s_id" class="form-label"><strong>Section ID</strong></label>
                    <input type="text" id="s_id" name="s_id" placeholder="Section ID" value="<?php echo $s_id; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="s_course" class="form-label"><strong>Course ID</strong></label>
                    <input type="text" id="s_course" name="s_course" placeholder="Course ID" value="<?php echo $s_course; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="s_loc" class="form-label"><strong>Location</strong></label>
                    <input type="text" id="s_loc" name="s_loc" placeholder="Location" value="<?php echo $s_loc; ?>">
                </div>
                <div class="mb-3">
                    <label for="s_professor" class="form-label"><strong>Professor</strong></label>
                    <input type="text" id="s_professor" name="s_professor" placeholder="Professor" value="<?php echo $s_professor; ?>">
                </div>
                <div class="mb-3">
                    <label for="s_days" class="form-label"><strong>Days</strong></label>
                    <input type="text" id="s_days" name="s_days" placeholder="Days" value="<?php echo $s_days; ?>">
                </div>
                <div class="mb-3">
                    <label for="s_start" class="form-label"><strong>Start Time</strong></label>
                    <input type="text" id="s_start" name="s_start" placeholder="Start Time" value="<?php echo $s_start; ?>">
                </div>
                <div class="mb-3">
                    <label for="s_duration" class="form-label"><strong>Duration</strong></label>
                    <input type="text" id="s_duration" name="s_duration" placeholder="Duration" value="<?php echo $s_duration; ?>">
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