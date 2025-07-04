<?php
require '../session.php';

session_unset();
session_destroy();

echo json_encode(["message" => "Logged out successfully"]);
?>
