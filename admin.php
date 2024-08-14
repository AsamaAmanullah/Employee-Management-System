<?php
include('Header.php');
include('db_connection.php');

$success = '';
$error = '';

// Fetch relevant details from the employee table for the admin user with Member_No = 1
$query = "SELECT * FROM employee WHERE Member_No = 1 LIMIT 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // If data is found, populate the input fields with the retrieved values
    $row = $result->fetch_assoc();
  
    $Member_No = $row['Member_No'];
    $F_name = $row['F_name'];
    $L_name = $row['L_name'];
    $DOB = $row['DOB'];
    $Gender = $row['Gender'];
    $Address = $row['Address'];
    $Mobile = $row['Mobile'];
    $NIC = $row['NIC'];
} else {
    $error = "No data found for the admin user with Member_No = 1.";
}

if (isset($_POST['update_credentials'])) {
    $newUsername = $_POST['new_username'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword != $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("UPDATE user SET username = ?, password = ? WHERE emp_id = 19");
        if ($stmt === false) {
            $error = "Prepare failed: " . $conn->error;
        } else {
            $stmt->bind_param("ss", $newUsername, $newPassword);

            // Execute the statement
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $success = "Credentials updated successfully.";
                } else {
                    $error = "No changes were made.";
                }
            } else {
                $error = "Execute failed: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

$conn->close();

?>

<section>
    <div class="main">
        <div class="container">    
            <h1 class="head">Admin Details</h1><br><br>
            <?php if ($success != ''): ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
            <?php elseif ($error != ''): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <form action="#" method="post">
                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Member number:</legend>
                    <div class="col-auto">
                        <input type="text" class="form-control" name="Member_No" value="<?php echo $Member_No; ?>" disabled>
                    </div>
                </div><br><br>

                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Employee Name:</legend>
                    <div class="col">
                        <input type="text" class="form-control" aria-label="First name" name="F_name" value="<?php echo $F_name; ?>" disabled>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" aria-label="Last name" name="L_name" value="<?php echo $L_name; ?>" disabled>
                    </div>
                </div><br><br>

                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Date Of Birth:</legend>
                    <div class="col-auto">
                        <input type="date" class="form-control" name="DOB" value="<?php echo $DOB; ?>" disabled>
                    </div>
                </div><br><br>

                <fieldset class="row mb-3">
                    <legend class="col-form-label col-sm-2 pt-0">Gender:</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="Gender" value="Male" <?php if($Gender === 'Male') echo 'checked'; ?> disabled> Male
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="Gender" value="Female" <?php if($Gender === 'Female') echo 'checked'; ?> disabled> Female
                        </div>
                    </div>
                </fieldset><br>  

                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Address</legend>
                    <div class="col">
                        <input type="text" class="form-control" name="Address" value="<?php echo $Address; ?>" disabled>
                    </div>
                </div><br><br>

                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Telephone number:</legend>
                    <div class="col-auto">
                        <input type="text" class="form-control" name="Mobile" value="<?php echo $Mobile; ?>" disabled>
                    </div>
                </div><br><br>

                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">NIC number:</legend>
                    <div class="col-auto">
                        <input type="text" class="form-control" name="NIC" value="<?php echo $NIC; ?>" disabled>
                    </div>
                </div><br><br>

                <h1 class="head">Change User Credentials</h1><br><br>

                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">New Username:</legend>
                    <div class="col-auto">
                        <input type="text" class="form-control" name="new_username" value="">
                    </div>
                </div><br><br>

                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">New Password:</legend>
                    <div class="col-auto">
                        <input type="password" class="form-control" name="new_password" value="">
                    </div>
                </div><br><br>

                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Re-enter Password:</legend>
                    <div class="col-auto">
                        <input type="password" class="form-control" name="confirm_password" value="">
                    </div>
                </div><br><br>

                <div>
                    <button type="submit" class="btn btn-success" style="color:black;" name="update_credentials">Update Credentials</button>
                    <a href="index.php" class="btn btn-danger" style="color:black;">Cancel</a>
                </div>
            </form>
        </div> 
    </div>     
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="script.js"></script>
