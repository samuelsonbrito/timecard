<?php

namespace TimeCard\Card;
use TimeCard\Utils\CardUtil;

trait CardTrait {

    public function tolerancePlus($hour){

        $tolerance = CardUtil::getMinInt($this->getTolerance());

	    $dateTime = clone $hour;

        return $dateTime->modify("+{$tolerance} minutes");
    }

    public function toleranceLess($hour){

        $tolerance = CardUtil::getMinInt($this->getTolerance());

	    $dateTime = clone $hour;

        return $dateTime->modify("-{$tolerance} minutes");
    }

}