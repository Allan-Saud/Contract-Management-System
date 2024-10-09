<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .redirect-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
        }

        .redirect-button:hover {
            background-color: #217dbb;
        }
    </style>
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projectmgmt";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM payments ORDER BY payment_date DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Payments Received Details</h2>";
        echo "<table>
                <tr>
                    <th>SN</th>
                    <th>Project ID</th>
                    <th>Company Name</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>";
        $sn = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $sn . "</td>
                    <td>" . $row["project_id"] . "</td>
                    <td>" . $row["from_company_name"] . "</td>
                    <td>" . $row["total_amount"] . "</td>
                    <td>" . $row["payment_date"] . "</td>
                </tr>";
            $sn++;
        }
        echo "</table>";

        // Fetch and display transaction details
        $totalPaymentAmount = 0; 
        $paymentDetailsSql = "SELECT SUM(total_amount) AS total_amount FROM payments";
        $paymentDetailsResult = $conn->query($paymentDetailsSql);
        if ($paymentDetailsResult->num_rows > 0) {
            echo "<h2>Transaction Details</h2>";
            echo "<table>
                    <tr>
                        <th>Company Name</th>
                        <th>Account Number</th>
                        <th>Total Amount</th>
                    </tr>";
            while ($paymentRow = $paymentDetailsResult->fetch_assoc()) {
                echo "<tr>
                        <td>D&D Electronics</td>
                        <td>0000012345</td>
                        <td>" . $paymentRow["total_amount"] . "</td>
                    </tr>";
                $totalPaymentAmount += $paymentRow["total_amount"];
            }
            echo "</table>";
        } else {
            echo "No transaction details found.";
        }
    }

    $conn->close();
    ?>

    <div style="text-align: center;">
        <a href="Projectdetails.php" class="redirect-button" style="
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        ">return</a>
    </div>
</body>
</html>
