<?php
  include ('connectSQL.php');
  $str_json = file_get_contents('php://input');
  $json_decode = json_decode($str_json, true);

  $question = $json_decode['question'];
  $functionName = $json_decode['funcName'];
  $difficulty = $json_decode['difficulty'];
  $type = $json_decode['type'];
  $testcase1In = $json_decode['tc1IN'];
  $testcase1Out = $json_decode['tc1OUT'];
  $testcase2In = $json_decode['tc2IN'];
  $testcase2Out = $json_decode['tc2OUT'];
  $testcase3In = $json_decode['tc3IN'];
  $testcase3Out = $json_decode['tc3OUT'];
  $testcase4In = $json_decode['tc4IN'];
  $testcase4Out = $json_decode['tc4OUT'];
  $testcase5In = $json_decode['tc5IN'];
  $testcase5Out = $json_decode['tc5OUT'];
  $testcase6In = $json_decode['tc6IN'];
  $testcase6Out = $json_decode['tc6OUT'];
  $constraint = $json_decode['constraint'];


 $result=mysqli_query($conn, "INSERT INTO question(q, functionName, difficulty, type,
  testcase1, testcase1out, testcase2, testcase2out, testcase3, testcase3out,
  testcase4, testcase4out, testcase5, testcase5out, testcase6, testcase6out, questionConstraint)
  VALUES ('$question', '$functionName','$difficulty','$type', '$testcase1In',
  '$testcase1Out', '$testcase2In', '$testcase2Out', '$testcase3In',
  '$testcase3Out', '$testcase4In', '$testcase4Out', '$testcase5In',
'$testcase5Out', '$testcase6In', '$testcase6Out','$constraint')");


mysqli_close($conn);
?>
