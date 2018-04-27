<?php 

namespace TimeCard\Time;

class TimeOrder{

	public static function scheduleAfterMidday($hours = [])
	{
	    $date = $hours[0];
	    $hoursTreated = [];
	    
	    if (!empty($hours[1])) {
	    
	        $hoursTreated[] = "$date {$hours[1]}";
	    
	    }

	    for ($index = 2; $index < count($hours); $index++) {
	        
	        $date2 = $date;
	        
	        if (strtotime($hours[$index]) < strtotime($hours[1])) {
	            $date2 = date('Y-m-d', strtotime($date . ' + 1 days'));
	        }
	        
	        $hoursTreated[] = "$date2 {$hours[$index]}";
	    }

	    return $hoursTreated;
	}

}