<?php
    include_once("includes/header.php");

    if (isset($_SESSION['check_out_msg'])){
        $alertMsg = $_SESSION['check_out_msg'];
        echo "<script type='text/javascript'> alert('$alertMsg') </script>";
        unset($_SESSION['check_out_msg']);
    }

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
        $_SESSION['alert_msg']="Please log in!";
        header("location:../index.php");
    } else {
        $u_name = $_SESSION["user_name"];
        $u_id = $_SESSION["user_id"];
?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>user check out</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        </head>
        <body>
            <h2 style="text-align: center">List your current parking and choose to check out!</h2>
            <button href="#" class="btn-default btn-block"> My current parking </button>

            <!-- list current parking -->
            <?php 
                
                try{
                    require_once("../classes/userparking.php");

                    $qRes = UserParking :: GetCurrentUse($u_id);
                    if ($qRes == false) {
                        echo "You don't have active parking today!";
                    } else {
                        while($row = $qRes -> fetch_assoc()) {
                            $parkings[]=$row; 
                        }
                        $qRes -> free_result();

                        echo"<table width='100%' class='table-striped' >";
                        echo"<tr>";
                        echo"<th>ParkingID</th>";
                        echo"<th>LocationID</th>";
                        echo"<th>Location</th>";
                        echo "<th>Check In Time</th>";
                        echo "<th>Action</th>";
                        echo "</tr>";
        

                        foreach($parkings as $parking) {
                            echo "<tr>";
                            //todo: to change the name HistroyID to ParkingID
                            echo "<td>". htmlentities($parking['HistoryID']) ."</td>";
                            echo "<td>". htmlentities($parking["LocationID"]) ."</td>";
                            echo "<td>". htmlentities($parking["Location"]) ."</td>";
                            echo "<td>". htmlentities($parking["CheckInTime"]) ."</td>";
                            echo "<td> <a href='check_out.php?parkingID=".$parking['HistoryID'] . "'> Check Out </a></td>";
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