<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectmgmt";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sn = 1;

$existingProducts = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_id = $_POST['project_id'];
    $product_names = $_POST['product_name'];
    $unit_prices = $_POST['unit_price'];
    $product_requireds = $_POST['product_required'];
    $amounts = $_POST['amount'];
    // Insert each product into the database with the project_id
    for ($i = 0; $i < count($product_names); $i++) {
        $product_name = $product_names[$i];
        $unit_price = $unit_prices[$i];
        $product_required = $product_requireds[$i];
        $amount = $amounts[$i];

        $insertSql = "INSERT INTO products (project_id, product_name, unit_price, product_required, amount) 
                      VALUES ('$project_id', '$product_name', '$unit_price', '$product_required', '$amount')";
        mysqli_query($conn, $insertSql);
    }
    header("Location: Projectdetails.php");
    exit();
} elseif (isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    $productSql = "SELECT * FROM products WHERE project_id = '$project_id'";
    $productResult = mysqli_query($conn, $productSql);
    if ($productResult) {
        while ($product = mysqli_fetch_assoc($productResult)) {
            $product['sn'] = $sn++;
            $existingProducts[] = $product;
        }
    } else {
        echo "Error fetching products: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"] {
            width: calc(50% - 20px);
            padding: 10px;
            margin: 5px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        #totalAmount {
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Products</h2>
        <form id="addProductForm" method="post">
            <input type="hidden" name="project_id" value="<?php echo htmlspecialchars($_GET['project_id']); ?>">
            <table id="productList">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Product Name</th>
                        <th>Unit Price</th>
                        <th>Product Required</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($existingProducts ?? [] as $product) { ?>
                        <tr>
                            <td data-product-id="<?php echo $product['id']; ?>"><?php echo $product['sn']; ?></td>
                            <td><?php echo $product['product_name']; ?></td>
                            <td><?php echo $product['unit_price']; ?></td>
                            <td><?php echo $product['product_required']; ?></td>
                            <td><?php echo $product['amount']; ?></td>
                            <td>
                                <button type="button" onclick="editProduct(this)">Edit</button>
                                <button type="button" onclick="removeProduct(this, <?php echo $product['id']; ?>)">Remove</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div id="totalAmount"></div>
            <button type="button" onclick="addProduct()">Add Product</button>
            <input type="submit" value="Submit">
        </form>
    </div>

    <script>
        let productIndex = 0;
        let totalAmount = 0;

        function addProduct() {
            productIndex++;
            const existingSNs = Array.from(document.querySelectorAll('#productList tbody tr td:first-child')).map(td => parseInt(td.textContent));
            let nextSN = 1;
            while (existingSNs.includes(nextSN)) {
                nextSN++;
            }

            const productList = document.getElementById('productList').querySelector('tbody');

            const newRow = productList.insertRow(-1);
            const snCell = newRow.insertCell(0);
            const productNameCell = newRow.insertCell(1);
            const unitPriceCell = newRow.insertCell(2);
            const productRequiredCell = newRow.insertCell(3);
            const amountCell = newRow.insertCell(4);
            const actionCell = newRow.insertCell(5);

            snCell.textContent = nextSN;
            productNameCell.innerHTML = `<input type="text" name="product_name[]" required>`;
            unitPriceCell.innerHTML = `<input type="number" name="unit_price[]" min="0" step="0.01" required onchange="updateAmount(this)">`;
            productRequiredCell.innerHTML = `<input type="number" name="product_required[]" min="1" required onchange="updateAmount(this)">`;
            amountCell.innerHTML = `<input type="number" name="amount[]" min="0" step="0.01" readonly>`;
            actionCell.innerHTML = `<button type="button" onclick="removeProduct(this)">Remove</button>`;

            updateSN();
            updateTotalAmount();
        }

        function removeProduct(button, productId) {
            const row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
            if (productId) {
                deleteProduct(productId);
            }
            updateSN();
            updateTotalAmount();
        }

        function deleteProduct(productId) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_product.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status == 200) {
                    console.log(xhr.responseText);
                } else {
                    console.error(xhr.responseText);
                }
            };
            xhr.send('product_id=' + encodeURIComponent(productId));
        }

        function updateSN() {
            const rows = document.querySelectorAll('#productList tbody tr');
            rows.forEach((row, index) => {
                row.cells[0].textContent = index + 1;
            });
        }

        function editProduct(button) {
            const row = button.parentNode.parentNode;
            const unitPriceCell = row.querySelector('td:nth-child(3)');
            const productRequiredCell = row.querySelector('td:nth-child(4)');
            const amountCell = row.querySelector('td:nth-child(5)');

            const unitPrice = unitPriceCell.textContent;
            const productRequired = productRequiredCell.textContent;
            const amount = amountCell.textContent;

            unitPriceCell.innerHTML = `<input type="number" name="unit_price[]" value="${unitPrice}" min="0" step="0.01" required onchange="updateAmount(this)">`;
            productRequiredCell.innerHTML = `<input type="number" name="product_required[]" value="${productRequired}" min="1" required onchange="updateAmount(this)">`;
            amountCell.innerHTML = `<input type="number" name="amount[]" value="${amount}" min="0" step="0.01" readonly>`;

            button.textContent = 'Save';
            button.setAttribute('onclick', 'saveProduct(this)');
        }

        function saveProduct(button) {
            const row = button.parentNode.parentNode;
            const productId = row.querySelector('td').getAttribute('data-product-id');
            const unitPrice = row.querySelector('input[name="unit_price[]"]').value;
            const productRequired = row.querySelector('input[name="product_required[]"]').value;
            const amount = (parseFloat(unitPrice) * parseFloat(productRequired)).toFixed(2);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_product.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status == 200) {
                    const cells = row.querySelectorAll('td');
                    cells[2].textContent = unitPrice;
                    cells[3].textContent = productRequired;
                    cells[4].textContent = amount;
                    updateTotalAmount();

                    const inputs = row.querySelectorAll('input[type="number"]');
                    inputs.forEach(input => {
                        input.setAttribute('readonly', true);
                    });

                    button.textContent = 'Edit';
                    button.setAttribute('onclick', 'editProduct(this)');
                } else {
                    console.error('Error saving product:', xhr.responseText);
                }
            };
            xhr.onerror = function() {
                console.error('Network error occurred while saving product.');
            };
            xhr.send('product_id=' + encodeURIComponent(productId) + '&unit_price=' + encodeURIComponent(unitPrice) + 
            '&product_required=' + encodeURIComponent(productRequired) + '&amount=' + encodeURIComponent(amount));
        }

        function updateTotalAmount() {
            totalAmount = 0;

            const amountCells = document.querySelectorAll('#productList tbody tr td:nth-child(5)');
            amountCells.forEach(cell => {
                totalAmount += parseFloat(cell.textContent) || 0;
            });

            const newAmountInputs = document.querySelectorAll('#productList input[name="amount[]"]');
            newAmountInputs.forEach(input => {
                totalAmount += parseFloat(input.value) || 0;
            });

            document.getElementById('totalAmount').textContent = `Total Amount: $${totalAmount.toFixed(2)}`;
        }

        function updateAmount(input) {
            const row = input.parentNode.parentNode;
            const unitPriceInput = row.querySelector('input[name="unit_price[]"]');
            const productRequiredInput = row.querySelector('input[name="product_required[]"]');
            const amountInput = row.querySelector('input[name="amount[]"]');

            if (unitPriceInput && productRequiredInput && amountInput) {
                const unitPrice = parseFloat(unitPriceInput.value);
                const productRequired = parseFloat(productRequiredInput.value);
                const amount = (unitPrice * productRequired).toFixed(2);
                amountInput.value = amount;

                updateTotalAmount();
            }
        }

        document.getElementById('addProductForm').addEventListener('submit', function(event) {
            event.preventDefault();
            this.submit();
        });

        window.onload = updateTotalAmount;
    </script>
</body>
</html>
