<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project</title>
    <style>
       
form {
    max-width: 50%;
    max-height:50%;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    border-radius: 5px;
}

label {
    font-weight: bold;
}

input[type="text"],
textarea,
input[type="date"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-sizing: border-box;
}

textarea {
    resize: vertical; 
}

input[type="submit"] {
    background-color: #4caf50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    font-size: 16px;
}

input[type="submit"]:hover {
    background-color: #45a049;
}
h2{
    
    text-align: center;
}
body{
    background-color: indigo;
}


    </style>
</head>
<body>
   
    <form  method="post">
        <h2>Add Project</h2>
        <label for="project_name">Project Name:</label><br>
        <input type="text" id="project_name" name="project_name" required><br><br>

        <label for="company_name">Company Name::</label><br>
        <input type="text" id="company_name" name="company_name" required><br><br>
        
        <label for="project_description">Project Description:</label><br>
        <textarea id="project_description" name="project_description" rows="4" required></textarea><br><br>
        
        <label for="start_date">Start Date:</label><br>
        <input type="date" id="start_date" name="start_date" required><br><br>
        
        <label for="end_date">End Date:</label><br>
        <input type="date" id="end_date" name="end_date" required><br><br>

        <label for="user_token">Set Token:</label><br>
        <input type="password" id="user_token" name="user_token" required><br><br>
        
        <input type="submit" value="Save Project">
    </form>
</body>
</html>


<?php
if (isset($_POST['user_token'], $_POST['project_name'], $_POST['company_name'], $_POST['project_description'], $_POST['start_date'], $_POST['end_date'])) {
    // Retrieve the user-set token from the form
    $user_token = $_POST['user_token'];

    // Rest of your existing code for processing form data
    $project_name = $_POST['project_name'];
    $company_name = $_POST['company_name'];
    $project_description = $_POST['project_description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projectmgmt";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    
    $sql = "INSERT INTO projects (project_name, company_name, project_description, start_date, end_date, user_token) 
            VALUES ('$project_name','$company_name','$project_description','$start_date','$end_date', '$user_token')";
    $stmt = mysqli_prepare($conn, $sql);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('New project created successfully');</script>";
        header("Location:index.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
