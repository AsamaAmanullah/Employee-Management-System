<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emsdatabase_new";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success_msg = "";
$error_msg = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];

    if (isset($_POST['delete'])) {
        // Delete attendance records for the selected date
        $delete_sql = "DELETE FROM attendance WHERE Date = '$date'";
        if ($conn->query($delete_sql) === TRUE) {
            $success_msg = "Attendance records for $date have been deleted successfully.";
        } else {
            $error_msg = "Error deleting attendance records: " . $conn->error;
        }
    } elseif (isset($_POST['update'])) {
        // Check if attendance has already been taken for the selected date
        $check_date_sql = "SELECT * FROM attendance WHERE Date = '$date'";
        $check_date_result = $conn->query($check_date_sql);

        if ($check_date_result->num_rows > 0) {
            // Loop through each employee to process their attendance
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'arrival_time_') === 0) {
                    $emp_id = substr($key, strlen('arrival_time_'));
                    $status = $_POST['status_' . $emp_id];

                    // Retrieve employee details for logging purposes
                    $query_emp = "SELECT F_name, L_name, member_no FROM employee WHERE EMP_ID = $emp_id";
                    $result_emp = $conn->query($query_emp);

                    if ($result_emp->num_rows > 0) {
                        $row_emp = $result_emp->fetch_assoc();
                        $name = $row_emp['F_name'] . ' ' . $row_emp['L_name'];
                        $member_no = $row_emp['member_no'];

                        // Check if attendance record already exists for this employee on this date
                        $check_sql = "SELECT * FROM attendance WHERE EMP_ID = $emp_id AND Date = '$date'";
                        $check_result = $conn->query($check_sql);

                        if ($status === 'Present') {
                            // Only proceed if status is 'Present'
                            $arrival_time = $value;
                            $leave_time = $_POST['leave_time_' . $emp_id];

                            if ($check_result->num_rows > 0) {
                                // Update the existing record
                                $update_sql = "UPDATE attendance SET Arrival_time = '$arrival_time', Leave_time = '$leave_time', status = '$status' 
                                               WHERE EMP_ID = $emp_id AND Date = '$date'";
                                if ($conn->query($update_sql) === TRUE) {
                                    $success_msg = "Attendance records updated successfully.";
                                } else {
                                    $error_msg = "Error updating attendance records: " . $conn->error;
                                }
                            } else {
                                // Insert a new record
                                $insert_sql = "INSERT INTO attendance (Date, Name, Arrival_time, Leave_time, status, EMP_ID, member_no) 
                                               VALUES ('$date', '$name', '$arrival_time', '$leave_time', '$status', $emp_id, '$member_no')";
                                if ($conn->query($insert_sql) === TRUE) {
                                    $success_msg = "Attendance records updated successfully.";
                                } else {
                                    $error_msg = "Error inserting attendance records: " . $conn->error;
                                }
                            }
                        } elseif ($status === 'Absent') {
                            // Handle Absent status without storing Arrival_time and Leave_time
                            if ($check_result->num_rows > 0) {
                                // Update the existing record to mark as Absent
                                $update_sql = "UPDATE attendance SET status = '$status', Arrival_time = NULL, Leave_time = NULL 
                                               WHERE EMP_ID = $emp_id AND Date = '$date'";
                                if ($conn->query($update_sql) === TRUE) {
                                    $success_msg = "Attendance records updated successfully.";
                                } else {
                                    $error_msg = "Error updating attendance records: " . $conn->error;
                                }
                            } else {
                                // Insert a new record for Absent without Arrival_time and Leave_time
                                $insert_sql = "INSERT INTO attendance (Date, Name, status, EMP_ID, member_no) 
                                               VALUES ('$date', '$name', '$status', $emp_id, '$member_no')";
                                if ($conn->query($insert_sql) === TRUE) {
                                    $success_msg = "Attendance records updated successfully.";
                                } else {
                                    $error_msg = "Error inserting attendance records: " . $conn->error;
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $error_msg = "Attendance for the selected date has not been recorded yet.";
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Himali Janitorial and Security Service - Monthly Attendance Sheet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
        }
        h1 {
            text-align: center;
            width: 100%;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin: 20px;
            flex: 1;
        }
        form {
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .form-group input[type="date"] {
            margin-right: 20px;
        }
        .form-group input[type="submit"], .form-group button {
            padding: 10px 20px;
            font-size: 16px;
            margin-left: 20px;
            background-color: navy;
            color: white;
            border: none;
            cursor: pointer;
        }
        .success-msg {
            color: green;
            margin-top: 10px;
        }
        .error-msg {
            color: red;
            margin-top: 10px;
        }
        .nav-bar {
            background-color: navy;
            color: white;
            width: 200px;
            height: 100vh;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .nav-bar img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        .nav-bar ul {
            list-style-type: none;
            padding: 0;
            width: 100%;
        }
        .nav-bar ul li {
            margin-bottom: 10px;
        }
        .nav-bar ul li a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="nav-bar">
        <img src="logo.jpg" alt="Company Logo">
        <h2>Attendance</h2>
        <ul>
            <li><a href="attendance_form.php">Take Attendance</a></li>
            <li><a href="mark_attendance.php">Delete Attendance</a></li>
            <li><a href="mark_attendance.php">Update Attendance</a></li>
            
            <li><a href="attendance_report.php">Attendance Reports</a></li>
        </ul>
    </div>
    <div class="container">
        <h1>Himali Janitorial and Security Service Monthly Attendance Sheet</h1>
        <form action="mark_attendance.php" method="post">
            <div class="form-group">
                <label for="date">Select Date:</label>
                <input type="date" name="date" id="date" required max="<?php echo date('Y-m-d'); ?>">
                <input type="submit" name="update" value="Update Attendance">
                <button type="submit" name="delete">Delete Attendance</button>
            </div>
            <?php if (!empty($success_msg)) { ?>
                <p class="success-msg"><?php echo $success_msg; ?></p>
            <?php } elseif (!empty($error_msg)) { ?>
                <p class="error-msg"><?php echo $error_msg; ?></p>
            <?php } ?>
            <table>
                <thead>
                    <tr>
                        <th>EMP ID</th>
                        <th>Name</th>
                        <th>Workplace</th>
                        <th>Arrival Time (am)</th>
                        <th>Leave Time (pm)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch employees and their work details from the employee and workplace tables
                    $conn = new mysqli('localhost', 'root', '', 'emsdatabase_final');
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $query = "SELECT e.EMP_ID, e.F_name, e.L_name, w.Work_name 
                              FROM employee e
                              LEFT JOIN workplace w ON e.work_ID = w.work_ID
                              ORDER BY e.work_ID";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['EMP_ID']}</td>
                                    <td>{$row['F_name']} {$row['L_name']}</td>
                                    <td>{$row['Work_name']}</td>
                                    <td><input type='time' name='arrival_time_{$row['EMP_ID']}' value='20:00' required></td>
                                    <td>
                                        <select name='leave_time_{$row['EMP_ID']}' required>
                                            <option value='16:00'>16:00 pm</option>
                                            <option value='12:00'>24:00 pm</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name='status_{$row['EMP_ID']}' required>
                                            <option value='Present'>Present</option>
                                            <option value='Absent'>Absent</option>
                                        </select>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No employees found</td></tr>";
                    }

                    // Close database connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </form>
    </div>
</body>
</html>
