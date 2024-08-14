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
            padding-top: -30px;
        }
        .container {
            margin-left: 170px;
            padding-top: 80px;
            padding-left: 20px;
        }
        .category-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            justify-items: center;
        }
        .category-box {
            width: 300px; /* Increased width */
            height: 200px; /* Increased height */
            background-color: #ffffff;
            color: black;
            text-align: center;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            font-size: 20px; /* Increased font size */
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .category-box img {
            width: 70px; /* Increased image width */
            height: 70px; /* Increased image height */
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
        .title {
            font-size: 28px; /* Adjust the font size as needed */
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.category-box').click(function() {
                var category = $(this).data('category');
                if (category === 1) {
                    window.location.href = 'profile.php';
                } else if (category === 2) {
                    window.location.href = 'leave_apply.php';
                } else if (category === 4) {
                    window.location.href = 'index.php';
                } else if (category === 5) {
                    window.location.href = 'attendance_form.php';
                }
            });
        });
    </script>
</head>
<body>

<div class="sidebar">
    <ul class="list-unstyled">
        <li class="sidebar-item">
            <a href="index.php">Items Management</a>
        </li>
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
</div>
<div class="container">
    <div class="title"><center>Welcome to Supervisor Dashboard</center></div>
    <div class="category-container">
        <a href="#" class="category-box" data-category="1">
            <img src="icons/profile.png" alt="profile">
            <span>User Profile</span>
        </a>
        <a href="#" class="category-box" data-category="2">
            <img src="icons/leave.jpg" alt="leave">
            <span>Leave Apply</span>
        </a>
        <a href="#" class="category-box" data-category="4">
            <img src="icons/itemss.png" alt="items">
            <span>Items Management</span>
        </a>
        <a href="#" class="category-box" data-category="5">
            <img src="icons/att.png" alt="att">
            <span>Attendance Management</span>
        </a>
    </div>
</div>

</body>
</html>
