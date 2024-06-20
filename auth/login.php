<?php
session_start();

    if (isset($_POST["submit"])){
        //get user input
        $email = stripcslashes($_POST["email"]);
        $user_pw = stripcslashes($_POST["user_pw"]);

        //validate user input
        if (empty($email) || empty($user_pw)){
            echo"Username and passord is required.";}
        else{
            try{
                //user login
                require_once("../classes/user.php");

                $response = User::login($email, $user_pw);

                if ($response === false){
                    echo "The email and password combination is not correct, please try again!";
                }else{
                    $result = $response['result'];
                    $userData = $result -> fetch_assoc();
                    $user_id = $userData['UserID'];
                    $user_name = $userData['Username'];
                    $userType = $userData['UserType'];

                    //redirect to admin home page if is admin
                    if ($userType == "Admin") {
                        $_SESSION['Login_msg'] = "Welcome, $user_name";
                        $_SESSION["user_id"] = $user_id;
                        $_SESSION["user_name"] = $user_name;
                        $_SESSION["loggedin"] = true;
                        header("location:../admin/index.php");
                    }

                    //redirect to user home page if is user
                    if ($userType == "User") {
                        $_SESSION['Login_msg'] = "Welcome, $user_name";
                        $_SESSION["user_id"] = $user_id;
                        $_SESSION["user_name"] = $user_name;
                        $_SESSION["loggedin"] = true;
                        header("location:../users/index.php");
                    }
                }
            }  catch (mysqli_sql_exception $e) {
                die("Error creating new user: " . $e->getCode(). ": " . $e->getMessage());}

        }

    }

?>
