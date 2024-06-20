<?php
    session_start();


    if (isset($_POST["submit"])) {
        $error = 0;
        $location = stripslashes($_POST["location"]);
        $description = stripslashes($_POST["description"]);
        $capacity = stripslashes($_POST["capacity"]);
        $costPerHour = stripslashes($_POST["cost_per_hour"]);

        //validate input before sent to sql
        if(empty($location) || empty($description) || empty($capacity) || empty($costPerHour)) {
            ++$error;
            echo"All fiels are required.";
        } else {
            try{
                require_once("../classes/ParkingLocation.php");
    
                $newParking = new ParkingLocation($location, $description, $capacity, $costPerHour);
                $result = $newParking->create() ;
    
                if ($result){
                    $_SESSION["update_msg"]="New Parking Lot $location has been successfully added!";
                    header("location:locations.php");
                } else{
                    $_SESSION["update_msg"]="New Parking Lot $location failed to add!";
                    header("location:locations.php");
                }
            } catch(mysqli_sql_exception $e){
                echo"". $e->getMessage() ."";
            }
        }
    
    }
?>