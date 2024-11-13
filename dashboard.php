<?php
// Start the session
session_start();

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// User is logged in, show the dashboard
echo "<h1>Welcome, " . $_SESSION['username'] . "!</h1>";
echo "<p>This is your dashboard. You are successfully logged in.</p>";
?>
