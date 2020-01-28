<?php

// $input = file_get_contents('php://input');
// $decode = json_decode($input, true);

// $examIDBack = $decode['examID'];
// $questionBack = $decode['question'];
// $funcNameBack = $decode['functionName'];
// $SanswerBack = $decode['studentAnswer'];
// $tcINBack = $decode['testCaseIn'];
// $tcOUTBack = $decode['testCaseOut'];
// $pointsBack = $decode['points'];
// $constraintBack = $decode['questionConstraint'];

$examIDBack = $_POST['examID'];
$questionBack = $_POST['question'];
$funcNameBack = $_POST['functionName'];
$SanswerBack = $_POST['studentAnswer'];
$tcINBack = $_POST['testCaseIn'];
$tcOUTBack = $_POST['testCaseOut'];
$pointsBack = $_POST['points'];
$constraintBack = $_POST['questionConstraint'];
$qIDBack = $_POST['qID'];

function TestCaseCleanUp($testcase)
{
    $testcasearray = array();
    for ($x = 0; $x <sizeof($testcase); $x++)
    {
        $new = array($testcase[$x]);
        // $newOut = array($tcOUTBackTemp[$x]);
        // array_push($tcINBack, $newIn);
        array_push($testcasearray, $new);
    }
    return $testcasearray;
    echo "TESTCASES HERE@@@@@@@@@";
    echo var_dump($testcasearray);
    echo '<br>';
}

echo "Data being sent to me<br>";
echo "================================================";
echo '<br>';
echo "questionBack: <br>";
echo var_dump($questionBack);
echo '<br><br>';
echo "pointsBack: <br>";
echo var_dump($pointsBack);
echo '<br><br>';
echo "SanswerBack: <br>";
echo var_dump($SanswerBack);
echo '<br><br>';
echo "tcINBack: <br>";
echo var_dump($tcINBack);
echo '<br><br>';
echo "tcOUTBack: <br>";
echo var_dump($tcOUTBack);
echo '<br><br>';
echo "funcNameBack: <br>";
echo var_dump($funcNameBack);
echo '<br><br>';
echo "constraintBack: <br>";
echo var_dump($constraintBack);
echo '<br><br>';
echo "examIDBack: <br>";
echo var_dump($examIDBack);
echo '<br><br>';
echo "qIDBack: <br>";
echo var_dump($qIDBack) . '<br>';
echo "================================================";
echo'<br><br>';
// $questionBack = array("Write a function getC() that returns the parameter's value.");
// $pointsBack = array("20");
// $SanswerBack = array("def getC(c):
//     return c");
// $tcINBack = array(array("4"));
// $tcOUTBack = array(array("4"));
// $funcNameBack = array("getC");
// $constraintBack = array("while");
// $examIDBack = array("10");

//$eqSize = checkGraderParamSizes($questionArray, $pointArray, $SanswerArray, $tcINArray, $tcOUTArray, $funcNameArray, $constraintArray);
function checkGraderParamSizes($q, $p, $a, $tcin, $tcout, $name, $c)
{
    $allequal = false;
    if  (
        sizeof($q) == sizeof($p) &&
        sizeof($p) == sizeof($a) &&
        sizeof($a) == sizeof($name) &&
        sizeof($name) == sizeof($c)
        )
        // sizeof($a) == sizeof($tcin) &&
        // sizeof($tcin) == sizeof($tcout) &&
        // sizeof($tcout) == sizeof($name) &&
    {
        return "true";
    }
    else
    {
        echo sizeof($q);
        echo sizeof($p);
        echo sizeof($a);
        // echo sizeof($tcin);
        // echo sizeof($tcout);
        echo sizeof($name);
        echo sizeof($c);
        return "false";
    }
}

#make all other functions searching for stuff like this
//$loopQ = checkForLoop($con);
//$loopC = checkForLoop($answer);
function checkForLoop($answerconstraint)
{
    if (preg_match("/for/", $answerconstraint) || preg_match("/loop/", $answerconstraint))
    {
        return true;
    }
    else
    {
        return false;
    }
}

