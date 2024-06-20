<?php
    include_once("includes/header.php");

    if (isset($_SESSION['check_in_msg'])){
        $alertMsg = $_SESSION['check_in_msg'];
        echo "<script type='text/javascript'> alert('$alertMsg') </script>";
        unset($_SESSION['check_in_msg']);
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
        <title>User Check In</title>

        <style>
            h2{
                text-align: center;
            }

            .parking_locations {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                justify-content: center;
                padding: 25px 0;
            }

            .parking_location {
                background-color: white;
                border: 1px solid #ddd;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                text-align: center;
                width: 300px;
            }

            .parking_location p {
                padding: 10px;
                margin: 0;
            }

            .parking_location p:first-of-type {
                font-weight: bold;
                background-color: #eaeaea;
            }
        </style>
    </head>
    <body>
        <h2><?php echo"Hi~ $u_name. " ?>Click on picture check in to start your parking!</h2>
        <!-- diaplay parking locations -->
        <div class="parking_locations">
            <?php 
                require_once("../classes/ParkingLocation.php");

                $response = ParkingLocation::allLocation() ;

                if ($response == null) {
                    echo "No parking locations found.";
                } else {
                    while ($loc = $response -> fetch_assoc()) {
                        $locationID = $loc["LocationID"];
                        $location = $loc["Location"];
                        $description = $loc["Description"];
                        $cost = $loc["CostPerHour"];
                        echo "<div class='parking_location'>";
                        echo "<form method='POST' action='./includes/check_in.php'>";
                        echo "<input type='hidden' name='LocationID' value='$locationID'>";
                        echo "<input type='hidden' name='Location' value='$location'>";
                        echo "<input type='hidden' name='cost' value='$cost'>";
                        echo "<input type='image' src='../assets/parking_sign.jpg' alt='$location' data-locationId='$locationID' class='clickable-image' style='width:250px;height:250px'>";
                        echo "</form>";
                        echo "<p>$location</p>";
                        echo "<p>$description</p>";
                        echo "<p>Hourly rate: AU\$$cost</p>";
                        echo "</div>";
                    }
                }
            ?>
        </div>

        
    <!-- 
        <script>
            var clickableImages = document.querySelectorAll('.clickable-image');

            clickableImages.forEach(image => {
                image.addEventListener('click', () => {
                    var locationID = image.getAttribute("data-locationId");
                    sendLocationID(locationID);
                    //alert(locationID); debug
                });
            });

            function sendLocationID(str) {
                var xhttp = new XMLHttpRequest();

                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Handle the response from the server
                        console.log(this.responseText);
                    }
                };
                xhttp.open("GET", "./includes/check_in.php?loc="+str, true);
                xhttp.send();
            }
        </script>
     -->    

    </body>
    <?php include_once("../includes/footer.php") ?>
</html>

        
<?php }?>