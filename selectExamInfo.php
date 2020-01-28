<?php

include ('connectSQL.php');
$str_json = file_get_contents('php://input');
$json_decode = json_decode($str_json, true);

$selectExam = array();
$result = mysqli_query($conn, "SELECT * FROM exam ORDER BY examID");

while($exam = mysqli_fetch_array($result)){
    $row['examID'] = $exam['examID'];
    $row['examname'] = $exam['examname'];
    $row['qID'] = $exam['qID'];
    $row['points'] = $exam['points'];
    $row['releasestatus'] = $exam['releasestatus'];

    array_push($selectExam, $row);

}

$jsonExam = json_encode($selectExam);
echo $jsonExam;

mysqli_close($conn);

?>
