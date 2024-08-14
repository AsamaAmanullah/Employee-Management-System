<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Leave</title>
    <link rel="stylesheet" href="style.css" />
    <script>
        document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        if (status === 'success') {
            // alert("Leave request submitted successfully.");
        } else if (status === 'error') {
            alert("There was an error submitting your leave request.");
        }
      });

      // Populate hidden fields with sessionStorage data on page load
      window.onload = function () {
        const empId = sessionStorage.getItem("EMP_ID");
        document.getElementById("emp_id").value = empId;

        // Fetch employee details
        if (empId) {
          fetchEmployeeDetails(empId);
        }
      };

      function fetchEmployeeDetails(empId) {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "get_employee_details.php?emp_id=" + empId, true);
        xhr.onload = function () {
          if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.error) {
              console.error(response.error);
            } else {
              document.getElementById("emp_name").value = response.emp_name;
              document.getElementById("position_id").value = response.position_id;
              document.getElementById("position").value = response.position;
            }
          } else {
            console.error("Error fetching employee details");
          }
        };
        xhr.send();
      }
    </script>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
      }
      .topbar {
        background-color: #ffffff;
        padding: 5px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      }
      .topbar img {
        width: 40px;
        height: 30px;
        margin-left: 20px;
      }
      .form {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        width: 100%;
      }
      table {
        width: 100%;
        border-collapse: collapse;
      }
      td {
        padding: 10px;
        vertical-align: top;
      }
      label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
      }
      input[type="text"],
      input[type="date"],
      select,
      textarea {
        width: 100%;
        padding: 6px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
      }
      input[type="submit"] {
        background-color: #007BFF;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
      }
      input[type="submit"]:hover {
        background-color: #0056b3;
      }
      .disabled-input {
        background-color: #f9f9f9;
        cursor: not-allowed;
      }
    </style>
  </head>
  <body>
    <div class="content">
      <div class="topbar">
        <img src="logo.jpeg">
      </div>
      <h1>Leave Page</h1>
      <div>
        <form action="submit_leave.php" method="post" class="form">
          <input type="hidden" id="emp_id" name="emp_id" />
          <input type="hidden" id="position_id" name="position_id" />
          <table>
            <tr>
              <td><label>Employee Name:</label></td>
              <td><input type="text" id="emp_name" value="" disabled class="disabled-input" /></td>
            </tr>
            <tr>
              <td><label>Position :</label></td>
              <td><input type="text" id="position" value="" disabled class="disabled-input" /></td>
            </tr>
            <tr>
              <td><label for="leave_type">Leave Type:</label></td>
              <td>
                <select name="leave_type" id="leave_type" required>
                  <option value="" selected disabled>Select...</option>
                  <option value="Sick Leave">Sick Leave</option>
                  <!-- Add more leave types here -->
                </select>
              </td>
            </tr>
            <tr>
              <td><label for="from_date">From Date:</label></td>
              <td><input type="date" name="from_date" id="from_date" required /></td>
            </tr>
            <tr>
              <td><label for="to_date">To Date:</label></td>
              <td><input type="date" name="to_date" id="to_date" required /></td>
            </tr>
            <tr>
              <td><label for="leave_duration">Leave Duration:</label></td>
              <td>
                <select name="leave_duration" id="leave_duration" required>
                  <option value="" selected disabled>Select...</option>
                  <option value="Half Day">Half Day</option>
                  <option value="Full Day">Full Day</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><label for="notes">Notes:</label></td>
              <td><textarea name="notes" id="notes" rows="4" cols="50"></textarea></td>
            </tr>
          </table>
          <div style="text-align: center;">
            <input type="submit" value="Submit" />
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
