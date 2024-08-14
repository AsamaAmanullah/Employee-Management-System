<?php
include('db_connection.php');

if(isset($_GET['id'])) {
    $work_ID = $_GET['id'];

    // First, remove the work_ID from assigned employees
    $removeWorkIDQuery = "UPDATE Employee SET work_ID = NULL WHERE work_ID = ?";
    if ($stmt = mysqli_prepare($conn, $removeWorkIDQuery)) {
        mysqli_stmt_bind_param($stmt, "i", $work_ID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        die("Failed to prepare query: " . mysqli_error($conn));
    }

    // Now, delete the workplace
    $deleteWorkplaceQuery = "DELETE FROM WorkPlace WHERE work_ID = ?";
    if ($stmt = mysqli_prepare($conn, $deleteWorkplaceQuery)) {
        mysqli_stmt_bind_param($stmt, "i", $work_ID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Redirect with success message
        header("Location: workview.php?msg=Workplace deleted successfully");
    } else {
        die("Failed to prepare query: " . mysqli_error($conn));
    }
} else {
    // Redirect with error message if ID is not set
    header("refresh:2; url=Workview.php");
}
?>
