<?php

namespace TimeCard\Card;

use \DateTime;
use TimeCard\Time\Time;
use TimeCard\Card\ToleranceTrait;

class CardCalculator{

    use ToleranceTrait;

	private $schedules;
    private $hoursCount;
	private $hour1;
	private $hour2;
	private $hour3;
	private $hour4;

    public function __construct(array $hours, $tolerance = '00:05:00'){

        $this->hoursCount = count(array_filter($hours));

    	$this->tolerance = is_int($tolerance) ? 5 : $tolerance;
        $this->hour1 = !empty($hours[0]) ? new DateTime($hours[0]) : null ;
        $this->hour2 = !empty($hours[1]) ? new DateTime($hours[1]) : null ;
        $this->hour3 = !empty($hours[2]) ? new DateTime($hours[2]) : null ;
        $this->hour4 = !empty($hours[3]) ? new DateTime($hours[3]) : null ;
    }

    public function setSchedules($schedules){
    	$this->schedules = $schedules;
    }

    public function worked(){

    	$interval1 = Time::diffOrNull($this->hour1,$this->hour2);

    	$interval2 = Time::diffOrNull($this->hour3,$this->hour4);

    	return Time::sumDateTime($interval1,$interval2);
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

            $interval = Time::diffValueOrNull($this->hour1,$this->schedules->getHour1());

            return $interval;
        }
    }

	public function overtimeHour2(){

    	if($this->hour2 > ($this->tolerancePlus($this->schedules->getHour2()))){

    		$interval = Time::diffValueOrNull($this->hour2,$this->schedules->getHour2());

    		return $interval;
    	}
    }

    public function overtimeHour4(){

    	if($this->hour4 > ($this->tolerancePlus($this->schedules->getHour4()))){

            Time::diffValueOrNull($this->hour4,$this->schedules->getHour4());

    		return $interval;
    	}
    }

    /**
    * Período de intervalo - coletando extras de cada intervalo de forma dinâmica
    */
    public function overtimeInterval1(){

    	$hoursInterval = Time::diffValueOrNull($this->schedules->getHour2(),$this->schedules->getHour3());
    	$hoursIntervalTolerance = Time::sub($hoursInterval,$this->tolerance);
    	$hoursIntervalRegister = Time::diffValueOrNull($this->hour2,$this->hour3);

    	if(strtotime($hoursIntervalRegister) < strtotime($hoursIntervalTolerance)){

    	return Time::diffHours($hoursIntervalRegister,$hoursInterval);
    	}

    }

    /**
    * Dividindo extras em partes para depois unir no overtime()
    */

    public function overdueHour2(){

        if($this->hour2 < $this->toleranceLess($this->schedules->getHour2())){

            $interval = Time::diffValueOrNull($this->hour2,$this->schedules->getHour2());

            return $interval;
        }
    }

    public function overdueHour4(){

        if($this->hour4 < $this->toleranceLess($this->schedules->getHour4())){

            $interval = Time::diffValueOrNull($this->hour4,$this->schedules->getHour4());

            return $interval;
        }
    }

    /**
    * Período de intervalo - coletando atrasos de cada intervalo de forma dinâmica
    */
    public function overdueInterval1(){

        $hoursInterval = Time::diffValueOrNull($this->schedules->getHour2(),$this->schedules->getHour3());

        $hoursIntervalTolerance = Time::sum($hoursInterval,$this->tolerance);
        $hoursIntervalRegister = Time::diffValueOrNull($this->hour2,$this->hour3);

        if(strtotime($hoursIntervalRegister) > strtotime($hoursIntervalTolerance)){
            return Time::diffHours($hoursIntervalRegister,$hoursInterval);
        }

    }

    public function gethoursCount(){
        return $this->hoursCount;
    }


}