<?php
// Include the database connection file
require 'config.php';

if (isset($_GET['emp_id'])) {
    $emp_id = $_GET['emp_id'];

    // Query to get employee details
    $query1 = "SELECT F_name, L_name, Position_ID FROM employee WHERE EMP_ID = ?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param("i", $emp_id);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $employee = $result1->fetch_assoc();

    if ($employee) {
        $position_id = $employee['Position_ID'];

        // Query to get position name
        $query2 = "SELECT Position_name FROM positions WHERE Position_ID = ?";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("i", $position_id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $position = $result2->fetch_assoc();

        $response = array(
            'emp_name' => $employee['F_name'] . ' ' . $employee['L_name'],
            'position_id' => $position_id,
            'position' => $position['Position_name']
        );

        echo json_encode($response);
    } else {
        echo json_encode(array('error' => 'Employee not found'));
    }
    
    // Close statements and connection
    $stmt1->close();
    $stmt2->close();
    $conn->close();
} else {
    echo json_encode(array('error' => 'Invalid request'));
}
?>
