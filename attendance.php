<?php
// Include the database connection file
include 'db_connection.php';

// Initialize variables for filtering
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Initialize variables for pagination
$limit = 10; // Number of entries per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Build the SQL query with filters if any
$sql = "SELECT `Date`, `EMP_ID`, `Name`, `Arrival_time`, `Leave_time`, `status` FROM `attendance` WHERE 1";

if ($from_date) {
    $sql .= " AND `Date` >= '$from_date'";
}

if ($to_date) {
    $sql .= " AND `Date` <= '$to_date'";
}

if ($id) {
    $sql .= " AND `EMP_ID` = '$id'";
}

// Add limit and offset for pagination
$sql .= " LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);

// Get the total number of records for pagination
$count_sql = "SELECT COUNT(*) AS total FROM `attendance` WHERE 1";
if ($from_date) {
    $count_sql .= " AND `Date` >= '$from_date'";
}
if ($to_date) {
    $count_sql .= " AND `Date` <= '$to_date'";
}
if ($id) {
    $count_sql .= " AND `EMP_ID` = '$id'";
}
$count_result = $conn->query($count_sql);
$total_records = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $limit);

// Pagination variables
$adjacents = 2; // Number of pages adjacent to the current page

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function loadPage(url) {
            document.getElementById('iframe').src = url;
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
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
            width: 800px;
            border: 1px solid #ddd;
        }
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .leave input[type="submit"] {
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100px;
        }
        .leave input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .leave input[type="date"],
        .leave input[type="text"],
        .leave input[type="submit"] {
            flex: 1 1 100%;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            color: #007BFF;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color 0.3s;
            margin: 0 4px;
        }
        .pagination a:hover {
            background-color: #ddd;
        }
        .pagination a.active {
            background-color: #007BFF;
            color: white;
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
            <h1>Attendance Page</h1>
            <form action="" method="GET" class="form">
                <div class="leave">
                    <label for="from_date">From Date:</label>
                    <input type="date" id="from_date" name="from_date" value="<?php echo $from_date; ?>">
                    <label for="to_date">To Date:</label>
                    <input type="date" id="to_date" name="to_date" value="<?php echo $to_date; ?>">
                    <label for="id">ID:</label>
                    <input type="text" id="id" name="id" value="<?php echo $id; ?>">
                    <input type="submit" value="Filter" class="btn">
                </div>
                <br>
                <div>
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Arrival Time</th>
                            <th>Leave Time</th>
                            <th>Status</th>
                        </tr>
                        <?php
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['Date']}</td>
                                    <td>{$row['EMP_ID']}</td>
                                    <td>{$row['Name']}</td>
                                    <td>{$row['Arrival_time']}</td>
                                    <td>{$row['Leave_time']}</td>
                                    <td>{$row['status']}</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No records found</td></tr>";
                        }
                        ?>
                    </table>
                </div>
            </form>
            <div class="pagination">
                <?php
                if ($total_pages > 1) {
                    if ($page > 1) {
                        echo '<a href="?page=' . ($page - 1) . '&from_date=' . $from_date . '&to_date=' . $to_date . '&id=' . $id . '">Previous</a>';
                    }

                    // Page range calculations
                    $start = max(1, $page - $adjacents);
                    $end = min($total_pages, $page + $adjacents);

                    if ($start > 1) {
                        echo '<a href="?page=1&from_date=' . $from_date . '&to_date=' . $to_date . '&id=' . $id . '">1</a>';
                        if ($start > 2) {
                            echo '<span>...</span>';
                        }
                    }

                    for ($i = $start; $i <= $end; $i++) {
                        if ($i == $page) {
                            echo '<a class="active" href="?page=' . $i . '&from_date=' . $from_date . '&to_date=' . $to_date . '&id=' . $id . '">' . $i . '</a>';
                        } else {
                            echo '<a href="?page=' . $i . '&from_date=' . $from_date . '&to_date=' . $to_date . '&id=' . $id . '">' . $i . '</a>';
                        }
                    }

                    if ($end < $total_pages) {
                        if ($end < $total_pages - 1) {
                            echo '<span>...</span>';
                        }
                        echo '<a href="?page=' . $total_pages . '&from_date=' . $from_date . '&to_date=' . $to_date . '&id=' . $id . '">' . $total_pages . '</a>';
                    }

                    if ($page < $total_pages) {
                        echo '<a href="?page=' . ($page + 1) . '&from_date=' . $from_date . '&to_date=' . $to_date . '&id=' . $id . '">Next</a>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
