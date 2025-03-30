<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <header class="row text-center bg-secondary">
                <h1>UCPRDB</h1>
                <p class="col-1 text-end"><a href="logout.php" target="_parent" class="btn btn-warning">logout</a></p>
                <p class="col-2 col-md"></p>
                <form id="searchInput" action="search.php" method="get" class="col-6 col-md-auto text-align: right;">
                    <label for="searchInput">Course Search:</label>
                    <input type="text" id="searchInput" name="searchInput" placeholder="Search">
                    <input id="searchButton" type="submit" value="Search">
                    <select id="filter" name="filter" placeholder="Filter By..">
                        <option value="name">Name</option>
                        <option value="id">Course ID</option>
                        <option value="department">Department</option>
                        <option value="prereq">Prerequisite</option>
                        <?php
                            if ($_SESSION['role'] === 'student'){
                                echo "<option value='enrolled'>Enrolled</option>";
                            }
                        ?>
                    </select></p>
            </header>    

        </div>
    </body>
</html>