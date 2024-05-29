<?php
include 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS assignment_2";
if ($conn->query($sql) === TRUE) {
    echo "<script>console.log('Database initialised successfully.');</script>";
} else {
    echo "<script>console.error('Error creating database: " . $conn->error . "');</script>";
}

// Close connection
$conn->close();

// Connect to the database
$conn = new mysqli($servername, $username, $password, "assignment_2");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
