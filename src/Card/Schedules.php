<?php

namespace TimeCard\Card;

use \DateTime;

class Schedules {

	private $data;

    public function __construct($date, array $hours){

    	$this->date = !empty($date) ? new DateTime($date) : null;
        $this->hour1 = !empty($hours[0]) ? new DateTime($hours[0]) : null;
        $this->hour2 = !empty($hours[1]) ? new DateTime($hours[1]) : null;
        $this->hour3 = !empty($hours[2]) ? new DateTime($hours[2]) : null;
        $this->hour4 = !empty($hours[3]) ? new DateTime($hours[3]) : null;
    }

    public function __set($prop, $value){
        $this->data[$prop] = $value;
    }

    public function __get($prop){
        return $this->data[$prop];
    }



}