<!-- list current parking -->
<?php 
    session_start();
    
    try{
        include_once("../includes/db_config.php");

        $sql = "SELECT * FROM parkinglocationswithavailability WHERE AvailableSpots>0;";
        $qRes = $conn->query($sql);

        if ($qRes->num_rows <= 0) {
            echo "Ooops, no available parking lot found!";
        } else {
            while($row = $qRes -> fetch_assoc()) {
                $ParkingLots[]=$row; 
            }
            $qRes -> free_result();

            echo"<table width='100%' class='table-striped' >";
            echo"<tr>";
            echo"<th>LocationID</th>";
            echo"<th>Location</th>";
            echo "<th>Description</th>";
            echo "<th>Capacity</th>";
            echo "<th>Hourly Rate</th>";
            echo "<th>Available Spots</th>";
            echo "</tr>";


            foreach($ParkingLots as $ParkingLot) {
                $lotID = $ParkingLot["LocationID"];
                echo "<tr>";
                //todo: to change the name HistroyID to ParkingID
                echo "<td>". htmlentities($ParkingLot['LocationID']) ."</td>";
                echo "<td>". htmlentities($ParkingLot["Location"]) ."</td>";
                echo "<td>". htmlentities($ParkingLot["Description"]) ."</td>";
                echo "<td>". htmlentities($ParkingLot["Capacity"]) ."</td>";
                echo "<td>". htmlentities($ParkingLot["CostPerHour"]) ."</td>";
                echo "<td>". htmlentities($ParkingLot["AvailableSpots"]) ."</td>";
                echo "</tr>";
            }

            echo"</table>";

        }
    } catch(mysqli_sql_exception $e){ 
        echo "".$e->getMessage()."";
    }

    $conn->close();
?>