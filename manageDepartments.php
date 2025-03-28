<?php
    session_start();   

    require "connect.php";

    if (!isset($_SESSION['username']) || !isset($_SESSION['password']) || !isset($_SESSION['role']) || (!$_SESSION['role'] === 'admin' && !$_SESSION['role'] === 'd_admin')){
        header("Location: index.php");
        exit();
    }

    // Handle search
    $search = $_POST['search'] ?? '';
    $where = '';
    if (!empty($search)) {
        $where = "WHERE d_name LIKE '%$search%' OR d_code LIKE '%$search%'";
    }
    $sql = "SELECT * FROM department $where ORDER BY d_name ASC";
    $result = $conn->query($sql);
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>DBMS Project</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-4">
            <div class="text-center content-section">
                <h1>Department Management Page</h1>
            </div>
            
            <div class="mb-3">
                <form id="searchInput" method="post" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search departments..." value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>

            <div class="mb-3">
                <a href="createDepartment.php" class="btn btn-success">Create Department</a>
                <a href="home.php" class="btn btn-secondary">Back</a>
            </div>

            <?php if ($result->num_rows > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>School</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['d_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['d_code']); ?></td>
                                <td><?php echo htmlspecialchars($row['d_email']); ?></td>
                                <td><?php echo htmlspecialchars($row['d_phone']); ?></td>
                                <td><?php echo htmlspecialchars($row['d_school']); ?></td>
                                <td>
                                    <a href="editDepartment.php?id=<?php echo $row['d_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="deleteDepartment.php?id=<?php echo $row['d_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-info">No departments found</div>
            <?php endif; ?>
        </div>
    </body>
</html>