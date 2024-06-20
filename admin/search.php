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
            <title>search location</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        </head>

        <body>
            <h2>Enter something to start searching!</h2>
            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" >
                <input type="text" name="search" size="80"/>
                <input type="submit" name="submit" value="Search" class="btn btn-dark"/>
            </form>

            <div class="result-container">
                <?php
                    if (isset($_POST['submit'])){
                        $search = $_POST['search'];

                        require_once('../classes/parkinglocation.php');

                        try{
                            $locations = ParkingLocation::searchLocation( $search );

                            if ($locations == null){
                                echo"Unfortunatley There is no such a parking nearby, please try other keyword";
                            } else {
                                
                                foreach($locations as $location) {
                                    echo "<img src='../assets/parking_sign.jpg'><br>";
                                    echo "<h4> LocationID: ". htmlentities($location['LocationID']) ."</h4> <br>";
                                    echo "<h4> Name: ". htmlentities($location["Location"]) ."</h4> <br>";
                                    echo "<h5> Capacity: ". htmlentities($location["Capacity"]) ."</h5> <br>";
                                    echo "<h5> Hourly Rate: ". htmlentities($location["CostPerHour"]) ."</h5> <br>";
                                    echo "<p><i> <b>Description</b>: ". htmlentities($location["Description"]) ."</i></p> <br>";
                                    echo "<hr/><br>";
                                }
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