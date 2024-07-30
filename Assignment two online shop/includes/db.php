<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "onlineshop"; // Replace with your actual database name

// Create connection
$connnection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connnection->connect_error) {
    die("Connection failed: " . $connnection->connect_error);
}
?>
