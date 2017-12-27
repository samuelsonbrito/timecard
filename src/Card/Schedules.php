<?php 

namespace TimeCard\Card;

class Schedules {
	
	private $date;
	private $hour1;
	private $hour2;
	private $hour3;
	private $hour4;

    public function __construct($date = null, $hour1=null,$hour2=null,$hour3=null,$hour4=null)
    {
    	$this->date = is_null($date) ? null : new \DateTime($date);
        $this->hour1 = is_null($hour1) ? null : new \DateTime($hour1);
        $this->hour2 = is_null($hour2) ? null : new \DateTime($hour2);
        $this->hour3 = is_null($hour3) ? null : new \DateTime($hour3);
        $this->hour4 = is_null($hour4) ? null : new \DateTime($hour4);
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