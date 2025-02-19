<?php

include("connection.php");


// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'Dynamic_Ui');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch images from the database
$sql = "SELECT img_path FROM  images";
$result = $conn->query($sql);

$images = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $images[] = $row;
    }
}

// Close the connection
$conn->close();

// Return images as JSON
echo json_encode($images);
