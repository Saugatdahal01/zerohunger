<?php
ob_start(); 
include("connect.php"); 

// Redirect to signin.php if the user is not logged in
if($_SESSION['name'] == ''){
    header("location:signin.php");
    exit; // Ensure no further processing after redirection
}

// Check if ID is set in the URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Check if form is submitted
    if(isset($_POST['submit'])) {
        // Get form data
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $gender = $_POST['gender'];

        // Determine if the ID belongs to a user or a delivery person
        if(isset($_POST['user_type']) && $_POST['user_type'] == 'user') {
            // Update user details in the database
            $query = "UPDATE login SET name='$name', email='$email', password='$password', gender='$gender' WHERE id=$id";
        } else {
            // Update delivery person details in the database
            $query = "UPDATE delivery_persons SET name='$name', email='$email', password='$password', city='$city' WHERE Did=$id";
        }
        
        $result = mysqli_query($connection, $query);

        // Check if update was successful
        if($result) {
            echo "Details updated successfully.";
            // Redirect to user management page
            header("location:user_management.php");
            exit;
        } else {
            echo "Error updating details: " . mysqli_error($connection);
        }
    }

    // Fetch user details from the database based on the ID
    $query = "SELECT * FROM login WHERE id = $id";
    $result = mysqli_query($connection, $query);

    // Check if user exists
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $email = $row['email'];
        $password = $row['password'];
        $gender = $row['gender'];
        $user_type = 'user';
    } else {
        // Fetch delivery person details from the database based on the ID
        $query = "SELECT * FROM delivery_persons WHERE Did = $id";
        $result = mysqli_query($connection, $query);

        // Check if delivery person exists
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $name = $row['name'];
            $email = $row['email'];
            $password = $row['password'];
            $city = $row['city'];
            $user_type = 'delivery_person';
        } else {
            // Redirect to user management page if neither user nor delivery person found
            header("location:user_management.php");
            exit;
        }
    }
} else {
    // Redirect to user management page if ID is not set
    header("location:user_management.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Modern CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        h2 {
            margin-top: 0;
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.3s ease;
            width: 100%;
            box-sizing: border-box; /* Ensure padding and border don't add to the width */
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
        }

        input[type="submit"] {
            padding: 12px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .password-input {
            position: relative;
        }

        #togglePassword {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h2>Edit <?php echo isset($user_type) && $user_type == 'user' ? 'User' : 'Delivery Person'; ?></h2>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>">

            <label for="password">Password:</label>
            <div class="password-input">
                <input type="password" id="password" name="password" value="<?php echo isset($password) ? $password : ''; ?>">
                <button type="button" id="togglePassword"><i class="fa fa-eye"></i></button>
            </div>

            

            <label for="gender">Gender:</label>
            <select id="gender" name="gender">
                <option value="Male" <?php if(isset($gender) && $gender == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if(isset($gender) && $gender == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if(isset($gender) && $gender == 'Other') echo 'selected'; ?>>Other</option>
            </select>

            <input type="hidden" name="user_type" value="<?php echo isset($user_type) ? $user_type : ''; ?>">
            <input type="submit" name="submit" value="Update">
        </form>
    </div>

    <script>
        // JavaScript for toggling password visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
