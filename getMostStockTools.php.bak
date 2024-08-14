<?php
// getMostStockTools.php

header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emsdatabase_new";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$query = "SELECT Tool_Name, Quantity FROM inventory WHERE Quantity > 10";
$result = $conn->query($query);

$mostStockTools = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mostStockTools[] = $row;
    }
}

$conn->close();

echo json_encode($mostStockTools);
?>
