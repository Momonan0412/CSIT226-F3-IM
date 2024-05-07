<?php
    include 'header.php';
    include 'connect.php';    
    if (!isset($_COOKIE['user_id']) && !isset($_COOKIE['username'])) {
        header("Location: login.php?please_login_or_create_account");
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
                            window.location.href = 'book.php';
                        }
                    });
              </script>";
    }
    
    ?>
    <div class="center-container">
            <div class="">
                <p> <b> <?php echo $_SESSION["ExistingUserAccountUsername"]?> </b> have successfully logged in.</p>
                <p>  Account Identification <b> <?php echo $_SESSION["ExistingUserAccountID"]?> </b> </p>
                <p> <a href="book.php">Go Back!</a></p> 
            </div>
        </div>
    <?php
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
        <h2 style="text-align: center;">Request</h2>
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
            <tr>
                <td>
                    <form action="" method="POST">
                        <button>Delete Request</button>
                    </form>
                </td>
            </tr>
        </table>
        <?php
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
        $query = "DELETE FROM `dbchuaf3`.`tblcustomer` WHERE `tblcustomer`.`accountID` = ?";
        $stmt = $mysqli->prepare($query);
        if(!$stmt) {
            throw new Exception("Error preparing SQL statement: " . $mysqli->error);
        }
        $stmt->bind_param("i", $_SESSION["ExistingUserAccountID"]);
        if(!$stmt->execute()) {
            throw new Exception("Error executing SQL statement: " . $stmt->error);
        }
        displaySweetAlert("Success", "Request Deleted!", "Go back and make another request!");
        $stmt->close();
    }
    ?>
    <?php include "footer.php" ?>