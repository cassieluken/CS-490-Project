<?php
include('connectSQL.php');
$login = file_get_contents('php://input');
$json_decode = json_decode($login, true);

$username = $json_decode['username'];
$password = $json_decode['password'];


$sql = "SELECT `type` FROM `beta_login` WHERE `username`='$username' AND `password`='$password'";

$data = mysqli_query($conn, $sql);
$result = mysqli_fetch_assoc($data);

if(!$data) {
 echo json_encode(array("response"=>"error"));
}
echo json_encode($result);

mysqli_close($conn);

?>
