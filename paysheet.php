<?php
include 'db_connection.php';

// Initialize variables
$id = $title = $from_date = $to_date = "";
$action = "insert";
$message = "";
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $from_date = $_POST["from_date"];
    $to_date = $_POST["to_date"];
    $current_time = date('Y-m-d H:i:s');

    if ($_POST["action"] == "insert") {
        $sql = "INSERT INTO payrollsheet (title, from_date, to_date, create_at, update_at) 
                VALUES ('$title', '$from_date', '$to_date', '$current_time', '$current_time')";
        if ($conn->query($sql) === TRUE) {
            $message = "New record created successfully";
            echo "<script>alert('$message');</script>";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
            echo "<script>alert('$message');</script>";
        }
    } else if ($_POST["action"] == "update") {
        $sql = "UPDATE payrollsheet SET title='$title', from_date='$from_date', to_date='$to_date', update_at='$current_time' 
                WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            $message = "Record updated successfully";
            echo "<script>alert('$message');</script>";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
            echo "<script>alert('$message');</script>";
        }
    }
}

// Handle delete request
if (isset($_GET["delete_id"])) {
    $delete_id = $_GET["delete_id"];
    $sql = "DELETE FROM payrollsheet WHERE id='$delete_id'";
    if ($conn->query($sql) === TRUE) {
        $message = "Record deleted successfully";
        echo "<script>alert('$message');</script>";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
        echo "<script>alert('$message');</script>";
    }
}

// Handle edit request
if (isset($_GET["edit_id"])) {
    $edit_id = $_GET["edit_id"];
    $sql = "SELECT * FROM payrollsheet WHERE id='$edit_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row["id"];
        $title = $row["title"];
        $from_date = $row["from_date"];
        $to_date = $row["to_date"];
        $action = "update";
    }
}

// Handle filtering
$month_filter = "";
if (isset($_GET["month"])) {
    $month_filter = $_GET["month"];
}

$today = date('Y-m-d');

// Query for pagination
$sql = "SELECT * FROM payrollsheet";
if ($month_filter) {
    $sql .= " WHERE from_date LIKE '$month_filter%'";
}
$sql .= " LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Count the total number of records
$count_sql = "SELECT COUNT(*) as total FROM payrollsheet";
if ($month_filter) {
    $count_sql .= " WHERE from_date LIKE '$month_filter%'";
}
$count_result = $conn->query($count_sql);
$total_records = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pay Sheet</title>
    <link rel="stylesheet" href="style.css">
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
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: 20px auto; /* Center the form horizontally */
        }
        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
        }
        #create-paysheet table {
            width: 100%;
        }
        #create-paysheet td {
            padding: 0px 20px 0px 20px;
            vertical-align: top;
        }
        input[type="text"],
        input[type="number"],
        form input[type="month"],
        input[type="date"] {
            width: calc(100% - 10px);
            padding: 6px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .submit-container {
            text-align: center;
            margin-top: 10px;
        }
        button[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 6px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 200px;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        #paysheet-table th {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        #paysheet-table th {
            background-color: #007BFF;
            color: white;
        }
        #paysheet-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        #paysheet-table tr:hover {
            background-color: #ddd;
        }
        #paysheet-table td a {
            color: #007BFF;
            text-decoration: none;
            margin-right: 5px;
        }
        #paysheet-table td a:hover {
            text-decoration: underline;
        }
        #paysheet-table td:last-child {
            text-align: center;
        }
        #paysheet-table table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
        }
        #paysheet-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .filter-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }
        .filter-container table {
            width: auto;
            border-collapse: collapse;
        }
        .filter-container td {
            padding: 10px;
        }
        .filter-container input[type="month"] {
            padding: 6px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .filter-container button {
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
            background-color: #007BFF;
            color: white;
            width: 100px;
        }
        .filter-container button:hover {
            background-color: #0056b3;
        }
        .filter-container button:last-child {
            margin-right: 0;
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
            <form method="post" action="paysheet.php" id="create-paysheet">
                <h1>Pay Sheet</h1>
                <input type="hidden" name="action" value="<?php echo $action; ?>">
                <table>
                    <tr>
                        <td>Title: <input type="text" name="title" value="<?php echo $title; ?>" required></td>
                    </tr>
                    <tr>
                        <td>From Date: <input type="date" name="from_date" value="<?php echo $from_date; ?>" max="<?php echo $today;?>" required></td>
                        <td>To Date: <input type="date" name="to_date" value="<?php echo $to_date; ?>" max="<?php echo $today; ?>" required></td>
                    </tr>
                </table>
                <div class="submit-container">
                    <button type="submit"><?php echo ($action == "insert") ? "Insert" : "Update"; ?></button>
                </div>
            </form>

            <p><?php echo $message; ?></p>

            <h2>Payroll Sheets</h2> 
            <div class="filter-container">
                <table>
                    <tr>
                        <td><input type="month" name="month"></td>
                        <td><button type="button" onclick="filterByMonth()">Filter</button></td>
                        <td><button type="button" onclick="filterByAll()">All</button></td>
                    </tr>
                </table>
            </div>
            <br/>
            <div>
                <table id="paysheet-table">
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Title</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['title']}</td>
                                    <td>{$row['from_date']}</td>
                                    <td>{$row['to_date']}</td>
                                    <td>{$row['create_at']}</td>
                                    <td>{$row['update_at']}</td>
                                    <td>
                                        <a href='paysheet.php?edit_id={$row['id']}'>Edit</a> | 
                                        <a href='paysheet.php?delete_id={$row['id']}'>Delete</a> | 
                                        <a href='view_paysheet.php?id={$row['id']}'>View</a> 
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No records found</td></tr>";
                    }
                    ?>
                </table>
                <!-- <td>{$row['id']}</td> -->
            </div>
            <div class="pagination">
                <?php
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<a href='?page=$i&month=$month_filter' class='".($i == $page ? "active" : "")."'>$i</a>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
