<?php
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "emsdatabase_new";
$conn = new mysqli($servername, $username, $password,  $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the POST request
$name = $_POST['name'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];
$date = $_POST['date'];
$categoryId = $_POST['categoryId'];

// Check if the tool already exists
$stmt = $conn->prepare("SELECT Tool_id, Quantity, Price, Purchase_date FROM inventory WHERE Tool_name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Tool already exists, update the quantity and price
    $row = $result->fetch_assoc();
    $existingQuantity = $row['Quantity'];
    $newQuantity = $existingQuantity + $quantity;
    
    $existingPrice = $row['Price'];
    $newPrice = $existingPrice + $price;

    // Update the quantity, price, and purchase date in the database
    $updateStmt = $conn->prepare("UPDATE inventory SET Quantity = ?, Price = ?, Purchase_date = ? WHERE Tool_name = ?");
    $updateStmt->bind_param("idss", $newQuantity, $newPrice, $date, $name);
    if ($updateStmt->execute()) {
        $response = "Quantity, Price, and Purchase date updated successfully for Item: " . $name . "<br>";
        $response .= "New Price: " . $newPrice . "<br>";
        $response .= "New Purchase Date: " . $date;
        echo $response;
    } else {
        echo "Error updating quantity, price, and purchase date: " . $conn->error;
    }
} else {
    // Tool does not exist, insert a new row
    $insertStmt = $conn->prepare("INSERT INTO inventory (Tool_name, Quantity, Price, Purchase_date, Category_id) VALUES (?, ?, ?, ?, ?)");
    $insertStmt->bind_param("sidsi", $name, $quantity, $price, $date, $categoryId);
    
    if ($insertStmt->execute()) {
        $response = "New Item added successfully: " . $name . "<br>";
        $response .= "Price: " . $price . "<br>";
        $response .= "Purchase Date: " . $date;
        echo $response;
    } else {
        echo "Error adding new tool: " . $conn->error;
    }
}

$conn->close();
?>
