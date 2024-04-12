<?php
// # ChatGPT
// Secure session configuration
// Set session cookie to be sent only over HTTPS connections, enhancing security.
ini_set('session.cookie_secure', 1);
// Prevent JavaScript from accessing the session cookie, reducing the risk of XSS attacks.
ini_set('session.cookie_httponly', 1);
// Ensure sessions are maintained only via cookies, mitigating the risk of session fixation attacks.
ini_set('session.use_only_cookies', 1);
// Set session cookie expiration time to one day, reducing the window of opportunity for session hijacking.
session_set_cookie_params(86400);
try{
    session_start();
    
    $user = "root";
    $password = "";
    $host = "localhost";
    $port = 3307;
    $dbname = "dbchuaf3";
    
    $mysqli = new mysqli($host, $user, $password, $dbname, $port);
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
}catch(Exception $e){
    echo "An error occurred: " . $e->getMessage();
}
?>