<?php

// include("connection.php");

$conn = new mysqli('localhost', 'root', '', 'Dynamic_Ui');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch home page content
$query = "SELECT * FROM home_content";
$result = mysqli_query($conn, $query);

if ($result->num_rows > 0) {
    $about = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $about[] = $row;
    }
    echo json_encode($about);
} else {
    echo json_encode(['error' => 'No data found']);
}


// $conn->close();
