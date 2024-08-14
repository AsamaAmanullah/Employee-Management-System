<?php
include('db_connection.php');
include('Header.php');

// Define how many results per page
$results_per_page = 10;

// Find out the number of results stored in the database
$query = "SELECT COUNT(*) AS total FROM WorkPlace";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_results = $row['total'];

// Determine the total number of pages available
$total_pages = ceil($total_results / $results_per_page);

// Determine which page number the visitor is currently on
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Determine the SQL LIMIT starting number for the results on the displaying page
$start_limit = ($page - 1) * $results_per_page;

// Fetch the selected results from the database, ordered by work_ID
$query = "SELECT * FROM WorkPlace ORDER BY work_ID ASC LIMIT $start_limit, $results_per_page";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<section>
    <div class="main">
        <div class="container">   
            <?php
                if(isset($_GET['msg'])){
                    $msg = $_GET['msg'];
                    echo '<div class="alert alert-warning alert-dismissible fade show" 
                    role="alert"> 
                    '.$msg.'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" 
                    aria-label="Close"></button>
                    </div>';
                } 
            ?>
            <h1 class="head">View Workplace Details</h1><br><br>

            <table class="table table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Work_ID</th>
                        <th scope="col">Work_Address</th>
                        <th scope="col">Work_name</th>
                        <th scope="col">No_of_workers</th>
                        <th scope="col">Person_in_charge_name</th>
                        <th scope="col">Person_in_charge_telephone</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Display fetched data
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr> 
                                <td><?php echo $row['work_ID']?></td>
                                <td><?php echo $row['Work_Address']?></td>
                                <td><?php echo $row['Work_name']?></td>
                                <td><?php echo $row['No_of_workers']?></td>
                                <td><?php echo $row['Person_in_charge_name']?></td>
                                <td><?php echo $row['Person_in_charge_telephone']?></td>
                                <td>
                                    <a href="Workedit.php?id=<?php echo $row['work_ID'] ?>" class="link-dark">
                                    <i class="fas fa-edit fs-5 me-3"></i></a>
                                    <a href="Workdelete.php?id=<?php echo $row['work_ID'] ?>" class="link-dark">
                                    <i class="fas fa-trash fs-5"></i></a>
                                </td>
                            </tr>
                            <?php    
                        }
                    ?>
                </tbody> 
            </table>
            <div class="pagination-container text-center">
                <?php
                // Display the pagination
                for ($i = 1; $i <= $total_pages; $i++) {
                    $activeClass = ($i == $page) ? 'active' : '';
                    echo '<a href="workview.php?page=' . $i . '" class="btn btn-success mx-1 ' . $activeClass . '">' . $i . '</a> ';
                }
                ?>
            </div>
        </div>
    </div>
</section>

<style>
    .pagination-container {
        margin-top: 20px;
    }
    .pagination-container .btn {
        min-width: 40px;
        border-radius: 4px;
    }
    .pagination-container .btn.active {
        background-color: green;
        color: white;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
<script src="script.js"></script>
