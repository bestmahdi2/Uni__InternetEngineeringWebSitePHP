<?php
// Include the database connection file
include "DataBaseConnect.php";

/**
 * Handle user registration through a POST request.
 */

// Check if the 'submit' key is present in the POST data
if (isset($_POST['submit'])) {
    // Check if the submitted form is a registration form
    if ($_POST['submit'] == "register") {
        // Extract username and password from the form data
        $username = $_POST['register_username'];
        $password = $_POST['register_password'];

        // Query the database to check if the chosen username is already taken
        $query = "SELECT * FROM users WHERE UserName = '$username'";
        $result = mysqli_query($con, $query) or die(mysql_error);

        // Check if there is already a user with the chosen username
        if (mysqli_num_rows($result) > 0) {
            // Redirect to the index page with an error message
            header("Location: index.php?register=" . "Username is already taken... Use a different username");
        } else {
            // Insert the new user into the database
            $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            $result = mysqli_query($con, $query);

            // Redirect to the index page with a success message
            header("Location: index.php?register=" . "Successfully Registered!!");
        }
    }
}


