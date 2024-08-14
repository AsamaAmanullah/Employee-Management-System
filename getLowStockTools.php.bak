<?php
// Database connection
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

// Query to get low stock tools (quantity < 5)
$sql = "SELECT Tool_Name, Quantity FROM inventory WHERE Quantity < 5";

$result = $conn->query($sql);

$lowStockTools = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $lowStockTools[] = [
            'Tool_Name' => $row['Tool_Name'],
            'Quantity' => $row['Quantity']
        ];
    }
} else {
    $lowStockTools['error'] = "No low stock tools found.";
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($lowStockTools);

$conn->close();
?>
