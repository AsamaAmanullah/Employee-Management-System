<?php
include 'db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);
$emp_id = $data['EMP_ID'];
$password = $data['password'];

// Hash the password before saving to the database
// $hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE `user` SET `Password`=? WHERE `EMP_ID`=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $password, $emp_id);

$response = array();
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
