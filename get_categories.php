<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "emsdatabase_new";

$conn = new mysqli($servername, $username, $password,  $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch categories
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

$categories = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Close connection
$conn->close();

// Output JSON
header('Content-Type: application/json');
echo json_encode($categories);
?>
