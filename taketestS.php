<?php 
  include "studentnav.php";
  
?>
<h2>Take your test here...</h2>

<div class="row">
  
  <div class="test" style="background-color:#aaa;">
    <form id="masterForm">
      <fieldset>
      <p id="insert0"></p>
      <table id="insert3">
      <p id="insert1"></p>
      </table>
      <p id="insert2"></p>
      <p style="font-size:12px;">**Press only when you want to submit**</p>
      <button id="sAnswerSubmit" type="button">Submit Exam</button>
      <p id="response"></p>
      </fieldset>
    </form>
  </div>
</div>
<script type="text/javascript">
  /*var btn = document.getElementById("btn");
  btn.addEventListener("click", submit);*/
  var makeTbtn = document.getElementById("sAnswerSubmit");
  makeTbtn.addEventListener("click", sendTest2Back);
  
  function getExams(){
    submit(btnFunc);
  }
  function btnFunc(jsonObj){
    var i, a="", b = "", exName="", exID="", releaseStatus ="";
    for(i=0; i<jsonObj.length; i++){
      exID = jsonObj[i].examID;
      exName = jsonObj[i].examname;
      releaseStatus = jsonObj[i].releasestatus;
      //console.log(releaseStatus);
      if(releaseStatus == "0"){
        a += '<br><button type="button" onclick="getExam(\'' + exID + '\',\'' + exName + '\')">Take</button> ' + exName;
      }
      else{
        b += "You have already taken: " + exName + '<br>';
      } 
    }
    document.getElementById("insert0").innerHTML = a + '<br>'+ b;
  }
  function getExam(exID, exName){
    exid = exID;
    exname = exName;
    document.getElementById("insert0").innerHTML = "You are now taking exam: " + exName;
    document.getElementById("insert1").innerHTML = '';
    document.getElementById("insert2").innerHTML = '';
    getSpecificExamInfo(buildExam);
  }
  function buildExam(jsonObj2){
  //console.log(jsonObj2.length);
  var j, exdata = "", qID = "", desc = "", qtype = "";
      for(j=0; j<jsonObj2.length; j++){
        qID = jsonObj2[j].qID;
        exID = jsonObj2[j].examID;
        qnum = j+1;
        desc = jsonObj2[j].question;
        pts = jsonObj2[j].point;
        //console.log(qnum);
        exdata += '<tr id="q' + j +'"><td>' + qnum + '</td><td>' + desc + '</td><td>' + pts + '</td><td><pre><textarea name="sAnswer[]" rows="10" cols="50" style="font-family: courier new"></textarea></pre></td><td><input type="text" name="qID[]" value=' + qID + ' hidden></td><td><input type="text" name="exID" value=' + exID + ' hidden></td><td><input type="text" name="pts[]" value=' + pts + ' hidden></td></tr>';
        }
      
      document.getElementById("insert3").innerHTML = '<tr><th>Number</th><th>Question</th><th>Point Value</th><th>Answers</th></tr>' + exdata;
  }
  
  function getSpecificExamInfo(cFunction){
    var xhttp = new XMLHttpRequest();
    payload= {
      "exid": exid
    }
    //xhttp.open("POST", "https://web.njit.edu/~cfl4/postExamBack.php", true);
    xhttp.open("POST", "https://web.njit.edu/~gvc3/postExamBackM.php", true);
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
  function sendTest2Back(){
    console.log("Button 2 make test Pressed");
    //var exName = document.getElementById("exName").value;
    var xhttp = new XMLHttpRequest();
    var x = document.forms["masterForm"];
    //var qID = x.getElementsByName('qID[]');
    //var pts = document.getElementsByName('points[]');
    
    //var qID = x.elements.namedItem("qID[]");
    //console.log(qID);
    var Apayload = [], QIDpayload= [], Ppayload= [], payload= [];
    var i, j, k, m;
    
    for(i=1; i<x.length-1; i++){
      payload.push(x.elements[i].value);
    }
    //var docLength = x.length;
    console.log(payload);
    //console.log(payload.length);
    //console.log(payload["0"]);
    for(j=0;j<payload.length; j=j+4){
      Apayload.push(payload[j] + "~");
      //console.log(payload[j]);
    }
    for(k=1; k<payload.length; k=k+4){
      QIDpayload.push(payload[k]);
    }
    for(m=3; m<payload.length; m=m+4){
      Ppayload.push(payload[m]);
    }
    var exID = payload[2];
 
    console.log("QIDs:"+QIDpayload);
    console.log("Answers:"+ Apayload);
    console.log("exID:"+ exID);
    console.log("Pts:" + Ppayload);
    
    var sendPayload ={
      "QIDpayload": QIDpayload,
      "Apayload": Apayload,
      "exID": exID,
      "Ppayload": Ppayload
    }
    
    var myJSON = JSON.stringify(sendPayload);
    console.log(myJSON);
    
    //xhttp.open("POST", "https://web.njit.edu/~gvc3/maketestM.php", true);
    xhttp.open("POST", "https://web.njit.edu/~gvc3/studentAnswersM.php", true);
    //xhttp.open("POST", "https://web.njit.edu/~cfl4/studentAnswers.php", true);
    xhttp.send(myJSON); //send stringified payload
    
    xhttp.onreadystatechange = function(){
      if(xhttp.readyState == 4 && xhttp.status == 200){
          var response = this.responseText;
          console.log(response);
          document.getElementById("insert0").innerHTML = '';
          document.getElementById("insert3").innerHTML = "You have completed the exam you may now close the page";
          document.getElementById("response").innerHTML = '<p style="background-color: #0033cc; color: white;">View your graded exam in the View Graded Test Tab</p>';
      };
    }
  }
  getExams();
</script>
</body>
</html>

