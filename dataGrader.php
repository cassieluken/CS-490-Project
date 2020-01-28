<?php

include('connectSQL.php');
function removeTilda($tcArr) {
  $returnArr = array();
  foreach($tcArr as $arr) {
    $lastVal = array_pop($arr);
    $lastVal = rtrim($lastVal);
    array_push($returnArr, $arr);
  }
  return $returnArr;
}

$examID = $_POST['examID'];

$sql = "SELECT q, functionName, Sanswer, testcase1, testcase2, testcase3, testcase4, testcase5, testcase6, testcase1out, testcase2out, testcase3out, testcase4out, testcase5out, testcase6out, questionConstraint
        FROM student JOIN question
          ON question.qID = student.qID
        WHERE examID = '$examID'";
$query = mysqli_query($conn, $sql);
if(!$query) {
  echo json_encode("Backend error:" . mysqli_error($conn));
}

$sql2 = "SELECT point, qID
         FROM middleexam
         WHERE examID = '$examID'";
$query2 = mysqli_query($conn, $sql2);
if(!$query2) {
  echo json_encode("Backend error: " . mysqli_error($conn));
}

//making arrays
$question = array();
$functionName = array();
$studentAnswer = array();
$points = array();
$qID = array();
$testcase1 = array();
$testcase2 = array();
$testcase3 = array();
$testcase4 = array();
$testcase5 = array();
$testcase6 = array();
$testcase1out = array();
$testcase2out = array();
$testcase3out = array();
$testcase4out = array();
$testcase5out = array();
$testcase6out = array();
$questionConstraint = array();
//first while loop for query 1
while($dataRows = mysqli_fetch_assoc($query)) {
  global $question;
  global $functionName;
  global $studentAnswer;
  global $testcase1;
  global $testcase2;
  global $testcase3;
  global $testcase4;
  global $testcase5;
  global $testcase6;
  global $testcase1out;
  global $testcase2out;
  global $testcase3out;
  global $testcase4out;
  global $testcase5out;
  global $testcase6out;
  global $questionConstraint;

  $question[] = $dataRows["q"];
  $functionName[] = $dataRows["functionName"];
  $studentAnswer[] = $dataRows["Sanswer"];
  $testcase1[] = $dataRows["testcase1"];
  $testcase2[] = $dataRows["testcase2"];
  $testcase3[] = $dataRows["testcase3"];
  $testcase4[] = $dataRows["testcase4"];
  $testcase5[] = $dataRows["testcase5"];
  $testcase6[] = $dataRows["testcase6"];
  $testcase1out[] = $dataRows["testcase1out"];
  $testcase2out[] = $dataRows["testcase2out"];
  $testcase3out[] = $dataRows["testcase3out"];
  $testcase4out[] = $dataRows["testcase4out"];
  $testcase5out[] = $dataRows["testcase5out"];
  $testcase6out[] = $dataRows["testcase6out"];
  $questionConstraint[] = $dataRows["questionConstraint"];
}
//while loop for query 2
while($dataRows = mysqli_fetch_assoc($query2)) {
  global $points;
  global $qID;

  $qID[] = $dataRows["qID"];
  $points[] = $dataRows["point"];
}

//var dumping all arrays
//echo var_dump($functionName);
//echo var_dump($studentAnswer);
//echo var_dump($question);
//echo var_dump($testcase1);
//echo '<br>';
//echo var_dump($testcase2);
//echo '<br>';
//echo var_dump($testcase3);
//echo '<br>';
//echo var_dump($testcase4);
//echo '<br>';
//echo var_dump($testcase5);
//echo '<br>';
//echo var_dump($testcase6 );

//echo var_dump($testcase1out);
//echo var_dump($testcase2out);
//echo var_dump($testcase3out);
//echo var_dump($testcase4out);
//echo var_dump($testcase5out);
//echo var_dump($testcase6out);
//echo var_dump($questionConstraint);

