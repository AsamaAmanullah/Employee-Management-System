<?php
include 'db_connection.php';

$position_id = $_GET['position_id'];
$sql = "SELECT Position_name FROM positions WHERE Position_ID='$position_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo $row['Position_name'];
$conn->close();
?>