<?php
    include 'header.php';
    include 'connect.php';    
    if ($_SESSION["ExistingUserAccountUsername"] !== "Admin") {
        header("Location: book.php");
    }
    function displaySweetAlert($icon, $title, $message) {
        echo "<script>
                console.log('SweetAlert function called');
                Swal.fire({
                    icon: '$icon',
                    title: '" . addslashes($title) . "',
                    text: '" . addslashes($message) . "',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'admin.php';
                        }
                    });
            </script>";
    }
    
    ?>
    <div class="center-container">
    <div class="">
        <p> <b> <?php echo $_SESSION["ExistingUserAccountUsername"]?> </b> have successfully logged in.</p>
        <!-- <p>  Account Identification <b> <?php echo $_SESSION["ExistingUserAccountID"]?> </b> </p> -->
        <!-- <p> <a href="book.php">Go Back!</a></p>  -->
    </div>
    </div>
    <table>
        <tr>
        <th>
            <form action="active_request.php" method="GET">
                <button type="submit">GO TO ACTIVE REQUEST</button>
            </form>
        </th>
        <th>
            <form action="view_inactive_users.php" method="GET">
                <button type="submit">VIEW INACTIVE ALL USERS</button>
            </form>
        </th>
        <th>
            <form action="view_active_users.php" method="GET">
                <button type="submit">VIEW ACTIVE ALL USERS</button>
            </form>
        </th>
        </tr>
    </table>
    <?php
    // $_SESSION["ExistingUserAccountID"] and $_SESSION["newlyRegisteredCustomerID"]
    $sql = "SELECT tbluseraccount.username, tbluserprofile.firstname, tbluserprofile.lastname, 
            tbluserprofile.gender, tblcustomer.payment, tblroomrequest.request, tbluseraccount.emailadd,
            tblcustomer.room_assigned, tblroomrequest.isApprove, tblcustomer.customerID, tblroomrequest.requestID
            FROM tbluseraccount
            JOIN tbluserprofile ON tbluseraccount.acctid = tbluserprofile.acctid
            LEFT JOIN tblcustomer ON tbluseraccount.acctid = tblcustomer.accountID
            LEFT JOIN tblroomrequest ON tblcustomer.customerID = tblroomrequest.customerID
            WHERE tblroomrequest.isCurrentRequest = ?;";
    $stmt = $mysqli->prepare($sql);
    if(!$stmt) {
        throw new Exception("Error preparing SQL statement: " . $mysqli->error);
    }
    $isActive = 0;
    $stmt->bind_param("i", $isActive);
    if(!$stmt->execute()) {
        throw new Exception("Error executing SQL statement: " . $stmt->error);
    }
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
        ?>
        <h2 style="text-align: center;">Inactive Request <?php echo $row['username']; ?></h2>
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
            <!-- <tr>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="requestID" value="<?php echo $row['requestID']; ?>">
                        <button >Delete Request</button> 
                    </form>
                </td>
            </tr> -->
        </table>
        <?php
        }
    } else {
        ?>
        <table>
            <tr>
                <td>
                    Empty!
                </td>
            </tr>
        </table>
        <?php
    }
    $stmt->close();
?>
<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['requestID']) && !empty($_POST['requestID'])){
            $requestID = $_POST['requestID'];
            echo "<script>console.log('REQUEST ID! " . $_POST["requestID"] . "')</script>";
            $query = "UPDATE tblroomrequest SET isCurrentRequest = ? WHERE requestID = ?";
            $stmt = $mysqli->prepare($query);
            if (!$stmt) {
                throw new Exception("Error preparing SQL statement: " . $mysqli->error);
            }
            $updateCol = 0;
            $stmt->bind_param("ii", $updateCol, $requestID);
            if (!$stmt->execute()) {
                throw new Exception("Error executing SQL statement: " . $stmt->error);
            }
            $stmt->close();
        }
        if(isset($_POST['customerID']) && !empty($_POST['customerID'])){
        }
    }
    ?>
    <?php include "footer.php" ?>
<script>    
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>