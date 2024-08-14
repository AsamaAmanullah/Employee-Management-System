<?php
include('db_connection.php');
include('Header.php');
$success='';

$EMP_ID = isset($_GET['id'])? $_GET['id'] : null;

if($EMP_ID !== null){
    // Fetch employee details based on EMP_ID
    $query = "SELECT e.Member_No, e.F_name, e.L_name, e.DOB, e.Gender, e.Address, e.Mobile, e.NIC,
    p.Position_name, pay.Pay_method, ad.Acc_No, bd.Bank_Name, e.EMP_ID
    FROM employee AS e
    LEFT JOIN accountdetails AS ad ON e.EMP_ID = ad.EMP_ID
    LEFT JOIN bankdetails AS bd ON ad.bank_id = bd.bank_id
    LEFT JOIN positions AS p ON e.Position_ID = p.Position_ID
    LEFT JOIN paymethod AS pay ON e.Pay_ID = pay.Pay_ID
    WHERE e.EMP_ID = $EMP_ID";


    $result = mysqli_query($conn,$query);

    if(!$result){
        die("query failed: ".mysqli_error($conn));
    }else{
        $row = mysqli_fetch_assoc($result);
    }
}else {
    echo "ID is not set.";
}

// Handle submission for update
if(isset($_POST['update'])){
    $EMP_ID = $_POST['EMP_ID'];

    $Member_No = $_POST['Member_No'];
    $F_name = $_POST['F_name'];
    $L_name = $_POST['L_name'];
    $DOB = $_POST['DOB'];
    $Gender = isset($_POST['Gender']) ? $_POST['Gender'] : ''; 
    $Address = $_POST['Address'];
    $Mobile = $_POST['Mobile'];
    $NIC = $_POST['NIC'];
    $Position_name = $_POST['Position_name'];
    $Pay_method = $_POST['Pay_method'];
    $Acc_No = $_POST['Acc_No'];
    $Bank_id = $_POST['Bank_Name'];

    // Update query
    $query = "UPDATE `employee` SET 
    `Member_No`='$Member_No',
    `F_name`='$F_name',
    `L_name`='$L_name',
    `DOB`='$DOB', 
    `Gender`='$Gender', 
    `Address`='$Address', 
    `Mobile`='$Mobile', 
    `Position_ID`='$Position_name',
    `Pay_ID`='$Pay_method',
    `NIC`='$NIC'
    WHERE `EMP_ID`='$EMP_ID'";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query2 failed: " . mysqli_error($conn));
    }

    // Update accountdetails table
    $update_account_query = "UPDATE `accountdetails` SET 
    `Acc_No`='$Acc_No',
    `bank_id`='$Bank_id'
    WHERE `EMP_ID`='$EMP_ID'";

    $result = mysqli_query($conn, $update_account_query);

    if (!$result) {
        die("Query3 failed: " . mysqli_error($conn));
    }       

    ?>
    <script>
        window.location.href = "Employee_view.php";
    </script>
    <?php 
    exit();
}
?>
<section>
    <div class="main">
        <div class="container">  
            <h1 class="head">Edit Employee Details</h1><br><br>
            <form action="#" method="post">
                <input type="hidden" name="EMP_ID" value="<?php echo $EMP_ID; ?>">

                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Member number:<span class="required">*</span></legend>
                    <div class="col-auto">
                        <input type="text" class="form-control" name="Member_No" value= "<?php echo isset($row['Member_No']) ? $row['Member_No'] : ''; ?>">
                    </div>
                </div><br><br>

                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Position:<span class="required">*</span></legend>
                    <div class="col-auto">
                        <select class="form-select"  name="Position_name" aria-label="position selection" >
                            <?php
                            $Positions = mysqli_query($conn,"Select * from positions");
                            while($cc = mysqli_fetch_array($Positions)){
                            ?>

                            <option value="<?php echo $cc['Position_ID'] ?>" <?php if(isset($row['Position_name']) && $cc['Position_name'] == $row['Position_name']) echo 'selected'; ?>>
                                <?php echo $cc['Position_name']?>
                            </option>     
                            <?php }?>
                        </select>
                    </div>
                </div><br><br>

                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Employee Name:<span class="required">*</span></legend>
                    <div class="col">
                        <input type="text" class="form-control" aria-label="First name" name="F_name" value="<?php echo isset($row['F_name']) ? $row['F_name'] : ''; ?>">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" aria-label="Last name" name="L_name" value="<?php echo isset($row['L_name']) ? $row['L_name'] : ''; ?>">
                    </div>
                </div><br><br>

                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Date Of Birth:<span class="required">*</span></legend>
                    <div class="col-auto">
                        <input type="date" class="form-control" name="DOB" value="<?php echo isset($row['DOB']) ? $row['DOB'] : ''; ?>">
                    </div>
                </div><br><br>

                <fieldset class="row mb-3">
                    <legend class="col-form-label col-sm-2 pt-0">Gender:<span class="required">*</span></legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="Gender"  value="Male" <?php if (isset($row['Gender']) && $row['Gender'] == 'Male') echo 'checked' ?>>
                            Male
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="Gender"  value="Female" <?php if (isset($row['Gender']) && $row['Gender'] == 'Female') echo 'checked' ?>>
                            Female
                        </div>
                    </div>
                </fieldset><br>  

                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Address:<span class="required">*</span></legend>
                    <div class="col">
                        <input type="text" class="form-control" name="Address" value="<?php echo isset($row['Address']) ? $row['Address'] : ''; ?>">
                    </div>
                </div><br><br>

                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Telephone number:<span class="required">*</span></legend>
                    <div class="col-auto">
                        <input type="text" class="form-control" name="Mobile" value="<?php echo isset($row['Mobile']) ? $row['Mobile'] : ''; ?>">
                    </div>
                </div><br><br>

                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">NIC number:<span class="required">*</span></legend>
                    <div class="col-auto">
                        <input type="text" class="form-control" name="NIC" value="<?php echo isset($row['NIC']) ? $row['NIC'] : ''; ?>">
                    </div>
                </div><br><br>

                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Account Number:<span class="required">*</span></legend>
                    <div class="col">
                        <input type="text" class="form-control" aria-label="Account Number" name="Acc_No" value="<?php echo isset($row['Acc_No']) ? $row['Acc_No'] : ''; ?>">
                    </div>
                    <div class="col">
                        <select class="form-select"  name="Bank_Name" aria-label="Bank Selection">
                            <?php
                            $BankDetails = mysqli_query($conn," Select * from bankdetails");
                            while($c = mysqli_fetch_array($BankDetails)){
                            ?>
                            <option value="<?php echo $c['Bank_ID'] ?>" <?php if(isset($row['Bank_Name']) && $c['Bank_Name'] == $row['Bank_Name']) echo 'selected'; ?>>
                                <?php echo $c['Bank_Name']?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div><br><br>

                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Payment Method:<span class="required">*</span></legend>
                    <div class="col-auto">
                        <select class="form-select" name="Pay_method" aria-label="payment selection" >
                            <?php
                            $PayMethod = mysqli_query($conn,"Select * from paymethod");
                            while($cc = mysqli_fetch_array($PayMethod)){
                            ?>
                            <option value="<?php echo $cc['Pay_ID'] ?>" <?php if(isset($row['Pay_method']) && $cc['Pay_method'] == $row['Pay_method']) echo 'selected'; ?>>
                                <?php echo $cc['Pay_method']?>
                            </option>
                            <?php }?>
                        </select>
                    </div>
                </div><br><br>

                <div>
                    <button type="submit" class="btn btn-success" style="color:black;" name="update" >Update</button>
                    <a href="Employee_view.php" class="btn btn-danger" style="color:black;">Cancel</a>
                </div>
            </form>
        </div>
    </div>        
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
<script src="script.js"></script>

                