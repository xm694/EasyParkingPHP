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
            <title>Add parking lot</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        </head>
        <body>
            <h2 style="text-align: center">Add a New Parking Lot</h2>

            <form method="post" action="insertLot.php" >
                <div style="padding:20px 0">
                    <label class="form-label">Location:</label>
                    <input type="text" name="location" class="form-control"><br>

                    <label>Description:</label>
                    <textarea name="description" size="250" class="form-control"> </textarea><br>

                    <label>Capacity:</label>
                    <input type="number" name="capacity" class="form-control"><br>

                    <label>Cost per Hour (sample:0.00):</label>
                    <input type="number" step="0.01" name="cost_per_hour" class="form-control"><br>

                    <input type="submit" name="submit" value="Add Parking Lot" class="btn btn-secondary btn-lg btn-block">
                </div>
            </form>

            </body>  
    </html>

<?php
                }
    include_once("../includes/footer.php");
?>