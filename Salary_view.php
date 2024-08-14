<?php
include('db_connection.php');
include('Header.php');


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


<section>
    <div class= main>
        <div class="container">   
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
                <table class="table table-hover text-center">
                    <thead class="table-dark">
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Title</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                    </thead>
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
                                        <a href='paysheet_view.php?id={$row['id']}'>View</a> 
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
</section>

          
                
                

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
<script src="script.js"></script>
                