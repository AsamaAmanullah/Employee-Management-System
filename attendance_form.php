<?php
// Establish database connection
$conn = new mysqli('localhost', 'root', 'root', 'emsdatabase_new');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for messages
$success_msg = $error_msg = '';

// Check if form is submitted and process attendance marking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];

    // Flag to check if any attendance was recorded
    $attendance_recorded = false;

    // Loop through each employee to record attendance
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'arrival_time_') === 0) {
            $emp_id = substr($key, strlen('arrival_time_'));

            $arrival_time = $_POST['arrival_time_' . $emp_id];
            $leave_time = $_POST['leave_time_' . $emp_id];
            $status = $_POST['status_' . $emp_id];

            // Set times to NULL if status is 'Absent'
            if ($status === 'Absent') {
                $arrival_time = NULL;
                $leave_time = NULL;
            }

            // Check if attendance already exists for the given date and employee
            $check_query = "SELECT * FROM attendance WHERE EMP_ID = '$emp_id' AND date = '$date'";
            $check_result = $conn->query($check_query);

            if ($check_result->num_rows == 0) {
                // Insert attendance record into database
                $insert_query = "INSERT INTO attendance (EMP_ID, date, arrival_time, leave_time, status) 
                                 VALUES ('$emp_id', '$date', " . ($arrival_time ? "'$arrival_time'" : "NULL") . ", " . ($leave_time ? "'$leave_time'" : "NULL") . ", '$status')";

                if ($conn->query($insert_query) === TRUE) {
                    $attendance_recorded = true;
                } else {
                    $error_msg = "Error: " . $conn->error;
                }
            } else {
                $error_msg = "Attendance  on $date already exists.";
            }
        }
    }

    // Display success message if attendance was recorded
    if ($attendance_recorded) {
        $success_msg = "Successfully Recorded the Attendance";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Himali Janitorial and Security Service Monthly Attendance Sheet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            margin: 0;
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
        .form-group input[type="submit"] {
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
        .logout-button {
            display: block;
            border-radius: 5px;
            width: 100px;
            padding: 10px;
            text-align: center;
            background-color: #f44336; /* Red background */
            color: white; /* White text */
            border: none;
            cursor: pointer;
            margin-top: 10px;
            text-decoration: none;
        }

        .logout-button a {
            color: white; /* Ensure the text is white */
            text-decoration: none; /* Remove underline */
        }

        .logout-button:hover {
            background-color: #d32f2f; /* Darker red on hover */
        }
    </style>
    <script>
        function logout() {
            sessionStorage.setItem('EMP_ID', "");
            window.top.location.href = 'login.html';
        }
    </script>
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
        <button class="logout-button"><a href="javascript:void(0);" onclick="logout()">Logout</a></button>
    </div>
    <div class="container">
        <h1>Himali Janitorial and Security Service Monthly Attendance Sheet</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="date">Select Date:</label>
                <input type="date" name="date" id="date" required max="<?php echo date('Y-m-d'); ?>">
                <input type="submit" value="Take Attendance">
            </div>
            <?php if (!empty($success_msg)) { ?>
                <p class="success-msg"><?php echo $success_msg; ?></p>
            <?php } ?>
            <?php if (!empty($error_msg)) { ?>
                <p class="error-msg"><?php echo $error_msg; ?></p>
            <?php } ?>
            <table>
                <thead>
                    <tr>
                        <th>EMP ID</th>
                        <th>Name</th>
                        <th>Workplace Name</th>
                        <th>Arrival Time (am)</th>
                        <th>Departure Time (pm)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch employees and their work details from the employee and workplace tables
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
                    ?>
                </tbody>
            </table>
        </form>
    </div>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
