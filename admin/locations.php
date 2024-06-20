<?php
    include_once("includes/header.php");

    if (isset($_SESSION['update_msg'])){
        $alertMsg = $_SESSION['update_msg'];
        echo "<script type='text/javascript'> alert('$alertMsg') </script>";
        unset($_SESSION['update_msg']);
    }

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
            <h2 style="text-align: center">View All Parking Lots</h2>

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
                        echo "<th>Edit Location</th>";
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
                            echo "<td> <a href='editLot.php?lotID=$lotID'> Edit </td>";
                            echo "</tr>";
                        }

                        echo"</table>";

                    }
                } catch(mysqli_sql_exception $e){ 
                    echo "".$e->getMessage()."";
                }
            ?>

            <script>
                function showFull() {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("FullList").innerHTML = this.responseText;
                    }
                    };
                    xmlhttp.open("GET","listFull.php",true);
                    xmlhttp.send();
                }

                function showAvail() {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("AvailableList").innerHTML = this.responseText;
                    }
                    };
                    xmlhttp.open("GET","listAvail.php",true);
                    xmlhttp.send();
                }
            </script>

            <div style="padding:30px">
                <a class="btn btn-secondary btn-lg btn-block" onclick="showFull()" role="button">List Full Parking Lots</a><br>
                <div id="FullList"></div><br>
                <a class="btn btn-secondary btn-lg btn-block" onclick="showAvail()" role="button">List Available Praking Lots</a><br>
                <div id="AvailableList"></div>
            </div>
        </body>  
    </html>

<?php
    }
    include_once("../includes/footer.php");
?>