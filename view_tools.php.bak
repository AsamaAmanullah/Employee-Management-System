<?php
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
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
    <title>Tool Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f4;
            display: flex;
            height: 100vh;
            margin: 0;
        }
        .navbar {
            background-color: #003366; /* Dark blue color */
            color: white;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: white;
        }
        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #003366; /* Dark blue color */
            padding-top: 20px;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        .content {
            margin-left: 200px; /* Same as the width of the sidebar */
            padding: 20px;
            flex-grow: 1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #f0f8ff; /* Light blue background color */
            border: 1px solid #ddd; /* Border color */
			
        }
        table th, table td {
            padding: 10px;
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
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#">Tool Management</a>
</nav>

<div class="sidebar">
    <a href="update.php">update Items</a>
    <!--<a href="#">Tools</a>
    <a href="#">Categories</a>
    <a href="#">Reports</a>
    <a href="#">Settings</a>-->
</div>

<div class="content">
   <h1 class="my-4">
    <img src="icons/items.jfif" alt="" style="width: 80px; height: auto; margin-right: 10px;">
   <?php echo htmlspecialchars($categoryName); ?></h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Item No</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Purchase Date</th>
                    <th>Category No</th>
                    <th>Actions</th>
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
                    <td>
                        <button class="btn btn-primary edit-btn" data-id="<?php echo $row['Tool_ID']; ?>" data-name="<?php echo htmlspecialchars($row['Tool_name']); ?>" data-quantity="<?php echo htmlspecialchars($row['Quantity']); ?>" data-price="<?php echo htmlspecialchars($row['Price']); ?>" data-date="<?php echo htmlspecialchars($row['Purchase_Date']); ?>" data-category="<?php echo htmlspecialchars($row['Category_ID']); ?>">Edit</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="editForm" action="update_tool.php" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Item</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="tool_id" id="editToolId">
          <div class="form-group">
            <label for="editToolName">Item Name</label>
            <input type="text" class="form-control" id="editToolName" name="tool_name" required>
          </div>
          <div class="form-group">
            <label for="editQuantity">Quantity</label>
            <input type="number" class="form-control" id="editQuantity" name="quantity" required>
          </div>
           <div class="form-group">
            <label for="editPrice">Price</label>
            <input type="text" class="form-control" id="editPrice" name="price" required>
            <small class="text-danger" id="priceValidationMsg"></small> <!-- Validation message -->
          </div>
         <!-- <div class="form-group">
            <label for="editPurchaseDate">Purchase Date</label>
            <input type="date" name="purchase_date" id="editPurchaseDate" class="form-control" readonly>
          </div>-->
          <div class="form-group">
            <label for="editCategoryId">Category No</label>
            <input type="text" class="form-control" id="editCategoryId" name="category_id" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('.edit-btn').on('click', function() {
            var toolId = $(this).data('id');
            var toolName = $(this).data('name');
            var quantity = $(this).data('quantity');
            var price = $(this).data('price');
            var purchaseDate = $(this).data('date');
            var categoryId = $(this).data('category');

            $('#editToolId').val(toolId);
            $('#editToolName').val(toolName);
            $('#editQuantity').val(quantity);
            $('#editPrice').val(price);
            $('#editPurchaseDate').val(purchaseDate);
            $('#editCategoryId').val(categoryId);

            $('#editModal').modal('show');
        });
		
		// Validate price field on form submission
    $('#editForm').submit(function(event) {
      var priceValue = $('#editPrice').val().trim();
      if (isNaN(priceValue) || priceValue === '') {
        $('#priceValidationMsg').text('Please enter a valid numeric price.');
        event.preventDefault(); // Prevent form submission if validation fails
      } else {
        $('#priceValidationMsg').text('');
      }
    });
    });
</script>

</body>
</html>

<?php
// Close prepared statements and database connection
$categoryNameQuery->close();
$sql->close();
$conn->close();
?>
