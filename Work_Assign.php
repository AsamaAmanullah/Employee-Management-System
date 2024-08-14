<?php
include('db_connection.php');
include('Header.php');
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Fetch data from the form
        $employee_id = $_POST['employee_id'];
        $workplace_id = $_POST['workplace_id'];

        // Update the employee record with the selected workplace
        $stmt = $conn->prepare("UPDATE Employee SET work_ID = ? WHERE EMP_ID = ?");
        $stmt->bind_param("ii", $workplace_id, $employee_id);

        if (!$stmt->execute()) {
            throw new Exception("Error updating employee workplace: " . $stmt->error);
        }

        $success = '<div class="alert alert-success" role="alert">Workplace assigned successfully</div>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>';
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}
?>

<section>
    <div class="main">
        <div class="container">  
            <h1 class="head">Assign Workplace to Employee</h1><br><br>
            <?php echo $success; ?>
            <form action="" method="post">
                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Employee:<span class="required">*</span></legend>
                    <div class="col-auto">
                        <select class="form-select" id="employee_id" name="employee_id" required>
                            <option value="">Select an employee</option>
                            <?php
                            $Employees = mysqli_query($conn, "SELECT EMP_ID, F_name, L_name FROM Employee WHERE work_ID IS NULL OR work_ID = 0");
                            while ($emp = mysqli_fetch_array($Employees)) {
                                echo "<option value=\"{$emp['EMP_ID']}\">{$emp['F_name']} {$emp['L_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div><br><br>

                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Workplace:<span class="required">*</span></legend>
                    <div class="col-auto">
                        <select class="form-select" id="workplace_id" name="workplace_id" required>
                            <option value="">Select a workplace</option>
                            <?php
                            $Workplaces = mysqli_query($conn, "SELECT work_ID, Work_name FROM workplace");
                            while ($wp = mysqli_fetch_array($Workplaces)) {
                                echo "<option value=\"{$wp['work_ID']}\">{$wp['Work_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div><br><br>

                <input class="btn btn-primary" type="submit" value="Assign" style="color:black;">
            </form>
        </div>
    </div>   
</section>

<style>
    .required {
        color: red;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
<script src="script.js"></script>
