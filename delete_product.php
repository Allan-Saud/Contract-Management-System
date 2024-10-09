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
    $product_id = $_POST['product_id'];
    $deleteSql = "DELETE FROM products WHERE id = '$product_id'";
    if (mysqli_query($conn, $deleteSql)) {
        echo "Product deleted successfully";
    } else {
        echo "Error deleting product: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
