<?php

class EngineerControl{

    public $complainT;
    public $querry;

    public function __construct(){
        $this->complainT = new ComplainDAO();
        $this->querry = new QuerryDAO();
    }

    //complains which are only in cretaed state and echo a table
    public function displayCreatedComplains(){
        $rows=$this->querry->getComplains();
        if ($rows){
        foreach($rows as $row){

            echo "<tr onclick=\"displaySelectedRecord({$row['compid']})\"><td>".$row['compid']."</td><td>".$row['Numplate']."</td><td>".$row['description']."</td><td>".$row['date']."</td></tr>";
        }
    }
    }

    public function displayComplainById($compid){
        //return $this->complainT->search($compid);
        return $this->querry->giveComplainDetails($compid);

    }

    //get all workers who are free
    public function displayFreeWorkers(){
        return $this->querry->getFreeWorkers();
    }

    public function addworkers($compid,$workerid){
        $this->querry->addworkertodb($compid,$workerid);
    }

    //display the worker added complains in a table
    public function displayWorkerAddedComplian(){
        $rows= $this->querry->getWorkerAddedComplain();
        $temp=null;
        $prev_empid=null;
        $out_string=null;
        $not_done=1;
        foreach($rows as $row){
            $delay=$this->countDayDelay($row['date']);
        if ($row['compid']==$temp){
            $out_string=$out_string.",".$row['FirstName'];
        }

        //if all the same rows are added
        else if ($temp!=null){
            $out_string=$out_string."</td></tr>";
            echo $out_string;
            $temp=null;
            $prev_empid=null;
            $not_done=0;
        }
        
        //new row
        if ($temp==null){
            $out_string="<tr onclick=\"displaySelectedRecord({$row['compid']})\"><td>". $row['compid'] . "</td><td>". $row['Numplate'] . "</td><td>". $row['description'] . "</td><td>". $delay . "</td><td>". $row['FirstName'] ;
            $temp=$row['compid'];
            $prev_empid=$row['empid'];
            $not_done=1;
        }
        
        }
        if ($not_done==1){
            $out_string=$out_string."</td></tr>";
            echo $out_string;
        }
    }

    public function closeComplain($compid){
        $this->querry->closeComplainDb($compid);
        $workers=$this->querry->getAssignWorkers($compid);
        foreach($workers as $worker){
            $this->querry->freeTheWorker($worker['empid']);
        }
        $this->querry->busToRun($compid);
    }
    //support function to calculate date delay
    public function countDayDelay($createdDate){
        $date1=$createdDate;
        $date2=date("Y-m-d");

        $date1_array=explode("-",$date1);
        $date2_array=explode("-",$date2);

        if ($date2_array[0]!=$date1_array[0]){
        // echo "year";
        }
        else if($date2_array[1]!= $date1_array[1]){
            //echo "month";
            if(($date2_array[2]- $date1_array[2])>=0){
                return "over a month";
            }
            else{
                $change=($date2_array[2]+ (30-$date1_array[2]));
                return "{$change} days";
            }
        }
        else if($date2_array[2]!= $date1_array[2]){
            $day_change=$date2_array[2]-$date1_array[2];
            return "{$day_change} days";
        }

    }

}

?>