<?php
// Include the database connection file
include "DataBaseConnect.php";

/**
 * Handle user login through a POST request.
 */

// Check if the 'submit' key is present in the POST data
if (isset($_POST['submit'])) {
    // Check if the submitted form is a login form
    if ($_POST['submit'] == "login") {
        // Extract username and password from the form data
        $username = $_POST['login_username'];
        $password = $_POST['login_password'];

        // Query the database to check if the provided credentials are valid
        $query = "SELECT * FROM users WHERE username ='$username' AND password='$password'";
        $result = mysqli_query($con, $query) or die(mysql_error());

        // Check if there is at least one matching record in the database
        if (mysqli_num_rows($result) > 0) {
            // Fetch the first result as a row
            $row = mysqli_fetch_assoc($result);

            // Set the user session and redirect to the index page
            $_SESSION['user'] = $row['UserName'];
            header("Location: index.php?login=" . "Successfully Logged In !");
        } else
            // Display an error message if the username or password is incorrect
            echo "Incorrect username or password !";
    }
}


