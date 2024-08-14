<?php
include 'db_connection.php';

if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];

    $sql = "SELECT 
                e.F_name, e.L_name, e.Position_ID, e.Bank_ID, e.work_ID, e.Pay_ID,
                p.Position_name, 
                b.Bank_Name, 
                w.Work_name, 
                pm.Pay_method,
                a.Acc_No,
                a.Branch
            FROM employee e
            LEFT JOIN positions p ON e.Position_ID = p.Position_ID
            LEFT JOIN bankdetails b ON e.Bank_ID = b.Bank_ID
            LEFT JOIN workplace w ON e.work_ID = w.work_ID
            LEFT JOIN paymethod pm ON e.Pay_ID = pm.Pay_ID
            LEFT JOIN accountdetails a ON e.EMP_ID = a.EMP_ID
            WHERE e.EMP_ID = '$employee_id'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode([]);
    }
}
?>
