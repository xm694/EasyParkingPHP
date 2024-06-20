<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "Please log in!";
    exit();
}

if (isset($_POST['LocationID'])) {
    $locationID = $_POST['LocationID'];
    $location = $_POST['Location'];
    $cost =  $_POST['cost'];
    $userID = $_SESSION['user_id'];
    $checkInTime = date('Y-m-d H:i:s');

    require_once("../../classes/ParkingLocation.php");

    $availableSpots = ParkingLocation::getAvailableSpaces($locationID);

    if ($availableSpots>0) {
        try{

            include("../../includes/db_config.php");
    
            //todo: change table name to userparking
            //insert new location into database
            $sql = "INSERT INTO userparkinghistory (UserID, LocationID, CheckInTime)
                    VALUES ('$userID', '$locationID', '$checkInTime')";
            $result = $conn -> query($sql);
    
            if ($result) {
                $conn->close();
                $_SESSION['check_in_msg'] = "You have start parking at $checkInTime \@$location, the hourly rate is $cost.";
                header("location:../check_in.php");
            } else {
                $conn->close();
                echo "Error";
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
    } else {
        $_SESSION['check_in_msg'] = "Parking Lot $location is not available, please try again.";
        header("location:../check_in.php");
    }
    
} else {
    echo "Something went wrong when checking in, please try again later.";
}

?>
