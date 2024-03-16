<?php
    include 'connect.php';
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
                        window.location.href = 'success.php';
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    </head> 
    <body>
        <div class="wrapper">
            <form method="post">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username">
                    <i class='bx bxs-user' ></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password">
                    <i class='bx bxs-lock' ></i>
                </div>
                <button type="submit" name="submit" class="btn">Login</button>
                <div class="login-link">
                   <p>Don't have an account? <a href="register.php">Register</a></p> 
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
        $_SESSION["ExistingUserName"] = $uname;
        $_SESSION["ExistingUserPass"] = $pword;
        
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
        } else{
            displaySweetAlert1("warning", "Input Error", "Type Og Tarung Chuy!");
        }
    } catch (Exception $e) {
        // Handle exception
        displaySweetAlert1("error", "Error", $e->getMessage());
    }
}
?>
