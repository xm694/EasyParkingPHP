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
?>

<!DOCTYPE html>
    <html>
        <head>
            <title>check out</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        </head>

        <body>
            <h2>Enter userID to search their current parking!</h2>
            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" >
                <input type="text" name="search" size="80"/>
                <input type="submit" name="submit" value="Search" class="btn btn-dark"/>
            </form>

            <div class="result-container">
                <?php
                    if (isset($_POST['submit'])){
                        $uID = $_POST['search'];
                        $_SESSION["userID"] = $uID;

                        require_once('../classes/userparking.php');

                        try{
                            $userparkings = UserParking::GetCurrentUse( $uID );

                            if ($userparkings == null){
                                echo"User $uID do not have an active parking!";
                            } else {
                                
                                echo"<table width='100%' class='table-striped' >";
                                echo"<tr>";
                                echo"<th>UserID</th>";
                                echo"<th>ParkingID</th>";
                                echo"<th>LocationID</th>";
                                echo"<th>Location</th>";
                                echo "<th>Check In Time</th>";
                                echo "<th>Action</th>";
                                echo "</tr>";
                
        
                                foreach($userparkings as $parking) {
                                    echo "<tr>";
                                    //todo: to change the name HistroyID to ParkingID
                                    echo "<td> $uID </td>";
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

                    }
                ?>

            </div>
        </body>
    </html>


<?php 
}
include_once("../includes/footer.php");
?>