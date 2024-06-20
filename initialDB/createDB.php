<?php

$servername = "localhost";
$username = "root";
$password = "";


//create connection
try{
    $conn = new mysqli($servername, $username, $password);
    echo "<p>Connection successful</p>\n";
}
catch (mysqli_sql_exception $e)
{
    die ($e->getCode(). ": " . $e->getMessage());
}

// Create database
$sql = "CREATE DATABASE EasyParking";

try {
    $conn->query($sql);
    echo "Database EasyParking created successfully";
} catch (mysqli_sql_exception $e) {
    die("Error creating table: " . $e->getCode(). ": " . $e->getMessage());}


// Select database
$conn->select_db("EasyParking");

// sql to create tables
//Create the Users table
$sql = "CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Phone VARCHAR(20) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    UserType ENUM('Admin', 'User') NOT NULL)";

try {
    $conn->query($sql);
    echo "Table Users created successfully";
} catch (mysqli_sql_exception $e) {
    die("Error creating table: " . $e->getCode(). ": " . $e->getMessage());}


//Create the ParkingLocations table
$sql = "CREATE TABLE ParkingLocations (
    LocationID INT AUTO_INCREMENT PRIMARY KEY,
    Location VARCHAR(100) NOT NULL,
    Description TEXT,
    Capacity INT NOT NULL,
    CostPerHour DECIMAL(10, 2) NOT NULL
)";

try {
    $conn->query($sql);
    echo "Table ParkingLocations created successfully";
} catch (mysqli_sql_exception $e) {
    die("Error creating table: " . $e->getCode(). ": " . $e->getMessage());}

//Create the UserParking table
$sql = "CREATE TABLE UserParkingHistory (
    HistoryID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT NOT NULL,
    LocationID INT NOT NULL,
    CheckInTime DATETIME NOT NULL,
    CheckOutTime DATETIME,
    TotalCost DECIMAL(10, 2),
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (LocationID) REFERENCES ParkingLocations(LocationID)
)";

try {
    $conn->query($sql);
    echo "Table UserParking created successfully";
} catch (mysqli_sql_exception $e) {
    die("Error creating table: " . $e->getCode(). ": " . $e->getMessage());}

// !!!!!IMPORTANT IF VIEW DID NOT CREATED, NEED TO DO IT MANUALLY
//THE SQL IS CORRECT, CANT FIGURE OUT WHY;
//create availability view
$sql = "CREATE VIEW ParkingLocationsWithAvailability AS
        SELECT
            PL.LocationID,
            PL.Location,
            PL.Description,
            PL.Capacity,
            PL.CostPerHour,
            (PL.Capacity - COALESCE((
                SELECT COUNT(*)
                FROM UserParkingHistory UPH
                WHERE UPH.LocationID = PL.LocationID
                AND UPH.CheckOutTime IS NULL
            ), 0)) AS AvailableSpots
        FROM
            ParkingLocations PL;";

try {
    $conn->query($sql);
    echo "View ParkingLocationsWithAvailability created successfully";
} catch (mysqli_sql_exception $e) {
    die("Error creating view: " . $e->getCode(). ": " . $e->getMessage());}


$conn -> close();

/*
//create a database roles
$sql = "CREATE ROLE 'admin'@'localhost', 'user'@'localhost';";

try {
    $conn->query($sql);
    echo "Database role admin and user created successfully";
} catch (mysqli_sql_exception $e) {
    die("Error creating table: " . $e->getCode(). ": " . $e->getMessage());}


//grant privileges based on different role
$sql = "GRANT ALL PRIVILEGES ON EasyParking.* TO 'admin'; 
        GRANT SELECT, INSERT, UPDATE ON EasyParking.UserParkingHistory TO 'user';
        GRANT SELECT ON EasyParking.ParkingLocations TO 'user';";

try {
    $conn->query($sql);
    echo "Database privileges granted successfully";
} catch (mysqli_sql_exception $e) {
    die("Error creating table: " . $e->getCode(). ": " . $e->getMessage());}
*/

?>