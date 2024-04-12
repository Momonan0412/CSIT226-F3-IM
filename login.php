<?php
    include 'connect.php';
    include 'header.php';
    function displaySweetAlert1($icon, $title, $message) {
        echo "<script>
                console.log('$title');
                Swal.fire({
                    icon: '$icon',
                    title: '$title',
                    text: '$message',
                }).then((result) => {
                    if ('$title' === 'Login Successful!') {
                        console.log('Redirecting to login page');
                        window.location.href = 'book.php';
                    }
                });
            </script>";
    }
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BookNStay | Register Page</title> 
        <link rel="stylesheet" href="css/register.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head> 
    <body>
        <div class="container">
            <form method="post" >
                <div  class="dropdown-container">
                <h1>Login</h1>
                    <div class="form-group">
                        <input type="text" name="username" placeholder="Username">
                        <i class='bx bxs-user' ></i>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password">
                        <i class='bx bxs-lock' ></i>
                    </div>
                    <button type="submit" name="submit">Login</button>
                    <div class="login-link">
                    <p>Don't have an account? <a href="register.php">Register</a></p> 
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>

<?php	 
if(isset($_POST['submit'])){
    try {
        $uname = $_POST['username'];
        $pword = $_POST['password'];
        // echo $uname . " " . $pword;

        // TO ENSURE THAT NOBODY CAN ACCESS THE SUCCESS.PHP
        
        // Prepare and execute SQL statement
        $sql = "SELECT * FROM tbluseraccount WHERE username = ?";
        $stmt = $mysqli->prepare($sql);
        if(!$stmt) {
            throw new Exception("Error preparing SQL statement: " . $mysqli->error);
        }
        $stmt->bind_param("s", $uname);
        if(!$stmt->execute()) {
            throw new Exception("Error executing SQL statement: " . $stmt->error);
        }
        
        // Get result
        $result = $stmt->get_result();
        echo "<script>
            console.log('outisde result');
            </script>";
        
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $hashedPasswordFromDB = $row['password'];
            // Verify the password
            echo "<script>console.log('Retrieved Password: $hashedPasswordFromDB');</script>";
            echo "<script>
                console.log('Password verification result:', " . (password_verify($pword, $hashedPasswordFromDB) ? 'true' : 'false') . ");
                </script>";

            try {
                if(password_verify($pword, $hashedPasswordFromDB)){
                    
                    // Assign session variables
                    $_SESSION["ExistingUserAccountID"] = $row['acctid'];
                    $_SESSION["ExistingUserAccountUsername"] = $row['username'];

                    // Set cookies
                    setcookie('user_id', $_SESSION["ExistingUserAccountID"], time() + 3600, '/');
                    setcookie('username', $_SESSION["ExistingUserAccountUsername"], time() + 3600, '/');

                    echo "<script>
                    console.log('inside password_verify');
                    </script>";
                    // Password is correct, login successful
                    displaySweetAlert1("success", "Login Successful!", "Welcome!");
                } else {
                    // Password is incorrect
                    displaySweetAlert1("warning", "Input Error", "Incorrect username or password!");
                }
            } catch (Exception $e) {
                throw new Exception("Error verifying password: " . $e->getMessage());
            }
        } else {
            displaySweetAlert1("warning", "Input Error", "Type Og Tarung Chuy!");
        }
    } catch (Exception $e) {
        // Handle exception
        displaySweetAlert1("error", "Error", $e->getMessage());
    }
}
?>
