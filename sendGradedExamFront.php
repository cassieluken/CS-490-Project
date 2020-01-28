<?php
include('connectSQL.php');
$str_json = file_get_contents('php://input');
$json_decode = json_decode($str_json, true);

$examID = $json_decode['exid'];

//query to get info from DB
$sql = "SELECT DISTINCT question.qID, question.q, question.difficulty, question.functionName, question.questionConstraint, question.type, question.testcase1, question.testcase2, question.testcase3, question.testcase4, question.testcase5, question.testcase6, question.testcase1out, question.testcase2out,  question.testcase3out, question.testcase4out, question.testcase5out, question.testcase6out,
student.Sanswer, student.comments, student.deductions, student.studentGrade, student.totalPoints,
testcasefinal.conDed, testcasefinal.colonDed, testcasefinal.funcNameDed, testcasefinal.compileDed, testcasefinal.testcaseDed, testcasefinal.conFB, testcasefinal.colonFB, testcasefinal.funcNameFB, testcasefinal.compileFB, testcasefinal.testcaseFB, testcasefinal.examID
        FROM student INNER JOIN question
             ON student.qID = question.qID
             INNER JOIN testcasefinal
             ON student.qID = testcasefinal.qID
        WHERE student.examID = '$examID'";
$query = mysqli_query($conn, $sql);
$gradedExamList = array();
while($gradeRows = mysqli_fetch_array($query)) {
  $table_row["qID"] = $gradeRows["qID"];
  $table_row["qCon"] = $gradeRows["questionConstraint"];
  $table_row["functionName"] = $gradeRows["functionName"];
  $table_row["question"] = $gradeRows["q"];
  $table_row["difficulty"] = $gradeRows["difficulty"];
  $table_row["type"] = $gradeRows["type"];
  $table_row["testcase1"] = $gradeRows["testcase1"];
  $table_row["testcase2"] = $gradeRows["testcase2"];
  $table_row["testcase3"] = $gradeRows["testcase3"];
  $table_row["testcase4"] = $gradeRows["testcase4"];
  $table_row["testcase5"] = $gradeRows["testcase5"];
  $table_row["testcase6"] = $gradeRows["testcase6"];
  $table_row["testcase1out"] = $gradeRows["testcase1out"];
  $table_row["testcase2out"] = $gradeRows["testcase2out"];
  $table_row["testcase3out"] = $gradeRows["testcase3out"];
  $table_row["testcase4out"] = $gradeRows["testcase4out"];
  $table_row["testcase5out"] = $gradeRows["testcase5out"];
  $table_row["testcase6out"] = $gradeRows["testcase6out"];
  $table_row["answer"] = $gradeRows["Sanswer"];
  $table_row["examID"] = $gradeRows["examID"];
  $table_row["comments"] = $gradeRows["comments"];
  $table_row["deductions"] = $gradeRows["deductions"];
  $table_row["studentGrade"] = $gradeRows["studentGrade"];
  $table_row["totalPoints"] = $gradeRows["totalPoints"];
  $table_row["conDed"] = $gradeRows["conDed"];
  $table_row["colonDed"] = $gradeRows["colonDed"];
  $table_row["funcNameDed"] = $gradeRows["funcNameDed"];
  $table_row["compileDed"] = $gradeRows["compileDed"];
  $table_row["testcaseDed"] = $gradeRows["testcaseDed"];
  $table_row["conFB"] = $gradeRows["conFB"];
  $table_row["colonFB"] = $gradeRows["colonFB"];
  $table_row["funcNameFB"] = $gradeRows["funcNameFB"];
  $table_row["compileFB"] = $gradeRows["compileFB"];
  $table_row["testcaseFB"] = $gradeRows["testcaseFB"];

  array_push($gradedExamList, $table_row);
}
array_push($gradedExamList, $examID);
echo json_encode($gradedExamList);


mysqli_close($conn);
?>
