<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectmgmt";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

var_dump($_POST);

if($_SERVER["REQUEST_METHOD"]=="POST"){
$product_id = $_POST['product_id'];
$unit_price = $_POST['unit_price'];  
$product_required = $_POST['product_required'];  
$amount = $_POST['amount'];  

$updateSql = "UPDATE products 
              SET unit_price = '$unit_price', 
                  product_required = '$product_required', 
                  amount = '$amount' 
              WHERE id = '$product_id'";

if (mysqli_query($conn, $updateSql)) {
    echo "Product updated successfully";
} else {
    echo "Error updating product: " . mysqli_error($conn);
}
}


mysqli_close($conn);

?>
