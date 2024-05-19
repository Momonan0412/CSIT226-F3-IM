<?php
// # ChatGPT
// Secure session configuration
// Set session cookie to be sent only over HTTPS connections, enhancing security.
ini_set('session.cookie_secure', 1);
// Prevent JavaScript from accessing the session cookie, reducing the risk of XSS attacks.
ini_set('session.cookie_httponly', 1);
// Ensure sessions are maintained only via cookies, mitigating the risk of session fixation attacks.
ini_set('session.use_only_cookies', 1);
// Set session cookie expiration time to one day, reducing the window of opportunity for session hijacking.
session_set_cookie_params(86400);
try{
    session_start();
    
    $user = "root";
    $password = "";
    $host = "localhost";
    $port = 3307;
    $dbname = "dbchuaf3";
    
    $mysqli = new mysqli($host, $user, $password, $dbname, $port);
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    
    $createThree = "CREATE TABLE IF NOT EXISTS `dbchuaf3`.`tbluseraccount` (
        `acctid` int(11) NOT NULL AUTO_INCREMENT,
        `emailadd` varchar(50) NOT NULL,
        `username` varchar(50) NOT NULL,
        `password` varchar(255) NOT NULL,
        `usertype` varchar(50) NOT NULL,
        PRIMARY KEY (`acctid`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    $mysqli->query($createThree);
    
    $createFour = "CREATE TABLE IF NOT EXISTS `dbchuaf3`.`tbluserprofile` (
        `userid` int(11) NOT NULL AUTO_INCREMENT,
        `acctid` int(11) NOT NULL,
        `firstname` varchar(50) NOT NULL,
        `lastname` varchar(50) NOT NULL,
        `gender` varchar(50) NOT NULL,
        PRIMARY KEY (`userid`),
        FOREIGN KEY (`acctid`) REFERENCES `dbchuaf3`.`tbluseraccount`(`acctid`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    $mysqli->query($createFour);
    
    $createOne = "CREATE TABLE IF NOT EXISTS `dbchuaf3`.`tblcustomer` (
        `customerID` int(11) NOT NULL AUTO_INCREMENT,
        `accountID` int(11) NOT NULL,
        `profileID` int(11) NOT NULL,
        `room_assigned` varchar(255) NOT NULL DEFAULT 'No Room Assigned',
        `payment` varchar(255) NOT NULL DEFAULT 'Payment Not Set',
        `isActive` tinyint(1) NOT NULL DEFAULT 1,
        PRIMARY KEY (`customerID`),
        FOREIGN KEY (`profileID`) REFERENCES `dbchuaf3`.`tbluserprofile`(`userid`) ON DELETE RESTRICT,
        FOREIGN KEY (`accountID`) REFERENCES `dbchuaf3`.`tbluseraccount`(`acctid`) ON DELETE RESTRICT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    $mysqli->query($createOne);
    $createFive = "CREATE TABLE IF NOT EXISTS `dbchuaf3`.`tblrequest` (
        `requestID` int(11) NOT NULL AUTO_INCREMENT,
        `room_type` varchar(255),
        `bed` varchar(255),
        `quality` varchar(255),
        `capacity` varchar(255),
        `bathroom` varchar(255),
        `meal` varchar(255),
        `room_size` varchar(255),
        PRIMARY KEY (`requestID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    $mysqli->query($createFive);
    $createTwo = "CREATE TABLE IF NOT EXISTS `dbchuaf3`.`tblroomrequest` (
        `roomrequestID` int(11) NOT NULL AUTO_INCREMENT,
        `customerID` int(11) NOT NULL,
        `requestID` int(11) NOT NULL,
        `isApprove` tinyint(1) NOT NULL DEFAULT 0,
        `isCurrentRequest` tinyint(1) NOT NULL DEFAULT 1,
        PRIMARY KEY (`roomrequestID`),
        FOREIGN KEY (`customerID`) REFERENCES `dbchuaf3`.`tblcustomer`(`customerID`) ON DELETE CASCADE,
        FOREIGN KEY (`requestID`) REFERENCES `dbchuaf3`.`tblrequest`(`requestID`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    $mysqli->query($createTwo);

}catch(Exception $e){
    echo "An error occurred: " . $e->getMessage();
}
?>