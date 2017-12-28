<?php 

namespace TimeCard\Card;

class Schedules {
	
	private $date;
	private $hour1;
	private $hour2;
	private $hour3;
	private $hour4;

    public function __construct($date, $hours){
    	$this->date = is_null($date) ? null : new \DateTime($date);
        $this->hour1 = is_null($hours[0]) ? null : new \DateTime($hours[0]);
        $this->hour2 = is_null($hours[1]) ? null : new \DateTime($hours[1]);
        $this->hour3 = is_null($hours[2]) ? null : new \DateTime($hours[2]);
        $this->hour4 = is_null($hours[3]) ? null : new \DateTime($hours[3]);
    }

    public function getDate(){
    	return $this->date;
    }

    public function getHour1(){
    	return $this->hour1;
    }

    public function getHour2(){
    	return $this->hour2;
    }

    public function getHour3(){
    	return $this->hour3;
    }

    public function getHour4(){
    	return $this->hour4;
    }

}