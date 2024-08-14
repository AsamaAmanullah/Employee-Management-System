<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emsdatabase_new";

// Establish connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$tool_name = isset($_POST['tool_name']) ? $_POST['tool_name'] : '';
$from_date = isset($_POST['from_date']) ? $_POST['from_date'] : '';
$to_date = isset($_POST['to_date']) ? $_POST['to_date'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : 'view';

// Supervisor and company details (hardcoded for this example)
$company_name = "Himali janitorial service";
$company_address = "No 37 1/2 Post Mahabulankulama Anuradhapura";
$company_email = "Himalijanitorialservice@gmail.com";
$company_tele = "+94 77 264 6654";
$company_logo = "icons/logo.jpeg"; // Make sure the logo file is in the same directory
$supervisor_name = "Malshi Rathnayake";
$supervisor_email = "Malshi.@Himalijanitorialservice@gmail.com";
$supervisor_tele = "+94 987 654 321";
$supervisor_sign = "supervisor_sign.png"; // Make sure the sign file is in the same directory
$report_date = date('Y-m-d H:i:s'); // Current date and time

// Build the query
$query = "SELECT * FROM inventory WHERE 1=1";

if (!empty($tool_name)) {
    $query .= " AND Tool_name LIKE '%" . $conn->real_escape_string($tool_name) . "%'";
}
if (!empty($from_date)) {
    $query .= " AND purchase_date >= '" . $conn->real_escape_string($from_date) . "'";
}
if (!empty($to_date)) {
    $query .= " AND purchase_date <= '" . $conn->real_escape_string($to_date) . "'";
}

// Execute the query
$result = $conn->query($query);

$html = '<div style="text-align: center; margin-bottom: 20px;">';
$html .= '<img src="' . $company_logo . '" alt="Company Logo" style="height: 100px;">';
$html .= '<h1>' . $company_name . '</h1>';
$html .= '<p>' . $company_address . '</p>';
$html .= '<p>Email: ' . $company_email . '</p>';
$html .= '<p>Telephone: ' . $company_tele . '</p>';
$html .= '</div>';

$html .= '<h2 style="text-align: center; margin-bottom: 20px;">';
if ($action == 'view') {
    $html .= 'Inventory Report';
} elseif ($action == 'save') {
    $reportName = isset($_POST['report_name']) ? $_POST['report_name'] : 'Untitled Report';
    $html .= htmlspecialchars($reportName);
}
$html .= '</h2>';

$html .= '<p><strong>Report Date:</strong> ' . $report_date . '</p>'; // Include report creation date and time

$html .= '<p><strong>Supervisor:</strong> ' . $supervisor_name . '</p>';
$html .= '<p>Email: ' . $supervisor_email . '</p>';
$html .= '<p>Telephone: ' . $supervisor_tele . '</p>';
$html .= '<table class="table table-bordered mt-4">';
$html .= '<thead class="thead-dark"><tr><th>Tool ID</th><th>Tool Name</th><th>Price</th><th>Quantity</th><th>Purchase Date</th></tr></thead>';
$html .= '<tbody>';

while ($row = $result->fetch_assoc()) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($row['Tool_ID']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['Tool_name']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['Price']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['Quantity']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['purchase_date']) . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody></table>';
$html .= '<div style="margin-top: 50px; text-align: right;">';
$html .= '<p>Supervisor Signature:</p>';
$html .= '<img src="' . $supervisor_sign . '" alt="Supervisor Signature" style="height: 50px;">';
$html .= '</div>';

if ($action == 'view') {
    // Display the report
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '    <meta charset="UTF-8">';
    echo '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '    <title>Inventory Report</title>';
    echo '    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">';
    echo '</head>';
    echo '<body>';
    echo '<div class="container mt-5">';
    echo $html;
    echo '</div>';
    echo '    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';
    echo '    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>';
    echo '</body>';
    echo '</html>';
} elseif ($action == 'save') {
    // Save the report to the database
    $stmt = $conn->prepare("INSERT INTO saved_reports (report_title, report_content, saved_datetime) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $reportName, $html, $report_date); // Assuming report_title is a VARCHAR
    if ($stmt->execute()) {
        echo "Report saved successfully.";
    } else {
        echo "Error saving report: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
