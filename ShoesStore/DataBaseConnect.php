<?php
/**
 * Database Connection Configuration
 */
const DB_HOST = 'localhost';  // Database host address
const DB_NAME = 'store'; // Database name
const DB_USER = 'root';        // Database username
const DB_PASSWORD = '';        // Database password

/**
 * Establish a connection to the MySQL database.
 *
 * @return mysqli|false A mysqli object on success or false on failure.
 */

// Attempt to create a connection to the MySQL database
$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check if the connection was successful
if ($con->connect_error) {
    // Connection failed, output an error message
    die("Connection failed: " . $con->connect_error);
}

