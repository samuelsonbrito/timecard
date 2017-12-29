<?php 

namespace TimeCard\Card;

use \DateTime;

class Schedules {

	private $date;
	private $hour1;
	private $hour2;
	private $hour3;
	private $hour4;

    public function __construct($date, array $hours){
    	$this->date = null ?? new DateTime($date);
        $this->hour1 = null ?? new DateTime($hours[0]);
        $this->hour2 = null ?? new DateTime($hours[1]);
        $this->hour3 = null ?? new DateTime($hours[2]);
        $this->hour4 = null ?? new DateTime($hours[3]);
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