<?php
include('db_connection.php');
include('Header.php');

$success='';

// Retrieve work ID from GET parameter
$work_ID = isset($_GET['id']) ? $_GET['id'] : null;

// Fetch work details
if ($work_ID !== null) {
    $query = "SELECT * FROM `workplace` WHERE `work_ID`= '$work_ID'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    } else {
        $row = mysqli_fetch_assoc($result);
    }
} else {
    echo "ID is not set.";
}

// Handle form submission for updating workplace
if (isset($_POST['update'])) {
    if (isset($_GET['Newwork_ID'])) {
        $Newwork_ID = $_GET['Newwork_ID'];
    }

    $Work_name = $_POST['Work_name'];
    $Work_Address = $_POST['Work_Address'];
    $No_of_workers = $_POST['No_of_workers'];
    $Person_in_charge_name = $_POST['Person_in_charge_name'];
    $Person_in_charge_telephone = $_POST['Person_in_charge_telephone'];

    // Update query
    $query = "UPDATE `workplace` SET 
        `Work_name` = '$Work_name',
        `Work_Address` = '$Work_Address', 
        `No_of_workers` = '$No_of_workers',
        `Person_in_charge_name` = '$Person_in_charge_name',
        `Person_in_charge_telephone` = '$Person_in_charge_telephone'
        WHERE `work_ID`= '$Newwork_ID'";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    ?>
    <script>
        window.location.href = "Workview.php";
    </script>
    <?php 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Workplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
</head>
<body>
    <section>
        <div class="main">
            <div class="container">    
                <h1 class="head">Edit Workplace Details</h1><br><br>

                <form action="Workedit.php?Newwork_ID=<?php echo $work_ID; ?>" method="post">
                    <input type="hidden" name="work_ID" value="<?php echo $work_ID; ?>">
                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0">Workplace Name:<span class="required">*</span></legend>
                        <div class="col">
                            <input type="text" class="form-control" name="Work_name" value="<?php echo $row['Work_name']?>">
                        </div>
                    </div><br><br>

                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0">Workplace Address:<span class="required">*</span></legend>
                        <div class="col">
                            <input type="text" class="form-control" name="Work_Address" value="<?php echo $row['Work_Address']?>">
                        </div>
                    </div><br><br>

                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0">Number of Workers:<span class="required">*</span></legend>
                        <div class="col">
                            <input type="text" class="form-control" name="No_of_workers" value="<?php echo $row['No_of_workers']?>" >
                        </div>
                    </div><br><br>

                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0">Person in Charge Name:<span class="required">*</span></legend>
                        <div class="col">
                            <input type="text" class="form-control" name="Person_in_charge_name" value="<?php echo $row['Person_in_charge_name']?>" >
                        </div>
                    </div><br><br>

                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0">Person in Charge Telephone:<span class="required">*</span></legend>
                        <div class="col-auto">
                            <input type="text" class="form-control" name="Person_in_charge_telephone"  value="<?php echo $row['Person_in_charge_telephone']?>">
                        </div>
                    </div><br><br>

                    <div>
                        <button type="submit" class="btn btn-success"style="color:black;" name="update">Update</button>
                        <a href="Workview.php" class="btn btn-danger" style="color:black;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>
