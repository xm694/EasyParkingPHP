<?php 
//create connection to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EasyParking";

try{
    $conn = new mysqli($servername, $username, $password, $dbname);
    $message = "Connection successful!";
    echo"<script type='text/javascript'> console.log('$message') </script>";
}
catch(mysqli_sql_exception $e){
    die($e->getCode(). ":". $e->getMessage());
}


//create instance for Users
$sql = "INSERT INTO Users (FirstName, LastName, Phone, Email, Username, Password, UserType)
VALUES
    ('John', 'Doe', '1234567890', 'john.doe@email.com', 'JoDo', MD5('password123'), 'User'),
    ('Jane', 'Smith', '9876543210', 'jane.smith@email.com', 'JaSS', MD5('password456'), 'User'),
    ('Admin', 'User', '5555555555', 'admin@email.com', 'Admin001', MD5('admin123'), 'Admin');";

try {
    $conn->query($sql);
    echo "Records for Users created successfully \n";
} catch (mysqli_sql_exception $e) {
    die("Error creating table: " . $e->getCode(). ": " . $e->getMessage());}


//create instance for parking locations
$sql = "INSERT INTO ParkingLocations (Location, Description, Capacity, CostPerHour)
        VALUES
            ('P1', 'Parking lot right at the front of student center', 50, 3.00),
            ('P2', 'Undercover parking next to student center', 200, 7.95),
            ('P3', 'Parking lot close to the main teaching building', 150, 3.00),
            ('P4', 'Parking lot for car pooling', 100, 3.00),
            ('P5', 'Parking lot near the sports area', 300, 3.00);";
try {
    $conn->query($sql);
    echo "Records for ParkingLocations created successfully \n";
} catch (mysqli_sql_exception $e) {
    die("Error creating table: " . $e->getCode(). ": " . $e->getMessage());
}

//create instance for UserParking
$sql = "INSERT INTO UserParkingHistory (UserID, LocationID, CheckInTime, CheckOutTime, TotalCost)
        VALUES
            (1, 1, '2023-05-19 08:30:00', '2023-05-19 11:45:00', 8.25),
            (2, 2, '2023-05-18 14:00:00', '2023-05-18 17:30:00', 6.13);";

try {
    $conn->query($sql);
    echo "Records for UserParking creted successfully \n";
} catch (mysqli_sql_exception $e) {
    die("Error creating table: " . $e->getCode(). ": " . $e->getMessage());
}

$conn -> close();   
?>