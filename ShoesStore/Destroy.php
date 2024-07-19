<?php
/**
 * Logout the current user by destroying the session.
 */
function logoutUser() {
    // Start the session to access session variables
    session_start();

    // Unset and destroy the user session
    unset($_SESSION['user']);
    session_destroy();

    // Redirect to the index page with a success message
    header("location: index.php?Message=" . "Successfully logged out!!");
}

// Call the function to log out the user
logoutUser();
