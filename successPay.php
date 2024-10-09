<?php
session_start();

// Check if the necessary GET parameters are set
if (isset($_GET['total_amount']) && isset($_GET['transaction_uuid']) && isset($_GET['product_code']) && isset($_GET['project_id']) && isset($_GET['from_company_name'])) {
    $total_amount = (float)$_GET['total_amount'];
    $transaction_uuid = $_GET['transaction_uuid'];
    $product_code = $_GET['product_code'];
    $project_id = (int)$_GET['project_id'];
    $from_company_name = $_GET['from_company_name'];

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projectmgmt";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO payments (project_id, transaction_uuid, total_amount, from_company_name, payment_date) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("isds", $project_id, $transaction_uuid, $total_amount, $from_company_name);

    if ($stmt->execute()) {
        echo "Payment details saved successfully.";
        header("Location:UserProjectDetails.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Required parameters missing.";
}
?>
