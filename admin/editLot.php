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
            <title>Edit parking lot</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        </head>
        <body>
            <h2 style="text-align: center">Edit Parking Lots</h2>

            <?php 
                if (isset($_GET["lotID"])){
                    $locID = $_GET["lotID"];

                    require_once("../classes/ParkingLocation.php");

                    try{
                        $result = ParkingLocation::get_location_by_ID($locID);

                        if ($result == null ){ 
                            echo"No such parking location found, please try another ID";
                            $row=null;
                        }else{
                            $row = $result->fetch_assoc();
                        }
                    } catch(mysqli_sql_exception $e){
                        echo "". $e->getMessage() ."";
                    }
                } else{
                    $row = null;
                }

                if ($row==null) {
                    echo "No parking lot found!";
                } else {
            ?>

            <form method="post" action="updateLot.php" >
                <div style="padding: 20px 0;">
                    <input type="hidden" name="LocationID" value="<?php echo $row["LocationID"]; ?>">

                    <label>Location:</label>
                    <input class="form-control" type="text" name="location" value="<?php echo $row["Location"]; ?>"><br>

                    <label>Description:</label>
                    <textarea class="form-control" name="description"><?php echo $row["Description"]; ?></textarea><br>

                    <label>Capacity:</label>
                    <input class="form-control" type="number" name="capacity" value="<?php echo $row["Capacity"]; ?>"><br>

                    <label>Cost per Hour:</label>
                    <input class="form-control" type="number" step="0.01" name="cost_per_hour" value="<?php echo $row["CostPerHour"]; ?>"><br>

                    <input type="submit" value="Update" class="btn btn-secondary btn-lg btn-block">
                </div>
            </form>

            </body>  
    </html>

<?php
                }
    }
    include_once("../includes/footer.php");
?>