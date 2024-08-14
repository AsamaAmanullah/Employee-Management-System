<?php
include 'db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);

$emp_id = $data['EMP_ID'];
$f_name = $data['F_name'];
$l_name = $data['L_name'];
$nic = $data['NIC'];
$mobile = $data['Mobile'];
$gender = $data['Gender'];
$address = $data['Address'];
$dob = $data['DOB'];

$sql = "UPDATE `employee` SET `F_name`=?, `L_name`=?, `NIC`=?, `Mobile`=?, `Gender`=?, `Address`=?, `DOB`=? WHERE `EMP_ID`=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssi", $f_name, $l_name, $nic, $mobile, $gender, $address, $dob, $emp_id);

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
