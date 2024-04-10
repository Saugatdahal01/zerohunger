<?php

include("connect.php");
include("function.php");

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email']; 

    // Check if the email exists in the database
    $query = "SELECT * FROM delivery_persons WHERE email='$email'";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        echo "User with this email does not exist";
        exit;
    }

    // Generate a random temporary password
    $temp_password = random_num(8); // Generating an 8-character random temporary password

    // Update the user's password with the temporary password
    $update_query = "UPDATE delivery_persons SET password='$temp_password' WHERE email='$email'";
    mysqli_query($connection, $update_query);

    // Send the temporary password to the user via email (You need to implement this part)

    // Redirect the user to the login page
    header("Location: deliverylogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        #box {
            background-color: #fff;
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        form {
            text-align: center;
        }
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="box">
        <h1>Forgot Password</h1>
        <form method="post">
            <input required type="email" name="email" placeholder="Enter your email address"><br><br>
            <input required type="submit" value="Reset Password">
        </form>
    </div>
</body>
</html>

