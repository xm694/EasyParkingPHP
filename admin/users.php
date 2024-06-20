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
            <title>view all parking lot</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        </head>
        <body>
            <h2 style="text-align: center">All Parking Lots</h2>

            <!-- list current parking -->
            <?php 
                
                try{
                    require_once("../classes/ParkingLocation.php");

                    $qRes = ParkingLocation::allLocation();
                    if ($qRes == false) {
                        echo "Ooops, no registered parking lot found!";
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
                        echo "<th>Action</th>";
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
                            echo "<td> <a href='currentUsers.php?lotID=$lotID'> Check Current Users </td>";
                            echo "</tr>";
                        }

                        echo"</table>";

                    }
                } catch(mysqli_sql_exception $e){ 
                    echo "".$e->getMessage()."";
                }
            ?>
        </body>  
    </html>

<?php
    }
    include_once("../includes/footer.php");
?>