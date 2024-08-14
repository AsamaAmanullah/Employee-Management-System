<?php
// Include the database connection file
include 'db_connection.php';

// Retrieve the payroll ID from the URL parameters
$payroll_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($payroll_id <= 0) {
    die("Invalid payroll ID.");
}

// SQL query to fetch payroll details
$sql = "
    SELECT 
        payroll.id AS Payroll_ID,
        employee.EMP_ID AS Employee_ID,
        CONCAT(employee.F_name, ' ', employee.L_name) AS Employee,
        positions.Position_name AS Position,
        bankdetails.Bank_Name AS Bank_Name,
        accountdetails.Acc_No AS Bank_No,
        workplace.Work_name AS Work_Place,
        paymethod.Pay_method AS Payment_Method,
        payroll.total_working_days AS Total_Working_Days,
        payroll.total_deduction AS Total_Deductions,
        payroll.other_earnings AS Other_Earnings,
        payroll.tax_amount AS Tax_Amount,
        payroll.net_salary AS Net_Salary,
        payroll.created_at AS Created_At
    FROM 
        payroll
    LEFT JOIN employee ON payroll.EMP_ID = employee.EMP_ID
    LEFT JOIN positions ON employee.Position_ID = positions.Position_ID
    LEFT JOIN bankdetails ON employee.Bank_ID = bankdetails.Bank_ID
    LEFT JOIN accountdetails ON employee.EMP_ID = accountdetails.EMP_ID
    LEFT JOIN workplace ON employee.work_ID = workplace.work_ID
    LEFT JOIN paymethod ON employee.Pay_ID = paymethod.Pay_ID
    WHERE 
        payroll.id = ?
";

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $payroll_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Payroll Details</title>
        <link rel="stylesheet" href="style.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
        <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
        <style>
            .payslip {
                background-color: #fff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                max-width: 600px;
                width: 400px;
                margin-top: 10px;
            }
            h4 {
            text-decoration: underline; /* Underlines the h4 text */
            }
            .pdftitle {
                display:flex;
                justify-content: center;
                align-items: center;
                gap: 20px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }
            td {
                padding: 5px;
                border-bottom: 1px solid #ddd;
                vertical-align: top;
                text-align: left;
            }
            h5 {
            text-align: center;
            }
            th{
                text-align: left;
            }
            td:first-child {
                font-weight: bold;
                color: #555;
                width: 40%;
            }
            td:last-child {
                width: 60%;
                color: #333;
            }
            tr:last-child td {
                border-bottom: none;
            }
            .container-menu {
            text-align: center;
        }

        .container-menu table {
            margin: 0 auto;
        }

        .container-menu button {
            background-color: #007BFF;
            color: white;
            padding: 6px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            width: 100px;
        }

        .container-menu button:hover {
            background-color: #0056b3;
        }

        </style>
        <script >
        function goBack(){
            window.history.back();
        }

        function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const content = document.querySelector('.payslip');
            if (content) {
                html2canvas(content).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const pdf = new jsPDF('p', 'mm', 'a4');
                    const imgProps = pdf.getImageProperties(imgData);
                    const pdfWidth = pdf.internal.pageSize.getWidth();
                    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                    pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                    pdf.save('payslip.pdf');
                }).catch(err => {
                    console.error("Error generating PDF: ", err);
                });
            } else {
                console.error("Element with class 'payslip' not found.");
            }
        }
    </script>
    </head>
    <body>
    <div class="container">
        <div>
            <!-- Sidebar iframe -->
            <iframe id="sidebar-iframe" src="sidebar.html" width="100%" height="100%" style="border: none;" title="Sidebar"></iframe>
        </div>
        <div class="content">
            <div class="payslip">
                
            <div>
                <div Class="pdftitle">
                    <img src="logo.jpg" width="100px" height="80px" >
                    <h3>Himali janitorial service</h3>
                </div>
                <h5>No 37 1/2 Post Mahabulankulama Anuradhapura <br>
                0772646654 / Himalijanitorialservice@gmail.com</h5>
            </div>
                <h4>Payroll Details</h4>
                <table class="details-table">
                    <tr><th>Payroll ID</th><td><?php echo htmlspecialchars($row['Payroll_ID'] ?? 'N/A'); ?></td></tr>
                    <tr><th>Employee ID</th><td><?php echo htmlspecialchars($row['Employee_ID'] ?? 'N/A'); ?></td></tr>
                    <tr><th>Employee</th><td><?php echo htmlspecialchars($row['Employee'] ?? 'N/A'); ?></td></tr>
                    <tr><th>Position</th><td><?php echo htmlspecialchars($row['Position'] ?? 'N/A'); ?></td></tr>
                    <tr><th>Bank Name</th><td><?php echo htmlspecialchars($row['Bank_Name'] ?? 'N/A'); ?></td></tr>
                    <tr><th>Bank No</th><td><?php echo htmlspecialchars($row['Bank_No'] ?? 'N/A'); ?></td></tr>
                    <tr><th>Work Place</th><td><?php echo htmlspecialchars($row['Work_Place'] ?? 'N/A'); ?></td></tr>
                    <tr><th>Payment Method</th><td><?php echo htmlspecialchars($row['Payment_Method'] ?? 'N/A'); ?></td></tr>
                    <tr><th>Total Working Days</th><td><?php echo htmlspecialchars($row['Total_Working_Days'] ?? 'N/A'); ?></td></tr>
                    <tr><th>Total Deductions</th><td>Rs:<?php echo htmlspecialchars($row['Total_Deductions'] ?? 'N/A'); ?></td></tr>
                    <tr><th>Other Earnings</th><td>Rs:<?php echo htmlspecialchars($row['Other_Earnings'] ?? 'N/A'); ?></td></tr>
                    <tr><th>ETF Amount</th><td>Rs:<?php echo htmlspecialchars($row['Tax_Amount'] ?? 'N/A'); ?></td></tr>
                    <tr><th>Net Salary</th><td>Rs:<?php echo htmlspecialchars($row['Net_Salary'] ?? 'N/A'); ?></td></tr>
                    <tr><th>Created At</th><td><?php echo htmlspecialchars($row['Created_At'] ?? 'N/A'); ?></td></tr>
                </table>
            </div>
        
            <div class="container-menu">
                <table>
                    <tr>
                    <td><button type="button" onclick="goBack()">Back</button></td>
                    <td><button type="button" onclick="downloadPDF()">Download</button></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
        
    </body>
    </html>
    <?php
} else {
    echo "No payroll details found for the specified ID.";
}

// Close the database connection
$conn->close();
?>
