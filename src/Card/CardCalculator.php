<?php

namespace TimeCard\Card;

class CardCalculator
{
	private $hour1;
	private $hour2;
	private $hour3;
	private $hour4;

    public function __construct($hour1=null,$hour2=null,$hour3=null,$hour4=null)
    {
        $this->hour1 = is_null($hour1) ? null : new \DateTime($hour1);
        $this->hour2 = is_null($hour2) ? null : new \DateTime($hour2);
        $this->hour3 = is_null($hour3) ? null : new \DateTime($hour3);
        $this->hour4 = is_null($hour4) ? null : new \DateTime($hour4);
    }

    public function worked(){

    	$interval1 = $this->hour1->diff($this->hour2);
    	$interval2 = $this->hour3->diff($this->hour4);

    	return $interval2->format("%H:%I:%S");
    }
}