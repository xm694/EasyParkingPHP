<?php
include_once("includes/header.php");

if (isset($_SESSION['Login_msg'])){
    $alertMsg = $_SESSION['Login_msg'];
    echo "<script type='text/javascript'> alert('$alertMsg') </script>";
}

?>

<!DOCTYPE html>
<html>
    <head>
        <?php  ?>
        <title>Admin Home</title>
        <!-- Style CSS -->
        <link rel="stylesheet" href="./assets/styles.css">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    </head>

    <body>
        <div>
            <img class="image-responsive" src="../assets/adminimg.jpg" alt="user home image" width="100%" height="460">
        </div>
        <div class="list-group">
            <a href="locations.php" class="list-group-item">View All Parking Lots(full & avail & edit)</a>
            <a href="addLot.php" class="list-group-item"> Add New Location</a>
            <a href="check_in.php" class="list-group-item"> Check in a user</a>
            <a href="get_user_parking.php" class="list-group-item"> Check out a user</a>
            <a href="search.php" class="list-group-item"> Search Location </a>
            <a href="allusers.php" class="list-group-item"> View All User </a>
            <a href="users.php" class="list-group-item"> View users for a location</a>
        </div>
    </body>
    <?php include_once("../includes/footer.php") ?>
</html> 