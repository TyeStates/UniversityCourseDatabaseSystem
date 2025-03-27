<!DOCTYPE HTML>
<html>
    <!--html code here-->
    <head>
        <title>DBMS Project</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="text-center content-section">
            <h1>University Course Prerequisite Database</h1>
        </div>
        <div class="text-center content-section">
            <form id="searchform" action="search.php" method="get">
                <label for="searchInput">Course Search:</label>
                <input type="text" id="searchInput" name="searchInput" placeholder="Search">
                <input id="searchButton" type="submit" value="Search">
                <select id="filter" name="filter" placeholder="Filter By..">
                    <option value="name">Name</option>
                    <option value="id">Course ID</option>
                    <option value="department">Department</option>
                    <option value="prereq">Prerequisite</option>
                </select>
            </form>
        </div>
    </body>
</html>