<?php   
    include 'connect.php';
    if($_SESSION["ExistingUserName"] == null && $_SESSION["ExistingUserPass"] == null)
    header("Location: login.php?please_login_or_create_account");
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Your Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        p {
            text-align: center;
            color: #666;
        }
        .btn-container {
            text-align: center;
            margin-top: 30px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <p><?php echo $_SESSION["ExistingUserName"]?> have successfully logged in.</p>

        <div>
        <h1>Registered Customers</h1>
        <?php
        $sql = "SELECT firstname, lastname, gender FROM tbluserprofile";
        $result = $mysqli->query($sql);
        if ($result) {
            if ($result->num_rows > 0) {
                // Output data of each row
                echo "<table style='border-collapse: collapse;'>";
                echo "<tr>";
                echo "<th style='border: 1px solid black;'>Name</th>";
                echo "<th style='border: 1px solid black;'>Gender</th>";
                echo "</tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='border: 1px solid black;'>" . $row["firstname"] . " " . $row["lastname"] . "</td>";
                    echo "<td style='border: 1px solid black;'>" .  $row["gender"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
        } else {
            echo "Error: " . $conn->error;
        }
        $mysqli->close();
        ?>
    </div>
    </div>
</body>
</html>
