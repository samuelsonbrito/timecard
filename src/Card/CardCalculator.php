<?php

namespace TimeCard\Card;

use \DateTime;
use TimeCard\Time\Time;
use TimeCard\Card\ToleranceTrait;

class CardCalculator{

    use ToleranceTrait;

	private $schedules;
    private $hoursCount;
    private $hours;

    public function __construct(array $hours, $tolerance = '00:05:00'){

        $this->hoursCount = count(array_filter($hours));

    	$this->tolerance = is_int($tolerance) ? 5 : $tolerance;

        $this->hours['hour1'] = !empty($hours[0]) ? new DateTime($hours[0]) : null;
        $this->hours['hour2'] = !empty($hours[1]) ? new DateTime($hours[1]) : null;
        $this->hours['hour3'] = !empty($hours[2]) ? new DateTime($hours[2]) : null;
        $this->hours['hour4'] = !empty($hours[3]) ? new DateTime($hours[3]) : null;

        $this->hours['hour5'] = !empty($hours[4]) ? new DateTime($hours[4]) : null;
        $this->hours['hour6'] = !empty($hours[5]) ? new DateTime($hours[5]) : null;
        $this->hours['hour7'] = !empty($hours[6]) ? new DateTime($hours[6]) : null;
        $this->hours['hour8'] = !empty($hours[7]) ? new DateTime($hours[7]) : null;        

    }

    public function setSchedules($schedules){
    	$this->schedules = $schedules;
    }

    public function worked(){

    	$interval1 = Time::diffOrNull($this->hours['hour1'],$this->hours['hour2']);

    	$interval2 = Time::diffOrNull($this->hours['hour3'],$this->hours['hour4']);

        $interval3 = Time::diffOrNull($this->hours['hour5'],$this->hours['hour6']);

        $interval4 = Time::diffOrNull($this->hours['hour7'],$this->hours['hour8']);

    	return Time::sumDateTime($interval1,$interval2,$interval3,$interval4);
    }

    public function overtime(){

        switch ($this->hoursCount) {
            case 2:

                return Time::sum($this->overtimeHour1(),$this->overtimeHour2());

            case 4:

                return Time::sum($this->overtimeHour1(),$this->overtimeHour4(), $this->overtimeInterval1());
        }

    }

   	public function overdue(){

        switch ($this->hoursCount) {

            case 2:

                return Time::sum($this->overdueHour1(),$this->overdueHour2());

            case 4:
                return Time::sum($this->overdueHour1(),$this->overdueHour4(),$this->overtimeInterval1());
        }

    }

    public function extraNight(){

    }

    /**
    * Dividindo extras em partes para depois unir no overtime()
	*/

    public function overtimeHour1(){

        if($this->hours['hour1'] < ($this->tolerancePlus($this->schedules->getHour1()))){

            $interval = Time::diffValueOrNull($this->hours['hour1'],$this->schedules->getHour1());

            return $interval;
        }
    }

	public function overtimeHour2(){

    	if($this->hours['hour2'] > ($this->tolerancePlus($this->schedules->getHour2()))){

    		$interval = Time::diffValueOrNull($this->hours['hour2'],$this->schedules->getHour2());

    		return $interval;
    	}
    }

    public function overtimeHour4(){

    	if($this->hours['hour4'] > ($this->tolerancePlus($this->schedules->getHour4()))){

            $interval = Time::diffValueOrNull($this->hours['hour4'],$this->schedules->getHour4());

    		return $interval;
    	}
    }

    /**
    * Período de intervalo - coletando extras de cada intervalo de forma dinâmica
    */
    public function overtimeInterval1(){

    	$hoursInterval = Time::diffValueOrNull($this->schedules->getHour2(),$this->schedules->getHour3());
    	$hoursIntervalTolerance = Time::sub($hoursInterval,$this->tolerance);
    	$hoursIntervalRegister = Time::diffValueOrNull($this->hours['hour2'],$this->hours['hour3']);

    	if(strtotime($hoursIntervalRegister) < strtotime($hoursIntervalTolerance)){
    	   return Time::diffHours($hoursIntervalRegister,$hoursInterval);
    	}

    }

    /**
    * Dividindo extras em partes para depois unir no overtime()
    */
    public function overdueHour1(){

        if($this->hours['hour2'] > $this->toleranceLess($this->schedules->getHour2())){

            $interval = Time::diffValueOrNull($this->hours['hour1'],$this->schedules->getHour1());

            return $interval;
        }
    }

    public function overdueHour2(){

        if($this->hours['hour2'] < $this->toleranceLess($this->schedules->getHour2())){

            $interval = Time::diffValueOrNull($this->hours['hour2'],$this->schedules->getHour2());

            return $interval;
        }
    }

    public function overdueHour4(){

        if($this->hours['hour4'] < $this->toleranceLess($this->schedules->getHour4())){

            $interval = Time::diffValueOrNull($this->hours['hour4'],$this->schedules->getHour4());

            return $interval;
        }
    }

    /**
    * Período de intervalo - coletando atrasos de cada intervalo de forma dinâmica
    */
    public function overdueInterval1(){

        $hoursInterval = Time::diffValueOrNull($this->schedules->getHour2(),$this->schedules->getHour3());

        $hoursIntervalTolerance = Time::sum($hoursInterval,$this->tolerance);
        $hoursIntervalRegister = Time::diffValueOrNull($this->hours['hour2'],$this->hours['hour3']);

        if(strtotime($hoursIntervalRegister) > strtotime($hoursIntervalTolerance)){
            return Time::diffHours($hoursIntervalRegister,$hoursInterval);
        }

    }

    public function gethoursCount(){
        return $this->hoursCount;
    }


}