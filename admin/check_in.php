<?php
    include_once("includes/header.php");

    if (isset($_SESSION['check_in_msg'])){
        unset($_SESSION['check_in_msg']);
    }

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
        $_SESSION['alert_msg']="Please log in!";
        header("location:../index.php");
    } else {
?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>Check in a user</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        </head>
        <body>

            <?php
                if (isset($_POST["submit"])){
                    $uID = $_POST["userID"];
                    $lname = $_POST["lname"];
                    $lotID = $_POST["lotID"];
                    $checkInTime = date('Y-m-d H:i:s');

                    //check if user exist
                    require_once("../classes/user.php");
                    $userexist = User::userExists( $uID, $lname);

                    //check if parking lot is available
                    if ($userexist == true){
                        require_once("../classes/ParkingLocation.php");
                        require_once("../classes/userparking.php");

                        $availableSpots = ParkingLocation::getAvailableSpaces($lotID);

                        if ($availableSpots>0) {
                            try{
                                //get hourly rate by location ID
                                $result = ParkingLocation::get_location_by_ID($lotID);
                                if ($result){
                                    $row = $result->fetch_assoc();
                                    $cost = $row["CostPerHour"];
                                }

                                //check user in
                                $newParking = new UserParking($uID, $lotID, $checkInTime);
                                $result = $newParking->create() ;
                    
                                if ($result){
                                    $_SESSION['check_in_msg'] = "You have checked user $uID in at $checkInTime \@Parking Lot$lotID, the hourly rate is $cost. ";
                                    $alertMsg = $_SESSION['check_in_msg'];
                                    echo "<script type='text/javascript'> alert('$alertMsg') </script>";
                                } else{
                                    $_SESSION['check_in_msg'] = "User $uID has not been checked-in successfully!";
                                    $alertMsg = $_SESSION['check_in_msg'];
                                    echo "<script type='text/javascript'> alert('$alertMsg') </script>";
                                }
                            } catch(mysqli_sql_exception $e){
                                echo"". $e->getMessage() ."";
                            }
                        } else {
                            $_SESSION['check_in_msg'] = "Parking Lot $lotID is not available, please try again.";
                            $alertMsg = $_SESSION['check_in_msg'];
                            echo "<script type='text/javascript'> alert('$alertMsg') </script>";
                        }
                    } else {
                        $_SESSION['check_in_msg'] = "User $uID do not exists.";
                            $alertMsg = $_SESSION['check_in_msg'];
                            echo "<script type='text/javascript'> alert('$alertMsg') </script>";
                    }
                }

            ?>

            <h2 style="text-align: center">Check in a user</h2>

            <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" >
                <div style="padding:20px 0">
                    <label class="form-label">UserID:</label>
                    <input type="text" name="userID" class="form-control"><br>

                    <label>Last Name:</label>
                    <input type="text" name="lname" class="form-control"><br>

                    <label>Check In Parking Lot ID:</label>
                    <input type="number" name="lotID" class="form-control"><br>

                    <input type="submit" name="submit" value="Check User In" class="btn btn-secondary btn-lg btn-block">
                </div>
            </form>

            </body>  
    </html>

<?php
        }
    include_once("../includes/footer.php");
?>