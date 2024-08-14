<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tool Inventory Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
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
        }
        .container {
            margin-left: 170px;
            padding-top: 80px;
            padding-left: 20px;
        }
        .category-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            justify-items: center;
        }
        .category-box {
            width: 250px;
            height: 150px;
            background-color: #ffffff;
            color: black;
            text-align: center;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            font-size: 18px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .category-box img {
            width: 50px;
            height: 50px;
        }
        .category-box:hover {
            background-color: #DEF1FE;
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
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.category-box').click(function() {
                var category = $(this).data('category');
                window.location.href = 'view_delete_tools.php?category=' + category;
            });
        });
    </script>
</head>
<body>



<div class="header--wrapper">
                <div class="header--title d-flex align-items-center">
                    <img src="icons/logo.jpeg" alt="Logo" class="mr-3" style="height: 40px;">
                    
                </div>
            </div>
			
<div class="sidebar">
    <ul>
        <ul class="list-unstyled">
            <li class="sidebar-item">
                <a href="#toolSubmenu" data-toggle="collapse" aria-expanded="false">
                    <i class="lni lni-cog"></i> <a href="new_item.php">Items Management</a>
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
    <div class="category-container">
        <a href="#" class="category-box" data-category="1">
            <img src="icons/liquid.png" alt="Liquid">
            <span>Liquid</span>
        </a>
        <a href="#" class="category-box" data-category="2">
            <img src="icons/washes.png" alt="Washes">
            <span>Washes</span>
        </a>
        <a href="#" class="category-box" data-category="3">
            <img src="icons/brooms.png" alt="Brooms">
            <span>Brooms</span>
        </a>
        <a href="#" class="category-box" data-category="4">
            <img src="icons/brushes.png" alt="Brushes">
            <span>Brushes</span>
        </a>
        <a href="#" class="category-box" data-category="5">
            <img src="icons/cleaners.png" alt="Cleaners">
            <span>Cleaners</span>
        </a>
        <a href="#" class="category-box" data-category="6">
            <img src="icons/polish.jfif" alt="Polish">
            <span>Polish</span>
        </a>
    </div>
</div>

</body>
</html>
