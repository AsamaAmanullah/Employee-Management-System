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

// Check if id parameter is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $report_id = $_GET['id'];

    // Fetch saved report details from the database based on id
    $stmt = $conn->prepare("SELECT * FROM saved_reports WHERE id = ?");
    $stmt->bind_param("i", $report_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $reportTitle = htmlspecialchars($row['report_title']);
        $reportContent = $row['report_content'];

        // Display report details
        echo '<!DOCTYPE html>';
        echo '<html lang="en">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<title>View Report: ' . $reportTitle . '</title>';
        echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">';
        echo '</head>';
        echo '<body>';
        echo '<div class="container mt-5">';
        echo '<h2>View Report: ' . $reportTitle . '</h2>';
        echo $reportContent; // Display the saved report content
        echo '</div>';
        echo '</body>';
        echo '</html>';
    } else {
        echo '<p>Report not found.</p>';
    }

    $stmt->close();
} else {
    echo '<p>Invalid request. Please provide a valid report ID.</p>';
}

$conn->close();
?>
