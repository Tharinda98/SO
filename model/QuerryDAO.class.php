<?php

class QuerryDAO implements SuperDAO{
    private $dbconnection;

    public function __construct(){
        $this->dbconnection= Dbh::getInstance();
    }

    //udithas code for users
    public function getUser($email,$pwd){
        $sql = 'SELECT * FROM userlist WHERE email = ? AND password = ? LIMIT 1 ';
        $stmt = $this->dbconnection->connect()->prepare($sql);
        $stmt->execute([$email , $pwd]);
    

        $results = $stmt->fetch();
        return $results;
    }


    //check whether the employee id is valid or not by SO
    public function checkID_employee($id){
        $sql = "SELECT empid FROM employee WHERE empid = ?";
        $stmt = $this->dbconnection->connect()->prepare($sql);
        $stmt->execute([$id]);

        $results = $stmt->fetchAll();
        if ($results==NULL){
            return false;
        }
        else{
            return true;
        }
        
    }
    //get complains which are only created
    public function getComplains(){
        $sql= "SELECT complain.compid, bus.Numplate, complain.description, complain.date, complain.state FROM complain INNER JOIN dutyrecord ON complain.dutyid=dutyrecord.dutyid INNER JOIN bus ON dutyrecord.busid=bus.busid WHERE complain.state='created'";
        $stmt=$this->dbconnection->connect()->prepare($sql);
        $stmt->execute();

        $results=$stmt->fetchAll();
        if ($results==NULL){
            return false;
        }
        else{
            return $results;
            echo "done";
        }
    }
    //get the workers who are free
    public function getFreeWorkers(){
        $sql= "SELECT empid,FirstName,Available,Designation FROM employee where Available='1' AND Designation='Worker'";
        $stmt=$this->dbconnection->connect()->prepare($sql);
        $stmt->execute();
        $results=$stmt->fetchAll();
        return $results;
    }

    public function giveDetails($userid){
        $sql = "SELECT first_name,designation,email FROM userlist WHERE id = ?";
        $stmt = $this->dbconnection->connect()->prepare($sql);
        $stmt->execute([$userid]);
        $result = $stmt->fetch();
        return $result;
    }
    public function updatePass($userid,$pass){
        $sql = "UPDATE userlist SET password = ? WHERE id = ?";
        $stmt = $this->dbconnection->connect()->prepare($sql);
        if ($stmt->execute([$pass,$userid])) {
            header('location:../view/profile.php?change=ok');
        }else{
            header('location:../view/profile.php?change=no');
        }           
    }
    //return the attended emplyee list on a curresponding date
    public function getAttendedEmployee(){
        $date = date("Y-m-d");
        $sql = "SELECT attendancerecord.Date, attendancerecord.ontime, attendancerecord.available, employee.FirstName FROM attendancerecord INNER JOIN employee ON attendancerecord.empid=employee.empid WHERE attendancerecord.available='1' AND attendancerecord.Date=?";
        $stmt = $this->dbconnection->connect()->prepare($sql);
        $stmt->execute([$date]);
        $result=$stmt->fetchAll();
        return $result;
    }

    public function addworkertodb($compid,$workerid){
        $sql="INSERT INTO workerassign(compid,empid) 
        VALUES ('$compid','$workerid')";
        $stmt = $this->dbconnection->connect()->prepare($sql);
        $stmt->execute();
        $sql2="UPDATE complain SET state='processed' WHERE compid=$compid";
        $stmt2 = $this->dbconnection->connect()->prepare($sql2);
        $stmt2->execute();
        $sql3="UPDATE employee SET Available='0' WHERE empid=$workerid";
        $stmt3 = $this->dbconnection->connect()->prepare($sql3);
        $stmt3->execute();
    }
    //get the complians which are in processed state
    public function getWorkerAddedComplain(){
        $sql = "SELECT complain.compid,bus.Numplate,complain.description,complain.date,complain.state,.workerassign.empid FROM complain INNER JOIN workerassign on complain.compid=workerassign.compid INNER JOIN dutyrecord on complain.dutyid=dutyrecord.dutyid INNER JOIN bus on dutyrecord.busid=bus.busid WHERE complain.state='processed' ORDER BY complain.compid";
        $stmt = $this->dbconnection->connect()->prepare($sql);
        $stmt->execute();
        $results=$stmt->fetchAll();
        return $results;
    }

    public function closeComplainDb($compid){
        $sql = "UPDATE complain SET state='closed' WHERE compid = ?";
        $stmt = $this->dbconnection->connect()->prepare($sql);
        $stmt->execute([$compid]);
        $result = $stmt->fetch();
        $sql2="SELECT compid,empid FROM workerassign WHERE compid=?";
        $stmt2 = $this->dbconnection->connect()->prepare($sql);
        return $result;
    }

    public function getAssignWorkers($compid){
        $sql="SELECT compid,empid FROM workerassign WHERE compid=?";
        $stmt = $this->dbconnection->connect()->prepare($sql);
        $stmt->execute([$compid]);
        $results=$stmt->fetchAll();
        return $results;
    }

    public function freeTheWorker($empid){
        $sql="UPDATE employee SET Available='1' WHERE empid = ?";
        $stmt = $this->dbconnection->connect()->prepare($sql);
        $stmt->execute([$empid]);
    }

    //search for employee this should be in emp DAO..search for emplyee ids and return details
    public function getEmployeeByID($id){
        $sql = "SELECT empid,FirstName,LastName,Address,Telephone,Designation FROM employee WHERE empid = ?";
        $stmt = $this->dbconnection->connect()->prepare($sql);
        $stmt->execute([$id]);
        $results=$stmt->fetchAll();
        if ($results==NULL){
            return false;
        }
        else{
        return $results;}
    }

    //change bus state as parked
    public function busToRun($compid){
        $sql="SELECT complain.compid, dutyrecord.dutyid, bus.busid,bus.Numplate FROM complain INNER JOIN dutyrecord ON complain.dutyid=dutyrecord.dutyid INNER JOIN bus ON dutyrecord.busid=bus.busid WHERE complain.compid=?";
        $stmt = $this->dbconnection->connect()->prepare($sql);
        $stmt->execute([$compid]);
        $results=$stmt->fetchAll();
        foreach($results as $result){
            $sql2="UPDATE bus SET State='parked' WHERE busid=?";
            $stmt2=$this->dbconnection->connect()->prepare($sql2);
            $stmt2->execute([$result['busid']]);
        }

    }

    
}


?>