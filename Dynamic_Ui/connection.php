<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Dynamic_Ui";

$conn = new mysqli($servername, $username, $password, $dbname);

if (!$conn) {
    die("Database not connected: " . mysqli_connect_error());
} else {
    echo "Connected";
}
