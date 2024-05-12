<?php
    include 'header.php';
    include 'connect.php'; 
    include 'database.queries.php';   
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
                <p> <a href="book.php">Go Back!</a></p> 
            </div>
        </div>
    <?php
    $isActive = 1;
    $isCurrentRequest = 1;
    $result = getUserData($mysqli, $_SESSION["ExistingUserAccountID"], $isActive, $isCurrentRequest);
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
?>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $updateCol = 0;
        updateRoomRequest($mysqli, $_SESSION["newlyRegisteredCustomerID"], $updateCol);
        displaySweetAlert("success", "Request Deleted!", "Go back and make another request!");
    }
?>
<?php include "footer.php" ?>