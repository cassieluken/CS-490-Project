<?php
  include('connectSQL.php');


  $grade = $_POST['studentgrade'];
  $totalReductions = $_POST['QR'];
  $examID = $_POST['examID'];
  $answer = $_POST['answer'];
  $qd = $_POST['QD'];
  $qf = $_POST['QF'];
  $tcf = $_POST['TCF'];
  $qIDarray = $_POST['qID'];
  $points = $_POST['points'];

   //updating the student table with deductions and score
   echo '<br><br>';


    $studentTableRed = array_combine($qIDarray, $totalReductions);
    echo "ARRAY COMBINE -> red qid: ";
     echo var_dump($studentTableRed);

   foreach($studentTableRed as $qID1=>$red) {
    $sql1 = "UPDATE student SET deductions='$red'
    WHERE examID='$examID' AND qID='$qID1'";
    $query1 = mysqli_query($conn, $sql1);

    if(!$query1) {
        echo mysqli_error($conn);
    }
    else {
        echo "reds INSERTED";
    }
 }

  $studentTableGrades = array_combine($qIDarray, $grade);
  echo "ARRAY COMBINE -> grade qid: ";
   echo var_dump($studentTableGrades);

   foreach($studentTableGrades as $qID2=>$g) {
    $sql2 = "UPDATE student SET studentGrade='$g'
    WHERE examID='$examID' AND qID='$qID2'";
    $query2 = mysqli_query($conn, $sql2);

    if(!$query2) {
        echo mysqli_error($conn);
    }
    else {
        echo "GRADES INSERTED";
    }
 }
 //$pointsTEST = array(1, 2, 3);
 echo "QIDS:";
 echo var_dump($qIDarray);

 $studentTablePoints = array_combine($qIDarray, $points);
   echo "ARRAY COMBINE -> point qid: ";
   echo var_dump($studentTablePoints);

    foreach($studentTablePoints as $qID3=>$p) {
    $sql3 = "UPDATE student SET totalPoints='$p'
    WHERE examID='$examID' AND qID='$qID3'";
    $query3 = mysqli_query($conn, $sql3);

    if(!$query3) {
        echo mysqli_error($conn);
    }
    else {
        echo "GRADES INSERTED";
    }
 }
  //selecting qIDs from student table to insert into testcase table
   $qidarray = array();
  for($x=0; $x<sizeof($qIDarray); $x++){
    array_push($qidarray, $qIDarray[0][$x]);
  }
   $qD = array();

   $tempqd = $qd[0];
   $constraintDed = $tempqd['constraintDed'];

   $colonDed = $tempqd['colonDed'];
   $funcNameDed = $tempqd['funcNameDed'];
   $compileDed = $tempqd['compileDed'];
   $testcaseDed = $tempqd['testCaseDed'];

   $qF = array();

   $tempqf = $qf[0];

   $constraintFeed = $tempqf['feedConstraint'];
   $colonFeed = $tempqf['feedColon'];
   $funcNameFeed = $tempqf['feedFuncName'];
   $compileFeed = $tempqf['feedCompile'];

   //deduction inserts be ready for a lot
   $questionCon = array_combine($qIDarray, $constraintDed);

   foreach($questionCon as $id => $col){
     $id = (int)$id;
     $sqlinsert = "INSERT INTO testcasefinal(examID, qID, conDed) VALUES('$examID', '$id', '$col')";
     $queryin = mysqli_query($conn, $sqlinsert);
     if(!$queryin){
       echo "ERROR: " . mysqli_error($conn);
     }
   }

   $questionCol = array_combine($qIDarray, $colonDed);

   foreach($questionCol as $id => $col){
     $qid = (int)$id;
     $sqlupdate = "UPDATE testcasefinal SET colonDed='$col' WHERE qID = '$id' AND examID= $examID";
     $queryup = mysqli_query($conn, $sqlupdate);
     if(!$queryup){
       echo "ERROR: " . mysqli_error($conn);
     }
   }

   $questionfn = array_combine($qIDarray, $funcNameDed);
    foreach($questionfn as $id => $col){
     $qid = (int)$id;
     $sqlinsert = "UPDATE testcasefinal SET funcNameDed='$col' WHERE qID = '$id' AND examID= $examID";
     $queryup = mysqli_query($conn, $sqlinsert);
     if(!$queryup){
       echo "ERROR: " . mysqli_error($conn);
     }
   }

   $questionComp = array_combine($qIDarray, $compileDed);
    foreach($questionComp as $id => $col){
     $qid = (int)$id;
     $sqlinsert = "UPDATE testcasefinal SET compileDed='$col' WHERE qID = '$id' AND examID= $examID";
     $queryup = mysqli_query($conn, $sqlinsert);
     if(!$queryup){
       echo "ERROR: " . mysqli_error($conn);
     }
   }

   $questiontcD = array_combine($qIDarray, $testcaseDed);
    foreach($questiontcD as $id => $col){
     $qid = (int)$id;
     $sqlinsert = "UPDATE testcasefinal SET testcaseDed='$col' WHERE qID = '$id' AND examID= $examID";
     $queryup = mysqli_query($conn, $sqlinsert);
     if(!$queryup){
       echo "ERROR: " . mysqli_error($conn);
     }
   }
   //Feedback inserts yes I know it's a lot

   $questionconF = array_combine($qIDarray, $constraintFeed);

    foreach($questionconF as $id => $col){
     $qid = (int)$id;
     $sqlinsert = "UPDATE testcasefinal SET conFB='$col' WHERE qID = '$id' AND examID= $examID";
     $queryup = mysqli_query($conn, $sqlinsert);
     if(!$queryup){
       echo "ERROR: " . mysqli_error($conn);
     }
   }

   $questioncolF = array_combine($qIDarray, $colonFeed);
    foreach($questioncolF as $id => $col){
     $qid = (int)$id;
     $sqlinsert = "UPDATE testcasefinal SET colonFB='$col' WHERE qID = '$id' AND examID= $examID";
     $queryup = mysqli_query($conn, $sqlinsert);
     if(!$queryup){
       echo "ERROR: " . mysqli_error($conn);
     }
   }

   $questionfnf = array_combine($qIDarray, $funcNameFeed);
    foreach($questionfnf as $id => $col){
     $qid = (int)$id;
     $sqlinsert = "UPDATE testcasefinal SET funcNameFB='$col' WHERE qID = '$id' AND examID= $examID";
     $queryup = mysqli_query($conn, $sqlinsert);
     if(!$queryup){
       echo "ERROR: " . mysqli_error($conn);
     }
   }

   $questioncompf = array_combine($qIDarray, $compileFeed);
    foreach($questioncompf as $id => $col){
     $qid = (int)$id;
     $sqlinsert = "UPDATE testcasefinal SET compileFB='$col' WHERE qID = '$id' AND examID= $examID";
     $queryup = mysqli_query($conn, $sqlinsert);
     if(!$queryup){
       echo "ERROR: " . mysqli_error($conn);
     }
   }

   echo "tcf: ";
   echo var_dump($tcf);
   $testcaseFeed = $tcf['feedTestCase'];

   echo '<br>';
   echo "TESTCASE FEED: ";
   echo var_dump($testcaseFeed);
   $questiontcFeed = array_combine($qIDarray, $testcaseFeed);
   foreach($questiontcFeed as $id => $col){
     $qid = (int)$id;
     $column = implode(",",$col);
     $sqlinsert = "UPDATE testcasefinal SET testcaseFB='$column' WHERE qID = '$id' AND examID= $examID";
     $queryup = mysqli_query($conn, $sqlinsert);
     if(!$queryup){
       echo "ERROR: " . mysqli_error($conn);
     }
   }


?>
