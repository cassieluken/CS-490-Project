<?php

include('connectSQL.php');
$str_json = file_get_contents('php://input');
$json_decode = json_decode($str_json, true);

$examID = $json_decode['exID'];
$qID = $json_decode['QIDpayload'];
$answer = $json_decode['Apayload'];

$sql2 = "UPDATE exam SET releasestatus='1' WHERE examID='$examID'";
$result = mysqli_query($conn, $sql2);

if($result)
{  
        echo json_encode("exam released");
    }
    else{
       echo json_encode("error: " . mysqli_error($conn));
    }


$qIDarray = implode(",", $qID);
$studentanswer = implode(",", $answer);
//echo var_dump($qID);
//echo var_dump($answer);
$qIDarray = explode(",", $qIDarray);
$studentanswer = explode("~,", $studentanswer);

$qIDanswer = array_combine($qIDarray, $studentanswer);
//echo var_dump($qIDanswer);
foreach($qIDanswer as $qID=>$answer) {
    $qID = (int)$qID;
    $sql = "INSERT INTO student(examID, qID, Sanswer) VALUES('$examID', '$qID', '$answer')";
    $query = mysqli_query($conn, $sql);
}

    if(!$query) {
                echo json_encode(mysqli_error($conn));
     }
    else {
        echo json_encode("updated");
     }

$payload = array("examID"=>$examID);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~ts557/dataGrader.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
$result = curl_exec($ch);
echo $result;
curl_close($ch);

mysqli_close($conn);
?>
