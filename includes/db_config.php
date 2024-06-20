<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "EasyParking";

try{
    $conn = new mysqli($servername, $username, $password, $dbname);
    $message = "Connection to database successful!";
    echo"<script type=text/javascript> console.log('$message');</script>";
}
catch(mysqli_sql_exception $e){
    die($e -> getCode() ."". $e ->getMessage()); 
}

?> 