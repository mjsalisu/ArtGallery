<?php
require_once 'session.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

// Load DB and retrieve user
require_once 'db.php';

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_role = $_SESSION['user_role'];

// Fetch full user info
$stmt = $pdo->prepare("SELECT * FROM users WHERE artistID = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// If somehow the user no longer exists in DB, destroy session
if (!$user) {
    session_unset();
    session_destroy();
    header("Location: login.html");
    exit;
}
?>
