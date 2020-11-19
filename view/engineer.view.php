<?php
include '../includes/class-autoload.inc.php';
session_start();

if(!isset($_SESSION['userId'])){
  header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en" dir = "ltr">
<head>
</style>
<meta charset = "utf-8">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    
<title>Engineer Control Panel</title>

</head>

<body>

<header>
    <?php
    include "../includes/headerpart.php";
    ?>
</header>

<div name="created complains">
<br>
    <h5 style="text-align:center">Complains to be Assign Workers</h5>
    
    <table class="table table-hover" style="min-height:200px;text-align:center;margin-left:auto;margin-right:auto;height:200px;width:80%">
        <thead class="thead-dark">
        <tr>
            <th>Complain ID</th>
            <th>Bus Number</th>
            <th>Complain</th>
            <th>Created Date</th>
        </tr>
        </thead>

        <tbody>
        <?php
            //display newly created complains
            $factory=new ControllerFactory();
            $ctrl = $factory->getController("ENGINEER");
            $ctrl->displayCreatedComplains();
        ?>
        </tbody>
    </table>
</div>


<script>
    function displaySelectedRecord(compid){
        var task="selectRecord"
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("outForm").innerHTML = this.responseText;
            } 
        };
        
        xhttp.open("GET", "../includes/showComplain.class.php?compid="+compid+"&workerid="+""+"&task="+task, true);
        xhttp.send();
    }

    function submit_added_worker(){
        var compid=document.getElementById("selected complain").value;
        var workerid=document.getElementById("add_worker").value;
        if ((compid=="selected Complain ID") && (workerid=="empty")){
            document.getElementById("displayresult").innerHTML = "<p>Select a complain and a worker</p>";
        }else if ((compid!="selected Complain ID") && (workerid=="empty")){
            document.getElementById("displayresult").innerHTML = "<p>Select a worker</p>";
        }else if ((compid =="selected Complain ID") && (workerid!="empty")){
            document.getElementById("displayresult").innerHTML = "<p>Select a complain</p>";
        }else{
            document.getElementById("displayresult").innerHTML = "<p>done</p>";

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                //document.getElementById("outForm").innerHTML = this.responseText;
                window.location.reload();
            } 
            };
        
            xhttp.open("GET", "../includes/showComplain.class.php?compid="+compid+"&workerid="+workerid+"&task=submitWorker", true);
            xhttp.send();
            
        }
    }

        function finish_complain(){
            var compid=document.getElementById("selected complain").value;
            if (compid=="select a complain"){
                document.getElementById("displayresult").innerHTML = "<p>Select a complain to finish</p>";
            }
            else{
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                   document.getElementById("outForm").innerHTML = this.responseText;
                   window.location.reload();
                } 
                };
        
                xhttp.open("GET", "../includes/showComplain.class.php?compid="+compid+"&workerid="+""+"&task=finishComplain", true);
                xhttp.send();
                
                
            }
        }
    
</script>

<div id="displayresult">
</div>

<div name="worker added complains">
<br>
    <h5 style="text-align:center">Workers Assigned Complains</h5>
    
    <table class="table table-hover" style="min-height:200px;text-align:center;margin-left:auto;margin-right:auto;width:80%">
        <thead class="thead-dark">
        <tr>
            <th>Complain ID</th>
            <th>Bus Number</th>
            <th>Complain</th>
            <th>Repair Period</th>
            <th>Assigned Workers</th>
        </tr>
        </thead>
        <tbody>
        <?php
            //display wokers added complains
            $ctrl->displayWorkerAddedComplian();
        ?>
        </tbody>
    </table>
</div>


<div class="form-row">
<div id="outForm">
    <form>
        <input type="text" id="selected complain" value="selected Complain ID" readonly>
        <input type="text" id="selected bus" value="Selected Bus Number" readonly>
    </form>
</div>
</div>

<div id="worker adding">
    <form>
        <select id="add_worker">
        <option id="add_worker" value="empty">select a worker</option>
        <?php
            //get free workers from the employee list
            $names=$ctrl->displayFreeWorkers();
            foreach($names as $name){
                echo "<option id=\"add_worker\" value=\"{$name['empid']}\">{$name['FirstName']}</option>";
            }
        ?>
        </select>

        <button type="button" onclick="submit_added_worker()">add worker</submit>
        <button type="button" onclick="finish_complain()">finish the complain</submit>
    </form>
</div>

<?php
    include "../includes/footerpart.php";
?>
</body>
</html>