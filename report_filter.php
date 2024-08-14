<?php
require_once('tcpdf_include.php');

// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "emsdatabase_new";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$tool_name = $_POST['tool_name'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];

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

if ($result->num_rows > 0) {
    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Inventory Report');
    $pdf->SetSubject('Generated Report');
    $pdf->SetKeywords('TCPDF, PDF, report, inventory');

    // Set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    // Set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // Set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // Set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // Set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Add content
    $html = '<h1>Inventory Report</h1>';
    $html .= '<table border="1" cellpadding="5">';
    $html .= '<thead><tr><th>Tool ID</th><th>Tool Name</th><th>Price</th><th>Quantity</th><th>Purchase Date</th></tr></thead>';
    $html .= '<tbody>';

    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . $row['Tool_ID'] . '</td>';
        $html .= '<td>' . $row['Tool_name'] . '</td>';
        $html .= '<td>' . $row['Price'] . '</td>';
        $html .= '<td>' . $row['Quantity'] . '</td>';
        $html .= '<td>' . $row['purchase_date'] . '</td>';
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';

    // Print text using writeHTMLCell()
    $pdf->writeHTML($html, true, false, true, false, '');

    // Close and output PDF document
    $pdf->Output('inventory_report.pdf', 'D');
} else {
    echo "No results found.";
}

$conn->close();
?>
