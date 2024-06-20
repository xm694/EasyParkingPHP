<?php
    session_start();


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $locationID = $_POST["LocationID"];
        $location = $_POST["location"];
        $description = $_POST["description"];
        $capacity = $_POST["capacity"];
        $costPerHour = $_POST["cost_per_hour"];

        try{
            require_once("../classes/ParkingLocation.php");

            $result = ParkingLocation::update($locationID, $location, $description, $capacity, $costPerHour);
            if ($result==true){
                $_SESSION["update_msg"]="Parking Lot $locationID Successfully Updated!";
                header("location:locations.php");
            } else{
                $_SESSION["update_msg"]="Parking Lot $locationID Update failed!";
                header("location:locations.php");
            }
        } catch(mysqli_sql_exception $e){
            echo"". $e->getMessage() ."";
        }
                
    }
?>