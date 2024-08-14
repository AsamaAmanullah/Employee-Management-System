<?php
include('db_connection.php');
include('Header.php');
?>

<section>
    <div class="main">
        <div class="container">   
            <?php
            if(isset($_GET['msg'])){
                $msg = $_GET['msg'];
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert"> 
                        '.$msg.'
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            } 
            ?>
            <h1 class="head">View Employee Leave Details</h1><br><br>

            <table class="table table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Employee Name</th>
                        <th>Position</th>
                        <th>Leave Type</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Leave Duration</th>
                        <th>Notes</th>
                        <th>Submission Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT el.leave_id, CONCAT(e.f_name, ' ', e.l_name) AS employee_name, p.position_name,
                                     el.leave_type, el.from_date, el.to_date, el.leave_duration,
                                     el.notes, el.submission_date
                              FROM emp_leaves AS el
                              INNER JOIN employee AS e ON el.EMP_ID = e.emp_id
                              INNER JOIN positions AS p ON el.position_id = p.position_id";

                    $result = mysqli_query($conn, $query);

                    if(mysqli_num_rows($result) > 0) {
                        $count = 1;
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>
                                    <td>'.$count.'</td>
                                    <td>'.$row['employee_name'].'</td>
                                    <td>'.$row['position_name'].'</td>
                                    <td>'.$row['leave_type'].'</td>
                                    <td>'.$row['from_date'].'</td>
                                    <td>'.$row['to_date'].'</td>
                                    <td>'.$row['leave_duration'].'</td>
                                    <td>'.$row['notes'].'</td>
                                    <td>'.$row['submission_date'].'</td>
                                  </tr>';
                            $count++;
                        }
                    } else {
                        echo '<tr><td colspan="9">No records found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
<script src="script.js"></script>
