

<?php
//change mysqli_connect(host_name,username, password); 
//$connection = mysqli_connect("zerowaste-rds.cxckq8ueksk6.us-east-1.rds.amazonaws.com:3306", "admin", "Panta1234");
//$db = mysqli_select_db($connection, 'demo');
$serverURL = "zerohunger.c03uhohp3ztg.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "Password0123";
$database = "zerohunger";

$connection = mysqli_connect($serverURL, $username, $password, $database);

if (!$connection)
{
    die("Error: Unable to connect. Error as here: ". mysqli_connect_error());
}


?>