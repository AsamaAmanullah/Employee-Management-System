<?php
include 'db_connection.php';

$emp_id = $_GET['EMP_ID'];

$sql = "SELECT `F_name`, `L_name`, `NIC`, `Mobile`, `Gender`, `Address`, `DOB` FROM `employee` WHERE `EMP_ID`=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $emp_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $employee = $result->fetch_assoc();
    echo json_encode($employee);
} else {
    echo json_encode([]);
}

$stmt->close();
$conn->close();
?>
