<?php

//bug fixe bcs path: includes/db_config.php do not work

class ParkingLocation
{
    private $id;
    private $location;
    private $description;
    private $capacity;
    private $costPerHour;

    public function __construct($location, $description, $capacity, $costPerHour)
    {
        $this->location = $location;
        $this->description = $description;
        $this->capacity = $capacity;
        $this->costPerHour = $costPerHour;
    }

    private static function conn()
    {
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
        return $conn;
    }

    public function create()
    {
        //include("../includes/db_config.php");
        $conn = $this->conn();

        //insert new location into database
        $sql = "INSERT INTO parkinglocations (Location, Description, Capacity, CostPerHour)
                VALUES ('$this->location', '$this->description', '$this->capacity', '$this->costPerHour')";
        $result = $conn -> query($sql);
        if ($result) {
            $conn->close();
            return true;
        } else {
            $conn -> close();
            return false;
        }
    }

    public static function update($locationID, $location, $description, $capacity, $costPerHour)
    {
        //include("../includes/db_config.php");
        $conn = self :: conn();

        //update parking loation details
        $sql = "UPDATE parkinglocations 
                SET location='$location', Description = '$description', Capacity = '$capacity', CostPerHour = '$costPerHour' 
                WHERE LocationID = '$locationID'";
        $result = $conn -> query($sql);
        if ($result) {
            $conn->close();
            return true;
        } else {
            $conn -> close();
            return false;
        }
    }

    public function delete($location)
    {
        //include("../includes/db_config.php");
        $conn = self :: conn();

        //delete a parking loation
        $sql = "DELETE FROM parkinglocations WHERE Location = '$location'";
        $result = $conn->query($sql);

        if ($result) {
            $conn->close();
            return true;
        } else {
            $conn->close();
            return false;
        }
    }

    public static function getAvailableSpaces($locationID)
    {
        //include("../includes/db_config.php");
        $conn = self :: conn();

        //todo:need to change the userparkinghistory to new name
        $sql = "SELECT p.Capacity - (
                    SELECT COUNT(*)
                    FROM userparkinghistory b
                    JOIN parkinglocations p ON b.locationID = p.locationID
                    WHERE p.LocationID = '$locationID'
                    AND b.CheckInTime IS NOT NULL
                    AND b.CheckOutTime IS NULL
                ) AS AvailableSpaces
                FROM parkinglocations p
                WHERE p.LocationID = '$locationID'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $conn->close();
            return $row['AvailableSpaces'];
        } else {
            $conn->close();
            return false;
        }
    }

    public static function searchLocation($search) 
    {
        //include("../includes/db_config.php");
        $conn = self :: conn();

        $sql = "SELECT * FROM parkinglocations WHERE locationID = '$search' OR Location = '$search' OR Description LIKE '%$search%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $locations = array();
            while ($row = $result->fetch_assoc()) {
                $locations[] = $row;
            }
            $conn->close();
            return $locations;
        } else {
            $conn->close();
            return null;
        }
    }

    public static function allLocation() 
    {
        //include("../includes/db_config.php");
        $conn = self :: conn();

        $sql = "SELECT * FROM parkinglocations";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $conn->close();
            return $result;
        } else {
            $conn->close();
            return null;
        }

    }

    public static function get_location_by_ID($locationID) 
    {
        //include("../includes/db_config.php");
        $conn = self :: conn();
        
        $sql = "SELECT * FROM parkinglocations WHERE LocationID=$locationID";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $conn->close();
            return $result;
        } else {
            $conn->close();
            return null;
        }

    }
}

?>