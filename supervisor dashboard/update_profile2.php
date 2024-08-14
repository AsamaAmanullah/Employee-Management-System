<?php
// update_profile.php

// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "emsdatabase_new";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$nic = $_POST['nic'];
$mobile = $_POST['mobile'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];
$address = $_POST['address'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validate passwords match
if ($password !== $confirm_password) {
    die("Passwords do not match.");
}

// Hash the password if it's not empty
if (!empty($password)) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
}

// SQL query to update the profile
$sql = "UPDATE employee SET 
    F_name='$first_name', 
    L_name='$last_name', 
    NIC='$nic', 
    Mobile='$mobile', 
    Gender='$gender', 
    DOB='$dob', 
    Address='$address'";

if (!empty($password)) {
    $sql .= ", password='$hashed_password'";
}

$sql .= " WHERE Position_ID=1"; // assuming Position_ID is 1 for the supervisor

if ($conn->query($sql) === TRUE) {
    echo "Profile updated successfully";
} else {
    echo "Error updating profile: " . $conn->error;
}

$conn->close();
?>
