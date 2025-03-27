<!DOCTYPE HTML>
<html>
    <!--html code here-->
    <head>
        <title>DBMS Project</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div>
            <?php
                session_start();

                require 'connect.php';

                $identifier = $_GET['searchInput'];
                $filter = $_GET['filter'];

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
                                <a href='search.php?searchInput=" . urlencode($row['c_id']) . "&filter=prereq'>" . htmlspecialchars($row['c_name']) . "</a>
                            </div>";
                    }
                    echo "<div><p>Required For:</p></div>";
                    while ($row = $requiredFor->fetch_assoc()) {
                        echo "<div>
                                <a href='search.php?searchInput=" . urlencode($row['c_id']) . "&filter=prereq'>" . htmlspecialchars($row['c_name']) . "</a>
                            </div>";
                    }
                } else if ($identifier != ''){
                    if ($filter === "name"){
                        $sql = "SELECT * FROM course WHERE c_name = '$identifier'";
                    } else if ($filter === "id"){
                        $sql = "SELECT * FROM course WHERE c_id = '$identifier'";
                    } else {
                        $sql = "SELECT * FROM course WHERE c_department = '$identifier'";
                    } 
    
                    $result = $conn->query($sql);
    
                    echo "<div><p>Courses</p></div>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<div>
                                <a href='search.php?searchInput=" . urlencode($row['c_id']) . "&filter=prereq'>" . htmlspecialchars($row['c_name']) . "</a>
                            </div>";
                    }
                } else {
                    echo "No Identifier provided.";
                }
                $conn->close();
            ?>
        </div>
    </body>
</html>