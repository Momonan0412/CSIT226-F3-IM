<?php
function insertRoomRequest($mysqliConnection, $customerIdentification, $requestID) {
    $queryToDatabase = "INSERT INTO tblroomrequest (customerID, requestID) VALUES (?, ?);";
    $stmt = $mysqliConnection->prepare($queryToDatabase);
    if (!$stmt) {
        throw new Exception("Error preparing SQL statement: " . $mysqliConnection->error);
    }
    $stmt->bind_param("is", $customerIdentification, $requestID);
    if (!$stmt->execute()) {
        throw new Exception("Error executing SQL statement: " . $stmt->error);
    }
    $stmt->close();
}
function insertCustomer($mysqliConnection, $customerPaymentMethod, $userProfileIdentification, $userAccountIdentification) {
    $queryToDatabase = "INSERT INTO tblcustomer (accountID, profileID, payment) VALUES (?, ?, ?);";
    $stmt = $mysqliConnection->prepare($queryToDatabase);
    if (!$stmt) {
        throw new Exception("Error preparing SQL statement: " . $mysqliConnection->error);
    }
    $stmt->bind_param("iis", $userAccountIdentification, $userProfileIdentification, $customerPaymentMethod);
    if (!$stmt->execute()) {
        throw new Exception("Error executing SQL statement: " . $stmt->error);
    }
    $stmt->close();
}
function userProfileIdentificationGetter($mysqliConnection, $userAccountIdentification){
    $queryToDatabase = "SELECT (userid) FROM tbluserprofile WHERE acctid = ?;";
    $stmt = $mysqliConnection->prepare($queryToDatabase);
    if (!$stmt) {
        throw new Exception("Error preparing SQL statement: " . $mysqliConnection->error);
    }
    $stmt->bind_param("i", $userAccountIdentification);
    if (!$stmt->execute()) {
        throw new Exception("Error executing SQL statement: " . $stmt->error);
    }
    $result = $stmt->get_result();
    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $_SESSION["ExistingUserProfileID"] = $row['userid'];
    }
    $stmt->close();
}
function getUserCustomerStatus($mysqli, $accountID, $userStatus) {
    $queryToDatabase = "SELECT * FROM tblcustomer WHERE accountID = ? AND isActive = ?";
    $stmt = $mysqli->prepare($queryToDatabase);
    if (!$stmt) {
        throw new Exception("Error preparing SQL statement: " . $mysqli->error);
    }
    $stmt->bind_param("ii", $accountID, $userStatus);
    if (!$stmt->execute()) {
        throw new Exception("Error executing SQL statement: " . $stmt->error);
    }
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}
function getUserRoomRequestStatus($mysqli, $customerIdentification, $userRequestStatus) {
    $queryToDatabase = "SELECT * FROM tblroomrequest WHERE customerID = ? and isCurrentRequest = ?";
    $stmt = $mysqli->prepare($queryToDatabase);
    if (!$stmt) {
        throw new Exception("Error preparing SQL statement: " . $mysqli->error);
    }
    $stmt->bind_param("ii", $customerIdentification, $userRequestStatus);
    if (!$stmt->execute()) {
        throw new Exception("Error executing SQL statement: " . $stmt->error);
    }
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}
function getUserData($mysqli, $accountId, $isActive, $isCurrentRequest) {
    $sql = "SELECT 
    ua.username, 
    up.firstname, 
    up.lastname, 
    up.gender, 
    c.payment, 
    r.room_type, 
    r.bed,
    r.quality, 
    r.capacity, 
    r.bathroom, 
    r.meal, 
    r.room_size,
    ua.emailadd, 
    c.room_assigned, 
    rr.isApprove
FROM 
    tbluseraccount AS ua
JOIN 
    tbluserprofile AS up ON ua.acctid = up.acctid
LEFT JOIN 
    tblcustomer AS c ON ua.acctid = c.accountID
LEFT JOIN 
    tblroomrequest AS rr ON c.customerID = rr.customerID
LEFT JOIN 
    tblrequest AS r ON rr.requestID = r.requestID
WHERE 
    ua.acctid = ? 
    AND c.isActive = ? 
    AND rr.isCurrentRequest = ?";


    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error preparing SQL statement: " . $mysqli->error);
        exit();
    }

    $stmt->bind_param("iii", $accountId, $isActive, $isCurrentRequest);
    if (!$stmt->execute()) {
        echo "Error executing SQL statement: " . $stmt->error;
        exit();
    }

    return $stmt->get_result();
}
function updateRoomRequest($mysqli, $customerId, $isCurrentRequest) {
    $query = "UPDATE tblroomrequest SET isCurrentRequest = ? WHERE customerID = ?";
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        throw new Exception("Error preparing SQL statement: " . $mysqli->error);
    }

    $stmt->bind_param("ii", $isCurrentRequest, $customerId);
    if (!$stmt->execute()) {
        throw new Exception("Error executing SQL statement: " . $stmt->error);
    }

    $stmt->close();
}
// `room_type` varchar(255),
// `beds` varchar(255),
// `quality` varchar(255),
// `capacity` varchar(255),
// `bathrooms` varchar(255),
// `meal` varchar(255),
// `room_size` varchar(255),
function insertRequest($mysqliConnection, $room_type, $bed, $quality, $capacity, $bathroom, $meal, $room_size){
    $queryToDatabase = "INSERT INTO tblrequest (room_type, bed, quality, capacity, bathroom, meal, room_size) VALUES (?,?,?,?,?,?,?)";
    
    $stmt = $mysqliConnection->prepare($queryToDatabase);
    if (!$stmt) {
        throw new Exception("Error preparing SQL statement: " . $mysqliConnection->error);
    }
    $stmt->bind_param("sssssss", $room_type, $bed, $quality, $capacity, $bathroom, $meal, $room_size);
    if (!$stmt->execute()) {
        throw new Exception("Error executing SQL statement: " . $stmt->error);
    }
    // Get the primary key value of the inserted row
    $primaryKey = $mysqliConnection->insert_id;
    
    $stmt->close();
    
    // Return the primary key value
    return $primaryKey;
}
?>
