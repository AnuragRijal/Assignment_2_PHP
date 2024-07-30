<?php
// Check if a session is not already started and start one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Function to check if a user is logged in
function isLoggedIn() {
    return isset($_SESSION['student_id']);
}

// Function to check if an admin is logged in
function isAdminLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Function to log out
function logout() {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();
}
?>
