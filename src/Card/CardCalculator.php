<?php

namespace TimeCard\Card;

use \DateTime;

class CardCalculator
{
	private $schedules;
	private $tolerance;
	private $hour1;
	private $hour2;
	private $hour3;
	private $hour4;

    public function __construct($hour1=null,$hour2=null,$hour3=null,$hour4=null)
    {
    	$this->tolerance = 5;
        $this->hour1 = is_null($hour1) ? null : new DateTime($hour1);
        $this->hour2 = is_null($hour2) ? null : new DateTime($hour2);
        $this->hour3 = is_null($hour3) ? null : new DateTime($hour3);
        $this->hour4 = is_null($hour4) ? null : new DateTime($hour4);
    }

    public function setSchedules($schedules){
    	$this->schedules = $schedules;
    }

    public function worked(){

    	$interval1 = $this->hour1->diff($this->hour2);
    	$interval2 = $this->hour3->diff($this->hour4);

    	$e = new DateTime('00:00');
		$f = clone $e;
		$e->add($interval1);
		$e->add($interval2);

    	return $f->diff($e)->format("%H:%I");
    }

    public function overtime(){

    }

   	public function overdue(){

    }

    /*
    * dividindo extras em partes para depois unir no overtime()
	*/
	
	public function overtimeHour2(){

    	if($this->hour2 > ($this->tolerancePlus($this->schedules->getHour2()))){

    		$interval = $this->hour2->diff($this->schedules->getHour2());

    		return $interval->format("%H:%I:%S");
    	}
    }

    public function overtimeHour4(){

    	if($this->hour4 > ($this->tolerancePlus($this->schedules->getHour4()))){

    		$interval = $this->hour4->diff($this->schedules->getHour4());

    		return $interval->format("%H:%I:%S");
    	}
    }

    /*
    * metodos auxiliares para tolerância
    */
    private function tolerancePlus($hour){
    	$dateTime = clone $hour;
    	return $dateTime->modify("+{$this->tolerance} minutes");
    }

    private function toleranceLess($hour){
    	$dateTime = clone $hour;
    	return $dateTime->modify("-{$this->tolerance} minutes");
    }
}