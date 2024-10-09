<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectmgmt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$projectDetails = [];
$projectStatus = '';
$tokenExists = false;
$tokenTimeout = 60;

if (isset($_SESSION['user_token']) && isset($_SESSION['token_time'])) {
    $user_token = $_SESSION['user_token'];
    $token_time = $_SESSION['token_time'];

    if (time() - $token_time > $tokenTimeout) {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT id AS project_id, company_name, project_name, project_description, start_date, end_date, status FROM projects WHERE user_token = ?");
    $stmt->bind_param("s", $user_token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $tokenExists = true;
        $projectDetails = $result->fetch_assoc();
        $projectStatus = $projectDetails['status'];

        $projectId = $projectDetails['project_id'];
        $productSql = "SELECT * FROM products WHERE project_id = ?";
        $stmt = $conn->prepare($productSql);
        $stmt->bind_param("i", $projectId);
        $stmt->execute();
        $productResult = $stmt->get_result();

        $totalAmount = 0;
        while ($row = $productResult->fetch_assoc()) {
            $totalAmount += $row['amount'];
        }
    }
}

if (!$tokenExists && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_token'])) {
    $_SESSION['user_token'] = $_POST['user_token'];
    $_SESSION['token_time'] = time();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Project Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 80%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            width: 100%;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            cursor: pointer;
            border: none;
        }

        input[type="submit"]:hover {
            background-color: #217dbb;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .button-container button {
            background-color: #3498db;
            color: #fff;
            cursor: pointer;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
        }

        .button-container button:hover {
            background-color: #217dbb;
        }

        .button-container-home {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .button-container-home button {
            background-color: #3498db;
            color: #fff;
            cursor: pointer;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
        }

        .button-container-home button:hover {
            background-color: #217dbb;
        }
    </style>
</head>
<body>
    <div class="button-container-home">
        <button id="redirectButton">return</button>
    </div>
    <script>
        document.getElementById('redirectButton').addEventListener('click', function() {
            window.location.href = 'customerpage.php';
        });
    </script>

    <h2>User Project Details</h2>

    <?php if ($tokenExists) { ?>
        <table>
            <tr>
                <th>Project Name</th>
                <th>Company Name</th>
                <th>Project Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
            </tr>
            <tr>
                <td><?php echo $projectDetails["project_name"]; ?></td>
                <td><?php echo $projectDetails["company_name"]; ?></td>
                <td><?php echo $projectDetails["project_description"]; ?></td>
                <td><?php echo $projectDetails["start_date"]; ?></td>
                <td><?php echo $projectDetails["end_date"]; ?></td>
                <td><?php echo $projectStatus; ?></td>
            </tr>
        </table>

        <h3>Product Details</h3>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Unit Price</th>
                <th>Product Required</th>
                <th>Amount</th>
            </tr>
            <?php
            $productResult = $conn->prepare($productSql);
            $productResult->bind_param("i", $projectId);
            $productResult->execute();
            $result = $productResult->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['product_name'] . "</td>";
                echo "<td>" . $row['unit_price'] . "</td>";
                echo "<td>" . $row['product_required'] . "</td>";
                echo "<td>" . $row['amount'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>

        <div class="total-amount-container">
            <h3>Total Amount</h3>
            <p>Total Amount: Rs <span id="totalAmount"><?php echo $totalAmount; ?></span></p>
        </div>
        
        <div style="margin-top: 20px; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); max-width: 300px; width: 100%;">
            <h3>Wages</h3>
            <label for="wagesInput" style="color: #333;">Enter Wages:</label>
            <input type="number" id="wagesInput" min="0" step="0.01" placeholder="Enter Wages" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; margin-bottom: 10px;">
        </div>
        
        <div class="total-amount-container">
            <h3>Overall Amount</h3>
            <p>Overall Amount: Rs <span id="overallAmount"><?php echo $totalAmount; ?></span></p>
        </div>
        
        <div class="button-container">
            <button id="paymentButton">Payment</button>
        </div>

        <script>
            const totalAmount = <?php echo $totalAmount; ?>;
            const wagesInput = document.getElementById('wagesInput');
            const overallAmountSpan = document.getElementById('overallAmount');

            wagesInput.addEventListener('input', function() {
                const wages = parseFloat(wagesInput.value) || 0;
                const overallAmount = totalAmount + wages;
                overallAmountSpan.textContent = overallAmount.toFixed(2);
            });

            document.getElementById('paymentButton').addEventListener('click', function() {
                const wages = parseFloat(wagesInput.value) || 0;
                const overallAmount = totalAmount + wages;
                window.location.href = 'Epay.php?project_id=<?php echo $projectId; ?>&from_company_name=<?php echo urlencode($projectDetails["company_name"]); ?>&total_amount=' + overallAmount;
            });
        </script>
    <?php } else { ?>
        <form method="post" action="">
            <label for="user_token">Enter User Token:</label>
            <input type="text" name="user_token" required>
            <input type="submit" value="Submit">
        </form>
    <?php } ?>
</body>
</html>
