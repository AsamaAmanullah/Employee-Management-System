<?php
// getAllTools.php

header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "emsdatabase_new";

// Create connection
$conn = new mysqli($servername, $username, $password,  $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$query = "SELECT Tool_Name, Quantity FROM inventory";
$result = $conn->query($query);

$allTools = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $allTools[] = $row;
    }
}

$conn->close();

echo json_encode($allTools);
?>
