<?php
require 'constants.php';

// Connect to the database
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check for connection errors
if ($connection->connect_errno) {
    die('Failed to connect: ' . $connection->connect_error);
}
echo ('salem!');

