<?php

class ComplainDTO{
    public $compid;
    public $dutyid;
    public $description;
    public $date;
    public $state;
    
    public function __construct($compid, $dutyid, $description, $date, $state){
        $this->compid=$compid;
        $this->dutyid=$dutyid;
        $this->description=$description;
        $this->date=$date;
        $this->state=$state;
    }


    public function getCompid(){
        return $this->compid;
    }
    public function getDutyid(){
        return $this->dutyid;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getDate(){
        return $this->date;
    }
    public function getState(){
        return $this->state;
    }
 
 
} 



?>