<?php
ob_start(); 
include("connect.php"); 

// Redirect to signin.php if the user is not logged in
if($_SESSION['name']==''){
	header("location:signin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Admin Dashboard Panel</title> 
    <?php
$connection=mysqli_connect("zerowaste-rds.cxckq8ueksk6.us-east-1.rds.amazonaws.com:3306","admin","Panta1234");
$db=mysqli_select_db($connection,'demo');
    ?>
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <!--<img src="images/logo.png" alt="">-->
            </div>
            <span class="logo_name">ADMIN</span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="admin.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dashboard</span>
                </a></li>
                <li><a href="analytics.php">
                    <i class="uil uil-chart"></i>
                    <span class="link-name">Analytics</span>
                </a></li>
                <li><a href="donate.php">
                    <i class="uil uil-heart"></i>
                    <span class="link-name">Donates</span>
                </a></li>
                <li class="active"><a href="user_management.php">
                    <i class="uil uil-user"></i> 
                    <span class="link-name">Users</span>
                </a></li>
                <li><a href="feedback.php">
                    <i class="uil uil-comments"></i>
                    <span class="link-name">Feedbacks</span>
                </a></li>
                <li><a href="adminprofile.php">
                    <i class="uil uil-user"></i>
                    <span class="link-name">Profile</span>
                </a></li>
            </ul>
            <ul class="logout-mode">
                <li><a href="../logout.php">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>
                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                        <span class="link-name">Dark Mode</span>
                    </a>
                    <div class="mode-toggle">
                        <span class="switch"></span>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <p  class ="logo" >ZeroWaste <b style="color: #06C167; ">Hub</b></p>
            <p class="user"></p>
        </div>
        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    
                    <span class="text"></span>
                </div>
                <div class="boxes">
                    <div class="box box1">
                        <i class="uil uil-user"></i>
                        <span class="text">Total users</span>
                        <?php
                            $query="SELECT count(*) as count FROM  login";
                            $result=mysqli_query($connection, $query);
                            $row=mysqli_fetch_assoc($result);
                            echo "<span class=\"number\">".$row['count']."</span>";
                        ?>
                    </div>
                    <div class="box box2">
                        <i class="uil uil-comments"></i>
                        <span class="text">Feedbacks</span>
                        <?php
                            $query="SELECT count(*) as count FROM  user_feedback";
                            $result=mysqli_query($connection, $query);
                            $row=mysqli_fetch_assoc($result);
                            echo "<span class=\"number\">".$row['count']."</span>";
                        ?>
                    </div>
                    <div class="box box3">
                        <i class="uil uil-heart"></i>
                        <span class="text">Total donates</span>
                        <?php
                            $query="SELECT count(*) as count FROM food_donations";
                            $result=mysqli_query($connection, $query);
                            $row=mysqli_fetch_assoc($result);
                            echo "<span class=\"number\">".$row['count']."</span>";
                        ?>
                    </div>
                </div>
            </div>
            <div class="activity">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">Users</span>
                </div>
                <div class="get">
                    <?php
                        // Fetch user details
                        $sql = "SELECT * FROM delivery_persons";
                        $sql1 = "SELECT * FROM login";
                        $result = mysqli_query($connection, $sql);
                        $result1 = mysqli_query($connection, $sql1);
                        if (!$result && !$result1) {
                            die("Error executing query: " . mysqli_error($connection));
                        }
                    ?>
                   <div class="get">
    <div style="text-align: center;">
        <h2>Delivery Persons</h2>
    </div>
    <div class="table-container">
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                   
                    <th>City</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['Did']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        
                        <td><?php echo $row['city']; ?></td>
                        <td>
                            <form method="GET" action="edit_user.php">
                                <input type="hidden" name="id" value="<?php echo $row['Did']; ?>">
                                <button type="submit">Edit</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

    <div style="margin-top: 20px; text-align: center;">
        <h2>Users</h2>
    </div>
    <div class="table-container">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        
                        <th>Gender</th>
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result1)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            
                            <td><?php echo $row['gender']; ?></td>
                            <td>
                                <form method="GET" action="edit_user.php">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit">Edit</button>
                                </form>
                            </td> 
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
        </div>
    </section>
    <script src="admin.js"></script>
</body>
</html>
