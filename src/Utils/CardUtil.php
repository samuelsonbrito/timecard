<?php

namespace TimeCard\Utils;

class CardUtil{

	public static function getMinInt($hour){

		return intval(((strlen($hour) == 8) || (strlen($hour) == 6))  ? substr($hour,3
    ,2) : ((strlen($hour) == 1) ? $hour : 0));

	}

}
