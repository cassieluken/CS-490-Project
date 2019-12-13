<?php 

include "teachernav.php"; 

?>

<h2>Create a Question Below</h2></br>

<div class="row">
  <div class="column left" style="background-color:#ff8080;">
  <h2>Add New Question</h2>
  <form name="addQuestionForm">  
  	<label for="type">Type: </label>
    <select id="type" name="type">
      <option value="">Any</option>
      <option value="Math">Math</option>
      <option value="String">String</option>
      <option value="Conditional">Conditional</option>
    </select></br>
    <h3>Constraint: </h3>
  	<input type="radio" id="for" name="constraint" value="for">For Loop<br>
  	<input type="radio" id="while" name="constraint" value="while">While Loop<br>
  	<input type="radio" id="print" name="constraint" value="print">Print<br>
    <p>Write a function named</p>
    <textarea id="new_funcName" style="width=100px;height:30px;" placeholder="function name"></textarea>
    <p>that</p>
    <textarea id="new_problem"></textarea></br>
    
    <p style="font-size:12px;">NOTE: if you are inputting a string and numerical values make sure you insert it as a function call would have it -- example: megamind("+", 2, 1) so input would be "+", 2, 1 </p>
    <label>Testcase 1: </label></br>
    <label class="mini_label" for="new_tc1IN">Input: </label>
	  <textarea id="new_tc1IN" style="width:85px;height:30px;"></textarea>
    <label class="mini_label" for="new_tc1OUT">Output: </label>
	  <textarea id="new_tc1OUT" style="width:85px;height:30px;"></textarea></br>
    
    <label>Testcase 2: </label></br>
    <label class="mini_label" for="new_tc2IN">Input: </label>
	  <textarea id="new_tc2IN" style="width:85px;height:30px;"></textarea>
    <label class="mini_label" for="new_tc2OUT">Output: </label>
	  <textarea id="new_tc2OUT" style="width:85px;height:30px;"></textarea></br>
    
    <label>Testcase 3: </label></br>
    <label class="mini_label" for="new_tc3IN">Input: </label>
	  <textarea id="new_tc3IN" style="width:85px;height:30px;"></textarea>
    <label class="mini_label" for="new_tc3OUT">Output: </label>
	  <textarea id="new_tc3OUT" style="width:85px;height:30px;"></textarea></br>
    
    <label>Testcase 4: </label></br>
    <label class="mini_label" for="new_tc4IN">Input: </label>
	  <textarea id="new_tc4IN" style="width:85px;height:30px;"></textarea>
    <label class="mini_label" for="new_tc4OUT">Output: </label>
	  <textarea id="new_tc4OUT" style="width:85px;height:30px;"></textarea></br>
    
    <label>Testcase 5: </label></br>
    <label class="mini_label" for="new_tc5IN">Input: </label>
	  <textarea id="new_tc5IN" style="width:85px;height:30px;"></textarea>
    <label class="mini_label" for="new_tc5OUT">Output: </label>
	  <textarea id="new_tc5OUT" style="width:85px;height:30px;"></textarea></br>
    
    <label>Testcase 6: </label></br>
    <label class="mini_label" for="new_tc6IN">Input: </label>
	  <textarea id="new_tc6IN" style="width:85px;height:30px;"></textarea>
    <label class="mini_label" for="new_tc6OUT">Output: </label>
	  <textarea id="new_tc6OUT" style="width:85px;height:30px;"></textarea></br>
    
  	<h3>Difficulty of the Question:</h3>
  	<input type="radio" id="easy" name="difficulty" value="Easy">Easy<br>
  	<input type="radio" id="med" name="difficulty" value="Medium">Medium<br>
  	<input type="radio" id="hard" name="difficulty" value="Hard">Hard<br>
  	<p id="response"></p><br>
    <p style="font-size:12px;">**Refresh after adding question</p>
    <button type="button" id="btn">Add Question</button>
  </form>
  </div>
  
  <div class="column right" style="background-color:#aaa;">
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
    <table id="exam_container" border="1">
      
    </table>
    <p id="error"></p>
  </div>
