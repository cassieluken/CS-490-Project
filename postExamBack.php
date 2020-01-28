<?php
include ('connectSQL.php');
$str_json = file_get_contents('php://input');
$json_decode = json_decode($str_json, true);

$examID = $json_decode['exid'];

//POST the data to student page
$makeExamMD = array(); //will be a multidimensional array
$sql4 = "SELECT *  FROM middleexam JOIN question ON middleexam.qID = question.qID WHERE examID = '$examID'";
$query4 = mysqli_query($conn, $sql4);
while($test = mysqli_fetch_array($query4, MYSQLI_ASSOC)){
 $row['examID'] = $test['examID'];
 $row['question'] = $test['q'];
  $row['difficulty'] = $test['difficulty'];
  $row['point'] = $test['point'];
  $row['qID'] = $test['qID'];

  array_push($makeExamMD,$row);
}
  $jsonExam = json_encode($makeExamMD);
  echo $jsonExam;

mysqli_close($conn);


?>
