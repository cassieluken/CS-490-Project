<?php
include "teachernav.php";
?>
<h2>Create an Exam Below</h2></br>
<p id="response"></p>
<div class="row">
  <form id="masterForm">
    <div class="column left_test">
      <fieldset>
      <input type="text" id="exName" placeholder="Exam Name">
      <div class="totalpoints_container"><h2>Total points:</h2>
      <p id="totalPoints"></p>
      </div>
      <table id="exam_container" border="1">
        <th>Type</th>
        <th>Difficulty</th>
        <th>Question</th>
        <th>Points</th>
      </table>
      <p style="font-size:12px;">**Press only when you are done making the test**</p>
      <button type="button" id="makeT">Make Test</button>
      </fieldset>
    </div>
  </form>
 
  <div class="column right_test" style="background-color:#aaa;">
    <h2>Test Bank</h2>
    <table class="table">
        <thead>
        
          <tr class="filters">
            <th>Type
              <select id="type-filter" class="form-control">
                <option value="Any">Any</option>
                <option value="Math">Math</option>
                <option value="String">String</option>
                <option value="Conditional">Conditional</option>
              </select>
            </th>
            <th>Difficulty
              <select id="difficulty-filter" class="form-control">
                <option value="Any">Any</option>
                <option value="Easy">Easy</option>
                <option value="Medium">Medium</option>
                <option value="Hard">Hard</option>
              </select>
            </th>
            <th>Keyword<input type="search" id="keyword-filter" class="light-table-filter" data-table="table-info" placeholder="Search Keyword">
            </th>
            <button id="btnSort" type="button">Filter</button>
          </tr>
        </thead>
      </table>
    <table id="qb_container" border="1">
      
    </table>
  </div>
</div>
<script type="text/javascript">
  //Button for filtering
  var btnSort = document.getElementById("btnSort");
  btnSort.addEventListener("click", showQB);
 
  var makeTbtn = document.getElementById("makeT");
  makeTbtn.addEventListener("click", sendTest2Back);
  function showQB(){
    submit(buildQB);
  };
 
  function buildQB(jsonObj){
    var filter_type = document.getElementById("type-filter").value;
    var filter_diff = document.getElementById("difficulty-filter").value;
    var filter_keyword = document.getElementById("keyword-filter").value;
    var i, qbData = "", qID = "", desc = "", qtype = "";
      for(i=0; i<jsonObj.length; i++){
        
        qID = jsonObj[i].qID;
        desc = jsonObj[i].question;
        qtype = jsonObj[i].type;
        diff = jsonObj[i].difficulty;
        
        if((filter_diff == diff || filter_diff == "Any") && (filter_type == qtype || filter_type == "Any") && (desc.includes(filter_keyword) || filter_keyword == "")){
          qbData += '<tr id="q' + i +'"><td><button type="button" onclick="removefromQB(q' + i + ')">Add</button></td><td>' + qtype + '</td><td>' + diff + '</td><td>' + desc + '</td><td><input type="text" name="qID[]" value=' + qID + ' hidden></td></tr>';
          //console.log(qID);
        }
      }
      document.getElementById("qb_container").innerHTML = '<tr><th>Add</th><th>Difficulty</th><th>Question</th><th>Type</th></tr>' + qbData;
  }
 
  function removefromQB(field){
    field.removeChild(field.childNodes[0]);
    addToExam(field);
  }
 
  function addToExam(field){
    //console.log('attempted to add');
    var td = document.createElement("td");
    
    //console.log("field="+field);
    var container = document.getElementById('exam_container');
    var pointCell = field.insertCell(3);
    pointCell.innerHTML = '<input type="number" style="width: 40px;" autocomplete="off" name="points[]" oninput="totalPoints()" text-align:"center">'
    container.appendChild(field);
  }
  function totalPoints(){
    var i, total = 0;
    var pts = document.getElementsByName('points[]');
    for(i=0; i<pts.length; i++){
      total += Number(pts[i].value);
    }
    document.getElementById("totalPoints").innerHTML = total;
  }
    
 
  function submit(cFunction){
    console.log("Button Pressed");
    //console.log(difficulty);
    
    var xhttp = new XMLHttpRequest();
    var msg = "SHOWQB";
    var payload = {
         test: "test"
    }
    //console.log(payload);
    var myJSON = JSON.stringify(msg);
    //console.log(myJSON);
    
    xhttp.onreadystatechange = function(){
      if(xhttp.readyState == 4 && xhttp.status == 200){
          //console.log("pls WORK");
          console.log(xhttp.responseText);
          jsonObj = JSON.parse(xhttp.responseText);
          console.log(jsonObj);
          cFunction(jsonObj);
      };
    }
    xhttp.open("POST", "https://web.njit.edu/~gvc3/selectquestionM.php", true);
    //xhttp.open("POST", "https://web.njit.edu/~ts557/selectQuestion.php", true);
    //xhttp.open("POST", "https://web.njit.edu/~cfl4/createExamBackNew.php", true);
    xhttp.send(myJSON); //send stringified payload
  }
  function sendTest2Back(){
    console.log("Button 2 make test Pressed");
    var exName = document.getElementById("exName").value;
    var xhttp = new XMLHttpRequest();
    var x = document.forms["masterForm"];
    //var qID = x.getElementsByName('qID[]');
    //var pts = document.getElementsByName('points[]');
    
    //var qID = x.elements.namedItem("qID[]");
    //console.log(qID);
    var QIDpayload = [], Ppayload= [], payload= [];
    var i, j, k;
    
    for(i=2; i<x.length-1; i++){
      payload.push(x.elements[i].value);
    }
    //var docLength = x.length;
    //console.log(payload);
    //console.log(payload.length);
    //console.log(payload["0"]);
    for(j=0;j<payload.length; j=j+2){
      Ppayload.push(payload[j]);
      //console.log(payload[j]);
    }
    for(k=1; k<payload.length; k=k+2){
      QIDpayload.push(payload[k]);
    }
 
    console.log("QID:"+QIDpayload);
    console.log("Points:"+Ppayload);
    
    var sendPayload ={
      "qID": QIDpayload,
      "points": Ppayload,
      "exName": exName
    }
    
    var myJSON = JSON.stringify(sendPayload);
    console.log(myJSON);
    
    xhttp.open("POST", "https://web.njit.edu/~gvc3/maketestM.php", true);
    //xhttp.open("POST", "https://web.njit.edu/~ts557/createExamBack.php", true);
    //xhttp.open("POST", "https://web.njit.edu/~cfl4/createExamBackNew.php", true);
    xhttp.send(myJSON); //send stringified payload
    
    xhttp.onreadystatechange = function(){
      if(xhttp.readyState == 4 && xhttp.status == 200){
          var response = this.responseText;
          console.log(response);
          document.getElementById("response").innerHTML = '<p style="background-color: #0033cc; color: white;">' + response + '</p>';
      };
    }
  }
  showQB();
 
</script>
</body>
</html>



