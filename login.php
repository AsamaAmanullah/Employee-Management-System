<?php
session_start();
header('Content-Type: application/json');
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT user.EMP_ID, employee.Position_ID 
            FROM user 
            JOIN employee ON user.EMP_ID = employee.EMP_ID 
            WHERE user.UserName = ? AND user.Password = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($emp_id, $position_id);
        $stmt->fetch();

        $_SESSION['EMP_ID'] = $emp_id;

        $response = ["success" => true, "emp_id" => $emp_id, "position_id" => $position_id];
        echo json_encode($response);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid username or password"]);
    }
    $stmt->close();
}
$conn->close();
?>
