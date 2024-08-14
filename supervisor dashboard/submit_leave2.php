<?php
// Include the database connection file
require 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $emp_id = $_POST['emp_id'];
    $position_id = $_POST['position_id'];
    $leave_type = $_POST['leave_type'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $leave_duration = $_POST['leave_duration'];
    $notes = $_POST['notes'];

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO emp_leaves (EMP_ID, leave_type, from_date, to_date, leave_duration, notes, Position_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param("isssssi", $emp_id, $leave_type, $from_date, $to_date, $leave_duration, $notes, $position_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "success";
        header("Location: leave.html?status=success");
    } else {
        header("Location: leave.html?status=error");
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
