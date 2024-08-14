<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Report Filters</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        .navbar-dark-custom {
            background-color: #D0D3D3; /* Custom dark blue */
        }
        .navbar-light-custom {
            background-color: #CCCECE; /* Custom light blue */
        }
        .sidebar-custom {
            background-color: #083C71; /* Custom orange */
        }
        .sidebar {
            width: 250px;
            position: fixed;
            top: 110px; /* Height of the first and second navbars */
            left: 0;
            height: calc(100% - 110px); /* Height minus the navbars */
            padding-top: 20px;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
            margin-top: 56px; /* Height of the first navbar */
        }
		.sidebar {
            background-color: #083C71;
            color: #fff;
            height: 100vh;
            width: 170px;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            text-align: left;
        }
		 .sidebar a {
            color: #fff; /* Text color for links */
        }
		 .sidebar-item {
            margin-bottom: 30px; /* Adjust margin for spacing between items */
        }
        .logout-button {
    display: block;
    border-radius: 5px;
    width: 100px;
    padding: 10px;
    text-align: center;
    background-color: #f44336; /* Red background */
    color: white; /* White text */
    border: none;
    cursor: pointer;
    margin-top: 10px;
    text-decoration: none;
}

.logout-button a {
    color: white; /* Ensure the text is white */
    text-decoration: none; /* Remove underline */
}

.logout-button:hover {
    background-color: #d32f2f; /* Darker red on hover */
}
        
    </style>
    <script>
        function logout() {
            sessionStorage.setItem('EMP_ID', "");
            window.top.location.href = 'login.html';
        }
    </script>
</head>
<body>
    <!-- First Navbar -->
    

    <!-- Second Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-light-custom">
        <a class="navbar-brand" href="#">Inventory Syste</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav2" aria-controls="navbarNav2" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav2">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#"><b>New Report</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="saved_reports.php"><b>Saved Reports</b></a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Vertical Sidebar -->
   <div class="sidebar">
    <ul>
        <ul class="list-unstyled">
            <li class="sidebar-item">
                <a href="#toolSubmenu" data-toggle="collapse" aria-expanded="false">
                    <i class="lni lni-cog"></i> <a href="new_item.php">Items Management</a>
                 <li class="sidebar-item">
                            <a href="add.php">Add Items</a>
								
            <li class="sidebar-item">
                <a href="add_new.php">Add New Items</a>
            </li>
       
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
        <button class="logout-button"><a href="javascript:void(0);" onclick="logout()">Logout</a></button>
    </div>
</div>

    <div class="content">
        <div class="container">
            <h2 class="mb-4">Report Filters</h2>
            <div class="card">
                <div class="card-body">
                    <p>Adjust the filters and customize your reports</p>
                    <form id="reportForm" method="POST" action="generate_report.php">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="tool_name">Item Name</label>
                                <input type="text" class="form-control" id="tool_name" name="tool_name" placeholder="Tool Name">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="from_date">From Date</label>
                                <input type="date" class="form-control" id="from_date" name="from_date">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="to_date">To Date</label>
                                <input type="date" class="form-control" id="to_date" name="to_date">
                            </div>
                        </div>
                        <input type="hidden" id="report_name" name="report_name" value="">
                        <button type="button" class="btn btn-info" id="fetchDetailsBtn">Fetch Details</button>
                        <button type="button" class="btn btn-success" id="createReportBtn">Create Report</button>
                        <button type="button" class="btn btn-primary" id="saveReportBtn">Save Report</button>
                    </form>
                    <div id="reportDetails" class="mt-4">
                        <!-- Tool details will be dynamically inserted here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script>
        $('#fetchDetailsBtn').on('click', function() {
            const toolName = $('#tool_name').val();
            const fromDate = $('#from_date').val();
            const toDate = $('#to_date').val();
            
            $.ajax({
                url: 'fetch_details.php',
                type: 'POST',
                data: { tool_name: toolName, from_date: fromDate, to_date: toDate },
                success: function(response) {
                    $('#reportDetails').html(response);
                },
                error: function() {
                    alert('Error fetching details.');
                }
            });
        });

        $('#createReportBtn').on('click', function() {
            $('#reportForm').attr('action', 'generate_report.php?action=view').submit();
        });

        $('#saveReportBtn').on('click', function() {
            // Prompt for report name
            const reportName = prompt('Enter a name for your report:');
            if (reportName) {
                $('#report_name').val(reportName); // Set report name in hidden input
                $('#reportForm').attr('action', 'generate_report.php?action=save').submit();
            } else {
                alert('Report name is required.');
            }
        });
    </script>
</body>
</html>
