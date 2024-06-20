<?php
    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
        $_SESSION['alert_msg']="Please log in!";
        header("location:../index.php");
    } else {
        $u_name = $_SESSION["user_name"];
        $u_id = $_SESSION["user_id"];
        $parkingID = $_GET["parkingID"];


        try{
            require_once("../classes/userparking.php");

            $response = UserParking :: CheckOutUpdate($parkingID);

            if ($response == false){
                echo "Can't find the parking record!";
            } else {
                $total_cost = $response;
                $total_cost = number_format($total_cost,2);
                $_SESSION['check_out_msg'] = "Thank you $u_name, your parking cost is $total_cost in total!";
                header("location:currentparking.php");
            }
        } catch(mysqli_sql_exception $e){
            echo "". $e->getMessage();
        }



    }

?>