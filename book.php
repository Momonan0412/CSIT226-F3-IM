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
                    text: '" . addslashes($message) . "'
                });
            </script>";
    }
    
?>
<body>
    <div class="center-container">
        <div class="">
            <p> <b> <?php echo $_SESSION["ExistingUserAccountUsername"]?> </b> have successfully logged in.</p>
            <p>  Account Identification <b> <?php echo $_SESSION["ExistingUserAccountID"]?> </b> </p>
            <p> Check your Information <a href="request.php">here</a></p> 
        </div>
    </div>
    <div class="container">
    <form id="submitForm" action="" method="POST">
        
            <label for="payment">Room Preference:</label>
            <div  class="dropdown-container">
                <label for="room_type">Room Type:</label>
                <select class="selectHomepage" class="form-select" size="1" aria-label="size 1 select example"  name="room_type" id="room_type">
                    <option value="single">Single Room</option>
                    <option value="double">Double Room</option>
                    <option value="suite">Suite</option>
                    <!-- Add more options as needed -->
                </select>
                <label for="beds">Number of Beds:</label>
                <select class="selectHomepage" class="form-select" size="1" aria-label="size 1 select example"  name="beds" id="beds">
                    <option value="1">1 Bed</option>
                    <option value="2">2 Beds</option>
                    <option value="3">3 Beds</option>
                    <!-- Add more options as needed -->
                </select>
                <label for="quality">Quality:</label>
                <select class="selectHomepage" class="form-select" size="1" aria-label="size 1 select example"  name="quality" id="quality">
                    <option value="standard">Standard</option>
                    <option value="vip">VIP</option>
                    <!-- Add more options as needed -->
                </select>
                <label for="capacity">Capacity:</label>
                <select class="selectHomepage" class="form-select" size="1" aria-label="size 1 select example"  name="capacity" id="capacity">
                    <option value="1">1 Person</option>
                    <option value="2">2 Persons</option>
                    <option value="3">3 Persons</option>
                    <!-- Add more options as needed -->
                </select>
                <label for="bathrooms">Number of Bathrooms:</label>
                <select class="selectHomepage" class="form-select" size="1" aria-label="size 1 select example"  name="bathrooms" id="bathrooms">
                    <option value="1">1 Bathroom</option>
                    <option value="2">2 Bathrooms</option>
                    <option value="3">3 Bathrooms</option>
                    <!-- Add more options as needed -->
                </select>
            <label for="meal">Pay for Meal:</label>
            <select class="selectHomepage" class="form-select" size="1" aria-label="size 1 select example"  name="meal" id="meal">
                <option value="included">Included</option>
                <option value="not_included">Not Included</option>
                <!-- Add more options as needed -->
            </select>
            
            <label for="room_size">Room Size:</label>
            <select class="selectHomepage" class="form-select" size="1" aria-label="size 1 select example"  name="room_size" id="room_size">
                <option value="large">Large</option>
                <option value="small">Small</option>
                <!-- Add more options as needed -->
            </select>
        </div>
        <label for="payment">Payment Method:</label>
        <div  class="dropdown-container"> 
            <select class="selectHomepage" class="form-select" size="1" aria-label="size 1 select example"  name="payment" id="payment">
                <option value="credit_card">Credit Card</option>
                <option value="debit_card">Debit Card</option>
                <option value="paypal">PayPal</option>
            </select>
        </div>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Retrieve selected choices from the form
    $room_type = $_POST['room_type'];
    $beds = $_POST['beds'];
    $quality = $_POST['quality'];
    $capacity = $_POST['capacity'];
    $bathrooms = $_POST['bathrooms'];
    $meal = $_POST['meal'];
    $room_size = $_POST['room_size'];
    $payment = $_POST['payment'];   
    // Concatenate selected choices into a single string with spaces
    $request = "Room Type: $room_type, Number of Beds: $beds, Quality: $quality, Capacity: $capacity Person(s), Number of Bathrooms: $bathrooms,    Pay for Meal: $meal, Room Size: $room_size";
    $payment = "Mode of Payment: $payment";

    $userStatus = 1; 
    $result = getUserCustomerStatus($mysqli, $_SESSION["ExistingUserAccountID"], $userStatus);
    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $_SESSION["newlyRegisteredCustomerID"] = $row['customerID'];
        $result = getUserRoomRequestStatus($mysqli, $_SESSION["newlyRegisteredCustomerID"], $userStatus);
            if($result->num_rows == 1){
                echo "<script>console.log('debugging 4....')</script>";
                displaySweetAlert("error", "Request Already Submitted", "You have already submitted a request. Please wait for it to be approved before submitting another one.");
                return;
            }else{
                echo '<script>console.log("Debug: CREATING THE REQUEST! ANYTHING PARA NIYA UWU!");</script>';
            }
    } else {
        echo '<script>showConfirmation();</script>';
        echo '<script>console.log("Debug: 1... 2....3....!");</script>';
        // TODO: CREATE CUSTOMER AND ADD PAYMENT METHOD!
        try{
            userProfileIdentificationGetter($mysqli, $_SESSION["ExistingUserAccountID"]);
            insertCustomer($mysqli, $payment, $_SESSION["ExistingUserProfileID"], $_SESSION["ExistingUserAccountID"]);
            // insertRoomRequest($mysqli, $_SESSION["newlyRegisteredCustomerID"], $request);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    echo '<script>showConfirmation();</script>';
    echo '<script>console.log("Debug: 4... 5....6....!");</script>';
    // TODO: CREATE TBLREQUEST BASE SA CUSTOMER!
    try {
        insertRoomRequest($mysqli, $_SESSION["newlyRegisteredCustomerID"], $request);
        echo "Room request inserted successfully!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php include "footer.php" ?>

<script>
var roomType = document.getElementById("room_type").value;
var beds = document.getElementById("beds").value;
var quality = document.getElementById("quality").value;
var capacity = document.getElementById("capacity").value;
var bathrooms = document.getElementById("bathrooms").value;
var meal = document.getElementById("meal").value;
var roomSize = document.getElementById("room_size").value;
var payment = document.getElementById("payment").value;
    document.querySelector('input[type="submit"]').addEventListener('click', function(event){
        event.preventDefault();
        showConfirmation().then((result) => { 
            if (result === false) {
                // If the user cancels, do nothing
                console.log("User canceled");
            } else {
                // If the user confirms, submit the form
                document.getElementById("submitForm").submit();
            }
        });
    });
</script>