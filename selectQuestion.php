<?php
  include ('connectSQL.php');
  $str_json = file_get_contents('php://input');
  $json_decode = json_decode($str_json, true);


$addQuestion = array();
$result2 = mysqli_query($conn, "SELECT * FROM question ORDER BY qID");

if(!$result2)
{
echo("error: ".mysqli_error($conn));

}

while($test = mysqli_fetch_array($result2)){
        $row['question'] = $test['question'];
        $row['difficulty'] = $test['difficulty'];
        $row['type'] = $test['type'];
        $row['qID'] = $test ['qID'];

        array_push($addQuestion, $row);
}

$jsonQuestion = json_encode($addQuestion);
echo $jsonQuestion;

mysqli_close($conn);
?>

