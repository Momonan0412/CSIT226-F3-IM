<?php    
    include 'connect.php';
    function displaySweetAlert($icon, $title, $message) {
        echo "<script>
                console.log('SweetAlert function called');
                Swal.fire({
                    icon: '$icon',
                    title: '$title',
                    text: '$message',
                }).then((result) => {
                    if ('$title' === 'You have registered successfully!.') {
                        console.log('Redirecting to login page');
                        window.location.href = 'login.php';
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
        <script>
        function togglePasswordVisibility(inputId) {
            var inputField = document.getElementById(inputId);
            if (inputField.type === "password") {
                inputField.type = "text";
            } else {
                inputField.type = "password";
            }
        }
    </script>
    </head> 
    <body>
        <div class="wrapper">
            <form method="post">
                <h1>REGISTER</h1>
                <div class="input-box">
                    <input type="text" name="firstname" placeholder="First name">
                    <i class='bx bxs-user' ></i>
                </div>
                <div class="input-box">
                    <input type="text" name="lastname" placeholder="Last name">
                    <i class='bx bxs-user' ></i>
                </div>
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username">
                    <i class='bx bxs-user' ></i>
                </div>
                <div class="input-box">
                    <input type="text" name="email" placeholder="Email">
                    <i class='bx bxs-user' ></i>
                </div>
                <div class="input-box">
                    <label>GENDER: </label>
                    <select name="gender">
                        <option value=""></option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="input-box">
                    <input type="password" id="password" name="password" placeholder="Password">
                    <i class='bx bxs-lock' ></i>
                    <button type="button" onclick="togglePasswordVisibility('password')">Show</button>
                </div>
                <div class="input-box">
                    <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm password"> 
                    <i class='bx bxs-lock'></i>
                    <button type="button" onclick="togglePasswordVisibility('confirmpassword')">Show</button>
                </div>
                <button type="submit" name="submit" class="btn">Register</button>
                <div class="login-link">
                <p>Already have an account? <a href="login.php">Login</a></p> 
                </div>
            </form>
        </div>
    </body>
</html>

<?php	 
	if(isset($_POST['submit'])){		
		$fname=$_POST['firstname'];		
		$lname=$_POST['lastname'];
		$gender=$_POST['gender'];
		
		$email=$_POST['email'];		
		$uname=$_POST['username'];

		$pword=$_POST['password'];
		$cpword=$_POST['confirmpassword'];

        if(empty($fname) || empty($lname) || empty($gender) ||
           empty($email) || empty($uname) || empty($pword)){
            displaySweetAlert("warning", "Input Error", "Please fill up all the inputs!");
            return;
        }
        $isValid = preg_match("/^[a-zA-Z0-9_]*$/", $uname);
        if (!$isValid) {
            displaySweetAlert("warning", "Invalid Username Error", "Please use another username!");
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            displaySweetAlert("warning", "Invalid Email Error", "Please input a valid Email!");
            return;
        }
		if($pword != $cpword){
            displaySweetAlert("warning", "Password Mismatch Error", "Check the password!");
            return;
        }
        // Check tbluseraccount if username is already existing. Save info if false. Prompt msg if true.
        $sql2 = "SELECT * FROM tbluseraccount WHERE username = ?";
        $stmt2 = $mysqli->prepare($sql2);
        $stmt2->bind_param("s", $uname);
        $stmt2->execute();
        $result = $stmt2->get_result();

        if($result->num_rows == 0){
            $hashedPassword = password_hash($pword, PASSWORD_DEFAULT);
            $sql = "INSERT INTO tbluseraccount (emailadd, username, password) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("sss", $email, $uname, $hashedPassword);
            $stmt->execute();
            $stmt->close();
                    // Save data to tbluserprofile
            $sql1 = "INSERT INTO tbluserprofile (firstname, lastname, gender) VALUES (?, ?, ?)";

            $stmt1 = $mysqli->prepare($sql1);
            $stmt1->bind_param("sss", $fname, $lname, $gender);
            $stmt1->execute();
            $stmt1->close();
            displaySweetAlert("success", "You have registered successfully!.", "Click OK to login!");
        } else {
            displaySweetAlert("Error", "Username Already Exist", "Please use another username!");
            return;
        }
	}
?>



