<?php
include "studentnav.php";

?>
<h2>YOUR TESTS</h2>

<div class="row">
  
  <div class="test" style="background-color:#aaa;">
    <form id="masterForm">
      <fieldset>
      <p id="insert0"></p>
      <div id="insert3">
      <p id="insert1"></p>
      </div>
      <p id="insert2"></p>
      
      <p id="response"></p>
      </fieldset>
    </form>
  </div>
</div>
<script type="text/javascript">
  
  function getExams(){
    submit(btnFunc);
  }
  function btnFunc(jsonObj){
    var i, a="", b = "", c= "", exName="", exID="", releaseStatus ="";
    for(i=0; i<jsonObj.length; i++){
      exID = jsonObj[i].examID;
      exName = jsonObj[i].examname;
      releaseStatus = jsonObj[i].releasestatus;
      //console.log(releaseStatus);
      if(releaseStatus == "1"){
        a += '<br>Waiting for grading: ' + exName;
        
      }
      else if(releaseStatus == "2"){
        b += '<br><button type="button" onclick="previewExam(\'' + exID + '\',\'' + exName + '\')">View Grades</button> ' + exName;
      } 
      else{
        c += "<br>Not Taken Yet: " + exName;
      }
    }
    document.getElementById("insert0").innerHTML = a + b + c;
  }
  function previewExam(exID, exName){
    exid = exID;
    exname = exName;
    document.getElementById("insert0").innerHTML = "Your grades for exam: " + exName;
    document.getElementById("insert1").innerHTML = '';
    document.getElementById("insert2").innerHTML = '';
    getSpecificExamInfo(buildExam);
  }
  
  function buildExam(jsonObj2){
  //console.log(jsonObj2.length);
  var i, j, totalScore= 0, outOf= 0, msg="", percentage= 0, exdata = "", qID = "", desc = "", qtype = "", tcFeedArr= [];
  var color0 = "",color1 = "",color2 = "",color3 = "",color4 = "",color5 = "";
  var con = "", col = "", comp = "", fn= "", tc="", fullcred= "";
  var intfg, inttpts, score=0, totalScore="", out=0, outOf, percentage, message, msg, num=0;
  var length = jsonObj2.length-1
  var EXAMid = jsonObj2[length];
  jsonObj2.pop();
  
      for(j=0; j<jsonObj2.length; j++){
        
        exID = jsonObj2[j].examID;
        console.log(exID);
        console.log(EXAMid);
        if(exID != EXAMid){
          num++;
        }
        qnum = j+1;
        if(exID == EXAMid){
          console.log("IN IF");
          qID = jsonObj2[j].qID;
          answer = jsonObj2[j].answer;
          fN = jsonObj2[j].functionName;
          desc = jsonObj2[j].question;
          diff = jsonObj2[j].difficulty;
          type = jsonObj2[j].type;
          tc1 = jsonObj2[j].testcase1;
          tc2 = jsonObj2[j].testcase2;
          tc3 = jsonObj2[j].testcase3;
          tc4 = jsonObj2[j].testcase4;
          tc5 = jsonObj2[j].testcase5;
          tc6 = jsonObj2[j].testcase6;
          tc1o = jsonObj2[j].testcase1out;
          tc2o = jsonObj2[j].testcase2out;
          tc3o = jsonObj2[j].testcase3out;
          tc4o = jsonObj2[j].testcase4out;
          tc5o = jsonObj2[j].testcase5out;
          tc6o = jsonObj2[j].testcase6out;
          ded = jsonObj2[j].deductions;
          fg = jsonObj2[j].studentGrade;
          tpts = jsonObj2[j].totalPoints;
          conDed = jsonObj2[j].conDed;
          colonDed = jsonObj2[j].colonDed;
          fnDed = jsonObj2[j].funcNameDed;
          compileDed = jsonObj2[j].compileDed;
          tcDed = jsonObj2[j].testcaseDed;
          conFB = jsonObj2[j].conFB;
          colonFB = jsonObj2[j].colonFB;
          fnFB = jsonObj2[j].funcNameFB;
          compileFB = jsonObj2[j].compileFB;
          tcFB = jsonObj2[j].testcaseFB;
          comments = jsonObj2[j].comments;
          exID = jsonObj2[j].examID;
          
          qnum = qnum - num;
          if(colonDed == 0 && fnDed == 0 && conDed == 0 && compileDed == 0 && tcDed == 0){
            fullcred = "<font color='green'>YOU GOT FULL CREDIT </font> <br>";
          }
          else{
            fullcred =" ";
          }
          if(colonDed != 0){
            col = colonFB + " ( -" + colonDed + " points) <br>";
          }
          else{
            col = " ";
          }
          if(fnDed != 0){
            fn = fnFB + " ( -" + fnDed + " points) <br>";
          }
          else{
            fn = " ";
          }
          if(conDed != 0){
            con = conFB + " ( -" + conDed + " points) <br>";
          }
          else{
            con = " ";
          }
          if(compileDed != 0){
            comp = compileFB + " ( -" + compileDed + " points) <br>";
          }
          else{
            comp = " ";
          }
          if(tcDed != 0){
            tc = "Testcases (reference chart below for breakdown): ( -" + tcDed + " points) <br>";
          }
          else{
            tc = "You got all of the testcases right!";
          }
          
          if(tc1 == ""){
            tc1 = "N/A";
            tc1o ="N/A";
          }
          if(tc2 == ""){
            tc2 = "N/A";
            tc2o ="N/A";
          }
          if(tc3 == ""){
            tc3 = "N/A";
            tc3o ="N/A";
          }
          if(tc4 == ""){
            tc4 = "N/A";
            tc4o ="N/A";
          }
          if(tc5 == ""){
            tc5 = "N/A";
            tc5o ="N/A";
          }
          if(tc6 == ""){
            tc6 = "N/A";
            tc6o ="N/A";
          }
          
          
          tcFeedArr = tcFB.split(",");
          console.log(tcFeedArr.length);
          var length = tcFeedArr.length;
          if(length<6){
            for(i=length-1;i<6;i++){
              tcFeedArr.push("N/A");
            }
          }
          search0 = tcFeedArr[0].search("N/A");
          if(search0 == -1){
            if(tcFeedArr[0].search("Worked") != -1){
              color0 = "green";
            }
            if(tcFeedArr[0].search("output") != -1){
              color0 = "red";
            }
          }
          else{
            color0 = "black";
          }
          
          search1 = tcFeedArr[1].search("N/A");
          if(search1 == -1){
            if(tcFeedArr[1].search("Worked") != -1){
              color1 = "green";
            }
            if(tcFeedArr[1].search("output") != -1){
              color1 = "red";   
            }
          }
          else{
            color1 = "black";
          }
          
          search2 = tcFeedArr[2].search("N/A");
          if(search2 == -1){
            if(tcFeedArr[2].search("Worked") != -1){
              color2 = "green";
            }
            if(tcFeedArr[2].search("output") != -1){
              color2 = "red";
            }
          }
          else{
            color2 = "black";
          }
          
          search3 = tcFeedArr[3].search("N/A");
          if(search3 == -1){
            if(tcFeedArr[3].search("Worked") != -1){
              color3 = "green";
            }
            if(tcFeedArr[3].search("output") != -1){
              color3 = "red";
            }
          }
          else{
            color3 = "black";
          }
          
          search4 = tcFeedArr[4].search("N/A");
          if(search4 == -1){
            if(tcFeedArr[4].search("Worked") != -1){
              color4 = "green";
            }
            if(tcFeedArr[4].search("output") != -1){
              color4 = "red";
            }
          }
          else{
            color4 = "black";
          }
          
          search5 = tcFeedArr[5].search("N/A");
          if(search5 == -1){
            if(tcFeedArr[5].search("Worked") != -1){
              color5 = "green";
            }
            if(tcFeedArr[5].search("output") != -1){
              color5 = "red";
            }
          }
          else{
            color5 = "black";
          }
          
          var comArr = comments.split(",");
  
          general = '<div class=description style=color:white; padding:10px>'+ '<br><font color="blue">Question '+ qnum +" you got "+ fg+' out of '+ tpts+ ' points</font><br>'+ desc + '</div><pre><p>Your Answer: <br>'+ answer +'</pre><p>Teacher comments: '+ comArr[0]+ " " +comArr[1] + " "+ comArr[2]+ " " +comArr[3] + " " +comArr[4] +'</p><p><b>Deduction breakdown: <br>'+ fullcred + fn+ col + comp + con  + tc + '</b></p>';
  
          
          tcRow ='<table><tr><td><table border=1><tr><td>TESTCASE INPUT</td><td>EXPECTED OUTPUT</td></tr><tr><td>'+ tc1 +'</td><td>'+tc1o +'</td></tr><tr><td>'+ tc2 +'</td><td>'+tc2o +'</td></tr><tr><td>'+ tc3 +'</td><td>'+tc3o +'</td></tr><tr><td>'+ tc4+'</td><td>'+tc4o +'</td></tr><tr><td>'+ tc5 +'</td><td>'+tc5o +'</td></tr><tr><td>'+tc6 +'</td><td>'+tc6o +'</td></tr></table></td><td><table border=1><tr><td>YOUR OUTPUTS</td></tr><tr><td><font color='+color0+'>'+ tcFeedArr[0]+ '</font></td></tr><tr><td><font color='+color1+'>'+ tcFeedArr[1] +'</font></td></tr><tr><td><font color='+color2+'>'+ tcFeedArr[2]+'</font></td></tr><tr><td><font color='+color3+'>'+ tcFeedArr[3]+'</font></td></tr><tr><td><font color='+color4+'>'+ tcFeedArr[4]+'</font></td></tr><tr><td><font color='+color5+'>'+ tcFeedArr[5]+'</font></td></tr></table></td></tr></table>'; 
          
          intfg = Number(fg);
          console.log("FG"+intfg);
          inttpts = Number(tpts);
          score += intfg;
          console.log("SCOREEEEEE"+score);
          totalScore = "<font color='#ffff00'>SCORE: " + score;
          out += inttpts;
          outOf = " out of " + out + "</font>"; 
          percentage = score / out * 100;
          if(percentage >= 89){
            message = "A, Great Job!!!";
          }
          if(percentage < 89 && percentage >=79){
            message = "B, well done.";
          }
          if(percentage < 79 && percentage >=69){
            message = "C, study harder next time";
          }
          if(percentage < 69 && percentage >=59){
            message = "D, you need to do better on the next exam to pass the class";
          }
          if(percentage < 59){
            message = "F, come to my office hours";
          }
          msg = " You got a " + message;
      }
      else{
        general = "";
        tcRow = "";
        totalScore = "";
        outOf = "";
        msg = "";
      }
          exdata += general + tcRow;
          
        
        }
      document.getElementById("insert3").innerHTML = totalScore + outOf + msg + exdata;
  }
  
  function getSpecificExamInfo(cFunction){
    var xhttp = new XMLHttpRequest();
    payload= {
      "exid": exid
    }
    //xhttp.open("POST", "https://web.njit.edu/~cfl4/postExamBack.php", true);
    xhttp.open("POST", "https://web.njit.edu/~gvc3/sendGradedExamFrontM.php", true);
    var myJSON = JSON.stringify(payload);
    xhttp.send(myJSON);
    console.log(myJSON);
    xhttp.onreadystatechange = function(){
      if(xhttp.readyState == 4 && xhttp.status == 200){
        console.log("Tanvir:");
        console.log(xhttp.responseText);
        jsonObj2 = JSON.parse(xhttp.responseText);
        //console.log(jsonObj2);
        cFunction(jsonObj2);
      }
    };
  }
  
  function submit(cFunction){
    console.log("Request to make buttons");
    //var exID = document.getTest.examID.value; 
    var xhttp = new XMLHttpRequest();
    //var payload = JSON.stringify({"exID":exID});
    var payload = {
      "msg": "HELLO"
    }
    //xhttp.open("POST", "https://web.njit.edu/~cfl4/postExamBack.php", true);
    xhttp.open("POST", "https://web.njit.edu/~gvc3/selectExamInfoM.php", true);
    xhttp.send(payload);
    console.log(payload);
    xhttp.onreadystatechange = function(){
      if(xhttp.readyState == 4 && xhttp.status == 200){
        console.log(xhttp.responseText);
        jsonObj = JSON.parse(xhttp.responseText);
        //console.log(jsonObj);
        cFunction(jsonObj);
      }
  
    };
  }
  getExams();
</script>
</body>
</html>