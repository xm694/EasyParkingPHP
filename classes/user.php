<?php
class User
{
    private $id;
    private $fname;
    private $lname;
    private $phone;
    private $email;
    private $u_name;
    private $user_pw;
    private $userType;

    public function __construct($fname, $lname, $phone, $email, $u_name, $user_pw, $userType)
    {
        $this->fname = $fname;
        $this->lname = $lname;
        $this->phone = $phone;
        $this->email = $email;
        $this->u_name = $u_name;
        $this->user_pw = md5($user_pw);
        $this->userType = $userType;
    }

    private static function conn()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "EasyParking";
    
        try{
        $conn = new mysqli($servername, $username, $password, $dbname);
        $message = "Connection to database successful!";
        echo"<script type=text/javascript> console.log('$message');</script>";
        }
        catch(mysqli_sql_exception $e){
        die($e -> getCode() ."". $e ->getMessage()); 
        }
        return $conn;
    }

    public function register()
    {
        //include("../includes/db_config.php");
        $conn = $this->conn();

        //check if username or email already exist
        $sql = "SELECT * FROM users WHERE Username='$this->u_name' OR Email = '$this->email' LIMIT 1";
        $result = $conn -> query($sql);
        $row = $result -> fetch_assoc();
        if ($row) {
            if ($row["Email"] == $this->email) {
                $conn->close();
                echo "Email already exists";
                return false;
            }
            if ($row["Username"] == $this->u_name) {
                $conn->close();
                echo "Username alredy exists.";
                return false;
            }
        }

        //insert new user into database
        $sql = "INSERT INTO users (FirstName, LastName, Phone, Email, Username, Password, UserType)
                VALUES ('$this->fname', '$this->lname', '$this->phone', '$this->email', '$this->u_name', '$this->user_pw', '$this->userType')";
        $result = $conn -> query($sql);
        if ($result) {
            $conn->close();
            return true;
        } else {
            $conn -> close();
            return false;
        }
    } 
 
    //registered user login
    public static function login($email, $user_pw)
    {
        //include("../includes/db_config.php");
        $conn = self :: conn();

        //authentication and validation
        $user_pw = md5($user_pw);
        $stmt = $conn -> prepare("SELECT * FROM users WHERE Email=? AND Password = ?");
        $stmt -> bind_param("ss", $email, $user_pw);
        $stmt -> execute();
        $qRes = $stmt -> get_result();
        $rowNum = $qRes->num_rows;
        if ($rowNum == 0) {
            $stmt->close();
            $conn->close();
            return false;
        }
        else{
            $stmt->close();
            $conn->close();
            return ['success'=> true, 'result'=> $qRes];
        }

    }

    public static function logout()
    {
        session_start();
        $_SESSION = array();
        session_destroy();
        // Redirect to the login page:
        header('Location: ../index.php');
        exit();
    }

    public static function userExists($u_id, $lname)
    {
        //include("../includes/db_config.php");
        $conn = self :: conn();

        $sql = "SELECT * FROM users WHERE UserID=$u_id and LastName='$lname'";
        $result = $conn -> query($sql);
        if ($result->num_rows > 0) {
            $conn->close();
            return true;
        } else{
            $conn->close();
            return false;
        }
    }


    public static function get_all_users()
    {
        //include("../includes/db_config.php");
        $conn = self :: conn();

        $sql = "SELECT * FROM users";
        $result = $conn -> query($sql);
        if ($result->num_rows > 0) {
            $conn->close();
            return $result;
        } else{
            $conn->close();
            return false;
        }
    }


    public static function get_current_parking_user($locationID)
    {
        //include("../includes/db_config.php");
        $conn = self :: conn();

        $sql="SELECT
                u.UserID,
                u.FirstName,
                u.LastName,
                u.Phone,
                u.Email,
                up.CheckInTime,
                u.UserType
            FROM UserParkingHistory up 
            JOIN Users u ON up.UserID = u.UserID
            WHERE up.LocationID = $locationID AND up.CheckOutTime IS NULL";
        $result = $conn -> query($sql);
        if ($result->num_rows > 0) {
            $conn->close();
            return $result;
        } else{
            $conn->close();
            return false;
        }
    }



    /*
    public static function updateProfile($name, $surname, $phone, $email)
    {
        // Code to update user profile
    }

    public static function changePassword($oldPassword, $newPassword)
    {
        // Code to change user password
    } */
}

?>