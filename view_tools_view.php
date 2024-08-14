<?php
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "emsdatabase_new";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch category from GET request
$category = $_GET['category'] ?? '';

// Validate the category input to prevent SQL injection
$category = $conn->real_escape_string($category);

// Fetch the category name
$categoryNameQuery = $conn->prepare("SELECT Category_name FROM categories WHERE Category_ID = ?");
$categoryNameQuery->bind_param("s", $category);
$categoryNameQuery->execute();
$categoryNameResult = $categoryNameQuery->get_result();
$categoryName = $categoryNameResult->fetch_assoc()['Category_name'] ?? '';

// Fetch tools for the selected category
$sql = $conn->prepare("SELECT Tool_name, Tool_ID, Quantity, Price, Purchase_Date, Category_ID FROM inventory WHERE Category_ID = ?");
$sql->bind_param("s", $category);
$sql->execute();
$result = $sql->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tools in Category</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f4;
        }
        .container {
            margin-left: 220px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #f0f8ff; /* Light blue background color */
            border: 1px solid #ddd; /* Border color */
        }
        table th, table td {
            padding: 5px; /* Reduced padding */
            text-align: left;
            border-bottom: 1px solid #ddd; /* Bottom border for cells */
        }
        table th {
            background-color: #6495ed; /* Light blue header background color */
            color: white; /* Header text color */
        }
        table tbody tr:nth-child(even) {
            background-color: #f2f2f2; /* Alternate row color */
        }
        #sidebar {
            background-color: #083C71;
            width: 200px;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            color: #fff;
            transition: all 0.3s;
        }
        .sidebar-item {
            margin-bottom: 20px; /* Adjust margin for spacing between items */
        }
        #sidebar a {
            color: #FFFFFF !important; /* Text color for links (white) */
            text-decoration: none; /* Remove underline from links */
        }
        #sidebar a:hover {
            color: #FFFFFF; /* Text color on hover (white) */
        }
    </style>
</head>
<body>

<div id="sidebar">
    <ul class="list-unstyled">
        <li class="sidebar-item">
            <a href="#toolSubmenu" data-toggle="collapse" aria-expanded="false">
                <i class="lni lni-cog"></i> <li class="sidebar-item">
                    <a href="index.php">Items management</a>
            </a>
            <li class="sidebar-item">
                <a href="add.php">Add Items</a>
            </li>
            <li class="sidebar-item">
                <a href="add_new.php">Add New Items</a>
            </li>
            <li class="sidebar-item">
                <a href="update.php">Update Items</a>
            </li>
            <li class="sidebar-item">
                <a href="delete.php">Delete Items</a>
            </li>
            <li class="sidebar-item">
                <a href="upnew.php">View Items</a>
            </li>
            <li class="sidebar-item">
                <a href="report.php">Reports</a>
            </li>
        </li>
    </ul>
</div>

<div class="container">
    <h1 class="my-4">Items in Category: <?php echo htmlspecialchars($categoryName); ?></h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Item ID</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Purchase Date</th>
                    <th>Category No</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Tool_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['Tool_ID']); ?></td>
                    <td><?php echo htmlspecialchars($row['Quantity']); ?></td>
                    <td><?php echo htmlspecialchars($row['Price']); ?></td>
                    <td><?php echo htmlspecialchars($row['Purchase_Date']); ?></td>
                    <td><?php echo htmlspecialchars($row['Category_ID']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$sql->close();
$conn->close();
?>
