<?php
$host = 'localhost';
$db = 'art_platform';
$user = 'art_platform';
$pass = 'art_platform';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo 'Database connected successfully!';
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
?>