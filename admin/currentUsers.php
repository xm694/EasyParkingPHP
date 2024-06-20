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
            <title>view Current User for a Parking Lot</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        </head>
        <body>
            <h2 style="text-align: center">Current Active Users</h2>

            <!-- list current parking -->
            <?php 
                
                if (isset($_GET["lotID"])){
                    $lotID = $_GET["lotID"];

                    try{
                        require_once("../classes/user.php");
    
                        $qRes = User::get_current_parking_user($lotID);
                        if ($qRes == false) {
                            echo "Ooops, no user is parking at this lot!";
                        } else {
                            while($row = $qRes -> fetch_assoc()) {
                                $Users[]=$row; 
                            }
                            $qRes -> free_result();
    
                            echo"<table width='100%' class='table-striped' >";
                            echo"<tr>";
                            echo"<th>First Name</th>";
                            echo"<th>Last Name</th>";
                            echo "<th>Phone</th>";
                            echo "<th>Email</th>";
                            echo "<th>User Type</th>";
                            echo "<th>Check In Time</th>";
                            echo "<th>Action</th>";
                            echo "</tr>";
            
    
                            foreach($Users as $user) {
                                $uID = $user["UserID"];
                                
                                echo "<tr>";
                                //todo: to change the name HistroyID to ParkingID
                                echo "<td>". htmlentities($user['FirstName']) ."</td>";
                                echo "<td>". htmlentities($user["LastName"]) ."</td>";
                                echo "<td>". htmlentities($user["Phone"]) ."</td>";
                                echo "<td>". htmlentities($user["Email"]) ."</td>";
                                echo "<td>". htmlentities($user["UserType"]) ."</td>";
                                echo "<td>". htmlentities($user["CheckInTime"]) ."</td>";
                                echo "<td> <a href='currentUsers.php?uID=$lotID'> Check Out for User</td>";
                                echo "</tr>";
                            }
    
                            echo"</table>";
    
                        }
                    } catch(mysqli_sql_exception $e){ 
                        echo "".$e->getMessage()."";
                    }
                }
            ?>
        </body>  
    </html>

<?php
    }
    include_once("../includes/footer.php");
?>