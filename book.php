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
                    text: '" . addslashes($message) . "'
                });
            </script>";
    }
    
?>
<body>
    <div class="center-container">
        <div class="container3D">
            <p> <b> <?php echo $_SESSION["ExistingUserAccountUsername"]?> </b> have successfully logged in.</p>
            <p>  Account Identification <b> <?php echo $_SESSION["ExistingUserAccountID"]?> </b> </p>
            <p> Check your Information here <a href="request.php">Information</a></p> 
        </div>
    </div>
    <div class="container">
    <form action="" method="post">
        
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
    
    $sqlOne = "SELECT (accountID) FROM tblcustomer WHERE accountID = ? "; // ? is the acctid
    $stmt = $mysqli->prepare($sqlOne);
    
    echo "<script>console.log('debugging 1....')</script>";
    if(!$stmt) {
        throw new Exception("Error preparing SQL statement: " . $mysqli->error);
    }
    echo "<script>console.log('debugging 2....')</script>";
    $stmt->bind_param("i", $_SESSION["ExistingUserAccountID"]);
    if(!$stmt->execute()) {
        throw new Exception("Error executing SQL statement: " . $stmt->error);
    }
    
    echo "<script>console.log('debugging 3....')</script>";
    $result = $stmt->get_result();
    if($result->num_rows == 1){
        echo "<script>console.log('debugging 4....')</script>";
        displaySweetAlert("error", "Request Already Submitted", "You have already submitted a request. Please wait for it to be approved before submitting another one.");
        $stmt->close();  
        return;
    }
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
    
    // Echo the concatenated string for testing
    // echo $request;
    // echo $payment;
    
    // Get the foreign keys of table account and profile
    $sqlOne = "SELECT (userid) FROM tbluserprofile WHERE acctid = ? "; // ? is the acctid
    $stmtOne = $mysqli->prepare($sqlOne);
    if(!$stmtOne) {
        throw new Exception("Error preparing SQL statement: " . $mysqli->error);
    }
    $stmtOne->bind_param("i", $_SESSION["ExistingUserAccountID"]);
    if(!$stmtOne->execute()) {
        throw new Exception("Error executing SQL statement: " . $stmtOne->error);
    }
    $result = $stmtOne->get_result();
    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $userid = $row['userid'];
        $_SESSION["ExistingUserProfileID"] = $userid;
        // echo $userid;
    }
    $stmtOne->close();  
    // Insert Data
    $sqlTwo = "INSERT INTO tblcustomer (accountID, profileID, payment) VALUES (?, ?, ?)";
    $stmtTwo = $mysqli->prepare($sqlTwo);
    if(!$stmtTwo) {
        throw new Exception("Error preparing SQL statement: " . $mysqli->error);
    }
    $stmtTwo->bind_param("iis", $_SESSION["ExistingUserAccountID"], $_SESSION["ExistingUserProfileID"], $payment);
    if(!$stmtTwo->execute()) {
        throw new Exception("Error executing SQL statement: " . $stmtTwo->error);
    }
    //GET THE tblCustomer's PRIMARY KEY HERE
    $_SESSION["newlyRegisteredCustomerID"]= $mysqli->insert_id;
    $stmtTwo->close();
    
    
    $sqlThree = "INSERT INTO tblroomrequest (customerID, request) VALUES (?, ?)";
    $stmtThree = $mysqli->prepare($sqlThree);
    if(!$stmtThree) {
        throw new Exception("Error preparing SQL statement: " . $mysqli->error);
    }
    $stmtThree->bind_param("is", $_SESSION["newlyRegisteredCustomerID"], $request);
    if(!$stmtThree->execute()) {
        throw new Exception("Error executing SQL statement: " . $stmtThree->error);
    }
    $stmtThree->close();
    
}
?>

<?php include "footer.php" ?>