<?php
class VisitorDTO{
    private $vid;
    private $national_id;
    private $first_name;
    private $last_name;
    private $reason;

    public function __construct($vid,$national_id,$first_name,$last_name,$reason){
        $this->vid=$vid;
        $this->national_id=$national_id;
        $this->first_name=$first_name;
        $this->last_name=$last_name;
        $this->reason=$reason;
    }
    public function getVid(){
        return $this->vid;
    }
    public function getNational_id(){
        return $this->national_id;
    }
    public function getFirst_name(){
        return $this->first_name;
    }
    public function getLast_name(){
        return $this->last_name;
    }
    public function getReason(){
        return $this->reason;
    }

    
}

?>