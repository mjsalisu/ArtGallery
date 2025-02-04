<?php
// PHP Script for rendering the Login page
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate login inputs (dummy logic for demonstration)
    if ($email === 'user@example.com' && $password === 'password123') {
        echo "<script>alert('Login successful! Redirecting...');</script>";
        // Redirect or handle login logic
    } else {
        echo "<script>alert('Invalid credentials! Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg" style="width: 22rem;">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Login</h4>
                <form method="POST" action="./dashboard.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Enter your password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <a href="#">Forgot password?</a>
                </div>
                <div class="text-center mt-2">
                    <p class="mb-0">Don't have an account? <a href="./signup.php">Sign up</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>