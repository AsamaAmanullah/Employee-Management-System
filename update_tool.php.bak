<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emsdatabase_new";
$conn = new mysqli($servername, $username, $password ,$dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $toolId = $_POST['tool_id'];
    $toolName = $_POST['tool_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $categoryId = $_POST['category_id'];

    $stmt = $conn->prepare("UPDATE inventory SET Tool_name = ?, Quantity = ?, Price = ?, Category_ID = ? WHERE Tool_ID = ?");
    $stmt->bind_param("sdiii", $toolName, $quantity, $price, $categoryId, $toolId);

    if ($stmt->execute()) {
        echo "Record updated successfully.";
        // header("Location: main_script.php?category=$categoryId");
        // exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}

if (isset($_GET['tool_id'])) {
    $toolId = $_GET['tool_id'];
    $stmt = $conn->prepare("SELECT Tool_name, Quantity, Price,  Category_ID FROM inventory WHERE Tool_ID = ?");
    $stmt->bind_param("i", $toolId);
    $stmt->execute();
    $stmt->bind_result($toolName, $quantity, $price, $purchaseDate, $categoryId);
    $stmt->fetch();
    $stmt->close();
}

$conn->close();
?>

