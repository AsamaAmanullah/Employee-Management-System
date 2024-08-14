<?php
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "emsdatabase_new";
$conn = new mysqli($servername, $username,$password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the tool name from the GET request
$toolName = isset($_GET['toolName']) ? $_GET['toolName'] : '';

if ($toolName) {
    // Query to get the tool ID based on the tool name
    $stmt = $conn->prepare("SELECT Tool_id FROM inventory WHERE Tool_name = ?");
    $stmt->bind_param("s", $toolName);
    $stmt->execute();
    $stmt->bind_result($toolId);
    $stmt->fetch();

    // Return the tool ID as a JSON response
    echo json_encode(['toolId' => $toolId]);

    $stmt->close();
}

$conn->close();
?>
