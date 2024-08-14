<?php
// Database connection
include('db_connection.php');

// Employee ID to delete, provided as input
$EMP_ID = isset($_GET['id']) ? $_GET['id'] : null;

if (empty($EMP_ID)) {
    die('<div class="alert alert-danger" role="alert">Employee ID is required.</div>');
}

// Start transaction
$conn->begin_transaction();

try {
    // Step 1: Delete from accountdetails table
    $sql1 = "DELETE FROM accountdetails WHERE EMP_ID = ?";
    $stmt1 = $conn->prepare($sql1);
    if (!$stmt1) {
        throw new Exception("Prepare statement failed: " . $conn->error);
    }
    $stmt1->bind_param("i", $EMP_ID);
    if (!$stmt1->execute()) {
        throw new Exception("Error deleting from accountdetails: " . $stmt1->error);
    }

    // Step 2: Delete from employee table
    $sql2 = "DELETE FROM employee WHERE EMP_ID = ?";
    $stmt2 = $conn->prepare($sql2);
    if (!$stmt2) {
        throw new Exception("Prepare statement failed: " . $conn->error);
    }
    $stmt2->bind_param("i", $EMP_ID);
    if (!$stmt2->execute()) {
        throw new Exception("Error deleting from employee: " . $stmt2->error);
    }

    // Commit the transaction
    $conn->commit();

    // Success message
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success!</strong> Employee and related records deleted successfully.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';

    // Redirect to the view page after a short delay
    header("refresh:2; url=Employee_view.php");

} catch (Exception $e) {
    // Rollback the transaction if any error occurs
    $conn->rollback();
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Error!</strong> ' . $e->getMessage() . '
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
} finally {
    // Close statements and connection
    if ($stmt1) $stmt1->close();
    if ($stmt2) $stmt2->close();
    $conn->close();
}
?>
