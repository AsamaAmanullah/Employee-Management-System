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

// Fetch tool ID from POST request
$tool_id = $_POST['tool_id'] ?? '';

// Validate the tool ID input to prevent SQL injection
$tool_id = $conn->real_escape_string($tool_id);

// Delete the tool from the database
$deleteQuery = $conn->prepare("DELETE FROM inventory WHERE Tool_ID = ?");
$deleteQuery->bind_param("s", $tool_id);
if ($deleteQuery->execute()) {
    echo "success";
} else {
    echo "Error deleting tool: " . $conn->error;
}

// Close prepared statements and database connection
$deleteQuery->close();
$conn->close();
?>
