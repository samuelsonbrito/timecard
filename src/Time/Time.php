<?php

namespace TimeCard\Time;


/**
 * Date: 2015-09-29
 * Classe com cálculos de horas para estruturas sem DateTime
 *
 * - Converter horas em segundos, minutos...
 * - Para sistemas sem padronizações e formarmatos de horas incompatíveis
 *
 * @author Samuelson
 */

class Time {

    public static function hoursInSeconds($hour) {
        if (count(explode(':', $hour)) == 3):
            $hour_exp = explode(':', $hour);
            $hourInSeconds = abs($hour_exp[0]) * 3600;
            $minInSeconds = abs($hour_exp[1]) * 60;
            $seconds = $hourInSeconds + $minInSeconds;
            return $seconds;
        else:
            return null;
        endif;
    }

    public static function hoursInMinutes($hour) {
        if (count(explode(':', $hour)) == 3):
            $hour_exp = explode(':', $hour);
            $hourInSeconds = abs($hour_exp[0]) * 60;
            $minInSeconds = abs($hour_exp[1]);
            $seconds = $hourInSeconds + $minInSeconds;
            return $seconds;
        else:
            return null;
        endif;
    }
    public static function formatHM($hour) {
        if (count(explode(':', $hour)) == 3):
            $hour_exp = explode(':', $hour);
            return "$hour_exp[0]:$hour_exp[1]";
        else:
            return null;
        endif;
    }

    public static function formatSecInHr($seconds) {


        $hours = floor($seconds / 3600);
        $seconds -= $hours * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;

        if ($hours < 10) {
            $hours = "0" . $hours;
        }
        if ($minutes < 10) {
            $minutes = "0" . $minutes;
        }
        if ($seconds < 10) {
            $seconds = "0" . $seconds;
        }

        $hoursFormat = $hours . ":" . $minutes . ":" . $seconds;

        return $hoursFormat;
    }


    public static function diffHours($hour1, $hour2) {

        $date1 = date('Y-m-d');

        $datetime1 = date_create("$date1 $hour1");
        $datetime2 = date_create("$date1 $hour2");
        $interval = date_diff($datetime1, $datetime2);

        return $interval->format("%H:%I:%S");
    }

    public static function diffTime($date1, $hour1, $hour2) {

        $date2 = null;

        if (self::checkHrNoturna($hour1, $hour2)):
            $date2 = date('Y-m-d', strtotime($date1 . ' + 1 days'));
        else:
            $date2 = $date1;
        endif;

        $datetime1 = date_create("$date1 $hour1");
        $datetime2 = date_create("$date2 $hour2");
        $interval = date_diff($datetime1, $datetime2);

        return $interval->format("%H:%I:%S");
    }

    public static function diffTime2($datetime1, $datetime2) {

        $interval = date_diff(date_create($datetime1), date_create($datetime2));

        return $interval->format("%H:%I:%S");
    }

    public static function calcNortuno22($data1, $hora2) {

        $data2 = null;

        if (self::checkHrNoturna("22:00:00", $hora2)):
            $data2 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data2 = $data1;
        endif;

        $datetime1 = date_create("$data1 22:00:00");
        $datetime2 = date_create("$data2 $hora2");

        $interval = date_diff($datetime1, $datetime2);

        $hrNot = Time::hoursInMinutes($interval->format("%H:%I:%S")) / 52.5;

        $exHrNot = explode(".", $hrNot);

        return self::formatZeroLeft($exHrNot[0]) . ":" . (isset($exHrNot[1]) ? self::formatZeroLeft(round(("0.$exHrNot[1]" * 60))) : "00") . ":00";
    }

    public static function calcNortuno22as5($data1, $hora1, $hora2, $hora3, $hora4) {

        $data2 = null;

        if (self::checkHrNoturna("22:00:00", $hora2)):
            $data2 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data2 = $data1;
        endif;

        $datetime1 = date_create("$data1 22:00:00");
        $datetime2 = date_create("$data2 $hora2");

        $interval = date_diff($datetime1, $datetime2);

        $hrNot = Time::hoursInMinutes($interval->format("%H:%I:%S")) / 52.5;

        $exHrNot = explode(".", $hrNot);

        return self::formatZeroLeft($exHrNot[0]) . ":" . (isset($exHrNot[1]) ? self::formatZeroLeft(round(("0.$exHrNot[1]" * 60))) : "00") . ":00";
    }