//$whileQ = checkForWhile($con);
//$whileC = checkForWhile($answer);
function checkForWhile($answerconstraint)
{
    if (preg_match("/while/", $answerconstraint))
    {
        return true;
    }
    else
    {
        return false;
    }
}

//$colonQ = checkForColon($studentanswer);
//$colonC = checkForColon($answer);
function checkForColon($studentanswer)
{
    $a = strpos($studentanswer, ")");
    $a = $a + 1;
    $colon = substr($studentanswer, $a, 1);
    if($colon !== ":")
    {
        return true;
    }
    else
    {
        return false;
    }
}

function replaceColon($studentanswer)
{
    $a = strpos($studentanswer, ")");
    $a = $a + 1;
    $colon = substr($studentanswer, 0 , $a);
    $remainder = ltrim($studentanswer, $colon);
    $w  = $colon . ":" . $remainder;
    return $w;
}

//$returnQ = checkforReturn($quest);
//$returnC = checkForReturn($answer);
function checkForReturn($question)
{
    if (preg_match("/return/", $question))
    {
        return true;
    }
    else
    {
        return false;
    }
}

//$printQ = checkForPrint($quest);
//$printC = checkForPrint($answer);
function checkForPrint($question)
{
    #used to get codetype for function call later
    if (preg_match("/print/", $question))
    {
        return true;
    }
    else
    {
        return false;
    }
}


#$funcNameCheck = checkStudentFuncName($answer, $mingze);
function checkStudentFuncName($studentanswer, $actualname)
{
    echo "Function names in checkStudentFuncName: <br>";
    echo "================================================";
    echo "<br> studentanswer: <br>";
    echo $studentanswer;
    echo "<br> actualname: <br>";
    echo $actualname;
    echo '<br><br>';
    $x = strpos($studentanswer, "(");
    $y = substr($studentanswer, 0, $x);
    // echo $y;
    // echo '<br><br>';
    #if the student's function name does not equal the actual function name, return true
    if($y !== ("def " . $actualname))
    {
        return true;
    }
    else
    {
        return false;
    }
}

//appendStudentAnswer($studentinput); --> is part of prepStudentAnswer
function appendStudentAnswer($studentinput)
{
    $file = file_get_contents('student_answer.py');
    $file1 = $file . "\n" . $studentinput;
    file_put_contents('student_answer.py', $file1);
    echo "This is the file stuff in appendStudentAnswer: <br>";
    echo "================================================ <br>";
    echo file_get_contents('student_answer.py');
    echo '<br><br>';
}
//for tcs
function nullCheck($var){
    return $var != NULL;
}
//$tcv = generateTestCaseVector($tcinarr, $tcoutarr, $ctype, $nam); ---> in prepStudentAnswer
//returns tcoutput
function generateTestCaseVector($InCaseArray, $OutCaseArray, $printorreturn, $name)
{
    $tcoutput = array();
    $NULLin = array_filter($InCaseArray, 'nullCheck');
    $NULLout = array_filter($OutCaseArray, 'nullCheck');
    $noin = $NULLin[0];
    $noout = $NULLout[0];
    $noNULLout = array_filter($noout, 'nullCheck');
    $noNULLin = array_filter($noin, 'nullCheck');
    // echo '<br><br>';
    echo "noNULLin & noNULLout used in generateTestCaseVector: <br>";
    echo "================================================ <br>";
    echo "noNULLin: <br>";
    echo var_dump($noNULLin);
    echo '<br>';
    echo "noNULLout: <br>";
    echo var_dump($noNULLout);
    echo '<br>';
    echo "************************************************ <br>";
    echo "caseArray which array_combine's both noNULLin & noNULLout: <br>";
    $caseArray = array_combine($noNULLin, $noNULLout);
    echo var_dump($caseArray);
    echo "================================================ <br>";
    echo '<br><br>';
    
    foreach ($caseArray as $in => $out)
    {
        array_push($tcoutput, $out);
        if($printorreturn == "return")
        {    
            echo "When tcoutput = out: ";
            echo '<br>';
            //$put = implode(',', $in);
            //echo $put;
            appendStudentAnswer("print(" . $name . "(" . $in . "))");
        }
        else
        {
            echo "IIIIIIII";
            appendStudentAnswer($name . "(" . $in . ")");
            //$put = implode(',', $in);
            //echo $put;
            $type = gettype($in);
            // if($type == integer){
            //     appendStudentAnswer($name . "(" . $in . ")");
            // }
            // elseif($type){
            //     appendStudentAnswer($name . "('" . $in . "')");
            // }
        }
    }
    return $tcoutput;
}

