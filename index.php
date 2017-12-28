<?php 

include('vendor/autoload.php');

use \TimeCard\Card\CardCalculator;
use \TimeCard\Card\Schedules;

$arraySchedule = ['2017-01-01 08:00:00','2017-01-01 12:00:00','2017-01-01 14:00:00','2017-01-01 18:00:00'];

$schedule = new Schedules('2017-01-01',$arraySchedule);

$arrayCard = ['2017-01-01 08:00:00','2017-01-01 13:00:00','2017-01-01 14:00:00','2017-01-01 18:06:00'];

$card = new CardCalculator($arrayCard,"00:05:00");
$card->setSchedules($schedule);

echo 'Horas trabalhadas: '.$card->worked();
echo '<br>Horas extras: '.$card->overtimeHour4();
