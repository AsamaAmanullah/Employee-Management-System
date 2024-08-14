<?php
include('db_connection.php');
include('Header.php');

// Pagination variables
$results_per_page = 10; // Number of items per page

if (!isset($_GET['page'])) {
    $page = 1; // Default page number
} else {
    $page = $_GET['page'];
}

// Calculate the starting limit for the query
$offset = ($page - 1) * $results_per_page;

?>

<section>
    <div class="main">
        <div class="container">
            <?php
            if (isset($_GET['msg'])) {
                $msg = $_GET['msg'];
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        ' . $msg . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }
            ?>
            <h1 class="head">View Inventory Details</h1><br><br>

            <table class="table table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Tool_ID</th>
                        <th scope="col">Tool_name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">purchase_date</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    // Fetch inventory details from database with pagination
                    $query = "SELECT * FROM inventory LIMIT $offset, $results_per_page";
                    $result = mysqli_query($conn, $query);
                    if (!$result) {
                        die("Query failed: " . mysqli_error($conn));
                    }

                    // Display fetched data
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row['Tool_ID'] ?></td>
                            <td><?php echo $row['Tool_name'] ?></td>
                            <td><?php echo $row['Price'] ?></td>
                            <td><?php echo $row['Quantity'] ?></td>
                            <td><?php echo $row['purchase_date'] ?></td>
                        </tr>
                    <?php
                    }
                    ?>

                </tbody>
            </table>

            <?php
            // Pagination links
            $query = "SELECT COUNT(*) AS total FROM inventory";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $total_pages = ceil($row['total'] / $results_per_page);

            echo '<nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">';
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
            }
            echo '</ul>
                </nav>';
            ?>

        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
<script src="script.js"></script>
