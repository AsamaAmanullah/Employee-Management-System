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

// Fetch saved reports from the database
$sql = "SELECT * FROM saved_reports";
$result = $conn->query($sql);

// HTML for displaying saved reports
$html = '<!DOCTYPE html>';
$html .= '<html lang="en">';
$html .= '<head>';
$html .= '<meta charset="UTF-8">';
$html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
$html .= '<title>Saved Reports</title>';
$html .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">';
$html .= '</head>';
$html .= '<body>';
$html .= '<div class="container mt-5">';
$html .= '<h2>Saved Reports</h2>';

if ($result->num_rows > 0) {
    $html .= '<ul class="list-group mt-3">';
    while ($row = $result->fetch_assoc()) {
        $reportTitle = isset($row['report_title']) ? htmlspecialchars($row['report_title']) : 'Untitled Report';
        $html .= '<li class="list-group-item">';
        $html .= '<a href="view_saved_report.php?id=' . $row['id'] . '">' . $reportTitle . '</a>';
        $html .= '</li>';
    }
    $html .= '</ul>';
} else {
    $html .= '<p>No saved reports found.</p>';
}

$html .= '</div>';
$html .= '</body>';
$html .= '</html>';

echo $html;

$conn->close();
?>
