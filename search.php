<!DOCTYPE HTML>
<html>
    <head>
        <title>DBMS Project</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div>
            <?php
                if (isset($_GET['error'])){
                    echo "<div class='error'>" . $_GET['error'] . "</div>";
                }
            ?>
            <?php
                session_start();

                require 'connect.php';

                $identifier = $_GET['searchInput'] ?? null;
                $filter = $_GET['filter'] ?? null;

                if ($filter === "prereq"){
                    $sql1 = "SELECT *
                            FROM prerequisites
                            JOIN course ON prerequisites.pr_id = course.c_id
                            WHERE prerequisites.c_id = '$identifier'";
                    $sql2 = "SELECT * 
                            FROM prerequisites
                            JOIN course ON prerequisites.c_id = course.c_id
                            WHERE prerequisites.pr_id = '$identifier'";

                    $prerequisites = $conn->query($sql1);
                    $requiredFor = $conn->query($sql2);

                    echo "<div><p>Pre-requisites:</p></div>";
                    while ($row = $prerequisites->fetch_assoc()) {
                        echo "<div>
                            <a href='search.php?searchInput=" . urlencode($row['c_id']) . "&filter=prereq'>" . htmlspecialchars($row['c_name']) . "</a>";
                        if ($_SESSION['role'] === 'student') {
                            echo "<form method='post' action='enroll.php' style='display:inline; margin-left:10px;'>
                                <input type='hidden' name='id' value='" . htmlspecialchars($row['c_id']) . "'>
                                <input type='hidden' name='student' value='" . $_SESSION['id'] . "'>
                                <button type='submit'>Enroll</button>
                                </form>";
                        }
                        echo "</div>";
                    }
                    echo "<div><p>Required For:</p></div>";
                    while ($row = $requiredFor->fetch_assoc()) {
                        echo "<div>
                            <a href='search.php?searchInput=" . urlencode($row['c_id']) . "&filter=prereq'>" . htmlspecialchars($row['c_name']) . "</a>";
                        if ($_SESSION['role'] === 'student') {
                            echo "<form method='post' action='enroll.php' style='display:inline; margin-left:10px;'>
                                <input type='hidden' name='id' value='" . htmlspecialchars($row['c_id']) . "'>
                                <input type='hidden' name='student' value='" . $_SESSION['id'] . "'>
                                <button type='submit'>Enroll</button>
                                </form>";
                        }
                        echo "</div>";
                    }
                } else if ($filter === "enrolled"){
                    $sql = "SELECT *
                        FROM enrolled
                        JOIN course ON enrolled.c_id = course.c_id
                        WHERE enrolled.std_id = '" . $_SESSION['id'] . "'";

                    $result = $conn->query($sql);
    
                    echo "<div><p>Courses</p></div>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<div>
                            <a href='search.php?searchInput=" . urlencode($row['c_id']) . "&filter=prereq'>" . htmlspecialchars($row['c_name']) . "</a>";
                        if ($_SESSION['role'] === 'student') {
                            echo "<form method='post' action='enroll.php' style='display:inline; margin-left:10px;'>
                                <input type='hidden' name='id' value='" . htmlspecialchars($row['c_id']) . "'>
                                <input type='hidden' name='student' value='" . htmlspecialchars($_SESSION['id']) . "'>
                                <button type='submit'>Enroll</button>
                                </form>";
                        }
                        echo "</div>";
                    }
                } else if ($identifier != ''){
                    if ($filter === "name"){
                        $sql = "SELECT * FROM course WHERE c_name = '$identifier'";
                    } else if ($filter === "id"){
                        $sql = "SELECT * FROM course WHERE c_id = '$identifier'";
                    } else {
                        $sql = "SELECT * 
                            FROM department
                            JOIN course ON course.c_department = department.d_id
                            WHERE department.d_name = '$identifier'";
                    } 
    
                    $result = $conn->query($sql);
    
                    echo "<div><p>Courses</p></div>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<div>
                            <a href='search.php?searchInput=" . urlencode($row['c_id']) . "&filter=prereq'>" . htmlspecialchars($row['c_name']) . "</a>";
                        if ($_SESSION['role'] === 'student') {
                            echo "<form method='post' action='enroll.php' style='display:inline; margin-left:10px;'>
                                <input type='hidden' name='id' value='" . htmlspecialchars($row['c_id']) . "'>
                                <input type='hidden' name='student' value='" . htmlspecialchars($_SESSION['id']) . "'>
                                <button type='submit'>Enroll</button>
                                </form>";
                        }
                        echo "</div>";
                    }
                } else {
                    echo "No Identifier provided.";
                }
                $conn->close();
            ?>
        </div>
    </body>
</html>
