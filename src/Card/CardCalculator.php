<?php

namespace TimeCard\Card;

use \DateTime;
use TimeCard\Time\Time;
use TimeCard\Card\ToleranceTrait;

class CardCalculator{

    use ToleranceTrait;

	private $schedules;
	private $hour1;
	private $hour2;
	private $hour3;
	private $hour4;

    public function __construct(array $hours, $tolerance = null){
    	$this->tolerance = is_int($tolerance) ? 5 : $tolerance;
        $this->hour1 = null ?? new DateTime($hours[0]);
        $this->hour2 = null ?? new DateTime($hours[1]);
        $this->hour3 = null ?? new DateTime($hours[2]);
        $this->hour4 = null ?? new DateTime($hours[3]);
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

    public function extraNight(){

    }

    /**
    * Dividindo extras em partes para depois unir no overtime()
	*/

    public function overtimeHour1(){

        if($this->hour1 < ($this->tolerancePlus($this->schedules->getHour1()))){

            $interval = $this->hour1->diff($this->schedules->getHour1());

            return $interval->format("%H:%I:%S");
        }
    }

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

    /**
    * Período de intervalo - coletando extras de cada intervalo de forma dinâmica
    */
    public function overtimeInterval1(){
    	$hoursInterval = $this->schedules->getHour2()->diff($this->schedules->getHour3());
    	$hoursIntervalTolerance = Time::sub($hoursInterval->format("%H:%I:%S"),$this->tolerance);
    	$hoursIntervalRegister = $this->hour2->diff($this->hour3);

    	if(strtotime($hoursIntervalRegister->format("%H:%I:%S")) < strtotime($hoursIntervalTolerance)){

    	return Time::diffHours($hoursIntervalRegister->format("%H:%I:%S"),$hoursInterval->format("%H:%I:%S"));
    	}

    }

    /**
    * Dividindo extras em partes para depois unir no overtime()
    */

    public function overdueHour2(){

        if($this->hour2 < $this->toleranceLess($this->schedules->getHour2())){

            $interval = $this->hour2->diff($this->schedules->getHour2());

            return $interval->format("%H:%I:%S");
        }
    }

    public function overdueHour4(){

        if($this->hour4 < $this->toleranceLess($this->schedules->getHour4())){

            $interval = $this->hour4->diff($this->schedules->getHour4());

            return $interval->format("%H:%I:%S");
        }
    }

    /**
    * Período de intervalo - coletando atrasos de cada intervalo de forma dinâmica
    */
    public function overdueInterval1(){
        $hoursInterval = $this->schedules->getHour2()->diff($this->schedules->getHour3());
        $hoursIntervalTolerance = Time::sum($hoursInterval->format("%H:%I:%S"),$this->tolerance);
        $hoursIntervalRegister = $this->hour2->diff($this->hour3);

        if(strtotime($hoursIntervalRegister->format("%H:%I:%S")) > strtotime($hoursIntervalTolerance)){

        return Time::diffHours($hoursIntervalRegister->format("%H:%I:%S"),$hoursInterval->format("%H:%I:%S"));
        }

    }


}