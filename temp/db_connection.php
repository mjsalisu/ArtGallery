<?php
// Database configuration
$host = 'localhost'; // Database server (usually 'localhost')
$username = 'art_platform';  // Database username
$password = 'art_platform';      // Database password
$database = 'art_platform'; // Name of your database

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Set charset to avoid issues with special characters
$conn->set_charset('utf8mb4');
// echo 'Database connected successfully!';
?>
