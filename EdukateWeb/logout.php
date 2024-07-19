<?php
// Logout script

// Start the session to access session variables
session_start();

// Destroy the session to log the user out
session_destroy();

// Redirect to the home page after logout
header("Location: index.php");

// Ensure no further code is executed after the redirection
exit;
?>
