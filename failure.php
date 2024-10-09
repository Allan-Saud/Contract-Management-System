<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .container {
            text-align: center;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
            color: #d9534f; /* Bootstrap's red color */
            margin-bottom: 20px;
        }

        .container p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .container a {
            display: inline-block;
            background-color: #5bc0de; /* Bootstrap's light blue color */
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .container a:hover {
            background-color: #31b0d5; /* Darker shade of light blue */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sorry!! Your payment was not successful</h1>
        <p>Please try again or contact support if the issue persists.</p>
        <a href="UserProjectDetails.php">Go to Homepage</a>
    </div>
</body>
</html>
