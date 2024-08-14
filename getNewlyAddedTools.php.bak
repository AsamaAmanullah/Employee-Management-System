<?php
// Database connection (similar to your main script)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emsdatabase_new";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get newly added tools today
$today = date('Y-m-d');
$newlyAddedToolsQuery = "SELECT tool_name, quantity, price FROM inventory WHERE DATE(purchase_date) = '$today'";

$newlyAddedToolsResult = $conn->query($newlyAddedToolsQuery);

$newlyAddedTools = [];
if ($newlyAddedToolsResult->num_rows > 0) {
    while ($row = $newlyAddedToolsResult->fetch_assoc()) {
        $newlyAddedTools[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($newlyAddedTools);
?>
