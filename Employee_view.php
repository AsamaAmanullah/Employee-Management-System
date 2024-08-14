<?php
include('db_connection.php');
include('Header.php');
$success = '';

// Check if connection was successful...
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all workplaces for the filter dropdown
$workplaces_sql = "SELECT work_ID, Work_name FROM workplace";
$workplaces_result = mysqli_query($conn, $workplaces_sql);
if (!$workplaces_result) {
    die("Query failed: " . mysqli_error($conn));
}

// Define the number of results per page
$results_per_page = 10;

// Get the selected workplace filter
$selected_workplace = isset($_GET['workplace']) ? $_GET['workplace'] : '';

// Find out the number of total results in the database
$sql_count = "SELECT COUNT(*) AS total FROM employee";
if ($selected_workplace) {
    $sql_count .= " WHERE work_ID = '$selected_workplace'";
}
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_results = $row_count['total'];

// Calculate the number of total pages
$total_pages = ceil($total_results / $results_per_page);

// Determine the current page number
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_from = ($page - 1) * $results_per_page;

// Fetch Employee details from tables Employee, Accountdetails, bankdetails, positions, paymentmethod, and workplace
$sql = "SELECT e.Member_No, e.F_name, e.L_name, e.DOB, e.Gender, e.Address, e.Mobile, e.NIC,
        p.Position_name, w.Work_name, pay.Pay_method, ad.Acc_No, ad.Branch, bd.Bank_Name, e.EMP_ID
        FROM employee AS e
        LEFT JOIN accountdetails AS ad ON e.EMP_ID = ad.EMP_ID
        LEFT JOIN bankdetails AS bd ON ad.Bank_ID = bd.Bank_ID
        LEFT JOIN positions AS p ON e.Position_ID = p.Position_ID
        LEFT JOIN paymethod AS pay ON e.Pay_ID = pay.Pay_ID
        LEFT JOIN workplace AS w ON e.work_ID = w.work_ID";
if ($selected_workplace) {
    $sql .= " WHERE e.work_ID = '$selected_workplace'";
}
$sql .= " LIMIT $start_from, $results_per_page";

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<section>
    <div class="main">
        <div class="scroll-container">
            <h1 class="head">View Employee details</h1><br><br>
            
            <!-- Filter Form -->
            <form id="filter-form" method="GET">
                <label for="workplace">Filter by Workplace:</label>
                <select name="workplace" id="workplace">
                    <option value="">All Workplaces</option>
                    <?php
                    while ($workplace = mysqli_fetch_assoc($workplaces_result)) {
                        $selected = ($workplace['work_ID'] == $selected_workplace) ? 'selected' : '';
                        echo "<option value='" . $workplace['work_ID'] . "' $selected>" . $workplace['Work_name'] . "</option>";
                    }
                    ?>
                </select>
                <noscript><input type="submit" value="Filter"></noscript>
            </form><br>

            <!-- Placeholder for the Table -->
            <div id="employee-table">
                <table class="table table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Member_No</th>
                            <th scope="col">F_name</th>
                            <th scope="col">L_name</th>
                            <th scope="col">DOB</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Address</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">NIC</th>
                            <th scope="col">Position_name</th>
                            <th scope="col">Work_name</th>
                            <th scope="col">Pay_method</th>
                            <th scope="col">Acc_No</th>
                            <th scope="col">Branch</th>
                            <th scope="col">Bank_Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Display fetched data
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo $row['Member_No'] ?></td>
                                <td><?php echo $row['F_name'] ?></td>
                                <td><?php echo $row['L_name'] ?></td>
                                <td><?php echo $row['DOB'] ?></td>
                                <td><?php echo $row['Gender'] ?></td>
                                <td><?php echo $row['Address'] ?></td>
                                <td><?php echo $row['Mobile'] ?></td>
                                <td><?php echo $row['NIC'] ?></td>
                                <td><?php echo $row['Position_name'] ?></td>
                                <td><?php echo $row['Work_name'] ?></td>
                                <td><?php echo $row['Pay_method'] ?></td>
                                <td><?php echo $row['Acc_No'] ?></td>
                                <td><?php echo $row['Branch'] ?></td>
                                <td><?php echo $row['Bank_Name'] ?></td>
                                <td>
                                    <a href="Employee_edit.php?id=<?php echo $row['EMP_ID'] ?>" class="link-dark">
                                        <i class="fas fa-edit fs-5 me-3"></i></a>
                                    <a href="Employee_delete.php?id=<?php echo $row['EMP_ID'] ?>" class="link-dark delete-btn">
                                        <i class="fas fa-trash fs-5"></i></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $link_class = ($i == $page) ? 'pagination-link active' : 'pagination-link';
                        echo "<a href='?page=$i&workplace=$selected_workplace' class='" . $link_class . "' data-page='" . $i . "'>" . $i . "</a> ";
                    }
                    ?>
                </div>

                <style>
                    .pagination {
                        display: flex;
                        justify-content: center;
                        margin-top: 20px;
                    }

                    .pagination-link {
                        margin: 0 5px;
                        padding: 8px 16px;
                        text-decoration: none;
                        border: 1px solid #ddd;
                        color: black;
                    }

                    .pagination-link:hover {
                        background-color: #ddd;
                    }

                    .pagination-link.active {
                        background-color: #4CAF50;
                        color: white;
                        border: 1px solid #4CAF50;
                    }
                </style>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Filter form change event
        $("#workplace").change(function() {
            $("#filter-form").submit();
        });
    });
</script>
