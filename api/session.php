<?php
session_start();

// Regenerate session ID periodically for security
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id();
    $_SESSION['initiated'] = true;
}
?>