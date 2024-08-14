<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emsdatabase_new";

// Create connection
$conn = new mysqli($servername, $username, $password,  $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get deleted tools for today
$today = date('Y-m-d');
$deletedToolsQuery = "SELECT tool_name, quantity, price FROM inventory WHERE DATE(deleted_date) = '$today'";

$deletedToolsResult = $conn->query($deletedToolsQuery);

$deletedTools = [];
if ($deletedToolsResult->num_rows > 0) {
    while ($row = $deletedToolsResult->fetch_assoc()) {
        $deletedTools[] = $row;
    }
}

$conn->close();

// Output JSON response
header('Content-Type: application/json');
echo json_encode($deletedTools);
?>
