<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Navbar</title>
    <style>
       body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            overflow: hidden;
            background-color: #333;
        }

        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .navbar a.active {
            background-color: #04AA6D;
            color: white;
        }

        /* Style for the content section */
        .content {
            padding: 20px;
            overflow: hidden; /* Clear floats */
        }

        /* Style for the image */
        .image-container {
            float: left;
            width: 50%; /* Adjust the width as needed */
            padding: 20px;
            box-sizing: border-box;
        }

        .image-container img {
            width: 100%;
            max-width: 100%;
            display: block;
        }

        /* Style for the "Assign Project" section */
        .assign-project {
            float: right;
            width: 50%; /* Adjust the width as needed */
            padding: 20px;
            box-sizing: border-box;
        }

        .assign-project h2 {
            margin-top: 0;
        }

        .assign-project a {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border-radius: 3px;
            text-align: center;
        }

        .assign-project a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a class="active" href="#">Home</a>
        <a href="UserProjectDetails.php">View Project</a>
        <!-- <a href="Acustomerpage.php">Customer</a> -->
        <!-- <a href="Viewpayment.php">Payment</a> -->
    </div>
</body>
</html>
