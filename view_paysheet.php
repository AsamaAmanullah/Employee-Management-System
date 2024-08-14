<?php
// Include the database connection
include 'db_connection.php';

// Retrieve the payroll id from the URL parameter
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Query to get from_date and to_date from payrollsheet
    $query = "SELECT `from_date`, `to_date`, `title`, `create_at`, `update_at` FROM `payrollsheet` WHERE `id`=?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($from_date, $to_date, $title, $create_at, $update_at);
        $stmt->fetch();
        $stmt->close();

        // If from_date and to_date are retrieved
        if ($from_date && $to_date) {
            // Query to get the sum of net_salary
            $query2 = "SELECT SUM(`net_salary`) AS net_salary FROM `payroll` WHERE `created_at` BETWEEN ? AND ?";
            if ($stmt2 = $conn->prepare($query2)) {
                $stmt2->bind_param("ss", $from_date, $to_date);
                $stmt2->execute();
                $stmt2->bind_result($net_salary);
                $stmt2->fetch();
                $stmt2->close();
            } else {
                die("Error preparing second statement: " . $conn->error);
            }

            // Query to get payroll details
            $query3 = "SELECT `EMP_ID`, `total_working_days`, `total_deduction`, `other_earnings`, `tax_amount`, `net_salary`, `created_at` FROM `payroll` WHERE `created_at` BETWEEN ? AND ?";
            if ($stmt3 = $conn->prepare($query3)) {
                $stmt3->bind_param("ss", $from_date, $to_date);
                $stmt3->execute();
                $stmt3->bind_result($emp_id, $total_working_days, $total_deduction, $other_earnings, $tax_amount, $net_salary_detail, $created_at);
                $payroll_data = [];
                while ($stmt3->fetch()) {
                    $payroll_data[] = [
                        'EMP_ID' => $emp_id,
                        'total_working_days' => $total_working_days,
                        'total_deduction' => $total_deduction,
                        'other_earnings' => $other_earnings,
                        'tax_amount' => $tax_amount,
                        'net_salary' => $net_salary_detail,
                        'created_at' => $created_at
                    ];
                }
                $stmt3->close();
            } else {
                die("Error preparing third statement: " . $conn->error);
            }
        } else {
            die("No payrollsheet found with the given ID.");
        }
    } else {
        die("Error preparing statement: " . $conn->error);
    }
} else {
    die("Invalid payroll ID.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Sheet Details</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            height: 100vh;
            margin: 0;
        }
        .payslip {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            width: 1000px;
            margin-top: 20px;
        }
        .title {
            text-decoration: underline; /* Underlines the h4 text */
        }
        .pdftitle {
            display:flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }
        .sheetTable table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .sheetTopic table{
            width: 300px;
            border-collapse: collapse;
            margin-top: 10px;
        }
        h5 {
            text-align: center;
        }
        td, th {
            padding: 5px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: left;
        }
        .container-menu {
            text-align: center;
            margin-top: 20px;
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
    <script>
        function goBack() {
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
            <h4 Class="title">Pay Sheet</h4>
            <div class="sheetTopic">
            <table>
                <tr>
                    <td>ID</td>
                    <td><?php echo htmlspecialchars($id); ?></td>
                </tr>
                <tr>
                    <td>Title</td>
                    <td><?php echo htmlspecialchars($title); ?></td>
                </tr>
                <tr>
                    <td>From Date</td>
                    <td><?php echo htmlspecialchars($from_date); ?></td>
                </tr>
                <tr>
                    <td>To Date</td>
                    <td><?php echo htmlspecialchars($to_date); ?></td>
                </tr>
                <tr>
                    <td>Created At</td>
                    <td><?php echo htmlspecialchars($create_at); ?></td>
                </tr>
                <tr>
                    <td>Updated At</td>
                    <td><?php echo htmlspecialchars($update_at); ?></td>
                </tr>
            </table>
            </div>

            <!-- Payroll details table -->
            <h4 Class="title">Payroll Details</h4>
            <div class="sheetTable">
            <table>
                <thead>
                    <tr>
                        <th>EMP ID</th>
                        <th>Total Working Days</th>
                        <th>Total Deduction</th>
                        <th>Other Earnings</th>
                        <th>Tax Amount</th>
                        <th>Net Salary</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($payroll_data)): ?>
                        <?php foreach ($payroll_data as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['EMP_ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['total_working_days']); ?></td>
                                <td><?php echo htmlspecialchars($row['total_deduction']); ?></td>
                                <td><?php echo htmlspecialchars($row['other_earnings']); ?></td>
                                <td><?php echo htmlspecialchars($row['tax_amount']); ?></td>
                                <td><?php echo htmlspecialchars($row['net_salary']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No payroll data found for the specified period.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>
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
