<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Establish database connection
$conn = mysqli_connect("mysql5035.site4now.net", "ab0a78_kantin", "panjiwp08", "db_ab0a78_kantin");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to fetch data from the daftar_kantin table
$query = "SELECT * FROM kantin"; // Update the table name here
$result = mysqli_query($conn, $query);

// Check for errors in the query
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}



// Close the database connection

?>