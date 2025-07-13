<?php
require '../session.php';
require '../db.php';

if (!isset($_SESSION['user_id'], $_SESSION['user_role'])) {
    header("Location: ../../create_requests.php?error=Unauthorized access");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../create_requests.php?error=Invalid request method");
    exit;
}

if (!isset($_POST['request_title'], $_POST['specifications'], $_POST['offered_price'])) {
    header("Location: ../../create_requests.php?error=Missing required fields");
    exit;
}

$created_by = $_SESSION['user_id'];
$title = trim($_POST['request_title']);
$specs = trim($_POST['specifications']);
$price = $_POST['offered_price'];
$sketch_sample = "";

// Duplicate check
$check = $pdo->prepare("SELECT requestID FROM custom_requests WHERE created_by = ? AND request_title = ? AND specifications = ? AND offered_price = ?");
$check->execute([$created_by, $title, $specs, $price]);
if ($check->rowCount() > 0) {
    header("Location: ../../create_requests.php?error=Request already exists");
    exit;
}

// Handle sketch upload
if (isset($_FILES['sketch_sample']) && $_FILES['sketch_sample']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/sketches/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $ext = pathinfo($_FILES['sketch_sample']['name'], PATHINFO_EXTENSION);
    $newName = uniqid('sketch_', true) . '.' . $ext;
    $targetPath = $uploadDir . $newName;

    if (move_uploaded_file($_FILES['sketch_sample']['tmp_name'], $targetPath)) {
        $sketch_sample = 'uploads/sketches/' . $newName;
    }
}

$sql = "INSERT INTO custom_requests (created_by, artistID, request_title, specifications, offered_price, sketch_sample, uploaded_artwork, status)
        VALUES (?, NULL, ?, ?, ?, ?, '', 0)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$created_by, $title, $specs, $price, $sketch_sample]);

header("Location: ../../create_requests.php?success=Request created successfully");
exit;
?>