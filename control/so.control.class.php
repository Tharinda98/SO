<?php

include "FacadeMaker.inf.php";

class SoControl implements FacadeMaker{
    public $attendanceT;
    public $querry;
    public function __construct(){
        $this->attendanceT = new AttendancerecordDAO();
        $this->visitorT=new VisitorDAO();
        $this->querry = new QuerryDAO();

    }

    public function showusers($id){
        $results = $this->getUser($id);
        while ($row = $results){
            echo $row;
        }
    }

    public function addrecord($id){
        if ($this->checkID_employee($id) AND $this->checkID_att($id)){
            $this->addAttendance($id);
            echo "done";
        }
        else{
            echo "Incorrect ID";
        }
        
    }

    public function offrecord($id){
        if (!$this->markOff($id)){
            echo "record not found";
        }
        else{echo"done";}
        
    }   

    //marking attendance
    public function markattendance($obj){

        //check whether it is an valid id
        if ($this->querry->checkID_employee($obj->empid)){
            
            //check whether there is already a unleaved attendance record(true if not have live attended record)
            $res=$this->attendanceT->search($obj);
            
            if ($res==NULL){
                //mark the attendance
                $this->attendanceT->save($obj);
                echo 'done';
            }
            else{echo 'marked as attended before';}
        }
        else{
            echo"Incorrect ID";
        }
    }

    //mark off time of an attended employee
    public function markoff($obj){
        //check whether there is already a unleaved attendance record(true if not have live attended record)
        if ($this->querry->checkID_employee($obj->empid)){
            $res=$this->attendanceT->search($obj);
            //if true that means there isnt a attendance record
            if ($res==NULL){
                echo 'not attended before';
            }
            else{
                $this->attendanceT->update($obj); 
                echo "done";
            }
        }
        else{
            echo"Incorrect ID";
        }
    }

    //search emplyee by id and return the details to display
    public function displayEmployeeById($empid){
        return $this->querry->getEmployeeByID($empid);
    }

    //give the attended worker list to the admin on a curresponding date
    public function givetoadmin(){
        //funcion to call
        $display="<table>";
        $attended=$this->querry-> getAttendedEmployee();
        $display.="<tr><th>Employee</th><th>ON_time</th></tr>";
        
        foreach($attended as $row){
            $display.="<tr>";
            $display.="<td>{$row['FirstName']}</td>";
            $display.="<td>{$row['ontime']}</td>";
            $display.="</tr>";
        }
        $display.="</table>";
        return $display;

    }

    //add a new visitor 
    public function addNewVisitor($obj){
        $this->visitorT->save($obj);
    }

    //show added visitors
    public function visitingVisitors(){
        
        $attended=$this->visitorT-> getAll();
        $display="";
        
        foreach($attended as $row){
            $id=$row['national_id'];
            $display.="<tr onclick=\"selectedVisitor('{$row['national_id']}')\">";
            $display.="<td style=\"width:60%\">{$row['first_name']}</td>";
            $display.="<td>{$row['national_id']}</td>";
            $display.="</tr>";
        }
        
        return $display;
    }

    //leave a visitor
    public function visitorLeave($obj){
        $this->visitorT->update($obj);
    }
}



?>
