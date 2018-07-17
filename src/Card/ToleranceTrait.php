<?php

namespace TimeCard\Card;

use TimeCard\Time\Time;

trait ToleranceTrait {

    private $tolerance;

    private function tolerancePlus($hour) {

        if (is_object($hour)) {

            $tolerance = Time::getMinInt($this->getTolerance());

            $dateTime = clone $hour;

            return $dateTime->modify("+{$tolerance} minutes");
        } else {
            return null;
        }
    }

    private function toleranceLess($hour) {

        if (is_object($hour)) {

            $tolerance = Time::getMinInt($this->getTolerance());

            $dateTime = clone $hour;

            return $dateTime->modify("-{$tolerance} minutes");
            
        } else {
            return null;
        }
    }

    public function getTolerance() {
        return $this->tolerance;
    }

}
