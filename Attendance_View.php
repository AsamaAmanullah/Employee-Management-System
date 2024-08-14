<?php
include('db_connection.php');
include('Header.php');

$report_html = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    // Build the report HTML
    if ($report_result->num_rows > 0) {
        $report_html .= "<h2>Monthly Attendance Report for " . date('F Y', strtotime("$year-$month-01")) . "</h2>";
        $report_html .= "<p>Attendance from $first_day to $last_day</p>";
        $report_html .= "<table class='table table-hover text-center'>
                <tr class='table-dark'>
                    <th>EMP ID</th>
                    <th>Name</th>
                    <th>Full Day Count</th>
                    <th>Half Day Count</th>
                    <th>Total Absents</th>
                </tr>";
        while ($row = $report_result->fetch_assoc()) {
            $report_html .= "<tr>
                    <td>{$row['EMP_ID']}</td>
                    <td>{$row['F_name']} {$row['L_name']}</td>
                    <td>{$row['full_day_count']}</td>
                    <td>{$row['half_day_count']}</td>
                    <td>{$row['total_absents']}</td>
                  </tr>";
        }
        $report_html .= "</table>";
    } else {
        $report_html .= "No records found for " . date('F Y', strtotime("$year-$month-01")) . ".";
    }
}

// Close the database connection
$conn->close();
?>

<section>
    <div class="main">
        <div class="container">  
            <h1 class="head">View Attendance Details</h1><br><br>
            <form method="post" action="attendance_View.php" class="form-group">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="month">Month:</label>
                        <select name="month" id="month" class="form-control">
                            <?php
                            // Generate options for months
                            for ($m = 1; $m <= 12; $m++) {
                                $month_name = date('F', mktime(0, 0, 0, $m, 1));
                                echo "<option value='$m'>$month_name</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="year">Year:</label>
                        <select name="year" id="year" class="form-control">
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
                    </div>    
                </div>
                <input type="submit" value="Generate Report" style="color:black;" class="btn btn-primary mt-3">
            </form>
            <hr>
            <?php
            // Display the report after the <hr>
            echo $report_html;
            ?>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
<script src="script.js"></script>
