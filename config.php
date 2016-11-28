<?php
$dbhost = "localhost";
$dbUser = 'root';
$dbPass = 'xyz@hackathon00';
$dbName = 'survey';
$servername = "localhost";

// Create connection
$conn = new mysqli($servername, $dbUser, $dbPass);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";

?>