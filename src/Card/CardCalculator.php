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
        $this->hour1 = $hour1;
        $this->hour2 = $hour2;
        $this->hour3 = $hour3;
        $this->hour4 = $hour4;
    }

    public function worked(){
    	
    }
}