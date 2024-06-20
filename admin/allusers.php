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
            <title>view all users</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        </head>
        <body>
            <h2 style="text-align: center">View All Users</h2>

            <!-- list current parking -->
            <?php 
                
                try{
                    require_once("../classes/user.php");

                    $qRes = User::get_all_users();
                    if ($qRes == false) {
                        echo "Ooops, no registered user yet!";
                    } else {
                        while($row = $qRes -> fetch_assoc()) {
                            $users[]=$row; 
                        }
                        $qRes -> free_result();

                        echo"<table width='100%' class='table-striped' >";
                        echo"<tr>";
                        echo"<th>UserID</th>";
                        echo"<th>First Name</th>";
                        echo "<th>Last Name</th>";
                        echo "<th>Phone</th>";
                        echo "<th>Email</th>";
                        echo "<th>User Type</th>";
                        echo "</tr>";
        

                        foreach($users as $user) {
                            echo "<tr>";
                            //todo: to change the name HistroyID to ParkingID
                            echo "<td>". htmlentities($user['UserID']) ."</td>";
                            echo "<td>". htmlentities($user["FirstName"]) ."</td>";
                            echo "<td>". htmlentities($user["LastName"]) ."</td>";
                            echo "<td>". htmlentities($user["Phone"]) ."</td>";
                            echo "<td>". htmlentities($user["Email"]) ."</td>";
                            echo "<td>". htmlentities($user["UserType"]) ."</td>";
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