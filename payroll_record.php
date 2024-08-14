<?php
include 'db_connection.php';

$message = "";

// Delete record if delete_id is set
if (isset($_GET["delete_id"])) {
    $delete_id = $_GET["delete_id"];
    
    // Prepare the DELETE statement
    $sql = "DELETE FROM payroll WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    
    // Execute the DELETE statement
    if ($stmt->execute()) {
        $message = "Payroll record deleted successfully";
    } else {
        $message = "Error: " . $stmt->error;
    }
}

// Fetch employee IDs for the select dropdown
$employee_ids = [];
$emp_sql = "SELECT DISTINCT EMP_ID FROM payroll";
$emp_result = $conn->query($emp_sql);
if ($emp_result->num_rows > 0) {
    while($emp_row = $emp_result->fetch_assoc()) {
        $employee_ids[] = $emp_row['EMP_ID'];
    }
}

// Initialize pagination variables
$filter_emp_id = isset($_GET['filter_emp_id']) ? $_GET['filter_emp_id'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Number of records per page
$offset = ($page - 1) * $limit;

// Fetch payroll records based on filter and pagination
$payroll_sql = "SELECT * FROM payroll";
$count_sql = "SELECT COUNT(*) as total FROM payroll";

if ($filter_emp_id) {
    $payroll_sql .= " WHERE EMP_ID = ?";
    $count_sql .= " WHERE EMP_ID = ?";
    $stmt = $conn->prepare($payroll_sql . " LIMIT ? OFFSET ?");
    $stmt->bind_param("iii", $filter_emp_id, $limit, $offset);
} else {
    $stmt = $conn->prepare($payroll_sql . " LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $limit, $offset);
}

$stmt->execute();
$result = $stmt->get_result();

// Count the total number of records
if ($filter_emp_id) {
    $count_stmt = $conn->prepare($count_sql);
    $count_stmt->bind_param("i", $filter_emp_id);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
} else {
    $count_result = $conn->query($count_sql);
}

$total_records = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Generate Payroll</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function filterByAll() {
            window.location.href = 'payroll_record.php';
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .topbar{
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
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        td a {
            color: #007BFF;
            text-decoration: none;
            margin-right: 5px;
        }
        td a:hover {
            text-decoration: underline;
        }
        td:last-child {
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
        }
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button[type="submit"], button[type="button"] {
            background-color: #007BFF;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
            width: 100%;
        }
        button[type="submit"]:hover, button[type="button"]:hover {
            background-color: #0056b3;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 8px 16px;
            text-decoration: none;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
        }
        .pagination a:hover {
            background-color: #0056b3;
        }
        .pagination a.active {
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
            <h1>Payroll Records</h1>
            <div>
                <form method="GET" action="">
                    <table>
                        <tr>
                            <td>
                                <select name="filter_emp_id">
                                    <option value="">Select Employee ID</option>
                                    <?php foreach($employee_ids as $emp_id): ?>
                                        <option value="<?php echo $emp_id; ?>" <?php echo ($emp_id == $filter_emp_id) ? 'selected' : ''; ?>>
                                            <?php echo $emp_id; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><button type="submit">Filter</button></td>
                            <td><button type="button" onclick="filterByAll()">All</button></td>
                        </tr>
                    </table>
                </form>
            </div>
            <br/>
            <table>
                <tr>
                    <!-- <th>ID</th> -->
                    <th>Employee ID</th>
                    <th>Total Working Days</th>
                    <th>Total Deductions (Rs)</th>
                    <th>Other Earnings (Rs)</th>
                    <th>ETP (Rs)</th>
                    <th>Net Salary (Rs)</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['EMP_ID']}</td>
                                <td>{$row['total_working_days']}</td>
                                <td>{$row['total_deduction']}</td>
                                <td>{$row['other_earnings']}</td>
                                <td>{$row['tax_amount']}</td>
                                <td>{$row['net_salary']}</td>
                                <td>{$row['created_at']}</td>
                                <td>
                                    <a href='view_payroll.php?id={$row['id']}'>View</a> | 
                                    <a href='payroll_record.php?delete_id={$row['id']}'>Delete</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No payroll records found</td></tr>";
                }
                ?>
                <!-- <td>{$row['id']}</td> -->
                
            </table>
            <div class="pagination">
                <?php
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<a href='?page=$i&filter_emp_id=$filter_emp_id' class='".($i == $page ? "active" : "")."'>$i</a>";
                }
                ?>
            </div>
            <p><?php echo $message; ?></p>
        </div>
    </div>
</body>
</html>
