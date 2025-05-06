<?php
session_start(); // Start the session

// Destroy the session to log out the admin
session_unset();  // Remove all session variables
session_destroy(); // Destroy the session

// Redirect to login page
header('Location: ../login.php');
exit;