#type is used in Yokai function for return/print
//$testCaseVector = prepStudentAnswer($studentanswer, $tin, $tou, $codeType, $mingze);
//returns tcoutput
function prepStudentAnswer($studentinput, $tcinarr, $tcoutarr, $ctype, $nam)
{
    // echo var_dump($tcoutarr);
    // echo $ctype;
    // echo $nam;
    // echo '<br>';
    file_put_contents("student_answer.py", "");

    appendStudentAnswer($studentinput);
    $tcoutput = generateTestCaseVector($tcinarr, $tcoutarr, $ctype, $nam);
    return $tcoutput;
}

##studentanswer = replaceFunctionName($answer, $mingze);
function replaceFunctionName($studentanswer, $actualname)
{
    $x = strpos($studentanswer, "(");
    $y = substr($studentanswer, 0, $x);
    $z = ltrim($studentanswer, $y);
    $newstudentanswer = "def " . $actualname . $z;
    return $newstudentanswer;
}

function generateAnswerVector($studentstuff)
{
    echo "&&&&&&&&&&&&&&&&&";
    echo $studentstuff;
    echo '<br><br>';
    $returnArray = explode("\n", $studentstuff);
    //unset($returnArray[sizeof($returnArray)-1]);
    array_pop($returnArray);
    echo "RETURN ARRAY ECHO HERE: ";
    echo var_dump($returnArray);
    echo '<br><br>';
    return $returnArray;
}
//$percentage = compareTestArrays($tcoutput, $tempAnswerVector);
function compareTestArrays($tcoutput, $fileoutput)
{
    if (sizeof($tcoutput) != sizeof($fileoutput))
    {
        $error = "CHECK";
        return $error;
    }
    $numCases = sizeof($tcoutput);
    $correctVals = 0;

    for ($i = 0; $i < sizeof($tcoutput); $i++)
    {
        if ($tcoutput[$i] == $fileoutput[$i])
        {
            $correctVals++;
        }
        else
        {
            #line 43
        }
    }
    $percentage = $correctVals/$numCases;

    return $percentage;
}

function getNumberOfWrongTestCases($tcoutput, $fileoutput)
{

    $wrongVals = 0;
    for ($i = 0; $i < sizeof($tcoutput); $i++)
    {
        if ($tcoutput[$i] != $fileoutput[$i])
        {
            $wrongVals++;
        }
    }
    return $wrongVals;
}

function compareTestArraysFeed($tcoutput, $fileoutput)
{
    $compare = array_combine($tcoutput, $fileoutput);
    echo "ARRAY COMBINE TCOUTPUT AND FILEOUTPUT HERE: ";
    echo var_dump($compare);
    echo '<br><br>';
    $feedback = array();
    for($i=0; $i< sizeof($tcoutput); $i++)
    {
        
        if($tcoutput[$i] !== $fileoutput[$i])
        {
            array_push($feedback, "Your output was ". $fileoutput[$i] . " expected was " . $tcoutput[$i]);
        }
        else
        {
            array_push($feedback, "Worked for this testcase");
        }
    }
    // echo var_dump($feedback);
    return $feedback;
}

function getActualQuestionGrade($percentage, $rawPoint)
{
    return ($percentage * $rawPoint);
}

