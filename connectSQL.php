<?php

$servername = "sql.njit.edu";
$dbusername = "ts557";
$dbpassword = "********";
$db = "ts557";

// Create connection to database 
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $db);
// Check connection to database 
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
