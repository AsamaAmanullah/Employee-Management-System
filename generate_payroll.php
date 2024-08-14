<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $position = $_POST['position'];
    $bank_no = $_POST['bank_no'];
    $bank_name = $_POST['bank_name'];
    $branch = $_POST['branch'];
    $work_place = $_POST['work_place'];
    $payment_method = $_POST['payment_method'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $total_deductions = $_POST['total_deductions'];
    $other_earnings = $_POST['other_earnings'];
    $current_time = date('Y-m-d');

    // Get the employee position and salary using a single JOIN query
    $employee_id = $conn->real_escape_string($employee_id);
    $employee_salary_sql = "
        SELECT p.salary 
        FROM employee e
        JOIN positions p ON e.Position_ID = p.Position_ID
        WHERE e.EMP_ID = '$employee_id'";

    $employee_salary_result = $conn->query($employee_salary_sql);
    if ($employee_salary_result->num_rows > 0) {
        $employee_salary_row = $employee_salary_result->fetch_assoc();
        $salary = $employee_salary_row['salary'];
    } else {
        $salary = 0; // Default or error handling
    }

    // Calculate total salary based on attendance
    $salarycal1 = 0;
    $attendance_sql = "
        SELECT Arrival_time, Leave_time 
        FROM attendance 
        WHERE Date BETWEEN '$from_date' AND '$to_date' AND EMP_ID = '$employee_id'";
    $attendance_result = $conn->query($attendance_sql);

    // Calculate total working days
    $total_working_days = $attendance_result->num_rows;

    if ($attendance_result->num_rows > 0) {
        while ($row = $attendance_result->fetch_assoc()) {
            $arrival_time = new DateTime($row['Arrival_time']);
            $leave_time = new DateTime($row['Leave_time']);
            $working_hours = $arrival_time->diff($leave_time)->h;
            if ($working_hours >= 8) {
                $salarycal1 += $salary;
            } elseif ($working_hours >= 4) {
                $salarycal1 += $salary / 2;
            }
        }
    }

    // Calculate net salary
    $salary_cal = $salarycal1 + $other_earnings - $total_deductions;
    $tax_amount = $salary_cal * 3 / 100; // tax Amount
    $net_salary = $salary_cal - $tax_amount;

    $sql = "INSERT INTO payroll (EMP_ID, total_working_days, total_deduction, other_earnings, tax_amount, net_salary, created_at) 
            VALUES ('$employee_id', '$total_working_days', '$total_deductions', '$other_earnings', '$tax_amount', '$net_salary', '$current_time')";
    if ($conn->query($sql) === TRUE) {
        $message = "New payroll record created successfully";
        echo "<script type='text/javascript'>window.alert('$message');</script>";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
        echo "<script type='text/javascript'>window.alert('$message');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Generate Payroll</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .topbar {
            background-color: #ffffff;
            padding: 5px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .topbar img {
            width: 40px;
            height: 30px;
            margin-left: 20px;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 600px;
            margin-top: 20px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        .submit-container {
            text-align: center;
            margin-top: 10px;
        }
        table {
            width: 100%;
        }
        table td {
            padding: 0px 20px 0px 20px;
            vertical-align: top;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"],
        input[type="number"],
        select {
            width: calc(100% - 10px);
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 200px;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <div>
        <!-- Sidebar iframe -->
        <iframe id="sidebar-iframe" src="sidebar.html" width="100%" height="100%" style="border: none;" title="Sidebar"></iframe>
    </div>
    <div class="content">
        <div class="topbar">
            <img src="logo.jpg">
        </div>
        <form id="payrollForm" method="post" action="generate_payroll.php">
            <h1>Generate Payroll</h1>
            <table>
                <tr>
                    <td>
                        <label for="employee_id">Employee:</label>
                        <select name="employee_id" id="employee_id" required>
                            <option value="">Select Employee</option>
                            <?php
                            $sql = "SELECT EMP_ID, F_name, L_name FROM employee";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['EMP_ID']}'>{$row['EMP_ID']} - {$row['F_name']} {$row['L_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <label for="position">Position:</label>
                        <input type="text" name="position" id="position" readonly>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="bank_name">Bank Name:</label>
                        <input type="text" name="bank_name" id="bank_name" readonly>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="bank_no">Bank No:</label>
                        <input type="text" name="bank_no" id="bank_no" readonly>
                    </td>
                    <td>
                        <label for="branch">Branch:</label>
                        <input type="text" name="branch" id="branch" readonly>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="from_date">From Date:</label>
                        <input type="date" name="from_date" id="from_date" required>
                    </td>
                    <td>
                        <label for="to_date">To Date:</label>
                        <input type="date" name="to_date" id="to_date" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="total_deductions">Total Deductions (Rs):</label>
                        <input type="number" name="total_deductions" step="0.01" value="0" >
                    </td>
                    <td>
                        <label for="other_earnings">Other Earnings (Rs):</label>
                        <input type="number" name="other_earnings" step="0.01" value="0" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="payment_method">Payment Method:</label>
                        <input type="text" name="payment_method" id="payment_method" readonly>
                    </td>
                    <td>
                        <label for="work_place">Work Place:</label>
                        <input type="text" name="work_place" id="work_place" readonly>
                    </td>
                </tr>
            </table>
            <div class="submit-container">
                <button type="submit">Insert</button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // Set the date range for the current month
    var today = new Date();
    var firstDay = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
    var lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().split('T')[0];

    $('#from_date').attr('min', firstDay);
    $('#from_date').attr('max', lastDay);
    $('#to_date').attr('min', firstDay);
    $('#to_date').attr('max', lastDay);

    $('#employee_id').change(function() {
        var employee_id = $(this).val();
        if (employee_id) {
            $.ajax({
                url: 'fetch_employee_details.php',
                type: 'GET',
                data: {employee_id: employee_id},
                success: function(data) {
                    var details = JSON.parse(data);
                    $('#position').val(details.Position_name);
                    $('#bank_no').val(details.Acc_No);
                    $('#bank_name').val(details.Bank_Name);
                    $('#branch').val(details.Branch);
                    $('#work_place').val(details.Work_name);
                    $('#payment_method').val(details.Pay_method);
                }
            });
        } else {
            $('#position').val('');
            $('#bank_no').val('');
            $('#bank_name').val('');
            $('#branch').val('');
            $('#work_place').val('');
            $('#payment_method').val('');
        }
    });

    $('#payrollForm').submit(function(e) {
        e.preventDefault();

        var employee_id = $('#employee_id').val();
        var position = $('#position').val();
        var bank_name = $('#bank_name').val();
        var bank_no = $('#bank_no').val();
        var branch = $('#branch').val();
        var from_date = $('input[name="from_date"]').val();
        var to_date = $('input[name="to_date"]').val();
        var total_deductions = $('input[name="total_deductions"]').val();
        var other_earnings = $('input[name="other_earnings"]').val();
        var tax_amount = $('input[name="tax_amount"]').val();
        var work_place = $('#work_place').val();
        var payment_method = $('#payment_method').val();

        if (employee_id === "" || payment_method === "") {
            alert("Please fill in all required fields.");
            return;
        }

        if (new Date(from_date) > new Date(to_date)) {
            alert("From Date cannot be greater than To Date.");
            return;
        }

        this.submit();
    });
});
</script>
</body>
</html>
