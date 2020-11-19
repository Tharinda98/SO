<?php
include '../includes/class-autoload.inc.php';
session_start();

if(!isset($_SESSION['userId'])){
  header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Security Officer Control Panel</title>
    <link rel="stylesheet" href="../include/style.css">
    
</head>
<body >


<header>
    <?php
    include "../includes/headerpart.php";
    ?>
</header>


    <div>
        <h3 style="text-align:center">Security Control System</h3>
        <br>
    </div>

    <div style="display: grid;grid-template-columns: auto auto;height:25%;padding: 1px;">

        <div name="Attendance Forms">
            <form class="ON" action = "so.view.php" method="POST">
                    <h4>Mark Attendance</h4>
                    <input id="attended_id" type="text" name="att_id_no" placeholder="Enter ID" oninput="displaySearchedEmployee()">
                    <button class="btn btn-dark" type="submit" >Mark Attendence</button>
                    
            </form>
            <form class ="OFF" action ="so.view.php" method ="POST">
                <h4>Mark Departure</h4>
                <input id="off_id" type="text" name="off_id_no" placeholder="Enter ID" oninput="displaySearchedEmployeeOff()">
                <button class="btn btn-dark" type="submit"> Mark OFF </button>
            </form>
        </div>


        <div id="empDisplay" class="shadow p-3 mb-5 bg-white rounded">
            <div>
            <H3 style="text-align:center">Employee Details</H3>
            Employee ID:<br>
                    First Name:<br>
                    Last Name:<br>
                    Address:<br>
                    Telephone No:<br>
                    Designation:<br>
            </div>
        </div>
    </div>

    <div style="margin-left:800px;margin-right:800px" class="alert alert-warning alert-dismissible fade show" id="display">
        
        <?php

        $factory=new ControllerFactory();
        $ctrl=$factory->getController("SO");


        if (isset($_POST["att_id_no"])){
            $time = date("h:i:s");
            $date = date("Y-m-d");
            $id=$_POST["att_id_no"];
            $mark_on=new AttendancerecordDTO($id,$date,$time,'','1');
            $ctrl->markattendance($mark_on);
        }

        if (isset($_POST["off_id_no"])){
            $time = date("h:i:s");
            $id=$_POST["off_id_no"];
            $mark_off=new AttendancerecordDTO($id,'','',$time,'');
            $ctrl->markoff($mark_off);
        }

        ?>
    </div>


<script>

    function displaySearchedEmployee(){
        var empid=document.getElementById("attended_id").value;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("empDisplay").innerHTML = this.responseText;
            } 
        };
        
        xhttp.open("GET", "../includes/showEmployee.class.php?empid="+empid, true);
        xhttp.send();
    }

    function displaySearchedEmployeeOff(){
        var empid=document.getElementById("off_id").value;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("empDisplay").innerHTML = this.responseText;
            } 
        };
        
        xhttp.open("GET", "../includes/showEmployee.class.php?empid="+empid, true);
        xhttp.send();
    }

    function selectedVisitor(national_id){
        
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("DisplayVisitors").innerHTML = this.responseText;
                
            } 
        };
        
        xhttp.open("GET", "../includes/showEmployee.class.php?national_id="+national_id, true);
        xhttp.send();
    }

</script>




<button class="open-button" onclick="openForm()">Visitor Section</button>

<div style="display: grid;grid-template-columns: auto auto;height:25%;padding: 1px;">

    <div id="myForm" style="display: block">
        <form  action="so.view.php" method="POST">
        Enter Guest Details<br>
        <label >National ID</label>
        <input type="text" name="N_ID" placeholder="Enter National ID" required>
        <label >First Name</label>
        <input type="text" name="F_Name" placeholder="Enter First Name" required>
        <label >Last Name</label>
        <input type="text" name="L_Name" placeholder="Enter Last Name" required><br>
        Enter the reason for visiting<br>
        <textarea rows = "3" cols = "60" name = "reason" required></textarea><br>
        <button class="btn btn-dark" type="submit"> Submit visitor form </button>
        <button type="button" onclick="closeForm()">Close</button>
        </form>
    </div>
    <?php

    if(isset($_POST["N_ID"])){
        $N_ID=$_POST["N_ID"];
        $F_Name=$_POST["F_Name"];
        $L_Name=$_POST["L_Name"];
        $reason=$_POST["reason"];
        $visitor=new VisitorDTO('',$N_ID,$F_Name,$L_Name,$reason);
        $ctrl->addNewVisitor($visitor);
       
    }
    
    if (isset($_POST["visitor_n_id"])){
        $national_id=$_POST["visitor_n_id"];
        $visitor=new VisitorDTO('',$national_id,'','','');
        $ctrl->visitorLeave($visitor);
                
    }
        

    
    ?>

    <div>
        <div name="visitor table"">
        <table class="table" style="display:block;width:250px">
        <thead class="thead-dark"style="display:block">
            <tr><th >Visitor Name</th><th>National ID</th></tr>
        </thead>
        <tbody style="height:150px;display:block;overflow:auto">
            <?php
            echo $ctrl->visitingVisitors();
            ?>
        </tbody>
        </table>
        </div>

        <div id="DisplayVisitors">
            <form action="so.view.php" method="POST">
            <input name="visitor_n_id" readonly>
            <button class="btn btn-dark" type="submit" > Mark OFF </button>
            </form>
        </div>
        
        
    </div>

</div>


<script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}

</script>


<?php
    include "../includes/footerpart.php";
?>

</body>
</html>
