<?php 
  include "teachernav.php";
  
?>
<h2>TEST VIEW</h2>

<div class="row">
  
  <div class="test" style="background-color:#aaa;">
    <form id="masterForm">
      <fieldset>
      <p id="insert0"></p>
      <div id="insert3">
      <p id="insert1"></p>
      </div>
      <p id="insert2"></p>
      <p style="font-size:12px;">**Press only when you want to submit**</p>
      <button id="tEditsSubmit" type="button">Submit Edits</button>
      <p id="response"></p>
      </fieldset>
    </form>
  </div>
</div>
<script type="text/javascript">
  /*var btn = document.getElementById("btn");
  btn.addEventListener("click", submit);*/
  var makeTbtn = document.getElementById("tEditsSubmit");
  makeTbtn.addEventListener("click", sendTest2Back);
  
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
        a += '<br><button type="button" onclick="previewExam(\'' + exID + '\',\'' + exName + '\')">Review/Edit Taken Test</button> ' + exName;
      }
      else if(releaseStatus == "2"){
        b += "<br>You have already edited: " + exName;
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
    document.getElementById("insert0").innerHTML = "You are now reviewing/editing exam: " + exName;
    document.getElementById("insert1").innerHTML = '';
    document.getElementById("insert2").innerHTML = '';
    getSpecificExamInfo(buildExam);
    
  }
  function totalPoints(qnum, tps){
          var i, total = 0;
          var override = document.getElementsByName('override'+qnum+'[]');
          for(i=0; i<override.length; i++){
            total += Number(override[i].value);
          }
    document.getElementById('totalPoints'+qnum).innerHTML = tps - total;
  }
  function buildExam(jsonObj2){
  //console.log(jsonObj2.length);
  console.log("LENGTH:"+jsonObj2.length);
  var length = jsonObj2.length-1
  var EXAMid = jsonObj2[length];
  jsonObj2.pop();
  console.log("JSONOBJ:" + jsonObj2);
  var i, j, exdata = "", qID = "", desc = "", qtype = "", tcFeedArr= [], qnum, num=0;
  var general, hidden, header , fnRow, conRow, colonRow, compileRow, tcRow
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
          fN = jsonObj2[j].functionName;
          desc = jsonObj2[j].question;
          diff = jsonObj2[j].difficulty;
          type = jsonObj2[j].type;
          con = jsonObj2[j].qCon;
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
          sg = jsonObj2[j].studentGrade;
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
          answer = jsonObj2[j].answer;
        
        
        if(con == ""){
          con = "None specified";
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
        qnum = qnum - num; 

        general = '<div class=description style=color:white; padding:10px>'+ '<br>Question '+ qnum + '<br>Question Type: ' + type + '<br>'+ desc + '<br>Difficulty: '+ diff + '<br><div style="display:inline-block;">Score: <textarea id="totalPoints'+qnum+'" name="finalScore[]" style="display=inline; width:50px; height: 30px;"">'+sg+'</textarea><p style="display:inline;">out of '+ tpts+' </p><br><pre><p>STUDENT ANSWER: <br>'+ answer +'</p></pre></div></div>';
        
        hidden = '<td><input type="text" name="qID[]" value=' + qID + ' hidden></td><td><input type="text" name="exID" value=' + exID + ' hidden></td><td><input type="text" name="pts[]" value=' + tpts + ' hidden>';
        
        header = '<tr><th>Criteria/Check</th><th>Feedback</th><th>Deductions</th><th>Point Override</th><th>Comment</th></tr>';
        
        fnRow = '<tr id="q' + j +'"><td>Right function name: '+ fN +'</td><td>' + fnFB + '</td><td>' + fnDed + '</td><td><textarea rows="1" cols="5" name="override'+qnum+'[]" oninput="totalPoints('+qnum+','+ tpts+')">' + fnDed +'</textarea></td><td><pre><textarea rows="3" cols="30" placeholder="Insert a comment here..."></textarea></pre></td></tr>';
        
        conRow = '<tr><td>Constraint: '+ con +'</td><td>'+ conFB +'</td><td>'+ conDed +'</td><td><textarea rows="1" cols="5" name="override'+qnum+'[] oninput="totalPoints('+qnum+','+ tpts+')"">'+ conDed +'</textarea></td><td><pre><textarea rows="3" cols="30" placeholder="Insert a comment here..."></textarea></pre></td></tr>';
        
        colonRow ='<tr><td>Colon Check</td><td>'+ colonFB +'</td><td>'+ colonDed +'</td><td><textarea rows="1" cols="5" name="override'+qnum+'[]" oninput="totalPoints('+qnum+','+ tpts+')">'+ colonDed +'</textarea></td><td><pre><textarea rows="3" cols="30" placeholder="Insert a comment here..."></textarea></pre></td></tr>';
        
        compileRow ='<tr><td>Ability to run (compilation error check)</td><td>'+ compileFB +'</td><td>'+ compileDed +'</td><td><textarea rows="1" cols="5" name="override'+qnum+'[]" oninput="totalPoints('+qnum+','+ tpts+')">'+ compileDed +'</textarea></td><td><pre><textarea rows="3" cols="30" placeholder="Insert a comment here..."></textarea></pre></td></tr>';
        
        /*tcRow ='<tr><td><table border=1 bordercolor=green><tr><td>THE TESTCASES</td></tr><tr><td>Input</td><td>Expected Output</td></tr><tr><td>'+ tc1 +'</td><td>'+tc1o +'</td></tr><tr><td>'+ tc2 +'</td><td>'+tc2o +'</td></tr><tr><td>'+ tc3 +'</td><td>'+tc3o +'</td></tr><tr><td>'+ tc4+'</td><td>'+tc4o +'</td></tr><tr><td>'+ tc5 +'</td><td>'+tc5o +'</td></tr><tr><td>'+tc6 +'</td><td>'+tc6o +'</td></tr></table></td><td><table><tr><td></td></tr><tr><td>Total deduction:</td></tr><tr><td>Testcase1: </td></tr><tr><td>testcase2:</td></tr><tr><td>Testcase3:</td></tr><tr><td>Testcase4: </td></tr><tr><td>Testcase5:</td></tr><tr><td>Testcase6:</td></tr></table></td></tr>';*/

        tcRow ='<tr><td><table border=1><tr><td>TESTCASE INPUT</td><td>EXPECTED OUTPUT</td></tr><tr><td>'+ tc1 +'</td><td>'+tc1o +'</td></tr><tr><td>'+ tc2 +'</td><td>'+tc2o +'</td></tr><tr><td>'+ tc3 +'</td><td>'+tc3o +'</td></tr><tr><td>'+ tc4+'</td><td>'+tc4o +'</td></tr><tr><td>'+ tc5 +'</td><td>'+tc5o +'</td></tr><tr><td>'+tc6 +'</td><td>'+tc6o +'</td></tr></table></td><td><table border=1><tr><td>STUDENT RESULTS</td></tr><tr><td>'+ tcFeedArr[0]+ '</td></tr><tr><td>'+ tcFeedArr[1] +'</td></tr><tr><td>'+ tcFeedArr[2]+'</td></tr><tr><td>'+ tcFeedArr[3]+'</td></tr><tr><td>'+ tcFeedArr[4]+'</td></tr><tr><td>'+ tcFeedArr[5]+'</td></tr></table></td><td>'+ tcDed +'</td><td><textarea rows="1" cols="5" name="override'+qnum+'[]" oninput="totalPoints('+qnum+','+ tpts+')">'+ tcDed +'</textarea></td><td><pre><textarea rows="3" cols="30" placeholder="Insert a comment here..."></textarea></pre></td></tr>'; 
        
        }
        else{
          general = "";
          hidden = "";
          header = "";
          fnRow = "";
          conRow = "";
          colonRow = "";
          compileRow = "";
          tcRow = "";
          qnum = j-1;
          
        }
        exdata += general + '<table>'+ hidden + header + fnRow + conRow + colonRow+ compileRow + tcRow +'</table>';
        }
        
      
      document.getElementById("insert3").innerHTML = exdata;
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
    console.log("JSON:");
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
  function sendTest2Back(cFunction){
    var exid
    console.log("Button 2 send test pressed");
    //var exName = document.getElementById("exName").value;
    var xhttp = new XMLHttpRequest();
    var x = document.forms["masterForm"];
    //var qID = x.getElementsByName('qID[]');
    //var pts = document.getElementsByName('points[]');
    
    //var qID = x.elements.namedItem("qID[]");
    //console.log(qID);
    var payload= [], newscore = [], QIDs= [];
    var fnover= [], conover = [], colover= [], compover = [], tcover = [];
    var fncom= [], concom = [], colcom= [], compcom = [], tccom = [];
    var a, b, c, d, e, f;
    
    for(a=1; a<x.length-1; a++){
      payload.push(x.elements[a].value);
    }
    console.log(payload);    
    
    for(b=0;b<payload.length; b=b+14){
      newscore.push(payload[b]);
    }
    for(c=1; c<payload.length; c=c+14){
      QIDs.push(payload[c]);
    }
    var exID = payload[2];
    //index 3 is the total points which we don't need to update
    for(d=4; d<payload.length; d=d+14){
      fnover.push(payload[d]);
      conover.push(payload[d+2]);
      colover.push(payload[d+4]);
      compover.push(payload[d+6]);
      tcover.push(payload[d+8]);
    }
    for(e=5; e<payload.length; e=e+14){
      fncom.push(payload[e]);
      concom.push(payload[e+2]);
      colcom.push(payload[e+4]);
      compcom.push(payload[e+6]);
      tccom.push(payload[e+8]);
    }
    
    
    console.log("QIDs:"+ QIDs);
    console.log("SCOREs:"+ newscore);
    console.log("exID:"+ exid);
    console.log("fnover:" + fnover);
    console.log("conover:" + conover);
    console.log("colover:" + colover);
    console.log("compover:" + compover);
    console.log("tcover:" + tcover);
    console.log("fncom:" + fncom);
    console.log("concom:" + concom);
    console.log("colcom:" + colcom);
    console.log("compcom:" + compcom);
    console.log("tccom:" + tccom);
    var length = fncom.length;
    console.log("LENGTH:" + length);
    
    var comments = [];
    for(f=0; f<length; f++){
      var temp = [fncom[f], concom[f], colcom[f], compcom[f], tccom[f]];
      comments[f] =  temp.join(" , ");
      console.log("COMMENT"+f + ":" + comments[f]);
    }
    var newcom = comments.join("~");
    console.log("comments: "+ newcom);
    var sendPayload ={
      "QIDs": QIDs,
      "SCOREs": newscore,
      "exID": exID,
      "fnover": fnover,
      "conover" : conover,
      "colover": colover,
      "compover":  compover,
      "tcover": tcover,
      "comments": newcom
    }
    
    var myJSON = JSON.stringify(sendPayload);
    console.log(myJSON);
    
    xhttp.open("POST", "https://web.njit.edu/~gvc3/updateCommentsPointsM.php", true);
    //xhttp.open("POST", "https://web.njit.edu/~ts557/updateCommentsPoints.php", true);
    //xhttp.open("POST", "https://web.njit.edu/~cfl4/studentAnswers.php", true);
    xhttp.send(myJSON); //send stringified payload
    
    xhttp.onreadystatechange = function(){
      if(xhttp.readyState == 4 && xhttp.status == 200){
          var response = this.responseText;
          console.log(response);
          //document.getElementById("insert0").innerHTML = '';
          document.getElementById("insert3").innerHTML = "To start again refresh the page";
          //document.getElementById("response").innerHTML = '<p style="background-color: #0033cc; color: white;">' + response + '</p>';
          document.getElementById("response").innerHTML = '<p style="background-color: #0033cc; color: white;">Your changes have been submitted, you may now close the page</p>';
      };
    }
  }
  getExams();
</script>
</body>
</html>