//for testcase inputs
$testCase1 = implode(",", $testcase1);
$testCase2 = implode(",", $testcase2);
$testCase3 = implode(",", $testcase3);
$testCase4 = implode(",", $testcase4);
$testCase5 = implode(",", $testcase5);
$testCase6 = implode(",", $testcase6);
/*echo $testCase1;
echo '<br>';
echo $testCase2;
echo '<br>';
echo $testCase3;
echo '<br>';
echo $testCase4;
echo '<br>';
echo $testCase5;
echo '<br>';
echo $testCase6;
echo '<br>';*/
$testCase = array($testCase1, $testCase2, $testCase3, $testCase4, $testCase5, $testCase6);
//echo var_dump($testCase);

function makeTCin($testcase1, $testcase2,
$testcase3, $testcase4, $testcase5, $testcase6,  $index){
    $qtc = array();
    $q1 = $testcase1[$index];
    $q2 = $testcase2[$index];
    $q3 = $testcase3[$index];
    $q4 = $testcase4[$index];
    $q5 = $testcase5[$index];
    $q6 = $testcase6[$index];
    //echo "index: ". '<br>';
    //echo $q1;
    //echo $q2;
    //echo $q3;
    //echo $q4;
    //echo $q5;
    //echo $q6;
    array_push($qtc, $q1, $q2, $q3, $q4, $q5, $q6);
//echo var_dump($qtc);
return $qtc;
}
$testCaseFINALin = array();
for($x=0;$x<sizeof($question); $x++){
    $tc = makeTCin($testcase1, $testcase2, $testcase3,
    $testcase4, $testcase5, $testcase6,  $x);
    echo '<br>';
    //echo "TCC";
    //echo var_dump($tc);
    array_push($testCaseFINALin, $tc);
}
//echo '<br>';
//echo "FINAL TC: ";
//echo var_dump($testCaseFINALin);

//for testcase outputs
$testCase1out = implode(",", $testcase1out);
$testCase2out = implode(",", $testcase2out);
$testCase3out = implode(",", $testcase3out);
$testCase4out = implode(",", $testcase4out);
$testCase5out = implode(",", $testcase5out);
$testCase6out = implode(",", $testcase6out);

$testCaseOut = array($testCase1out, $testCase2out, $testCase3out, $testCase4out, $testCase5out, $testCase6out);
//echo var_dump($testCaseOut);
//echo '<br>';

function makeTCout($testcase1out, $testcase2out,
$testcase3out, $testcase4out, $testcase5out, $testcase6out,
$indextwo){
    $qtcOUT = array();
    $q1out = $testcase1out[$indextwo];
    $q2out = $testcase2out[$indextwo];
    $q3out = $testcase3out[$indextwo];
    $q4out = $testcase4out[$indextwo];
    $q5out = $testcase5out[$indextwo];
    $q6out = $testcase6out[$indextwo];

    array_push($qtcOUT, $q1out, $q2out, $q3out, $q4out,
    $q5out, $q6out);

    return $qtcOUT;
}
$testCaseFINALout = array();
for($y=0; $y<sizeof($question); $y++){
    $tcOut = makeTCout($testcase1out, $testcase2out,
    $testcase3out, $testcase4out, $testcase5out,
    $testcase6out, $y);

    //echo '<br>';

    array_push($testCaseFINALout, $tcOut);
}
//echo '<br>';
//echo "FINAL TC OUT: ";
//echo var_dump($testCaseFINALout);

//removing tilda from end of student answer
$lastVal = array_pop($studentAnswer);
$lastVal = rtrim($lastVal, "~");
array_push($studentAnswer, $lastVal);

//putting all info into array to cURL to grader
$dataList = array("examID"=>$examID, "question"=>$question,
"functionName"=>$functionName,
"studentAnswer"=>$studentAnswer,
"testCaseIn"=>$testCaseFINALin,
"testCaseOut"=>$testCaseFINALout, "points"=>$points, "questionConstraint"=>$questionConstraint, "qID"=>$qID);

$query_string = http_build_query($dataList);
//$json = json_encode($query_string);
//curl to grader
//echo var_dump($json);
  $ch = curl_init();
 //curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~ndl25/backupProject/beta/back/login.php");
 curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~gvc3/thegrader5.php");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
 //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
 $result = curl_exec($ch);
 // echo '<br>';
  echo $result;

 curl_close($ch);



mysqli_close($conn);

?>
