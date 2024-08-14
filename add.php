<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tool Inventory Management</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            background-color: #083C71;
            color: #fff;
            height: 100vh;
            width: 150px;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            text-align: left;
        }
        .navbar {
            background-color: #D0D3D3;
            padding-top: -1000px;
        }
        .container {
            margin-left: 170px;
            padding-top: 80px;
            padding-left: 20px;
        }
        table {
            width: 90%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        input, select, button {
            margin: 5px;
        }
        th {
            background-color: #ACDDFE;
            color: black;
        }
        tr:nth-child(even) {
            background-color: #DEF1FE;
        }
        .low-stock {
            background-color: white;
        }
        .confirmationMessage {
            color: green;
            margin-top: 20px;
        }
        .add-tool-button, .add-new-tool-button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
            width: 150px; /* Fixed width for buttons */
        }
        .add-tool-button:hover, .add-new-tool-button:hover {
            background-color: #45a049;
        }
        .cancel-button {
            background-color: #f44336; /* Red color */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
            width: 150px; /* Fixed width for buttons */
        }
        .cancel-button:hover {
            background-color: #da190b; /* Darker red on hover */
        }
        canvas {
            max-width: 400px;
            max-height: 200px;
        }
        .sidebar ul {
            padding-left: 0;
        }
        .sidebar-item a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px;
        }
        .sidebar-item a:hover {
            background-color: #2a2a72;
        }
        .sidebar-item.active .collapse {
            display: block;
        }
		
		
    </style>