    public static function horaMaior22($data, $hora1, $hora2, $hora3, $hora4) {

        $data0 = date('Y-m-d', strtotime($data . ' + 1 days'));

        $data1 = $data;
        $data2 = null;
        $data3 = null;
        $data4 = null;

        $datetimelei = null;
        $datetime1 = null;
        $datetime2 = null;
        $datetime3 = null;
        $datetime4 = null;

        if (self::checkHrNoturna($hora1, $hora2)):
            $data2 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data2 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora3)):
            $data3 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data3 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora4)):
            $data4 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data4 = $data1;
        endif;

        $datetimelei5 = date_create("$data0 05:00:00");

        $datetimelei = date_create("$data1 22:00:00");

        $datetime1 = date_create("$data1 $hora1");
        $datetime2 = date_create("$data2 $hora2");
        $datetime3 = date_create("$data3 $hora3");
        $datetime4 = date_create("$data4 $hora4");

        $pontos = array();

        if ($datetime1 > $datetimelei):
            $pontos[1] = $datetime1;
        endif;

        if ($datetime2 > $datetimelei):
            $pontos[2] = $datetime2;
        endif;

        if ($datetime3 > $datetimelei):
            $pontos[3] = $datetime3;
        endif;

        if ($datetime4 > $datetimelei):
            $pontos[4] = $datetime4;
        endif;



        return !empty($pontos);
    }
    public static function horaMaior22For6($data, $hora1, $hora2, $hora3, $hora4, $hora5, $hora6) {

        $data0 = date('Y-m-d', strtotime($data . ' + 1 days'));

        $data1 = $data;
        $data2 = null;
        $data3 = null;
        $data4 = null;
        $data5 = null;
        $data6 = null;

        $datetimelei = null;
        $datetime1 = null;
        $datetime2 = null;
        $datetime3 = null;
        $datetime4 = null;
        $datetime5 = null;
        $datetime6 = null;

        if (self::checkHrNoturna($hora1, $hora2)):
            $data2 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data2 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora3)):
            $data3 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data3 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora4)):
            $data4 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data4 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora5)):
            $data5 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data5 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora6)):
            $data6 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data6 = $data1;
        endif;

        $datetimelei5 = date_create("$data0 05:00:00");

        $datetimelei = date_create("$data1 22:00:00");

        $datetime1 = date_create("$data1 $hora1");
        $datetime2 = date_create("$data2 $hora2");
        $datetime3 = date_create("$data3 $hora3");
        $datetime4 = date_create("$data4 $hora4");
        $datetime5 = date_create("$data5 $hora5");
        $datetime6 = date_create("$data6 $hora6");

        $pontos = array();

        if ($datetime1 > $datetimelei):
            $pontos[1] = $datetime1;
        endif;

        if ($datetime2 > $datetimelei):
            $pontos[2] = $datetime2;
        endif;

        if ($datetime3 > $datetimelei):
            $pontos[3] = $datetime3;
        endif;

        if ($datetime4 > $datetimelei):
            $pontos[4] = $datetime4;
        endif;

        if ($datetime5 > $datetimelei):
            $pontos[5] = $datetime5;
        endif;

        if ($datetime6 > $datetimelei):
            $pontos[6] = $datetime6;
        endif;

        return !empty($pontos);
    }

    public static function horaMaior22For2($data, $hora1, $hora2) {

        $data0 = date('Y-m-d', strtotime($data . ' + 1 days'));

        $data1 = $data;
        $data2 = null;
        $data3 = null;
        $data4 = null;

        $datetimelei = null;
        $datetime1 = null;
        $datetime2 = null;
        $datetime3 = null;
        $datetime4 = null;

        if (self::checkHrNoturna($hora1, $hora2)):
            $data2 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data2 = $data1;
        endif;

        $datetimelei5 = date_create("$data0 05:00:00");

        $datetimelei = date_create("$data1 22:00:00");

        $datetime1 = date_create("$data1 $hora1");
        $datetime2 = date_create("$data2 $hora2");


        $pontos = array();

        if ($datetime1 > $datetimelei):
            $pontos[1] = $datetime1;
        endif;

        if ($datetime2 > $datetimelei):
            $pontos[2] = $datetime2;
        endif;



        return !empty($pontos);
    }

    public static function horaMaior22ForPonto($data, $ponto, $hora1, $hora2, $hora3, $hora4, $hora5 = null, $hora6 = null) {

        $data0 = date('Y-m-d', strtotime($data . ' + 1 days'));

        $data1 = $data;
        $data2 = null;
        $data3 = null;
        $data4 = null;
        $data5 = null;
        $data6 = null;

        $datetimelei = null;
        $datetime1 = null;
        $datetime2 = null;
        $datetime3 = null;
        $datetime4 = null;
        $datetime5 = null;
        $datetime6 = null;

        if (self::checkHrNoturna($hora1, $hora2)):
            $data2 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data2 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora3)):
            $data3 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data3 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora4)):
            $data4 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data4 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora5)):
            $data5 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data5 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora6)):
            $data6 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data6 = $data1;
        endif;

        $datetimelei5 = date_create("$data0 05:00:00");

        $datetimelei = date_create("$data1 22:00:00");

        $datetime1 = date_create("$data1 $hora1");
        $datetime2 = date_create("$data2 $hora2");
        $datetime3 = date_create("$data3 $hora3");
        $datetime4 = date_create("$data4 $hora4");
        $datetime5 = date_create("$data5 $hora5");
        $datetime6 = date_create("$data6 $hora6");

        $pontos = array();

        $pontos[1] = $datetime1;

        $pontos[2] = $datetime2;

        $pontos[3] = $datetime3;

        $pontos[4] = $datetime4;

        $pontos[5] = $datetime5;

        $pontos[6] = $datetime6;



        return $pontos[$ponto]->format('Y-m-d H:i:s');
    }

    public static function isHoraMaior22ForPonto($data, $ponto, $hora1, $hora2, $hora3, $hora4) {

        $data0 = date('Y-m-d', strtotime($data . ' + 1 days'));

        $data1 = $data;
        $data2 = null;
        $data3 = null;
        $data4 = null;

        $datetimelei = null;
        $datetime1 = null;
        $datetime2 = null;
        $datetime3 = null;
        $datetime4 = null;

        if (self::checkHrNoturna($hora1, $hora2)):
            $data2 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data2 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora3)):
            $data3 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data3 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora4)):
            $data4 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data4 = $data1;
        endif;

        $datetimelei5 = date_create("$data0 05:00:00");

        $datetimelei = date_create("$data1 22:00:00");

        $datetime1 = date_create("$data1 $hora1");
        $datetime2 = date_create("$data2 $hora2");
        $datetime3 = date_create("$data3 $hora3");
        $datetime4 = date_create("$data4 $hora4");

        $pontos = false;

        if ($ponto == '1'):
            if ($datetime1 > $datetimelei):
                $pontos = true;
            endif;
        endif;
        if ($ponto == '2'):
            if ($datetime2 > $datetimelei):
                $pontos = true;
            endif;
        endif;
        if ($ponto == '3'):
            if ($datetime3 > $datetimelei):
                $pontos = true;
            endif;
        endif;

        if ($ponto == '4'):

            if ($datetime4 > $datetimelei):
                $pontos = true;
            endif;
        endif;

        return $pontos;
    }

    public static function calcNortuno2SemReducao($data, $hora1, $hora2) {

        $data0 = date('Y-m-d', strtotime($data . ' + 1 days'));

        $data1 = $data;
        $data2 = null;


        $datetimelei = null;
        $datetime1 = null;
        $datetime2 = null;
        $datetime3 = null;
        $datetime4 = null;

        if (self::checkHrNoturna($hora1, $hora2)):
            $data2 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data2 = $data1;
        endif;

        $pontos = array();


        $datetimelei5 = date_create("$data0 05:00:00");

        $datetimelei22 = date_create("$data1 22:00:00");

        $datetime1 = date_create("$data1 $hora1");
        $datetime2 = date_create("$data2 $hora2");

        if ($datetime1 > $datetimelei22):
            $pontos[1] = $datetime1;

            if ($datetime1 < $datetimelei5):
                $pontos[1] = $datetime1;
            else:
                $pontos[1] = $datetimelei5;
            endif;

        else:
            $pontos[1] = $datetimelei22;
        endif;


        if ($datetime2 > $datetimelei22):
            $pontos[2] = $datetime2;

            if ($datetime2 < $datetimelei5):
                $pontos[2] = $datetime2;
            else:
                $pontos[2] = $datetimelei5;
            endif;

        else:
            $pontos[2] = $datetimelei22;
        endif;

        $interval = date_diff($pontos[1], $pontos[2]);

        return $interval->format("%H:%I:%S");
    }

    public static function calcNortuno6($data, $hora1, $hora2, $hora3, $hora4, $hora5, $hora6) {

        $data0 = date('Y-m-d', strtotime($data . ' + 1 days'));
        $pontos = array();
        $data1 = $data;
        $data2 = null;
        $data3 = null;
        $data4 = null;
        $data5 = null;
        $data6 = null;

        $datetimelei = null;
        $datetime1 = null;
        $datetime2 = null;
        $datetime3 = null;
        $datetime4 = null;
        $datetime5 = null;
        $datetime6 = null;

        if (self::checkHrNoturna($hora1, $hora2)):
            $data2 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data2 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora3)):
            $data3 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data3 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora4)):
            $data4 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data4 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora5)):
            $data5 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data5 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora6)):
            $data6 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data6 = $data1;
        endif;

        $datetimelei5 = date_create("$data0 05:00:00");

        $datetimelei22 = date_create("$data1 22:00:00");

        $datetime1 = date_create("$data1 $hora1");
        $datetime2 = date_create("$data2 $hora2");
        $datetime3 = date_create("$data3 $hora3");
        $datetime4 = date_create("$data4 $hora4");
        $datetime5 = date_create("$data5 $hora5");
        $datetime6 = date_create("$data6 $hora6");

        if ($datetime1 > $datetimelei22):
            $pontos[1] = $datetime1;
        else:
            $pontos[1] = $datetimelei22;
        endif;

        if ($datetime2 > $datetimelei5):
            $pontos[2] = $datetimelei5;
        else:
            $pontos[2] = $datetime2;
        endif;

        if ($datetime3 > $datetimelei22):
            $pontos[3] = $datetime3;
        else:
            $pontos[3] = $datetimelei22;
        endif;

        if ($datetime4 > $datetimelei5):
            $pontos[4] = $datetimelei5;
        else:
            $pontos[4] = $datetime4;
        endif;

        if ($datetime5 > $datetimelei22):

            if(!empty($datetime6)){

                if($datetime6 > $datetimelei22){
                    $pontos[5] = $datetimelei22;
                }else{
                    $pontos[5] = $datetime5;
                }

            }else{
                $pontos[5] = $datetime5;
            }

        else:
            $pontos[5] = $datetimelei22;
        endif;

        if ($datetime6 > $datetimelei5):
            $pontos[6] = $datetimelei5;
        else:
            $pontos[6] = $datetime6;
        endif;

        $interval = null;
        $interval2 = null;
        $interval3 = null;
        $hrNot = 0;

        if(($datetime1>=$datetimelei22 && $datetime1 < $datetimelei5) || ($datetime2 >= $datetimelei22 && $datetime2 < $datetimelei5)){
            $interval = date_diff($pontos[1], $pontos[2]);
            $hrNot += Time::hoursInMinutes($interval->format("%H:%I:%S")) / 52.5;
        }

        if(($datetime3>=$datetimelei22 && $datetime3 < $datetimelei5) || ($datetime4 >= $datetimelei22 && $datetime4 < $datetimelei5)){
            $interval2 = date_diff($pontos[3], $pontos[4]);
            $hrNot += Time::hoursInMinutes($interval2->format("%H:%I:%S")) / 52.5;
        }

        if(($datetime5>=$datetimelei22 && $datetime5 < $datetimelei5) || ($datetime6 >= $datetimelei22 && $datetime6 < $datetimelei5)){
            $interval3 = date_diff($pontos[5], $pontos[6]);
            $hrNot += Time::hoursInMinutes($interval3->format("%H:%I:%S")) / 52.5;
        }

        return ((self::formatAdcNot($hrNot) == "00:00:00") || (self::hoursInSeconds(self::formatAdcNot($hrNot)) > 28800)) ? null : self::formatAdcNot($hrNot);
    }


    public static function calcNortuno4($data, $hora1, $hora2, $hora3, $hora4) {

        $data0 = date('Y-m-d', strtotime($data . ' + 1 days'));
        $pontos = array();
        $data1 = $data;
        $data2 = null;
        $data3 = null;
        $data4 = null;

        $datetimelei = null;
        $datetime1 = null;
        $datetime2 = null;
        $datetime3 = null;
        $datetime4 = null;

        if (self::checkHrNoturna($hora1, $hora2)):
            $data2 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data2 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora3)):
            $data3 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data3 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora4)):
            $data4 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data4 = $data1;
        endif;

        $datetimelei5 = date_create("$data0 05:00:00");

        $datetimelei22 = date_create("$data1 22:00:00");

        $datetime1 = date_create("$data1 $hora1");
        $datetime2 = date_create("$data2 $hora2");
        $datetime3 = date_create("$data3 $hora3");
        $datetime4 = date_create("$data4 $hora4");

        if ($datetime1 > $datetimelei22):
            $pontos[1] = $datetime1;
        else:
            $pontos[1] = $datetimelei22;
        endif;

        if ($datetime2 > $datetimelei5):
            $pontos[2] = $datetimelei5;
        else:
            $pontos[2] = $datetime2;
        endif;

        if ($datetime3 > $datetimelei22):
            $pontos[3] = $datetime3;
        else:
            $pontos[3] = $datetimelei22;
        endif;

        if ($datetime4 > $datetimelei5):
            $pontos[4] = $datetimelei5;
        else:
            $pontos[4] = $datetime4;
        endif;

        $interval = null;
        $interval2 = null;

        $hrNot = 0;

        if(($datetime1>=$datetimelei22 && $datetime1 < $datetimelei5) || ($datetime2 >= $datetimelei22 && $datetime2 < $datetimelei5)){
            $interval = date_diff($pontos[1], $pontos[2]);
            $hrNot += Time::hoursInMinutes($interval->format("%H:%I:%S")) / 52.5;
        }

        if(($datetime3>=$datetimelei22 && $datetime3 < $datetimelei5) || ($datetime4 >= $datetimelei22 && $datetime4 < $datetimelei5)){
            $interval2 = date_diff($pontos[3], $pontos[4]);
            $hrNot += Time::hoursInMinutes($interval2->format("%H:%I:%S")) / 52.5;
        }

       return ((self::formatAdcNot($hrNot) == "00:00:00") || (self::hoursInSeconds(self::formatAdcNot($hrNot)) > 28800)) ? null : self::formatAdcNot($hrNot);
    }
    public static function horaInDateTime($data, $hora1, $hora2, $hora3, $hora4) {

        $data0 = date('Y-m-d', strtotime($data . ' + 1 days'));
        $pontos = array();

        $data1 = $data;
        $data2 = null;
        $data3 = null;
        $data4 = null;

        $datetimelei = null;
        $datetime1 = null;
        $datetime2 = null;
        $datetime3 = null;
        $datetime4 = null;

        if (self::checkHrNoturna($hora1, $hora2)):
            $data2 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data2 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora3)):
            $data3 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data3 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora4)):
            $data4 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data4 = $data1;
        endif;

        $datetimelei5 = date_create("$data0 05:00:00");

        $datetimelei22 = date_create("$data1 22:00:00");

        $datetime1 = date_create("$data1 $hora1");
        $datetime2 = date_create("$data2 $hora2");
        $datetime3 = date_create("$data3 $hora3");
        $datetime4 = date_create("$data4 $hora4");

        $pontos[] = date_format($datetime1, 'Y-m-d H:i:s');
        $pontos[] = date_format($datetime2, 'Y-m-d H:i:s');
        $pontos[] = date_format($datetime3, 'Y-m-d H:i:s');
        $pontos[] = date_format($datetime4, 'Y-m-d H:i:s');


        return $pontos;
    }

    public static function calcNortuno2($data, $hora1, $hora2, $hora3, $hora4) {

        $data0 = date('Y-m-d', strtotime($data . ' + 1 days'));
        $pontos = array();
        $data1 = $data;
        $data2 = null;
        $data3 = null;
        $data4 = null;

        $datetimelei = null;
        $datetime1 = null;
        $datetime2 = null;
        $datetime3 = null;
        $datetime4 = null;

        if (self::checkHrNoturna($hora1, $hora2)):
            $data2 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data2 = $data1;
            $data0 = $data1;;
        endif;

        if (self::checkHrNoturna($hora1, $hora3)):
            $data3 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data3 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora4)):
            $data4 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data4 = $data1;
        endif;

        $datetimelei5 = date_create("$data0 05:00:00");

        $datetimelei22 = date_create("$data1 22:00:00");

        $datetime1 = date_create("$data1 $hora1");
        $datetime2 = date_create("$data2 $hora2");
        $datetime3 = date_create("$data3 $hora3");
        $datetime4 = date_create("$data4 $hora4");

        if ($datetime1 > $datetimelei22 && $datetime1 < $datetimelei5):
            $pontos[1] = $datetime1;


        else:

            $pontos[1] = $datetimelei22;

            if (self::checkHrNoturna($hora1, $hora2)):

                if($datetime1 > $datetimelei22):
                    $pontos[1] = $datetime1;
                endif;

            else:

               if($datetime1 > $datetimelei22 && $datetime1 < $datetimelei5):
                    $pontos[1] = $datetime1;
                else:

                    if($datetime1 < $datetimelei22):
                        $pontos[1] = $datetimelei22;
                    else:
                        $pontos[1] =$datetime1;
                    endif;


                    if (!self::checkHrNoturna($hora1, $hora2)):

                         $datetime1tolerancia = date_create("$data1 00:00:00");
                         $datetime2tolerancia = date_create("$data1 01:00:00");

                        if($datetime1>= $datetime1tolerancia && $datetime1<= $datetime2tolerancia) {

                            $pontos[1] = $datetime1;
                        }

                    endif;

            endif;

            endif;



        endif;

        if ($datetime2 > $datetimelei5 && $datetime2 < $datetimelei22):
            $pontos[2] = $datetimelei5;
        else:

            if (self::checkHrNoturna($hora1, $hora2)):

                if($datetime2 > $datetimelei5):
                    $pontos[2] =$datetimelei5;
                else:
                    $pontos[2] = $datetime2;
                endif;

            else:
               if($datetime2 > $datetimelei22):
                    $pontos[2] = $datetime2;
                endif;

            endif;

        endif;


        if ($datetime3 > $datetimelei22):
            $pontos[3] = $datetime3;
        else:
            $pontos[3] = $datetimelei22;
        endif;

        if ($datetime4 > $datetimelei5):
            $pontos[4] = $datetimelei5;
        else:
            $pontos[4] = $datetime4;
        endif;

        $hrNot = 0;


        if(!empty($pontos[1]) && !empty($pontos[2])){

            if(($datetime1>=$datetimelei22 || $datetime1 < $datetimelei5) ){
                $interval = date_diff($pontos[1], $pontos[2]);
                $hrNot = Time::hoursInMinutes($interval->format("%H:%I:%S")) / 52.5;
            }elseif(($datetime2 >= $datetimelei22 || $datetime2 < $datetimelei5)){
                $interval = date_diff($pontos[1], $pontos[2]);
                $hrNot = Time::hoursInMinutes($interval->format("%H:%I:%S")) / 52.5;
            }

        }

        return ((self::formatAdcNot($hrNot) == "00:00:00") || (self::hoursInSeconds(self::formatAdcNot($hrNot)) > 28800)) ? null : self::formatAdcNot($hrNot);
    }

    public static function calcNortuno4SemReducao($data, $hora1, $hora2, $hora3, $hora4) {

        $data0 = date('Y-m-d', strtotime($data . ' + 1 days'));
        $pontos = array();
        $data1 = $data;
        $data2 = null;
        $data3 = null;
        $data4 = null;

        $datetimelei = null;
        $datetime1 = null;
        $datetime2 = null;
        $datetime3 = null;
        $datetime4 = null;

        if (self::checkHrNoturna($hora1, $hora2)):
            $data2 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data2 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora3)):
            $data3 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data3 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora4)):
            $data4 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data4 = $data1;
        endif;

        $datetimelei5 = date_create("$data0 05:00:00");

        $datetimelei22 = date_create("$data1 22:00:00");

        $datetime1 = date_create("$data1 $hora1");
        $datetime2 = date_create("$data2 $hora2");
        $datetime3 = date_create("$data3 $hora3");
        $datetime4 = date_create("$data4 $hora4");

        if ($datetime1 > $datetimelei22):
            $pontos[1] = $datetime1;

            if ($datetime1 < $datetimelei5):
                $pontos[1] = $datetime1;
            else:
                $pontos[1] = $datetimelei5;
            endif;

        else:
            $pontos[1] = $datetimelei22;
        endif;


        if ($datetime2 > $datetimelei22):
            $pontos[2] = $datetime2;

            if ($datetime2 < $datetimelei5):
                $pontos[2] = $datetime2;
            else:
                $pontos[2] = $datetimelei5;
            endif;

        else:
            $pontos[2] = $datetimelei22;
        endif;


        if ($datetime3 > $datetimelei22):
            $pontos[3] = $datetime2;

            if ($datetime3 < $datetimelei5):
                $pontos[3] = $datetime3;
            else:
                $pontos[3] = $datetimelei5;
            endif;

        else:
            $pontos[3] = $datetimelei22;
        endif;


        if ($datetime4 > $datetimelei22):
            $pontos[4] = $datetime4;

            if ($datetime4 < $datetimelei5):
                $pontos[4] = $datetime4;
            else:
                $pontos[4] = $datetimelei5;
            endif;

        else:
            $pontos[4] = $datetimelei22;
        endif;



        $interval = date_diff($pontos[1], $pontos[2]);

        $interval2 = date_diff($pontos[3], $pontos[4]);


        return $interval2->format("%H:%I:%S");
    }

    public static function formatAdcNot($hrNot) {
        $exHrNot = explode(".", $hrNot);
        return self::formatZeroLeft($exHrNot[0]) . ":" . (isset($exHrNot[1]) ? self::formatZeroLeft(round(("0.$exHrNot[1]" * 60))) : "00") . ":00";
    }

    /**
     * Realiaz o calculo da redução de horas. Informe as quantidade de horas brutas e o método realizará a redução.
     * @param type $hora2
     * @return type
     */
    public static function calcNortuno($hora2) {

        $hrNot = Time::hoursInMinutes($hora2) / 52.5;

        $exHrNot = explode(".", $hrNot);

        return self::formatZeroLeft($exHrNot[0]) . ":" . (isset($exHrNot[1]) ? self::formatZeroLeft(round(("0.$exHrNot[1]" * 60))) : "00") . ":00";

    }

    /**
     * 
     * Verifica se a hora informada passou do horário determinado por lei e realiza o cálculo bruto, sem reduzir as horas.
     * 
     * @param type $data1
     * @param type $hora2
     * @return type
     */
    public static function isNoturno($data1, $hora2) {

        $data2 = null;

        if (self::checkHrNoturna("22:00:00", $hora2)):
            $data2 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data2 = $data1;
        endif;

        $datetime1 = date_create("$data1 22:00:00");
        $datetime2 = date_create("$data2 $hora2");

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format("%H:%I:%S");
    }

    private static function formatZeroLeft($valor) {
        return str_pad($valor, (strlen($valor) == 1) ? 2 : strlen($valor), '0', STR_PAD_LEFT);
    }

    private static function formatNull($valor) {
        return ($valor >= 0 && !empty($valor)) ? $valor : 0;
    }

    /**
     * Verificar se horário1 é maior que o horário2 informado
     * @param type $data1
     * @param type $hora1
     * @param type $hora2
     * @return boolean
     */
    public static function isTimeMaior($data1, $hora1, $hora2) {

        $data2 = null;

        if (self::checkHrNoturna($hora1, $hora2)):
            $data2 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data2 = $data1;
        endif;

        $datetime1 = ("$data1 $hora1");
        $datetime2 = ("$data2 $hora2");


        if (strtotime($datetime1) > strtotime($datetime2)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Verificar se horário passou das 22hrs
     * @param type $data1
     * @param type $hora1
     * @param type $hora2
     * @return boolean
     */
    public static function isTimeMaior22($data, $hora1, $hora2 = null, $hora3 = null, $hora4 = null) {

        $data0 = date('Y-m-d', strtotime($data . ' + 1 days'));
        $pontos = array();
        $data1 = $data;
        $data2 = null;
        $data3 = null;
        $data4 = null;

        $datetimelei = null;
        $datetime1 = null;
        $datetime2 = null;
        $datetime3 = null;
        $datetime4 = null;

        if (self::checkHrNoturna($hora1, $hora2)):
            $data2 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data2 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora3)):
            $data3 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data3 = $data1;
        endif;

        if (self::checkHrNoturna($hora1, $hora4)):
            $data4 = date('Y-m-d', strtotime($data1 . ' + 1 days'));
        else:
            $data4 = $data1;
        endif;

        $datetimelei5 = date_create("$data0 05:00:00");
        $datetimelei22 = date_create("$data1 22:00:00");

        $datetime1 = date_create("$data1 $hora1");
        $datetime2 = date_create("$data2 $hora2");


        $hrNot = 0;

        if (!empty($hora2)) {

            if(($datetime2 >= $datetimelei22 || $datetime2 < $datetimelei5)){
                return true;
            }else{
                return false;
            }

        } else {

            if(($datetime1 >= $datetimelei22 || $datetime1 < $datetimelei5)){
                return true;
            }else{
                return false;
            }
        }
    }

    public static function sumHorasTrabalhadas($data, $descanso, $ponto1, $ponto2, $ponto3 = null, $ponto4 = null, $ponto5 = null, $ponto6 = null, $ponto7 = null, $ponto8 = null) {

        $hrTrab1 = (!empty($ponto1) && !empty($ponto2)) ? self::diffTime($data, $ponto1, $ponto2) : 0;
        $hrTrab2 = (!empty($ponto3) && !empty($ponto4)) ? self::diffTime($data, $ponto3, $ponto4) : 0;
        $hrTrab3 = (!empty($ponto5) && !empty($ponto6)) ? self::diffTime($data, $ponto5, $ponto6) : 0;
        $hrTrab4 = (!empty($ponto7) && !empty($ponto8)) ? self::diffTime($data, $ponto7, $ponto8) : 0;

        $total = self::hoursInSeconds($hrTrab1) + self::hoursInSeconds($hrTrab2) + self::hoursInSeconds($hrTrab3) + self::hoursInSeconds($hrTrab4);
        $horasTrabalhadas = (self::hoursInSeconds($descanso) > $total) ? $total : $total - self::hoursInSeconds($descanso);
        return self::formatSecInHr($horasTrabalhadas);
    }

    public static function sum($hour1, $hour2, $hour3 = null, $hour4 = null, $hour5 = null) {
        $total = self::hoursInSeconds($hour1) + self::hoursInSeconds($hour2) + self::hoursInSeconds($hour3) + self::hoursInSeconds($hour4) + self::hoursInSeconds($hour5);
        return self::formatSecInHr($total);
    }

    public static function sub($hour1, $hour2, $hour3 = null, $hour4 = null) {

        $total = self::hoursInSeconds($hour1) - self::hoursInSeconds($hour2) - self::hoursInSeconds($hour3) - self::hoursInSeconds($hour4);
        return self::formatSecInHr($total);
    }

    /**
     *
     * @param type $hora
     * @return type
     */
    public static function formatSegZero($hora) {
        if (count(explode(':', $hora)) == 3):
            $tempo = explode(':', $hora);
            return "$tempo[0]:$tempo[1]:00";
        else:
            return null;
        endif;
    }

    private static function checkHrNoturna($hora1, $hora2) {
        if (Time::hoursInSeconds($hora2) < Time::hoursInSeconds($hora1)) {
            return true;
        } else {
            return false;
        }
    }

    private static function checkHrNoturnaData($hora1, $hora2, $hora3, $hora4) {

        if (Time::hoursInSeconds($hora2) < Time::hoursInSeconds($hora1)):
            return true;
        elseif (Time::hoursInSeconds($hora3) < Time::hoursInSeconds($hora1)):
            return true;
        elseif (Time::hoursInSeconds($hora4) < Time::hoursInSeconds($hora1)):
            return true;
        else:
            return false;
        endif;
    }

    public static function dateTime5($data) {

        $data0 = date('Y-m-d', strtotime($data . ' + 1 days'));

        $datetime1 = date_create("$data0 05:00:00");

        return $datetime1->format("Y-m-d H:i:s");
    }

    public static function dateTime22($data) {

        $datetime1 = date_create("$data 22:00:00");

        return $datetime1->format("Y-m-d H:i:s");
    }

    public static function lei22At5($data, $hora) {

        if (strtotime($hora) > strtotime(Time::dateTime22($data)) && strtotime($hora) < strtotime(Time::dateTime5($data))):
            return true;
        else:
            return false;
        endif;

    }

}
