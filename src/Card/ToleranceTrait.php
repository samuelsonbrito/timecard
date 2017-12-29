<?php

namespace TimeCard\Card;
use TimeCard\Time\Time;

trait ToleranceTrait {

	private $tolerance;

    private function tolerancePlus($hour){

        $tolerance = Time::getMinInt($this->getTolerance());

	    $dateTime = clone $hour;

        return $dateTime->modify("+{$tolerance} minutes");
    }

    private function toleranceLess($hour){

        $tolerance = Time::getMinInt($this->getTolerance());

	    $dateTime = clone $hour;

        return $dateTime->modify("-{$tolerance} minutes");
    }

    public function getTolerance(){
        return $this->tolerance;
    }

}