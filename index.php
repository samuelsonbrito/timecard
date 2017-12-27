<?php 

include('vendor/autoload.php');

use \TimeCard\Card\CardCalculator;
use \TimeCard\Card\Schedules;

$schedule = new Schedules('2017-01-01','2017-01-01 08:00:00','2017-01-01 12:00:00','2017-01-01 14:00:00','2017-01-01 18:00:00');

$card = new CardCalculator('2017-01-01 08:00:00','2017-01-01 12:00:00','2017-01-01 14:00:00','2017-01-01 18:06:00');
$card->setSchedules($schedule);

echo 'Horas trabalhadas: '.$card->worked();
echo '<br>Horas extras: '.$card->overtime();