</head>
<body>
    
    </div>
    <div class="sidebar">
        <ul>
            <ul class="list-unstyled">
                <li class="sidebar-item">
                    <a href="#toolSubmenu" data-toggle="collapse" aria-expanded="false">
                        <i class="lni lni-cog"></i> <a href="new_item.php">Items Management</a>
                        <ul class="collapse list-unstyled" id="toolSubmenu">
                            <li class="sidebar-item">
                                <a href="add.php">Add Items</a>
								<ul class="list-unstyled">
            <li class="sidebar-item">
                <a href="add_new.php">Add New Items</a>
            </li>
        </ul>
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
                    </a>
                </li>
            </ul>
        </ul>
    </div>
    <div class="container">
        <h2>Low Stock Items Chart</h2>
        <div style="width: 50%;">
            <canvas id="lowStockChart"></canvas>
        </div>
        <br>
        <div>
            <button class="add-tool-button" onclick="showAddToolForm()">Add Items</button>
            <!--<button class="add-new-tool-button" onclick="showAddNewToolForm()">Add New Tool</button>-->
        </div>
        <div id="addToolForm" style="display: none;">
            <h2>Add Items</h2>
            <br>
            <table id="toolTable">
                <thead>
                    <tr>
                        <th>Items Name</th>
                        <th>Items No</th>
                        <th>Unit Price(R.s)</th>
                        <th>Quantity</th>
                        <th>Total Price(R.s)</th>
                        <th>Purchase Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select id="newToolName" onchange="fillToolId()">
                                <?php
                                // Database connection setup
                                $servername = "localhost";
                                $username = "root";
                                $password = "root";
                                $dbname = "emsdatabase_new";
                                $conn = new mysqli($servername, $username,$password,  $dbname);
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Query to fetch distinct tool names from the Inventory table
                                $sql = "SELECT DISTINCT Tool_name FROM inventory ORDER BY Tool_name";
                                $result = $conn->query($sql);
                                
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $toolName = $row["Tool_name"] ?? '';
                                        echo "<option value='" . htmlspecialchars($toolName, ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($toolName, ENT_QUOTES, 'UTF-8') . "</option>";
                                    }
                                } else {
                                    echo "<option>No tools available</option>";
                                }
                                
                                $conn->close();
                                ?>
                            </select>
                        </td>
                        <td><input type="number" id="newToolId" placeholder="Tool ID" readonly></td>
                        <td><input type="number" id="newUnitPrice" placeholder="Unit Price" oninput="calculateTotalPrice()"></td>
                        <td><input type="number" id="newQuantity" placeholder="Quantity" oninput="calculateTotalPrice()"></td>
                        <td><input type="number" id="newPrice" placeholder="Total Price" readonly></td>
                        <td><input type="date" id="newPurchaseDate"></td>
                        <td>
                            <button class="add-tool-button" onclick="addTool()">Add Item</button>
                            <button class="cancel-button" onclick="cancelAdd()">Cancel</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div id="confirmationMessage" class="confirmationMessage"></div>
        </div>
    </div>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // PHP code to fetch data and encode into JavaScript variables
        var toolNames = <?php
            // Database connection setup
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dbname = "emsdatabase_new";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to fetch tool names and their quantities for low stock tools
            $sql = "SELECT Tool_name, Quantity FROM inventory WHERE Quantity < 5 ORDER BY Tool_name";
            $result = $conn->query($sql);

            $toolNames = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $toolNames[] = htmlspecialchars($row["Tool_name"], ENT_QUOTES, 'UTF-8');
                }
            }

            echo json_encode($toolNames);

            $conn->close();
        ?>;
        var quantities = <?php
            // Database connection setup (same as above)
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to fetch quantities for low stock tools
            $sql = "SELECT Quantity FROM inventory WHERE Quantity < 5 ORDER BY Tool_name";
            $result = $conn->query($sql);

            $quantities = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $quantities[] = $row["Quantity"];
                }
            }

            echo json_encode($quantities);

            $conn->close();
        ?>;

        // Chart.js code to create a bar chart
        var lowStockData = {
            labels: toolNames,
            datasets: [{
                label: 'Quantity',
                data: quantities,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        };

        var ctx = document.getElementById('lowStockChart').getContext('2d');
        var stockChart = new Chart(ctx, {
            type: 'bar',
            data: lowStockData,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            precision: 0 // Display whole numbers only
                        }
                    }]
                }
            }
        });

        function fillToolId() {
            var selectedToolName = document.getElementById("newToolName").value;
            var toolIdField = document.getElementById("newToolId");

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        toolIdField.value = xhr.responseText.trim();
                    } else {
                        console.error("Error fetching tool ID");
                    }
                }
            };
            xhr.open("GET", "get_tool_id.php?toolName=" + selectedToolName, true);
            xhr.send();
        }

        function calculateTotalPrice() {
            var unitPrice = parseFloat(document.getElementById("newUnitPrice").value);
            var quantity = parseInt(document.getElementById("newQuantity").value);

            // Check if both fields have valid numeric values
            if (!isNaN(unitPrice) && !isNaN(quantity)) {
                var totalPrice = unitPrice * quantity;
                document.getElementById("newPrice").value = totalPrice.toFixed(2); // Adjust decimals as needed
            } else {
                document.getElementById("newPrice").value = ""; // Reset if invalid input
            }
        }

        function addTool() {
            var toolName = document.getElementById("newToolName").value;
            var toolId = document.getElementById("newToolId").value;
            var unitPrice = document.getElementById("newUnitPrice").value;
            var quantity = document.getElementById("newQuantity").value;
            var totalPrice = document.getElementById("newPrice").value;
            var purchaseDate = document.getElementById("newPurchaseDate").value;

            // Validate Tool ID (numeric check)
            if (isNaN(toolId) || toolId === '') {
                alert("Tool ID must be a numeric value.");
                return;
            }

            // Proceed with AJAX request
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        document.getElementById("confirmationMessage").innerHTML = xhr.responseText;
                        clearFormFields();
                    } else {
                        console.error("Error adding tool");
                    }
                }
            };
            xhr.open("POST", "add_tool.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("toolName=" + encodeURIComponent(toolName) + "&toolId=" + encodeURIComponent(toolId) + "&unitPrice=" + encodeURIComponent(unitPrice) + "&quantity=" + encodeURIComponent(quantity) + "&totalPrice=" + encodeURIComponent(totalPrice) + "&purchaseDate=" + encodeURIComponent(purchaseDate));
        }

        function clearFormFields() {
            document.getElementById("newToolName").value = "";
            document.getElementById("newToolId").value = "";
            document.getElementById("newUnitPrice").value = "";
            document.getElementById("newQuantity").value = "";
            document.getElementById("newPrice").value = "";
            document.getElementById("newPurchaseDate").value = "";
        }

        function cancelAdd() {
            document.getElementById("addToolForm").style.display = "none";
            clearFormFields();
        }

        function showAddToolForm() {
            document.getElementById("addToolForm").style.display = "block";
        }

        function showAddNewToolForm() {
            alert("Implement functionality for 'Add New Tool' form here");
        }
    </script>
</body>
</html>
