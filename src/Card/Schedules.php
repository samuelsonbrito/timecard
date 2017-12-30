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

    	$this->date = !empty($date) ? new DateTime($date) : null;
        $this->hour1 = !empty($hours[0]) ? new DateTime($hours[0]) : null;
        $this->hour2 = !empty($hours[1]) ? new DateTime($hours[1]) : null;
        $this->hour3 = !empty($hours[2]) ? new DateTime($hours[2]) : null;
        $this->hour4 = !empty($hours[3]) ? new DateTime($hours[3]) : null;
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