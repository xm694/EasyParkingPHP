<?php 
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>New User Register</title>
    </head>

    <body>
        <?php 

        if (isset($_POST["submit"])) {
            $error = 0;
            $fname = stripslashes($_POST["fname"]);
            $lname = stripslashes($_POST["lname"]);
            $phone = stripslashes($_POST["phone"]);
            $email = stripslashes($_POST["email"]);
            $u_name = stripslashes($_POST["username"]);
            $user_pw = stripslashes($_POST["user_pw"]);
            $userType = $_POST["userType"];

            //user input validation
            if (empty($email)) {
                 ++ $error;
                 echo "<p>Email is required </p>";
            }
            else {
                if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email) == 0) {
                    ++ $error;
                    echo "<p>Email address is not valid.</p>";
                    $email = "";
                }
            }
            if (empty($fname)) {
                ++ $error;
                echo "<p>First name is required. </p>";
            }
            if (empty($lname)) {
                ++ $error;
                echo "<p>Last name is required. </p>";
            }
            if (empty($phone)) {
                ++ $error;
                echo "<p>Contact number is required. </p>";
            } 
            else {
                if (preg_match("/^(?:\+?61|0)[2-478][0-9]{8}$/", $phone) == 0) {
                    ++ $error;
                    echo "<p>Please enter a valid Australian phone number.</p>";
                    $phone = "";
                }


            if (empty($u_name)) {
                ++ $error;
                echo "<p>User name is required.</p>";
            }
            if (empty($user_pw)) {
                ++ $error;
                echo "<p>Password is required. </p>";
            }
        }

        //use OOP register()
        require_once("../classes/user.php");

        if ($error == 0) {
            try{
                $user = new User($fname, $lname, $phone, $email, $u_name, $user_pw, $userType);

                if ($user->register()) {
                    $_SESSION['alert_msg'] = "Registration succeed! Welcom $u_name!";
                    header("location:../index.php");
                } else {
                    echo "Something went wrong during registration, please go back and try again.";
                }
            }
            catch (mysqli_sql_exception $e) {
                die("Error creating new user: " . $e->getCode(). ": " . $e->getMessage());}
        }
    }










/*    
        if ($error == 0) {
            try {
                include_once("../includes/db_config.php");

                //check if username or email already exist
                $sql = "SELECT * FROM users WHERE Username='$u_name' OR Email = '$email' LIMIT 1";
                $result = $conn -> query($sql);
                $row = $result -> fetch_assoc();
                if ($row) {
                    if ($row["Username"] == $u_name) {
                        ++ $error;
                        echo "Username alredy exits.";
                    }
                    if ($row["Email"] == $email) {
                        ++ $error;
                        echo "Email already exits.";
                    }
                }
            }
            catch (mysqli_sql_exception $e) {
                echo "$e->getCode(). ':' .$e->getMessage()";
                ++ $error;
            }
        }

        if ($error > 0) {
            echo "Something went wrong during registration, please go back and try again.";
        }

        if ($error == 0) {
            try {
                $user_pw = md5($user_pw);
                $sql = "INSERT INTO users (FirstName, LastName, Phone, Email, Username, Password, UserType)
                        VALUES ('$fname', '$lname', '$phone', '$email', '$u_name', '$user_pw', '$userType')";
                $result = $conn -> query($sql);
                $conn -> close();

                header("location:../index.php");
                $_SESSION['alert_msg'] = "Registration succeed! Welcom $u_name!";
            }  
            catch (mysqli_sql_exception $e) {
                die("Error creating new user: " . $e->getCode(). ": " . $e->getMessage());}
        }
*/
        ?>
    </body>
</html>