//$executionData = executeYokai($answerArray[$x], $tcINArray[$x], $tcOUTArray[$x], $funcNameArray[$x], $constraintArray[$x], $point, $questionArray[$x]);
function executeYokai($answer, $tin, $tou, $mingze, $con, $pint, $quest)
{
    file_put_contents("student_answer.py", "");

    ###may need to check for constraint being sent instead of description
//question & constraint checks T/F
    $studentanswer = $answer;
    $loopQ = checkForLoop($con);
    $whileQ = checkForWhile($con);
    $returnQ = checkforReturn($quest);
    $printQ = checkForPrint($quest);

//student checks T/F
    $loopC = checkForLoop($answer);
    $whileC = checkForWhile($answer);
    $returnC = checkForReturn($answer);
    $printC = checkForPrint($answer);

    $funcNameCheck = checkStudentFuncName($answer, $mingze);

    $constraintRed = 0;
    $colonRed = 0;
    $funcNameRed = 0;
    #$funcOutputRed = 0;
    $testCaseRed = 0;
    $compileRed = 0;
    #extra credit adds instead
    // $extraRed = 0;

    $constraintFeed = "Constraint is not missing or selected.";
    $funcNameFeed = "Function name is correct.";
    $colonFeed = "Colon is not missing.";
    $compileFeed = "Function compiles properly.";
    // $loopFeed = "For loop is not missing.";
    // $whileFeed = "While loop is not missing.";


    #check for function name
    #outA = output in an array and $exitCode = 0 if runs and anything else if not
    if($funcNameCheck)
    {
        $funcNameRed = 0.15;
        $funcNameFeed = "The name of the function is incorrect, 15% taken off.";
        $studentanswer = replaceFunctionName($answer, $mingze);

    }

    $colonC = checkForColon($studentanswer);
    #check for colon
    if ($colonC)
    {
        $colonRed = 0.1;
        $colonFeed = "Expected a colon, 10% was taken off.";
        $studentanswer = replaceColon($studentanswer);
    }

    #changing questions to return or print
    if ($returnQ)
    {
        $type = "return";
    }
    else
    {
        $type = "print";
    }
    if ($returnC)
    {
        $codeType = "return";
    }
    else
    {
        $codeType = "print";
    }

    // $deductions = 0;

    $tcoutput = prepStudentAnswer($studentanswer, $tin, $tou, $codeType, $mingze);
    echo '<br><br>';
    echo "TCOUTPUT: ";
    echo var_dump($tcoutput);
    echo '<br><br>';
    $outA = array(); //used by php exec function
    //$functionName = getFunctionName($question);
    //$functionName = $mingze;

    echo "type: " . $type . '<br>';
    echo "code type: " . $codeType . '<br>';


    $printyo = checkforPrint($con);
    #check for improper return/print type
    #point reduction style may change because colon must be -5 or -3
    if ($printyo)
    {
        if (!$printC)
        {
            $constraintRed = 0.25;
            $constraintFeed = "The expected type is return but got a print instead, 25% was taken off";
        }
    }
    
    #check for loop
    if ($loopQ)
    {
        if (!$loopC)
        {
            $constraintRed = 0.25;
            $constraintFeed = "For loop was expected, but not found. 25% was taken off.";
        }

    }

    #check while
    if ($whileQ)
    {
        if (!$whileC)
        {
            $constraintRed = 0.25;
            $constraintFeed = "While loop was expected, but not found. 25% was taken off.";
        }
    }

    exec('/afs/cad/linux/anaconda3.6/anaconda/bin/python3 /afs/cad/u/g/v/gvc3/public_html/student_answer.py', $tempAnswer, $exitCode);
    // exec('python3 student_answer.py', $outA, $exitCode);
    // echo '<br>';
    echo "EXIT CODE NUMBER: ";
    echo $exitCode;
    echo '<br><br>';
    //$outA not working, so using another exec for output.
    // echo "OUTA HERE";
    // print_r($outA);
    // echo '<br><br>';
    // $sOutput = exec('/afs/cad/linux/anaconda3.6/anaconda/bin/python3 /afs/cad/u/g/v/gvc3/public_html/student_answer.py');
    // echo "OUTPUT FOR FILE FROM STUDENT INPUT";
    // echo var_dump($sOutput);
    // echo "POINTS HERE ";
    // echo $pint;
    // echo '<br>';
    if($exitCode != 0)
    {
        $compileRed = 0.25;
        $compileFeed = "The code did not compile correctly, 25% was taken off.";
        $deductions = 0;
        echo "Failed to execute";
        echo '<br>';
        $testCaseRed = 0.25;
        $testCaseFeed = "None of the testcases could run because there is an error in your code";
        $deductions = $constraintRed + $colonRed + $funcNameRed + $compileRed + $testCaseRed;
        echo "Total deductions: " . $deductions . "";
        echo '<br>';
        $percentage = 1 - $deductions;
        $score = getActualQuestionGrade($percentage, $pint);
        echo "Question points: " . $pint . "";
        echo '<br>';
        echo "Score: " . $score . "";
        echo '<br>';
        $eData = array(
            "constraintD" => $pint * $constraintRed,
            "funcNameD" => $pint * $funcNameRed,
            "colonD" => $pint * $colonRed,
            "compileD" => $pint * $compileRed,
            "testCaseD" => $pint * $testCaseRed,
            "extraD" => $pint * $extraRed,
            "score" => $score,
            "funcNameF" => $funcNameFeed,
            "colonF" => $colonFeed,
            "constraintF" => $constraintFeed,
            "compileF" => $compileFeed,
            "testCaseF" => $testCaseFeed
        );
        // echo var_dump($eData);
    }

    echo "Outer Return";
    $tempAnswer = shell_exec('/afs/cad/linux/anaconda3.6/anaconda/bin/python3 /afs/cad/u/g/v/gvc3/public_html/student_answer.py');
    //$tempAnswerVector is the outputs of the file exploded by a /n
    $tempAnswerVector = generateAnswerVector($tempAnswer);
    echo "TCOUTPUT HERE@@@@@@@@@@@: ";
    echo var_dump($tcoutput);
    echo '<br><br>';
    //echo var_dump($testCaseVector);2
    echo "ECHOING TEMPANSWERVECTOR: ";
    echo var_dump($tempAnswerVector);
    $testCaseFeed2 = compareTestArraysFeed($tcoutput, $tempAnswerVector);
    $compare = compareTestArrays($tcoutput, $tempAnswerVector);

    
    echo "compare: " . $compare . " if 1 means it was correct<br>";
    if ($compare < 1)
    {
        if ($compare == 0)
        {
            $testCaseRed = 0.25;
        }
        else
        {
            $wrongones = getNumberOfWrongTestCases($tcoutput, $tempAnswerVector);
            $a = sizeof($tcoutput);
            $pointsPerTC = (0.25/$a);
            echo $pointsPerTC;
            $testCaseRed = $wrongones * $pointsPerTC;
            echo '<br><br>';
            echo "TESTTT CASEE REDDDDDDDDDDDDDDDDD";
            echo $testCaseRed;
        }
        // $percentage = $percentage * (1 - $deductions);
        // $totalRed = 1 - $percentage;
        // $extraRed = $totalRed - $deductions;
        // echo "Extra reductions: " . $extraRed;
    }
    // else
    // {
    //     $percentage = $percentage - $deductions;
    // }
    echo "test case reduction: " . $testCaseRed . '<br>';
    $deductions = $constraintRed + $colonRed + $funcNameRed + $compileRed + $testCaseRed;
    echo "Total deductions: " . $deductions . "";
    echo '<br>';
    $percentage = 1 - $deductions;
    echo "Final %: " . $percentage * 100 . "";
    echo '<br>';

    $score = getActualQuestionGrade($percentage, $pint);
    echo "Question points: " . $pint . "";
    echo '<br>';
    echo "Score: " . $score . "";
    echo '<br>';
    $eData = array(
        "constraintD" => $pint * $constraintRed,
        "funcNameD" => $pint * $funcNameRed,
        "colonD" => $pint * $colonRed,
        "compileD" => $pint * $compileRed,
        "testCaseD" => $pint * $testCaseRed,
        "totalD" => $pint * $deductions,
        // "extraD" => $pint * $extraRed,
        "score" => $score,
        "funcNameF" => $funcNameFeed,
        "colonF" => $colonFeed,
        "constraintF" => $constraintFeed,
        "compileF" => $compileFeed,
        "testCaseF" => $testCaseFeed2
    );
    echo '<br><br>';
    return $eData;

}

