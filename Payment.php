<?php
if(isset($_GET['project_id']) && isset($_GET['from_company_name']) && isset($_GET['total_amount'])) {
    $project_id = $_GET['project_id'];
    $from_company_name = $_GET['from_company_name'];
    $total_amount = $_GET['total_amount'];
} else {
    echo "Project ID, From company name, or Total amount is missing.";
    exit;
}
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectmgmt";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $project_id = $_POST['project_id'];
    $from_company_name = $_POST['from_company_name'];
    $to_company_name = $_POST['to_company_name'];
    $account_number = $_POST['account_number'];
    $amount = $_POST['amount'];

  
    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
$checkPaymentSql = "SELECT * FROM payments WHERE project_id = '$project_id'";
$checkPaymentResult = $conn->query($checkPaymentSql);

if ($checkPaymentResult->num_rows > 0) {
    echo "Payment for this project has already been made. Another payment cannot be processed.";
    
    exit;
}

    
    $sql = "INSERT INTO payments (project_id, from_company_name, to_company_name, account_number, amount) VALUES ('$project_id', '$from_company_name', '$to_company_name', '$account_number', '$amount')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Payment saved successfully.');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <style>
        form {
            max-width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #217dbb;
        }
        h2{
            text-align:center;
        }
    </style>
</head>

<script>
    function goBack() {
        window.location.href = 'UserProjectDetails.php'; 
    }
</script>

<body>

<h2>Payment Form</h2>

<form method="post" action="">
    <label for="project_id">Project Id:</label>
    <input type="text" name="project_id" value="<?php echo $project_id; ?>" readonly>
    <label for="from_company_name">From:</label>
    <input type="text" name="from_company_name" value="<?php echo $from_company_name; ?>" readonly>
    <label for="to_company_name">To:</label>
    <input type="text" name="to_company_name" value="Allan and Sons" readonly>
    <label for="account_number">A/C Number:</label>
    <input type="text" name="account_number" value="000001234567891" readonly>
    <label for="amount">Amount:</label>
    <input type="text" name="amount" value="<?php echo $total_amount; ?>" required readonly>
    <input type="submit" value="Submit">
    <button type="button" onclick="goBack()">Go Back</button>
</form>

</body>
</html>
