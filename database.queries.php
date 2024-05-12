<?php
function insertRoomRequest($mysqliConnection, $customerIdentification, $request) {
    $queryToDatabase = "INSERT INTO tblroomrequest (customerID, request) VALUES (?, ?);";
    $stmt = $mysqliConnection->prepare($queryToDatabase);
    if (!$stmt) {
        throw new Exception("Error preparing SQL statement: " . $mysqliConnection->error);
    }
    $stmt->bind_param("is", $customerIdentification, $request);
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
    $sql = "SELECT tbluseraccount.username, tbluserprofile.firstname, tbluserprofile.lastname, 
            tbluserprofile.gender, tblcustomer.payment, tblroomrequest.request, tbluseraccount.emailadd,
            tblcustomer.room_assigned, tblroomrequest.isApprove
            FROM tbluseraccount
            JOIN tbluserprofile ON tbluseraccount.acctid = tbluserprofile.acctid
            LEFT JOIN tblcustomer ON tbluseraccount.acctid = tblcustomer.accountID
            LEFT JOIN tblroomrequest ON tblcustomer.customerID = tblroomrequest.customerID
            WHERE tbluseraccount.acctid = ? AND tblcustomer.isActive = ? AND tblroomrequest.isCurrentRequest = ?;";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error preparing SQL statement: " . $mysqli->error);
    }

    $stmt->bind_param("iii", $accountId, $isActive, $isCurrentRequest);
    if (!$stmt->execute()) {
        throw new Exception("Error executing SQL statement: " . $stmt->error);
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
?>
