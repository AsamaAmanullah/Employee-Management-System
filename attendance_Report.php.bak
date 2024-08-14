<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Attendance Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            margin: 0;
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
        .nav-bar h2 {
            text-align: center;
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
        .container {
            flex: 1;
            padding: 20px;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-group {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        .form-group label {
            margin-right: 10px;
        }
        .form-group select, .form-group input[type="submit"] {
            padding: 8px;
            font-size: 14px;
            border: none;
        }
        .form-group select {
            background-color: navy;
            color: white;
            margin-right: 10px;
        }
        .form-group input[type="submit"] {
            background-color: navy;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-group input[type="submit"]:hover {
            background-color: #001f4d; /* Darker shade of navy for hover effect */
        }
        .center-title {
            text-align: center;
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
        <li><a href="attendance_Report.php">Attendance Reports</a></li>
    </ul>
</div>

<div class="container">
    <h2 class="center-title">Select Month and Year for Attendance Report</h2>

    <form method="post" action="attendance_report.php" class="form-group">
        <label for="month">Month:</label>
        <select name="month" id="month">
            <?php
            // Generate options for months
            for ($m = 1; $m <= 12; $m++) {
                $month = date('F', mktime(0, 0, 0, $m, 1));
                echo "<option value='$m' style='background-color: navy; color: white;'>$month</option>";
            }
            ?>
        </select>

        <label for="year">Year:</label>
        <select name="year" id="year" style="background-color: navy; color: white;">
            <?php
            // Generate options for years, adjust the range as needed
            $currentYear = date('Y');
            $startYear = $currentYear - 5;
            $endYear = $currentYear + 5;

            for ($y = $startYear; $y <= $endYear; $y++) {
                echo "<option value='$y'>$y</option>";
            }
            ?>
        </select>

        <input type="submit" value="Generate Report">
    </form>

    <hr>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        // Handle form submission
        $month = $_POST['month'];
        $year = $_POST['year'];

        // Calculate first and last day of the selected month
        $first_day = date('Y-m-01', strtotime("$year-$month-01"));
        $last_day = date('Y-m-t', strtotime("$year-$month-01"));

        // Fetch attendance report for the selected month and year
        $report_query = "
            SELECT e.EMP_ID, e.F_name, e.L_name, 
                   SUM(CASE WHEN a.status = 'Present' AND a.leave_time = '12:00:00' THEN 1 ELSE 0 END) AS half_day_count,
                   SUM(CASE WHEN a.status = 'Present' AND a.leave_time != '12:00:00' THEN 1 ELSE 0 END) AS full_day_count,
                   SUM(CASE WHEN a.status = 'Absent' THEN 1 ELSE 0 END) AS total_absents
            FROM employee e
            LEFT JOIN attendance a ON e.EMP_ID = a.EMP_ID
            WHERE a.Date >= '$first_day' AND a.Date <= '$last_day'
            GROUP BY e.EMP_ID, e.F_name, e.L_name";

        $report_result = $conn->query($report_query);

        // Display the report
        if ($report_result->num_rows > 0) {
            echo "<h2>Monthly Attendance Report for " . date('F Y', strtotime("$year-$month-01")) . "</h2>";
            echo "<p>Attendance from $first_day to $last_day</p>";
            echo "<table>
                    <tr>
                        <th>EMP ID</th>
                        <th>Name</th>
                        <th>Full Day Count</th>
                        <th>Half Day Count</th>
                        <th>Total Absents</th>
                    </tr>";
            while ($row = $report_result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['EMP_ID']}</td>
                        <td>{$row['F_name']} {$row['L_name']}</td>
                        <td>{$row['full_day_count']}</td>
                        <td>{$row['half_day_count']}</td>
                        <td>{$row['total_absents']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No records found for " . date('F Y', strtotime("$year-$month-01")) . ".";
        }

        // Close the database connection
        $conn->close();
    }
    ?>
</div>

</body>
</html>
