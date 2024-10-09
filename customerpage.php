<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            min-height: 100vh; /* Changed height to min-height */
        }

        .navbar {
            width: 100%;
            background-color: #333;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: fixed; /* Fixed position to stick at the top */
            top: 0; /* Align to the top */
            z-index: 999; /* Ensure it's above other content */
        }

        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 17px;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .navbar a.active {
            background-color: #4CAF50;
            color: white;
        }

        .content {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            text-align: center;
            margin-top: 80px; /* Adjusted margin-top to accommodate navbar height */
        }

        .content p {
            font-size: 18px;
            line-height: 1.6;
            color: #333333;
        }

        .content p strong {
            color: #3498db;
        }

        .image-container {
            text-align: center;
            margin-top: 20px;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a class="active" href="index.php">Home</a>
        <!-- <a href="Adminform.php">Admin</a> -->
        <a href="UserProjectDetails.php">View Project</a>
    </div>

    <div class="content">
        <p>
            <strong>Hello Customer,</strong> welcome to <strong>D&D Electronics.</strong><br>
            To view your contract project status, please click on the <strong>View Project</strong> button and then enter the token which you set at the time of registration. Thank you.
        </p>
    </div>
    <div class="image-container">
        <img src="customerimg.jpg" alt="Description of the image">
    </div>
</body>
</html>
