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
            .section-container {
                max-width: 800px;
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
            .back-link {
                color: #0d6efd;
                text-decoration: none;
            }
            .back-link:hover {
                text-decoration: underline;
            }
            .form-group-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
                margin-bottom: 1rem;
            }
        </style>
    </head>
    <body style="background-color: #f8f9fa;">
        <div class="section-container">
            <h1 class="text-center mb-4">Create Course Section</h1>
            <form method="post">
                <?php if (isset($_GET['error'])): ?>
                    <div class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>
                
                <div class="form-group-grid">
                    <div class="mb-3">
                        <label for="s_id" class="form-label">Section ID</label>
                        <input type="text" class="form-control" id="s_id" name="s_id" placeholder="Enter section ID" value="<?php echo htmlspecialchars($s_id); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="s_course" class="form-label">Course ID</label>
                        <input type="text" class="form-control" id="s_course" name="s_course" placeholder="Enter course ID" value="<?php echo htmlspecialchars($s_course); ?>" required>
                    </div>
                </div>
                
                <div class="form-group-grid">
                    <div class="mb-3">
                        <label for="s_loc" class="form-label">Location</label>
                        <input type="text" class="form-control" id="s_loc" name="s_loc" placeholder="Enter location" value="<?php echo htmlspecialchars($s_loc); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="s_professor" class="form-label">Professor</label>
                        <input type="text" class="form-control" id="s_professor" name="s_professor" placeholder="Enter professor name" value="<?php echo htmlspecialchars($s_professor); ?>">
                    </div>
                </div>
                
                <div class="form-group-grid">
                    <div class="mb-3">
                        <label for="s_days" class="form-label">Days</label>
                        <input type="text" class="form-control" id="s_days" name="s_days" placeholder="e.g., MWF or TTh" value="<?php echo htmlspecialchars($s_days); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="s_start" class="form-label">Start Time</label>
                        <input type="text" class="form-control" id="s_start" name="s_start" placeholder="e.g., 09:00 AM" value="<?php echo htmlspecialchars($s_start); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="s_duration" class="form-label">Duration</label>
                        <input type="text" class="form-control" id="s_duration" name="s_duration" placeholder="e.g., 1 hour" value="<?php echo htmlspecialchars($s_duration); ?>">
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Create Section</button>
                </div>
                <div class="text-center mt-3">
                    <a href="manageCourses.php" class="back-link">Back to Course Management</a>
                </div>
            </form>
        </div>
    </body>
</html>