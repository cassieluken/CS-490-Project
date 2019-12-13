<?php
	$input = file_get_contents("php://input");
		
  $ch = curl_init();
	
  curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~gvc3/mLogin.php");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $input);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

	$result = curl_exec($ch);
  echo $result;
  
	curl_close($ch);
?>
