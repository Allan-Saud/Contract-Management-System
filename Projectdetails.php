<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectmgmt";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && isset($_POST['project_id'])) {
        $action = $_POST['action'];
        $project_id = $_POST['project_id'];
        $updateSql = "UPDATE projects SET status = '$action' WHERE id = $project_id";
        mysqli_query($conn, $updateSql);
    }
}

$sql = "SELECT * FROM projects";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
        }

        form {
            display: inline;
        }
        .redirect-button-container {
            text-align: center;
            margin-top: 20px; 
        }

        .redirect-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .redirect-button:hover {
            background-color: #217dbb;
        }
    </style>
</head>
<body>
    <?php include("adminheader.php");?>

<h2>Received Project List</h2>

<table>
    <tr>
        <th>Project Name</th>
        <th>Company Name</th>
        <th>Project Description</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["project_name"] . "</td>";
            echo "<td>" . $row["company_name"] . "</td>";
            echo "<td>" . $row["project_description"] . "</td>";
            echo "<td>" . $row["start_date"] . "</td>";
            echo "<td>" . $row["end_date"] . "</td>";
            echo "<td>" . $row["status"] . "</td>";
            echo "<td>";
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='project_id' value='" . $row["id"] . "'>";
            echo "<select name='action'>";
            echo "<option value='Pending'>Pending</option>";
            echo "<option value='Accepted'>Accept</option>";
            echo "<option value='Rejected'>Reject</option>";
            echo "<option value='Completed'>Completed</option>";
            echo "</select>";
            echo "<input type='submit' value='Submit'>";
            echo "</form>";
           
            echo "<form method='get' action='addproduct.php'>";
            echo "<input type='hidden' name='project_id' value='" . $row["id"] . "'>";
            echo "<input type='submit' value='Add Product'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No projects found</td></tr>";
    }
    mysqli_close($conn);
    ?>
</table>
<div class="redirect-button-container">
    <a href="index.php" class="redirect-button">Home</a>
</div>
</body>
</html>
