<?php
class visitorDAO implements CrudDAO{
    private $dbconnection;
    public function __construct(){
        $this->dbconnection= Dbh:: getInstance();
    }

    public function save($savable){
        $national_id=$savable->getNational_id();
        $first_name=$savable->getFirst_name();
        $last_name=$savable->getLast_name();
        $reason=$savable->getReason();
        $time = date("h:i:s");
        $date = date("Y-m-d");
        $sql="INSERT INTO visitor(vid,national_id,first_name,last_name,reason,date,on_time,off_time) 
        VALUES ('','$national_id','$first_name','$last_name','$reason','$date','$time','')";
        $stmt = $this->dbconnection->connect()->prepare($sql);
        $stmt->execute();

        
    }
    public function update($updatable){
        $time = date("h:i:s");
        $n_id=$updatable->getNational_id();
        $sql="UPDATE visitor SET off_time='$time' WHERE off_time='00:00:00' AND national_id='$n_id'";
        $stmt = $this->dbconnection->connect()->prepare($sql);
        $stmt->execute();
    }
    public function delete($deletable){}

    public function search($searchable){}
    
    public function getAll(){
        $sql="SELECT vid,national_id,first_name FROM visitor WHERE off_time='00:00:00'";
        $stmt=$this->dbconnection->connect()->prepare($sql);
        $stmt->execute();
        $results=$stmt->fetchAll();
        return $results;
    }


}
?>