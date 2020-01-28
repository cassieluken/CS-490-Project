<?php

  include('connectSQL.php');
  $str_json = file_get_contents('php://input');
  
 $json_decode = json_decode($str_json, true);
 $qID = $json_decode['qID'];
 $points = $json_decode['points'];
 $examname = $json_decode['exName'];

$a = implode (",", $qID);

for($i=0;$i< count($qID);$i++){
        $arr[$i]= $qID[$i];
        
}

//FUNCTION TO remove  NULL VALUES AND SEND BACK  
function nullCheck($var){
 return $var != NULL;
}

$pointsNULL = array_filter($points, 'nullCheck');
$b = implode (",", $pointsNULL);

//query to insert new exam to DB
$sql = "INSERT INTO exam(examname, qID, points) VALUES (‘$examname’, '$a', '$b')";
$query = mysqli_query($conn, $sql);
if($query){

      echo "Exam Created";
}
else{
         echo ("error: ".mysqli_error($conn));
        
}

//next query is used to select examID from newly created exam
$sql2 = "SELECT examID FROM exam WHERE qID='$a' AND points='$b'";

$query2 = mysqli_query($conn, $sql2);
$examID = mysqli_fetch_assoc($query2);

$examID = (int)$examID["examID"];


//updating the examMiddle table
$qIDarray = explode(",", $a);
$pointsArray = explode(",",$b);

$multidimensionalarray = array_combine($qIDarray, $pointsArray);

foreach($multidimensionalarray as $question=>$point){

        $point = (int)$point;
        $question = (int)$question;

        $sql3 = "INSERT INTO middleexam(examID, qID, point) VALUES('$examID', '$question', '$point')";
        $query3 = mysqli_query($conn, $sql3);
        if(!$query3){
                echo json_encode("Middle exam table not updated");
        }
}

mysqli_close($conn);
?>
