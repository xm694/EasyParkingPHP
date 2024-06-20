<?php
    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
        $_SESSION['alert_msg']="Please log in!";
        header("location:../index.php");
    } else {
        $u_id = $_SESSION["userID"];
        $parkingID = $_GET["parkingID"];


        try{
            require_once("../classes/userparking.php");

            $response = UserParking :: CheckOutUpdate($parkingID);

            if ($response == false){
                echo "Can't find the parking record!";
            } else {
                $total_cost = $response;
                $total_cost = number_format($total_cost,2);
                $_SESSION['check_out_msg'] = "You have successfully check user $u_id out, the total cost is $total_cost!";
                header("location:get_user_parking.php");
            }
        } catch(mysqli_sql_exception $e){
            echo "". $e->getMessage();
        }
    }

?>