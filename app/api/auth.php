<?php
session_start(); // Start session

// Include database connection
require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['RegisterBtn'])) {
    // Sanitize input data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    // Validate input fields
    if (empty($name) || empty($email) || empty($phone) || empty($password)) {
        $_SESSION['msg'] = "All fields are required.";
        header("Location: ./register.php");
        exit;
    }

    // Check if user already exists (by email or phone)
    $checkStmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR phone = ?");
    $checkStmt->bind_param("ss", $email, $phone);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $_SESSION['msg'] = "Email or phone number already exists.";
        $checkStmt->close();
        header("Location: ./register.php");
        exit;
    }
    $checkStmt->close();

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert new user record
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $hashedPassword);

    if ($stmt->execute()) {
        $_SESSION["msg"] = 'Your account created successfull.';
    } else {
        $_SESSION['msg'] = "Oooops, something went wrong " . $stmt->error;
        header("Location: ./register.php");
        exit;
    }

    $stmt->close();
    $conn->close();

    // Redirect after processing
    header("Location: ./login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['LoginBtn'])) {
    // Sanitize input data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input fields
    if (empty($email) || empty($password)) {
        $_SESSION['msg'] = "All fields are required.";
        header("Location: ./login.php");
        exit;
    }

    // Check if user exists
    $checkStmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $user = $result->fetch_assoc();

    if ($result->num_rows == 0) {
        $_SESSION['msg'] = "Invalid login details.";
        $checkStmt->close();
        header("Location: ./login.php");
        exit;
    }
    $checkStmt->close();

    // Verify password
    if (password_verify($password, $user['password'])) {
        $_SESSION['msg'] = "Login successful!";
        $_SESSION['user'] = $user;

        header("Location: ./index.php");
        exit;
    } else {
        $_SESSION['msg'] = "Invalid password.";
        header("Location: ./login.php");
        exit;
    }
}
?>
