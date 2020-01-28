<?php
//---- IMPORTING CURL FUNCTION ---
include "curlFunc.php";
/*RECEIVE DATA FROM POST REQUEST*/
$indata = file_get_contents("php://input");
//---- CONTACTING BACK SERVER ----
$url = "https://web.njit.edu/~ts557/postExamBack.php";
echo curlyHair($url, $indata);
?>
