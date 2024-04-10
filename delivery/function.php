<?php
function check_delivery_person_login($con)
{
    if(isset($_SESSION['Did']))
    {
        $Did = $_SESSION['Did'];
        $query = "SELECT * FROM delivery_persons WHERE Did = '$Did' LIMIT 1";

        $result = mysqli_query($con, $query);
        if($result && mysqli_num_rows($result) > 0)
        {
            $delivery_person_data = mysqli_fetch_assoc($result);
            return $delivery_person_data;
        }
    }
    // Redirect to login
    header("Location: login.php");
    die;
}

function random_num($length)
{
    $text = "";
    if ($length < 5)
    {
        $length = 5;
    }

    $len = rand(4, $length);

    for ($i = 0; $i < $len; $i++) {
        $text .= rand(0, 9);
    }
    return $text;
}
?>
