<?php
include_once("includes/header.php");

if (isset($_SESSION['Login_msg'])){
    $alertMsg = $_SESSION['Login_msg'];
    echo "<script type='text/javascript'> alert('$alertMsg') </script>";

    $user = $_SESSION['user_name'];
    $loggedin = $_SESSION['loggedin'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>User Home</title>
        <!-- Style CSS -->
        <link rel="stylesheet" href="./assets/styles.css">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    </head>

    <body>
        <div>
            <img class="image-responsive" src="../assets/userimg.jpg" alt="user home image" width="100%" height="460">
        </div>
        <div> 
            <?php 
                if ( $loggedin || $loggedin== true){
                    $t = time();
                    echo"<p>Hi~ $user. Now is ".date('Y-m-d H:i:s', $t) ."!</p>"; 
                } else { echo""; }
                
            ?> 
        </div>
        <div class="list-group">
            <a href="check_in.php" class="list-group-item"> Check In</a>
            <a href="currentparking.php" class="list-group-item"> My Current Parking (Check Out) </a>
            <a href="availability.php" class="list-group-item"> Available Spaces </a>
            <a href="search.php" class="list-group-item"> Search Location </a>
            <a href="history.php" class="list-group-item"> Parking History </a>
        </div>
        <?php include_once("../includes/footer.php") ?>
    </body>
</html>

<?php 
} else {
    $_SESSION['alert_msg']="Please log in!";
    header("location:../index.php");
}
?>