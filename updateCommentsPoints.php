<?php

    include('connectSQL.php');
    $str_json = file_get_contents('php://input');
    $json_decode = json_decode($str_json, true);

    $examID = $json_decode['exID'];
    $points = $json_decode['SCOREs'];
    $qIDarray = $json_decode['QIDs'];
    $conDed = $json_decode['conover'];
    $colonDed = $json_decode['colover'];
    $funcNameDed = $json_decode['fnover'];
    $compileDed = $json_decode['compover'];
    $testcaseDed = $json_decode['tcover'];
     $comments = $json_decode['comments'];

    echo var_dump($colonDed);
    echo var_dump($conDed);
    echo var_dump($funcNameDed);
    echo var_dump($compileDed);
    echo var_dump($testcaseDed);
  $newcom = explode("~", $comments);
  echo var_dump($newcom);

  $sql0 = "UPDATE exam SET releasestatus= '2' WHERE examID='$examID'";
  $query0 = mysqli_query($conn, $sql0);
  if(!$query0){
    echo mysqli_error($conn);
  }
  else{
    echo "Release status updated";
  }


    $updatescore = array_combine($qIDarray, $points);
    foreach($updatescore as $qID1=>$updateScores){
        $sql = "UPDATE student SET studentGrade='$updateScores' WHERE
        examID='$examID' AND qID='$qID1'";

        $query = mysqli_query($conn, $sql);

        if(!$query){
            echo mysqli_error($conn);
        }
        else{
            echo "UPDATED SCORES";
        }
    }

    $updateCon = array_combine($qIDarray, $conDed);
    foreach($updateCon as $qID2=>$updateCON) {
        $sql2 = "UPDATE testcasefinal SET conDed='$updateCON' WHERE
        examID='$examID' AND qID='$qID2'";

        $query2 = mysqli_query($conn, $sql2);

        if(!$query2){
            echo mysqli_error($conn);
        }
        else {
            echo "UPDATED CONSTRAINT DEDUCT";
        }
    }

    $updateColon = array_combine($qIDarray, $colonDed);
    foreach($updateColon as $qID3=>$updateCOLON) {
        $sql3 = "UPDATE testcasefinal SET colonDed='$updateCOLON' WHERE
        examID='$examID' AND qID='$qID3'";
        $query3 = mysqli_query($conn, $sql3);

        if(!$query3){
            echo mysqli_error($conn);
        }
        else {
            echo "UPDATED COLON DEDUCT";
        }
    }

    $updatefun = array_combine($qIDarray, $funcNameDed);
    foreach($updatefun as $qID4=>$updateFUN) {
        $sql4 = "UPDATE testcasefinal SET funcNameDed='$updateFUN' WHERE
        examID='$examID' AND qID='$qID4'";
        $query4 = mysqli_query($conn, $sql4);

        if(!$query4){
            echo mysqli_error($conn);
        }
        else {
            echo "UPDATED FUNC NAME DEDUCT";
        }
    }

    $updatecomp = array_combine($qIDarray, $compileDed);
    foreach($updatecomp as $qID5=>$updateCOMP) {
        $sql5 = "UPDATE testcasefinal SET compileDed='$updateCOMP' WHERE
        examID='$examID' AND qID='$qID5'";
        $query5 = mysqli_query($conn, $sql5);

        if(!$query5){
            echo mysqli_error($conn, $sql5);
        }
        else {
            echo "UPDATED COMPILE DEDUCT";
        }
        }

    $updateTC = array_combine($qIDarray, $testcaseDed);
    foreach($updateTC as $qID6=>$updatetc){
        $sql6 = "UPDATE testcasefinal SET testcaseDed='$updatetc' WHERE
        examID='$examID' AND qID='$qID6'";
        $query6 = mysqli_query($conn, $sql6);

        if(!$query6){
            echo mysqli_error($conn);
        }
        else {
            echo "UPDATED TESTCASE DEDUCT";
        }
        }

    $updatecomments = array_combine($qIDarray, $newcom);
    foreach($updatecomments as $qID7=>$update) {
        $sql7 = "UPDATE student SET comments='$update' WHERE
        examID='$examID' AND qID='$qID7'";
        $query7 = mysqli_query($conn, $sql7);

        if(!$query7){
            echo mysqli_error($conn);
        }
        else {
            echo "UPDATED COMMENTS";
        }
        }

     mysqli_close($conn);
?>
