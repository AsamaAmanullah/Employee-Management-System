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
            padding-top: 10px;
            height: 60px;
            width: 100%;
            position: fixed;
            top: 0;
            left: 100px
            z-index: 1;
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
        .form-container {
            background-color: #e3f2fd;
            padding: 20px;
            border-radius: 10px;
            max-width: 800px;
            margin: auto;
        }
        .btn-cancel {
            background-color: red;
            color: white;
        }
        .btn-add {
            background-color: green;
            color: white;
        }
        .form-row {
            margin-bottom: 50px;
        }
        .form-control, .btn {
            height: 30px; /* Adjust the height as needed */
            border-radius: 0;
        }
        .form-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .form-group label, .form-group input, .form-group select {
            flex: 5;
            margin-right: 100px;
        }
        .form-group label {
            flex: 0 0 150px;
            line-height: 70px;
        }
        .form-group input, .form-group select {
            flex: 1 5 50px; /* Reduced width for input boxes */
        }
        .form-group:last-child {
            margin-right: 0;
        }
        @media (max-width: 600px) {
            .form-group {
                flex-direction: column;
            }
            .form-group label, .form-group input, .form-group select {
                flex: 1 0 100%;
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    
    <div class="sidebar">
        <ul>
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
    </div>
    
    <div class="container">
        <h2 class="form-title">Add New Item</h2>
        <div class="form-container">
            <form action="add_tool_new.php" method="POST">
                <div class="form-group">
                    <label for="toolName">Item Name</label>
                    <input type="text" class="form-control" id="toolName" name="name" placeholder="Enter Tool Name" required oninput="fetchToolDetails()">
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity" required oninput="calculateTotalPrice()">
                </div>
                <div class="form-group">
                    <label for="unitPrice">Unit Price(R.s)</label>
                    <input type="number" class="form-control" id="unitPrice" name="unitPrice" placeholder="Enter Unit Price" required oninput="calculateTotalPrice()">
                </div>
                <div class="form-group">
                    <label for="totalPrice">Total Price(R.s)</label>
                    <input type="number" class="form-control" id="totalPrice" name="price" placeholder="Enter Total Price" readonly>
                </div>
                <div class="form-group">
                    <label for="purchaseDate">Purchase Date</label>
                    <input type="date" class="form-control" id="purchaseDate" name="date" required>
                </div>
                <div class="form-group">
                    <label for="categoryId">Category</label>
                    <select class="form-control" id="categoryId" name="categoryId" required>
                        <option value="">Select Category</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-add">Add Item</button>
                    <button type="reset" class="btn btn-cancel">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Function to fetch categories and populate the dropdown
        function fetchCategories() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_categories.php', true); // Assuming get_categories.php fetches categories
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var categories = JSON.parse(xhr.responseText);
                    var select = document.getElementById('categoryId');
                    select.innerHTML = '<option value="">Select Category</option>';
                    categories.forEach(function(category) {
                        var option = document.createElement('option');
                        option.value = category.Category_ID;
                        option.textContent = category.Category_Name;
                        select.appendChild(option);
                    });
                }
            };
            xhr.send();
        }

        // Call fetchCategories function when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            fetchCategories();
        });

        function fetchToolDetails() {
            var toolName = document.getElementById('toolName').value;
            if (toolName) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'get_tool_details.php?toolName=' + toolName, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        document.getElementById('quantity').value = response.quantity || '';
                        document.getElementById('unitPrice').value = response.unitPrice || '';
                        document.getElementById('purchaseDate').value = response.purchaseDate || '';
                        document.getElementById('categoryId').value = response.categoryId || '';
                        calculateTotalPrice();
                    }
                };
                xhr.send();
            }
        }

        function calculateTotalPrice() {
            var quantity = document.getElementById('quantity').value;
            var unitPrice = document.getElementById('unitPrice').value;
            var totalPrice = document.getElementById('totalPrice');

            if (quantity && unitPrice) {
                totalPrice.value = quantity * unitPrice;
            } else {
                totalPrice.value = '';
            }
        }
    </script>
</body>
</html>