/*-------------------------------------------------------------------*/

function gradeExam($questionArray, $pointArray, $SanswerArray, $tcINArray, $tcOUTArray, $funcNameArray, $constraintArray, $examID, $qID)
    {
        #checking if array sizes are all the same
        $eqSize = checkGraderParamSizes($questionArray, $pointArray, $SanswerArray, $tcINArray, $tcOUTArray, $funcNameArray, $constraintArray);

        if($eqSize == "true")
        {
            $studentQPoints = array();
            $studentDPoints = array();

            $studentDConstraint = array();
            $studentDColon = array();
            $studentDCompile = array();
            $studentDfuncName = array();
            $studentDtestCase = array();
            // $studentDExtra = array();

            $studentFuncNameF = array();
            $studentColonF = array();
            $studentConstraintF = array();
            $studentCompileF = array();
            $studentTestCaseF = array();

        $MDtestcaseIn = TestCaseCleanUp($tcINArray);
        $MDtestcaseOut = TestCaseCleanUp($tcOUTArray);
        echo var_dump($MDtestcaseIn);
        echo var_dump($MDtestcaseOut);
        echo '<br><br>';

            #go through each question and actually start grading it
            for($x = 0; $x < sizeof($questionArray); $x++)
            {
                file_put_contents("student_answer.py", "");
                #getting points worth of question
                $point = (int)$pointArray[$x];

                $executionData = executeYokai($SanswerArray[$x], $MDtestcaseIn[$x], $MDtestcaseOut[$x], $funcNameArray[$x], $constraintArray[$x], $point, $questionArray[$x]);

                array_push($studentQPoints, $executionData["score"]);
                array_push($studentDPoints, $executionData["totalD"]);

                array_push($studentDConstraint, $executionData["constraintD"]);
                array_push($studentDColon, $executionData["colonD"]);
                array_push($studentDfuncName, $executionData["funcNameD"]);
                array_push($studentDCompile, $executionData["compileD"]);
                array_push($studentDtestCase, $executionData["testCaseD"]);
                // array_push($studentDExtra, $executionData["extraD"]);

                array_push($studentFuncNameF, $executionData["funcNameF"]);
                array_push($studentColonF, $executionData["colonF"]);
                array_push($studentConstraintF, $executionData["constraintF"]);
                array_push($studentCompileF, $executionData["compileF"]);
                array_push($studentTestCaseF, $executionData["testCaseF"]);
            }


            $data = array
            (
                "studentgrade" => $studentQPoints,
                "QR" => $studentDPoints,
                #not sure if using this
                "examID" => $examID,
                "qID" => $qID,
                "points" => $pointArray,
                ###
                "answer" => $SanswerArray,
                "QD" => array
                (
                    array
                    (
                        "constraintDed" => $studentDConstraint,
                        "colonDed" => $studentDColon,
                        "funcNameDed" => $studentDfuncName,
                        "compileDed" => $studentDCompile,
                        "testCaseDed" => $studentDtestCase,
                        // "extra" => $studentDExtra
                    )
                ),
                "QF" => array
                (
                    array
                    (
                        "feedConstraint" => $studentConstraintF,
                        "feedColon" => $studentColonF,
                        "feedFuncName" => $studentFuncNameF,
                        "feedCompile" => $studentCompileF,
                        // "feedTestCase" => $studentTestCaseF
                    )
                ),
                "TCF" => array
                (

                    "feedTestCase" => $studentTestCaseF
                )

            );
            return $data;
        }

        else
            {

            }
    }


#####variables originally received
$data = gradeExam($questionBack, $pointsBack, $SanswerBack, $tcINBack, $tcOUTBack, $funcNameBack, $constraintBack, $examIDBack, $qIDBack);
var_dump($data);

$string = http_build_query($data);
$ch = curl_init("https://web.njit.edu/~ts557/addGradingDB.php");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$out = curl_exec($ch);
curl_close($ch);
echo $out;

?>
