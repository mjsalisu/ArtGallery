<?php
require '../session.php';
require '../db.php';

if (!isset($_SESSION['user_id'], $_SESSION['user_role'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$userID = $_SESSION['user_id'];
$role = $_SESSION['user_role'];
$requestID = $_POST['requestID'] ?? null;

if (!$requestID) {
    http_response_code(400);
    echo json_encode(["error" => "Request ID is required"]);
    exit;
}

// Fetch request
$sql = "SELECT * FROM custom_requests WHERE requestID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$requestID]);
$request = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$request) {
    http_response_code(404);
    echo json_encode(["error" => "Request not found"]);
    exit;
}

// Process by role
if ($role === 'Artist') {
    // Claim request
    if ($request['status'] == 0 && $request['artistID'] == null) {
        $sql = "UPDATE custom_requests SET artistID = ?, status = 1 WHERE requestID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userID, $requestID]);
        echo json_encode(["message" => "Request claimed"]);
        exit;
    }

    // Upload final artwork
    if ($request['artistID'] == $userID && $request['status'] == 1) {
        if (!isset($_FILES['uploaded_artwork']) || $_FILES['uploaded_artwork']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(["error" => "Final artwork image is required"]);
            exit;
        }

        $upload_dir = '../../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $filename = uniqid() . '_' . basename($_FILES['uploaded_artwork']['name']);
        $filepath = $upload_dir . $filename;

        if (!move_uploaded_file($_FILES['uploaded_artwork']['tmp_name'], $filepath)) {
            http_response_code(500);
            echo json_encode(["error" => "Failed to upload final artwork"]);
            exit;
        }

        $sql = "UPDATE custom_requests SET uploaded_artwork = ?, status = 2 WHERE requestID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$filename, $requestID]);
        echo json_encode(["message" => "Final artwork uploaded"]);
        exit;
    }

    http_response_code(403);
    echo json_encode(["error" => "You cannot perform this action"]);
    exit;
}

if ($role === 'Buyer') {
    if ($request['buyerID'] != $userID || $request['status'] != 2) {
        http_response_code(403);
        echo json_encode(["error" => "Only the requesting buyer can approve/reject"]);
        exit;
    }

    $action = $_POST['action'] ?? '';
    if ($action === 'approve') {
        $sql = "UPDATE custom_requests SET status = 3 WHERE requestID = ?";
    } elseif ($action === 'reject') {
        $sql = "UPDATE custom_requests SET status = 4 WHERE requestID = ?";
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Invalid buyer action"]);
        exit;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$requestID]);
    echo json_encode(["message" => "Request $action" . "d"]);
    exit;
}
?>
