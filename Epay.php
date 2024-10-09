<?php
session_start();

// Check if the necessary GET parameters are set
if (isset($_GET['total_amount']) && isset($_GET['project_id']) && isset($_GET['from_company_name'])) {
    $total_amount = (float)$_GET['total_amount'];
    $project_id = (int)$_GET['project_id'];
    $from_company_name = $_GET['from_company_name'];

    $tax = 0; // Set the tax amount here if needed
    $transaction_uuid = uniqid();
    $secret = '8gBm/:&EnhH.1/q';
    $Message = "total_amount=$total_amount,transaction_uuid=$transaction_uuid,product_code=EPAYTEST";
    $s = hash_hmac('sha256', $Message, $secret, true);
    $signature = base64_encode($s);
} else {
    die("Required parameters missing.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="text"],
        input[type="hidden"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #217dbb;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Pay for Project with Esewa</h2>
        <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
            <input type="text" name="amount" value="<?php echo htmlspecialchars($total_amount); ?>" readonly>
            <input type="hidden" name="tax_amount" value="<?php echo htmlspecialchars($tax); ?>">
            <input type="hidden" name="total_amount" value="<?php echo htmlspecialchars($total_amount); ?>">
            <input type="hidden" name="transaction_uuid" value="<?php echo htmlspecialchars($transaction_uuid); ?>">
            <input type="hidden" name="product_code" value="EPAYTEST">
            <input type="hidden" name="product_service_charge" value="0">
            <input type="hidden" name="product_delivery_charge" value="0">
            <input type="hidden" name="success_url" value="http://localhost/Sumer_project_php/successPay.php?project_id=<?php echo urlencode($project_id); ?>&from_company_name=<?php echo urlencode($from_company_name); ?>&total_amount=<?php echo urlencode($total_amount); ?>&transaction_uuid=<?php echo urlencode($transaction_uuid); ?>&product_code=EPAYTEST">
            <input type="hidden" name="failure_url" value="http://localhost/Sumer_project_php/failure.php">
            <input type="hidden" name="signed_field_names" value="total_amount,transaction_uuid,product_code">
            <input type="hidden" name="signature" value="<?php echo htmlspecialchars($signature); ?>">
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
