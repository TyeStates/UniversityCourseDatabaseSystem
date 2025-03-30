<!DOCTYPE HTML>
<html>
    <head>
        <title>DBMS Project</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .login-container {
                max-width: 400px;
                margin: 0 auto;
                padding: 2rem;
                border: 1px solid #dee2e6;
                border-radius: 0.5rem;
                margin-top: 5rem;
                background-color: #fff;
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            }
            .error {
                color: #dc3545;
                margin-bottom: 1rem;
            }
        </style>
    </head>
    <body class="bg-light">
        <div class="login-container">
            <h1 class="text-center mb-4">Login</h1>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
            <?php endif; ?>
            <form action="login.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label"><strong>Username</strong></label>
                    <input type="text" class="form-control" id="username" name="username" 
                           placeholder="Enter your username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"><strong>Password</strong></label>
                    <input type="password" class="form-control" id="password" name="password" 
                           placeholder="Enter your password" required>
                </div>
                <div class="mb-3">
                    <label for="loginFilter" class="form-label"><strong>User Type</strong></label>
                    <select class="form-select" id="loginFilter" name="loginFilter" required>
                        <option value="student">Student</option>
                        <option value="professor">Professor</option>
                        <option value="d_admin">Department Admin</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
                <div class="text-center mt-3">
                    <a href="register.php" class="text-decoration-none">Register</a>
                </div>
            </form>
        </div>
    </body>
</html>