<?php
// profile.php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emsdatabase_new";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch supervisor data (assuming Position_ID is 1 for the supervisor)
$position_id = 1;
$sql = "SELECT * FROM employee WHERE Position_ID = $position_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the row
    $row = $result->fetch_assoc();
} else {
    echo "No supervisor found";
    exit;
}

$conn->close();
?>

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
            background-color: #f4f4f9;
        }
        .sidebar {
            background-color: #083C71;
            color: #fff;
            height: 100vh;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            text-align: left;
        }
        .sidebar ul {
            list-style: none;
            padding-left: 0;
        }
        .sidebar-item a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 15px;
            font-size: 16px;
        }
        .sidebar-item a:hover {
            background-color: #2a2a72;
        }
        .sidebar-item.active .collapse {
            display: block;
        }
        .container {
            margin-left: 220px;
            padding: 40px;
        }
        h2 {
            color: #083C71;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        form input[type="text"],
        form input[type="date"],
        form input[type="password"],
        form select,
        form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        form input[type="submit"] {
            background-color: #083C71;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }
        form input[type="submit"]:hover {
            background-color: #2a2a72;
        }
        .back-button {
            background-color: #083C71;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
        }
        .back-button:hover {
            background-color: #2a2a72;
        }
        .cancel-button {
            background-color: #da190b;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }
        .cancel-button:hover {
            background-color: #c71518;
        }
        .error {
            color: red;
            margin-top: 5px;
            font-size: 12px;
        }
    </style>
</head>
<body>
<a class="back-button" href="supervisor.php">Back to Dashboard</a>
   
    <div class="container">
        <!-- Profile Form -->
        <h2>Supervisor Profile</h2>
        <form action="update_profile.php" method="post" onsubmit="return validateForm()">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($row['F_name']); ?>" required>
            <div id="first_name_error" class="error"></div>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($row['L_name']); ?>" required>
            <div id="last_name_error" class="error"></div>

            <label for="nic">NIC:</label>
            <input type="text" id="nic" name="nic" value="<?php echo htmlspecialchars($row['NIC']); ?>" pattern="^[0-9]{9}[vVxX]$" required>
            <div id="nic_error" class="error"></div>

            <label for="mobile">Mobile:</label>
            <input type="text" id="mobile" name="mobile" value="<?php echo htmlspecialchars($row['Mobile']); ?>" pattern="^[0-9]{10}$" required>
            <div id="mobile_error" class="error"></div>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="male" <?php if($row['Gender'] == 'male') echo 'selected'; ?>>Male</option>
                <option value="female" <?php if($row['Gender'] == 'female') echo 'selected'; ?>>Female</option>
                <option value="other" <?php if($row['Gender'] == 'other') echo 'selected'; ?>>Other</option>
            </select>
            <div id="gender_error" class="error"></div>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($row['DOB']); ?>" required>
            <div id="dob_error" class="error"></div>

            <label for="address">Address:</label>
            <textarea id="address" name="address" required><?php echo htmlspecialchars($row['Address']); ?></textarea>
            <div id="address_error" class="error"></div>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <div id="password_error" class="error"></div>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <div id="confirm_password_error" class="error"></div>

            <input type="submit" value="Update Profile">
          
            <button type="button" class="cancel-button" onclick="window.location.href='profile.php'">Cancel</button>
        </form>
    </div>
</body>
</html>
