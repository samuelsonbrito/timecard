<?php 

include('vendor/autoload.php');

use \TimeCard\Card\CardCalculator;
use \TimeCard\Card\Schedules;
use \TimeCard\Time\Time;

$arraySchedule = ['2017-01-01 08:00:00','2017-01-01 12:00:00','2017-01-01 14:00:00','2017-01-01 18:00:00'];

$schedule = new Schedules('2017-01-01',$arraySchedule);

$arrayCard = ['2017-01-01 09:00:00','2017-01-01 12:00:00','2017-01-01 12:30:00','2017-01-01 19:00:00'];

$card = new CardCalculator($arrayCard,"00:05:00");
$card->setSchedules($schedule);

print_r($arraySchedule);
echo '<br>';
print_r($arrayCard);
echo '<br>';
echo '<br>';

echo 'Horas trabalhadas: '.$card->worked();
echo '<br>';
echo 'Horas extras: '.$card->overtimeInterval1();
echo '<br>';
echo 'Horas extras entrada antecipada: '.$card->overtimeHour1();
echo '<br>';
echo 'Horas atradadas 4: '.$card->overdueHour4();

$tolerance1 = '00:05:00';

echo '<hr>';
echo strlen($tolerance1)==8;
echo '<hr>';
echo 'Quantidade de batidas:'.$card->gethoursCount();
echo '<hr>';
echo 'Total extras:'.$card->overtime();
echo '<hr>';
echo 'Horas atrasadas 1: '.$card->overdueHour1();