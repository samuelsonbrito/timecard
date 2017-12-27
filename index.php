<?php 

include('vendor/autoload.php');

$card = new \TimeCard\Card\CardCalculator('2017-01-01 08:00:00','2017-01-01 12:00:00','2017-01-01 14:00:00','2017-01-01 18:00:00');

echo $card->worked();