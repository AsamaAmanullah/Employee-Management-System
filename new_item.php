<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
    <style>
        #sidebar {
            background-color: #083C71;
            width: 190px;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            color: #fff;
            transition: all 0.3s;
        }
        .sidebar-header, .sidebar-item {
            padding: 20px;
        }
        .sidebar-item a {
            color: #fff;
            text-decoration: none;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .info-card {
            color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
            cursor: pointer; /* Add cursor pointer for clickable effect */
        }
        .info-card:hover {
            opacity: 0.8; /* Optional: Reduce opacity on hover for visual feedback */
        }
        canvas {
            display: block;
            margin: 0 auto;
            max-width: 100%; /* Ensure the chart is responsive */
        }
        .navbar {
            background-color: #D0D3D3;
            padding-top: 30px;
        }
        .navbar img {
            height: 50px; /* Adjust height as needed */
            width: auto;
            margin-left: -10px; /* Adjust margin to move logo to the right */

        }
    </style>
</head>
<body>
    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "emsdatabase_new";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get counts
    $totalProductsQuery = "SELECT COUNT(*) AS total FROM inventory";
    $lowStockQuery = "SELECT COUNT(*) AS low_stock FROM inventory WHERE quantity < 5";
    $mostStockQuery = "SELECT MAX(quantity) AS most_stock FROM inventory";
    $zeroStockQuery = "SELECT COUNT(*) AS zero_stock FROM inventory WHERE quantity = 0";

    $totalProducts = $conn->query($totalProductsQuery)->fetch_assoc()['total'];
    $lowStock = $conn->query($lowStockQuery)->fetch_assoc()['low_stock'];
    $mostStock = $conn->query($mostStockQuery)->fetch_assoc()['most_stock'];
    $zeroStock = $conn->query($zeroStockQuery)->fetch_assoc()['zero_stock'];

    // Query to get today's orders based on purchase_date
    $today = date('Y-m-d');
    $todaysOrdersQuery = "SELECT 
                            COUNT(CASE WHEN DATE(purchase_date) = '$today' THEN 1 END) AS new_tools_count,
                            SUM(CASE WHEN DATE(purchase_date) = '$today' THEN price * quantity END) AS new_tools_value
                        FROM inventory";

    $todaysOrdersResult = $conn->query($todaysOrdersQuery)->fetch_assoc();
    $newToolsCount = $todaysOrdersResult['new_tools_count'] ?? 0;
    $newToolsValue = $todaysOrdersResult['new_tools_value'] ?? 0;

    // Query to get categories ordered per month using purchase_date
    $categoryOrdersQuery = "
        SELECT 
            DATE_FORMAT(purchase_date, '%Y-%m') AS Order_Month, 
            categories.Category_Name, 
            COUNT(*) AS Quantity 
        FROM inventory
        JOIN categories ON inventory.Category_ID = categories.Category_ID
        GROUP BY Order_Month, categories.Category_Name
        ORDER BY Order_Month, categories.Category_Name;
    ";

    $categoryOrdersResult = $conn->query($categoryOrdersQuery);

    $categoryOrdersData = [];
    while ($row = $categoryOrdersResult->fetch_assoc()) {
        $categoryOrdersData[] = $row;
    }

    $conn->close();
    ?>

    <div id="sidebar">
	
        <div class="sidebar-header">
		
            <h4>Inventory Dashboard</h4>
        </div>
        <ul class="list-unstyled">
            <li class="sidebar-item">
                <a href="#toolSubmenu" data-toggle="collapse" aria-expanded="false">
                    <i class="lni lni-cog"></i> Items Management
                </a>
               
                <ul class="collapse list-unstyled" id="toolSubmenu">
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
                </ul>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="row mt-4">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Items Categories Added per Month</h2>
                        <canvas id="categoryOrdersChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="info-card bg-light text-dark" onclick="showTodayDetails()">
                    <h4>Today's Report</h4>
                    <p>New Items Added Today: <span id="newToolsCount"><?php echo $newToolsCount; ?></span></p>
                    <p>Total Value of New Items: Rs. <span id="newToolsValue"><?php echo number_format($newToolsValue, 2); ?></span></p>
                </div>
            </div>
        </div>

        <!-- Info cards in a single row -->
        <div class="row mt-4">
            <div class="col-md-3" id="totalProductsCard" onclick="showAllTools()">
                <div class="info-card bg-primary">
                    <h4>Total Stock Items</h4>
                    <p id="totalProducts"><?php echo $totalProducts; ?></p>
                </div>
            </div>
            <div class="col-md-3" id="lowStockCard" onclick="showLowStockTools()">
                <div class="info-card bg-warning">
                    <h4>Low Stock Items</h4>
                    <p id="lowStock"><?php echo $lowStock; ?></p>
                </div>
            </div>
            <div class="col-md-3" id="mostStockCard" onclick="showMostStockTools()">
                <div class="info-card bg-success">
                    <h4>Most Stock Items</h4>
                    <p id="mostStock"><?php echo $mostStock; ?></p>
                </div>
            </div>
            <div class="col-md-3" id="zeroStockCard" onclick="showZeroStockTools()">
                <div class="info-card bg-danger">
                    <h4>Zero Stock Items</h4>
                    <p id="zeroStock"><?php echo $zeroStock; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="toolsModal" tabindex="-1" aria-labelledby="toolsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="toolsModalLabel">Items Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody id="toolsTableBody">
                            <!-- Tool details will be populated here -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
    <script>
        // Function to show today's report details
        function showTodayDetails() {
            let newToolsCount = document.getElementById('newToolsCount').innerText;
            let newToolsValue = document.getElementById('newToolsValue').innerText;
            let reportMessage = `Today's Report:\nNew Tools Added Today: ${newToolsCount}\nTotal Value of New Tools: Rs. ${newToolsValue}`;
            alert(reportMessage);
        }

        // Function to show low stock tools
        function showLowStockTools() {
            fetch('getLowStockTools.php')
                .then(response => response.json())
                .then(lowStockTools => {
                    populateModal('Low Stock Items', lowStockTools);
                })
                .catch(error => {
                    console.error('Error fetching low stock tools:', error);
                    alert('Failed to fetch low stock tools. Please try again.');
                });
        }

        // Function to show most stock tools
        function showMostStockTools() {
            fetch('getMostStockTools.php')
                .then(response => response.json())
                .then(mostStockTools => {
                    populateModal('Most Stock Items', mostStockTools);
                })
                .catch(error => {
                    console.error('Error fetching most stock tools:', error);
                    alert('Failed to fetch most stock tools. Please try again.');
                });
        }

        // Function to show zero stock tools
        function showZeroStockTools() {
            fetch('getZeroStockTools.php')
                .then(response => response.json())
                .then(zeroStockTools => {
                    populateModal('Zero Stock Items', zeroStockTools);
                })
                .catch(error => {
                    console.error('Error fetching zero stock tools:', error);
                    alert('Failed to fetch zero stock tools. Please try again.');
                });
        }

        // Function to show all tools with quantities
        function showAllTools() {
            fetch('getAllTools.php')
                .then(response => response.json())
                .then(allTools => {
                    populateModal('All Items', allTools);
                })
                .catch(error => {
                    console.error('Error fetching all tools:', error);
                    alert('Failed to fetch all tools. Please try again.');
                });
        }

        // Function to populate the modal with tool details
        function populateModal(title, tools) {
            document.getElementById('toolsModalLabel').innerText = title;
            let toolsTableBody = document.getElementById('toolsTableBody');
            toolsTableBody.innerHTML = '';
            tools.forEach(tool => {
                let row = `<tr><td>${tool.Tool_Name}</td><td>${tool.Quantity}</td></tr>`;
                toolsTableBody.innerHTML += row;
            });
            $('#toolsModal').modal('show');
        }

        // Data for category orders per month
        const categoryOrdersData = <?php echo json_encode($categoryOrdersData); ?>;
        
        const categoryOrdersLabels = [...new Set(categoryOrdersData.map(order => order.Order_Month))];
        const categoryNames = [...new Set(categoryOrdersData.map(order => order.Category_Name))];

        const blueShades = [
            '#1E90FF', '#00BFFF', '#87CEFA', '#4682B4', 
            '#5F9EA0', '#00CED1', '#4682B4', '#4169E1',
            '#6495ED', '#00BFFF', '#1E90FF', '#5F9EA0'
        ];

        const categoryOrdersDatasets = categoryNames.map((category, index) => {
            return {
                label: category,
                data: categoryOrdersLabels.map(month => {
                    const order = categoryOrdersData.find(order => order.Order_Month === month && order.Category_Name === category);
                    return order ? order.Quantity : 0;
                }),
                fill: false,
                borderColor: blueShades[index % blueShades.length],
                tension: 0.1
            };
        });

        const categoryOrdersCtx = document.getElementById('categoryOrdersChart').getContext('2d');
        const categoryOrdersChart = new Chart(categoryOrdersCtx, {
            type: 'line',
            data: {
                labels: categoryOrdersLabels,
                datasets: categoryOrdersDatasets
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Categories Ordered per Month'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Quantity'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
