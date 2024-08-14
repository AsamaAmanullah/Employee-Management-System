<?php
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emsdatabase_new";
$conn = new mysqli($servername, $username, $password,  $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get parameters from POST request
$toolName = $_POST['toolName'] ?? '';
$toolId = $_POST['toolId'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$totalPrice = $_POST['totalPrice'] ?? '';
$purchaseDate = $_POST['purchaseDate'] ?? '';

// Validate inputs (you should add more validation as needed)

// Check if the tool already exists
$sql_check = "SELECT * FROM inventory WHERE Tool_name = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $toolName);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check) {
    if ($result_check->num_rows > 0) {
        // Tool exists, update quantity, total price, and purchase date
        $row = $result_check->fetch_assoc();
        $currentQuantity = $row['Quantity'];
        $currentTotalPrice = $row['Price'];

        // Calculate new quantity and total price
        $newQuantity = $currentQuantity + $quantity;
        $newTotalPrice = $currentTotalPrice + $totalPrice;

        // Update the purchase date if provided
        if (!empty($purchaseDate)) {
            $newPurchaseDate = $purchaseDate;
        } else {
            $newPurchaseDate = $row['purchase_date']; // Use existing purchase date
        }

        // Update the quantity, total price, and purchase date for the existing tool
        $sql_update = "UPDATE inventory SET Quantity = ?, Price = ?, purchase_date = ? WHERE Tool_name = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("idss", $newQuantity, $newTotalPrice, $newPurchaseDate, $toolName);

        if ($stmt_update->execute()) {
            echo "Quantity, total price, and purchase date added successfully";
        } else {
            echo "Error updating quantity, total price, and purchase date: " . $stmt_update->error;
        }
    } else {
        // Tool does not exist, insert a new record
        $sql_insert = "INSERT INTO inventory (Tool_name, Tool_ID, Quantity, Price, purchase_date) 
                       VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("sidss", $toolName, $toolId, $quantity, $totalPrice, $purchaseDate);

        if ($stmt_insert->execute()) {
            echo "New Item added successfully";
        } else {
            echo "Error adding new tool: " . $stmt_insert->error;
        }
    }
} else {
    echo "Error: " . $sql_check . "<br>" . $conn->error;
}

$conn->close();
?>
