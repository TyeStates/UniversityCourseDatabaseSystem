<?php
    session_start();

    require "connect.php";

    $c_id = "";
    $pr_id = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $c_id = $_POST['c_id'];
        $pr_id = $_POST['pr_id'];
    
        do{
            if (empty($c_id)) {
                header("Location: createPrerequisite.php?error=Course ID is required");
                exit();
            } 
            if (empty($pr_id)) {
                header("Location: createPrerequisite.php?error=Prerequisite ID is required");
                exit();
            } 
            $sql = "SELECT * FROM course WHERE c_id = '$c_id' OR c_id = '$pr_id'";
            $result = $conn->query($sql);
            if (($result->num_rows) < 2){
                header("Location: createPrerequisite.php?error=Can't find courses with those ids");
                exit();
            } 
            $sql = "SELECT * FROM prerequisites WHERE c_id = '$c_id'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()){
                if ($row['pr_id'] === $pr_id){
                    header("Location: createPrerequisite.php?error=Already a prerequisite");
                    exit();
                }
            } 
            $sql = "INSERT INTO prerequisites (c_id, pr_id) VALUES ('$c_id', '$pr_id')";
            $result = $conn->query($sql);
            if (!$result){
                header("Location: createPrerequisite.php?error=Failed to create prerequisite");
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
                    <label for="c_id" class="form-label"><strong>Course ID</strong></label>
                    <input type="text" id="c_id" name="c_id" placeholder="Course ID" value="<?php echo $c_id; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="pr_id" class="form-label"><strong>Prerequisite ID</strong></label>
                    <input type="text" id="pr_id" name="pr_id" placeholder="Prerequisite ID" value="<?php echo $pr_id; ?>" required>
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