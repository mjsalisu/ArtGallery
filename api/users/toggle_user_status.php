<?php
require '../auth.php';
require '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('You do not have permission to access this page.'); window.location.href='../../users.php';</script>";
    exit;
}

if (!isset($_GET['id'], $_GET['action']) || !in_array($_GET['action'], ['enable', 'disable'])) {
    die("Invalid request.");
}

$userID = (int)$_GET['id'];
$action = $_GET['action'];
$newStatus = $action === 'enable' ? 1 : 0;

// Prevent admin from disabling themselves
if ($userID == $_SESSION['user_id']) {
    echo "<script>alert('You cannot disable your own account.'); window.location.href='../../users.php?msg=You cannot disable your own account.';</script>";
    exit;
}

$stmt = $pdo->prepare("UPDATE users SET status = ? WHERE userID = ?");
$success = $stmt->execute([$newStatus, $userID]);

if ($success) {
    header("Location: ../../users.php?msg=User " . ($action === 'enable' ? 'enabled' : 'disabled') . " successfully");
    exit;
} else {
    die("Failed to update user status.");
}
