<?php
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emsdatabase_new";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch category from GET request
$category = $_GET['category'] ?? '';

// Validate the category input to prevent SQL injection
$category = $conn->real_escape_string($category);

// Assuming the column name for the category in your inventory table is 'Category_ID'
$sql = $conn->prepare("SELECT Tool_name, Tool_ID, Quantity, Price, Purchase_Date, Category_ID FROM inventory WHERE Category_ID = ?");
$sql->bind_param("s", $category);
$sql->execute();
$result = $sql->get_result();

// Generate HTML table rows for each tool
$output = "";
while ($row = $result->fetch_assoc()) {
    $output .= "<tr>
                    <td>" . htmlspecialchars($row['Tool_name']) . "</td>
                    <td>" . htmlspecialchars($row['Tool_ID']) . "</td>
                    <td>" . htmlspecialchars($row['Quantity']) . "</td>
                    <td>" . htmlspecialchars($row['Price']) . "</td>
                    <td>" . htmlspecialchars($row['Purchase_Date']) . "</td>
                    <td>" . htmlspecialchars($row['Category_ID']) . "</td>
                </tr>";
}

echo $output;

$sql->close();
$conn->close();
?>
