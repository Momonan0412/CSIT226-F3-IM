<?php
    include 'header.php';
    include 'connect.php';    
    if (!isset($_COOKIE['user_id']) && !isset($_COOKIE['username'])) {
        header("Location: login.php?please_login_or_create_account");
    }
    // $_SESSION["ExistingUserAccountID"] and $_SESSION["newlyRegisteredCustomerID"]
    $sql = "SELECT *
        FROM tbluseraccount
        JOIN tbluserprofile ON tbluseraccount.acctid = tbluserprofile.acctid
        JOIN tblcustomer ON tbluseraccount.acctid = tblcustomer.accountID
        JOIN tblroomrequest ON tblcustomer.customerID = tblroomrequest.customerID
        WHERE tbluseraccount.acctid = ? OR tblcustomer.customerID = ?";
    $stmt = $mysqli->prepare($sql);
    if(!$stmt) {
        throw new Exception("Error preparing SQL statement: " . $mysqli->error);
    }
    // Bind parameters
    $stmt->bind_param("ii", $_SESSION["ExistingUserAccountID"], $_SESSION["newlyRegisteredCustomerID"]);

    if(!$stmt->execute()) {
        throw new Exception("Error executing SQL statement: " . $stmt->error);
    }
    $result = $stmt->get_result();
    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        ?>
        <h2 style="text-align: center;">Information</h2>
        <table>
            <tr>
                <th>Room Assigned</th>
                <td><?php echo $row['room_assigned']; ?></td>
            </tr>
            <tr>
                <th>Payment</th>
                <td><?php echo $row['payment']; ?></td>
            </tr>
            <tr>
                <th>Request</th>
                <td><?php echo $row['request']; ?></td>
            </tr>
            <tr>
                <th>Is Approved</th>
                <td><?php echo $row['isApprove']; ?></td>
            </tr>
            <tr>
                <th>Email Address</th>
                <td><?php echo $row['emailadd']; ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?php echo $row['username']; ?></td>
            </tr>
            <tr>
                <th>First Name</th>
                <td><?php echo $row['firstname']; ?></td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td><?php echo $row['lastname']; ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><?php echo $row['gender']; ?></td>
            </tr>
        </table>
        <?php
    }
    
    
    $stmt->close();
?>
<?php include "footer.php" ?>