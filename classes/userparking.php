<?php 
class UserParking{
    private $HistoryID; //todo: need to change to ParkingID
    private $UserID;
    private $LocationID;
    private $CheckInTime;
    private $CheckOutTime;
    private $TotalCost;

    public function __construct($UserID, $LocationID, $CheckInTime,  $CheckOutTime=null, $TotalCost=null)
    {
        $this->UserID = $UserID;
        $this->LocationID = $LocationID;
        $this->CheckInTime = $CheckInTime;
        $this->CheckOutTime = $CheckOutTime;
        $this->TotalCost = $TotalCost;
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

        $sql = "INSERT INTO userparkinghistory (UserID, LocationID, CheckInTime)
                VALUES ('$this->UserID', '$this->LocationID', '$this->CheckInTime')";
        $result = $conn -> query($sql);
        if ($result) {
            $conn->close();
            return true;
        } else {
            $conn -> close();
            return false;
        }
    }

    public static function CheckOutUpdate($parkingID)
    {
        //include("../includes/db_config.php");
        $conn = self :: conn();

        $t = time();
        $CheckOutTime = date("Y-m-d H:i:s", $t);

        //todo: change table name to userparking and HistoryID to ParkingID
        $sql = "UPDATE userparkinghistory up
                JOIN ParkingLocations pl ON up.LocationID = pl.LocationID
                SET up.CheckOutTime = ?, 
                up.TotalCost = (TIME_TO_SEC(TIMEDIFF(?, up.CheckInTime)) / 3600 + 1)*pl.CostPerHour
                WHERE HistoryID = ?
                AND CheckInTime IS NOT NULL
                AND CheckOutTime IS NULL;";
        // Prepare the SQL statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param("ssi", $CheckOutTime, $CheckOutTime, $parkingID);
                // Execute the statement
            if ($stmt->execute()) {
                $sqlstr = "Select * FROM userparkinghistory WHERE HistoryID = $parkingID";
                $qRes = $conn->query( $sqlstr );
                $row = $qRes->fetch_assoc();
                $totalCost = $row["TotalCost"];
    
                $qRes->free_result();
                $conn->close();
    
                return $totalCost;
                
            } else {
                $conn -> close();
                return false;
            }
        }

    } 


    public static function GetCurrentUse($userID)
    {
        //include("../includes/db_config.php");
        $conn = self :: conn();

        //todo: change table name to userparking and HistoryID to ParkingID
        //list current parking 
        $sql = "SELECT up.HistoryID, up.LocationID, pl.Location, up.CheckInTime, pl.CostPerHour FROM userparkinghistory up 
                JOIN ParkingLocations pl ON up.LocationID = pl.LocationID 
                WHERE up.UserID = $userID AND up.CheckInTime IS NOT NULL AND up.CheckOutTime IS NULL";
        $result = $conn -> query($sql);
        if (mysqli_num_rows($result) > 0) {
            $conn->close();
            return $result;
        } else {
            $conn->close();
            return false;
        }
    }

    public static function GetParkingHistory($userID)
    {
        //include("../includes/db_config.php");
        $conn = self :: conn();

        //todo: change table name to userparking
        //list current parking 
        $sql = "SELECT * FROM userparkinghistory WHERE UserID = $userID AND CheckInTime IS NOT NULL AND CheckOutTime IS NOT NULL";
        $result = $conn -> query($sql);
        if (mysqli_num_rows($result) > 0) {
            $conn->close();
            return $result;
        } else {
            $conn->close();
            return false;
        }
    }


    public static function GetAvailability()
    {
        try{
            //include("../includes/db_config.php");
            $conn = self :: conn();

            // Check if the view exists
            $sql = "SHOW FULL TABLES IN easyparking WHERE TABLE_TYPE = 'VIEW'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $viewExists = false;
                while( $row = $result->fetch_assoc() ) {
                    if ($row["Tables_in_easyparking"] == "parkinglocationswithavailability") {
                        $viewExists = true;
                        break;
                    }
                }
            }
    
            // Create the view if it doesn't exist
            if (!$viewExists) {
                $createViewSQL = "CREATE VIEW ParkingLocationsWithAvailability AS
                                    SELECT
                                        PL.LocationID,
                                        PL.Location,
                                        PL.Description,
                                        PL.Capacity,
                                        PL.CostPerHour,
                                        (PL.Capacity - COALESCE((
                                            SELECT COUNT(*)
                                            FROM UserParkingHistory UPH
                                            WHERE UPH.LocationID = PL.LocationID
                                            AND UPH.CheckOutTime IS NULL
                                        ), 0)) AS AvailableSpots
                                    FROM
                                        ParkingLocations PL;";

                if ($conn->query($createViewSQL) === TRUE) {
                    echo "View 'ParkingLocationsWithAvailability' created successfully.";
                } else {
                    echo "Error creating view. ";
                }
            }

            //else query the view
            $sql="SELECT * FROM parkinglocationswithavailability";
            $result = $conn->query($sql);

            if($result){
                $conn->close();
                return $result;
            } else {
                $conn->close();
                return false;
            }

        } catch(mysqli_sql_exception $e){ 
            echo "".$e->getMessage()."";
        }

    }

}
?>