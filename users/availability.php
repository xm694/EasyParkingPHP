<?php
    include_once("includes/header.php");

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
        $_SESSION['alert_msg']="Please log in!";
        header("location:../index.php");
    } else {
?>

<!DOCTYPE html>
    <html>
        <head>
            <title>check availability</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        </head>

        <body>

            <?php
                    require_once("../classes/userparking.php");
                
                    $result = UserParking::GetAvailability();

                    if ($result == false){
                        echo"Something went wrong while checking the availability, please try again!";
                    } else {
                        if ($result->num_rows > 0) {
                            while($row = $result -> fetch_assoc()) {
                                $parkingLots[]=$row; 
                            }
                            $result -> free_result();
    
                            echo"<table width='100%' class='table-striped' >";
                            echo"<tr>";
                            echo"<th>LocationID</th>";
                            echo"<th>Location</th>";
                            echo "<th>Description</th>";
                            echo "<th>Capacity</th>";
                            echo"<th>Hourly Rate</th>";
                            echo"<th>Available Spots</th>";
                            echo "</tr>";
    
                            foreach($parkingLots as $parkingLot) {
                                echo "<tr>";
                                //todo: to change the name HistroyID to ParkingID
                                echo "<td>". htmlentities($parkingLot['LocationID']) ."</td>";
                                echo "<td>". htmlentities($parkingLot["Location"]) ."</td>";
                                echo "<td>". htmlentities($parkingLot["Description"]) ."</td>";
                                echo "<td>". htmlentities($parkingLot["Capacity"]) ."</td>";
                                echo "<td>". htmlentities($parkingLot["CostPerHour"]) ."</td>";
                                echo "<td>". htmlentities($parkingLot["AvailableSpots"]) ."</td>";
                                echo "</tr>";
                            }
    
                            echo"</table>";
                        } else {
                            echo "No data found!";
                        }

                    }
                
                }

                include_once("../includes/footer.php");
            ?>

        </body>
</html>