</div>
<script type="text/javascript">
  //Button for filtering
  var btnSort = document.getElementById("btnSort");
  btnSort.addEventListener("click", showQB);

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
          qbData += '<tr><td>' + qtype + '</td><td>' + diff + '</td><td>' + desc + '</td>';
          console.log('filter');
        }
      }
      document.getElementById("exam_container").innerHTML = '<tr><th>Type</th><th>Difficulty</th><th>Question</th></tr>' + qbData;
  }
    
  var btn = document.getElementById("btn");
  btn.addEventListener("click", newQuestionFunc);
  
  function checkDifficulty(){
    if(document.getElementById('easy').checked){
      var lvl = document.getElementById('easy').value;
    }
    else if(document.getElementById('med').checked){
      var lvl = document.getElementById('med').value;
    }
    else if(document.getElementById('hard').checked){
      var lvl = document.getElementById('hard').value;
    }
    else{
      document.getElementById("error").innerHTML = "Please enter a difficulty";
    }
    return lvl;
  }
  function checkConstraint(){
    if(document.getElementById('for').checked){
      var constraint = document.getElementById('for').value;
    }
    else if(document.getElementById('while').checked){
      var constraint = document.getElementById('while').value;
    }
    else if(document.getElementById('print').checked){
      var constraint = document.getElementById('print').value;
    }
    else{
      var constraint = "";
    }
    return constraint;
  }
  
  function newQuestionFunc(cFunction){
    console.log("Button Pressed!!!");
    var question = document.getElementById('new_problem').value;
    var tc1IN = document.getElementById('new_tc1IN').value;
    var tc1OUT = document.getElementById('new_tc1OUT').value;
    var tc2IN = document.getElementById('new_tc2IN').value;
    var tc2OUT = document.getElementById('new_tc2OUT').value;
    var tc3IN = document.getElementById('new_tc3IN').value;
    var tc3OUT = document.getElementById('new_tc3OUT').value;
    var tc4IN = document.getElementById('new_tc4IN').value;
    var tc4OUT = document.getElementById('new_tc4OUT').value;
    var tc5IN = document.getElementById('new_tc5IN').value;
    var tc5OUT = document.getElementById('new_tc5OUT').value;
    var tc6IN = document.getElementById('new_tc6IN').value;
    var tc6OUT = document.getElementById('new_tc6OUT').value;
    var type = document.getElementById('type').value;
    var funcName = document.getElementById('new_funcName').value;
    var difficulty = checkDifficulty();
    var constraint = checkConstraint();
    //console.log(difficulty);
    
    var xhttp = new XMLHttpRequest();
    var msg = "addQuestionTB";
    var payload = {
      "funcName": funcName,
      "question":"Write a function named "+ funcName + " that " +question,
      "tc1IN":tc1IN,
      "tc1OUT": tc1OUT,
      "tc2IN": tc2IN,
      "tc2OUT": tc2OUT,
      "tc3IN": tc3IN,
      "tc3OUT": tc3OUT,
      "tc4IN": tc4IN,
      "tc4OUT": tc4OUT,
      "tc5IN": tc5IN,
      "tc5OUT": tc5OUT,
      "tc6IN": tc6IN,
      "tc6OUT": tc6OUT,
      "type":type,
      "difficulty":difficulty,
      "constraint": constraint,   
    }
    //console.log(payload);
    var myJSON = JSON.stringify(payload);
    console.log(myJSON);
    
    xhttp.onreadystatechange = function(){
      if(xhttp.readyState == 4 && xhttp.status == 200){
          //console.log("pls WORK");
          document.getElementById("response").innerHTML = '<p style="background-color: #0033cc; color: white;">Added q success</p>';
      };
    }
    xhttp.open("POST", "https://web.njit.edu/~gvc3/addQuestionM.php", true);
    //xhttp.open("POST", "https://web.njit.edu/~ts557/addQuestionBack.php", true);
    //xhttp.open("POST", "https://web.njit.edu/~cfl4/addQuestionBack.php", true);
    xhttp.send(myJSON); //send stringified payload 
  }
  
  function submit(cFunction){
    console.log("Button Pressed");
    
    var xhttp = new XMLHttpRequest();
    var msg = "addQuestionTB";
    var payload = {
         
    }
    //console.log(payload);
    var myJSON = JSON.stringify(payload);
    console.log(myJSON);
    
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
    //xhttp.open("POST", "https://web.njit.edu/~cfl4/addQuestionBack.php", true);
    xhttp.send(myJSON); //send stringified payload 
  }
  
  showQB();
  
</script>
</body>
</html>

