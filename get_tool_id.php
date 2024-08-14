<?php
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "emsdatabase_new";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Tool ID based on toolName parameter
$toolName = $_GET['toolName']; // Assuming 'toolName' is passed via GET request

$sql = "SELECT Tool_ID FROM inventory WHERE Tool_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $toolName);
$stmt->execute();
$stmt->bind_result($toolId);
$stmt->fetch();
$stmt->close();

echo $toolId; // Return Tool ID to AJAX request

$conn->close();
?>
