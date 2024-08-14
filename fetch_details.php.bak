<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emsdatabase_final";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$tool_name = isset($_POST['tool_name']) ? $_POST['tool_name'] : '';
$from_date = isset($_POST['from_date']) ? $_POST['from_date'] : '';
$to_date = isset($_POST['to_date']) ? $_POST['to_date'] : '';

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
    $html = '<h3>Tool Details</h3>';
    $html .= '<table class="table table-bordered">';
    $html .= '<thead><tr><th>Tool ID</th><th>Tool Name</th><th>Price</th><th>Quantity</th><th>Purchase Date</th></tr></thead>';
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
    echo $html;
} else {
    echo '<p>No details found for the given criteria.</p>';
}

$conn->close();
?>
