<?php

namespace TimeCard\Card;

use \DateTime;
use TimeCard\Time\Time;
use TimeCard\Card\ToleranceTrait;

class CardCalculator {

    use ToleranceTrait;

    private $schedules;
    private $hoursCount;
    private $hour1;
    private $hour2;
    private $hour3;
    private $hour4;
    private $hour5;
    private $hour6;
    private $hour7;
    private $hour8;

    public function __construct(array $hours, $tolerance = '00:05:00') {

        $this->hoursCount = count(array_filter($hours));

        $this->tolerance = is_int($tolerance) ? 5 : $tolerance;

        $this->hour1 = !empty($hours[0]) ? new DateTime($hours[0]) : null;
        $this->hour2 = !empty($hours[1]) ? new DateTime($hours[1]) : null;
        $this->hour3 = !empty($hours[2]) ? new DateTime($hours[2]) : null;
        $this->hour4 = !empty($hours[3]) ? new DateTime($hours[3]) : null;

        $this->hour5 = !empty($hours[4]) ? new DateTime($hours[4]) : null;
        $this->hour6 = !empty($hours[5]) ? new DateTime($hours[5]) : null;
        $this->hour7 = !empty($hours[6]) ? new DateTime($hours[6]) : null;
        $this->hour8 = !empty($hours[7]) ? new DateTime($hours[7]) : null;
    }

    public function getHour1() {
        return !empty($this->hour1) ? $this->hour1->format('H:i') : null;
    }

    public function getHour2() {
        return !empty($this->hour2) ? $this->hour2->format('H:i') : null;
    }

    public function getHour3() {
        return !empty($this->hour3) ? $this->hour3->format('H:i') : null;
    }

    public function getHour4() {
        return !empty($this->hour4) ? $this->hour4->format('H:i') : null;
    }

    public function getHour5() {
        return !empty($this->hour5) ? $this->hour5->format('H:i') : null;
    }

    public function getHour6() {
        return !empty($this->hour6) ? $this->hour6->format('H:i') : null;
    }

    public function getHour7() {
        return !empty($this->hour7) ? $this->hour7->format('H:i') : null;
    }

    public function getHour8() {
        return !empty($this->hour8) ? $this->hour8->format('H:i') : null;
    }

    public function setHour1($hour1) {
        $this->hour1 = $hour1;
    }

    public function setHour2($hour2) {
        $this->hour2 = $hour2;
    }

    public function setHour3($hour3) {
        $this->hour3 = $hour3;
    }

    public function setHour4($hour4) {
        $this->hour4 = $hour4;
    }

    public function setHour5($hour5) {
        $this->hour5 = $hour5;
    }

    public function setHour6($hour6) {
        $this->hour6 = $hour6;
    }

    public function setHour7($hour7) {
        $this->hour7 = $hour7;
    }

    public function setHour8($hour8) {
        $this->hour8 = $hour8;
    }

    public function setSchedules($schedules) {
        $this->schedules = $schedules;
    }

    public function worked() {

        $interval1 = Time::diffOrNull($this->hour1, $this->hour2);

        $interval2 = Time::diffOrNull($this->hour3, $this->hour4);

        $interval3 = Time::diffOrNull($this->hour5, $this->hour6);

        $interval4 = Time::diffOrNull($this->hour7, $this->hour8);

        return Time::sumDateTime($interval1, $interval2, $interval3, $interval4);
    }

    public function overtime() {

        switch ($this->hoursCount) {
            case 2:
                return Time::sum($this->overtimeHour1(), $this->overtimeHour2());

            case 4:
//                var_dump($this->schedules->hour1);
                return Time::sum($this->overtimeHour1(), $this->overtimeHour4(), $this->overtimeInterval1());
//                return '00:00:00';
        }
    }

    public function overdue() {

        switch ($this->hoursCount) {

            case 2:

                return Time::sum($this->overdueHour1(), $this->overdueHour2());

            case 4:
                return Time::sum($this->overdueHour1(), $this->overdueHour4(), $this->overdueInterval1());
        }
    }

    public function extraNight() {

        return Time::calcExtraNight($this->hour1, $this->hour2);
    }

    /**
     * Dividindo extras em partes para depois unir no overtime()
     */
    public function overtimeHour1() {

            if ($this->hour1 < ($this->tolerancePlus($this->schedules->hour1))) {

                $interval = Time::diffValueOrNull($this->hour1, $this->schedules->hour1);

                return $interval;
            }
    }

    public function overtimeHour2() {

            if ($this->hour2 > ($this->tolerancePlus($this->schedules->hour2))) {

                $interval = Time::diffValueOrNull($this->hour2, $this->schedules->hour2);

                return $interval;
            }
    }

    public function overtimeHour4() {

        if ($this->hour4 > ($this->tolerancePlus($this->schedules->hour4))) {

            $interval = Time::diffValueOrNull($this->hour4, $this->schedules->hour4);

            return $interval;
        }
    }

    public function overtimeHour6() {

        if ($this->hour6 > ($this->tolerancePlus($this->schedules->hour6))) {

            $interval = Time::diffValueOrNull($this->hour6, $this->schedules->hour6);

            return $interval;
        }
    }

    public function overtimeHour8() {

        if ($this->hour8 > ($this->tolerancePlus($this->schedules->hour8))) {

            $interval = Time::diffValueOrNull($this->hour8, $this->schedules->hour8);

            return $interval;
        }
    }

    /**
     * Período de intervalo - coletando extras de cada intervalo de forma dinâmica
     */
    public function overtimeInterval1() {

        $hoursInterval = Time::diffValueOrNull($this->schedules->hour2, $this->schedules->hour3);
        $hoursIntervalTolerance = Time::sub($hoursInterval, $this->tolerance);
        $hoursIntervalRegister = Time::diffValueOrNull($this->hour2, $this->hour3);

        if (strtotime($hoursIntervalRegister) < strtotime($hoursIntervalTolerance)) {
            return Time::diffHours($hoursIntervalRegister, $hoursInterval);
        }
    }

    public function overtimeInterval2() {

        $hoursInterval = Time::diffValueOrNull($this->schedules->hour4, $this->schedules->hour5);
        $hoursIntervalTolerance = Time::sub($hoursInterval, $this->tolerance);
        $hoursIntervalRegister = Time::diffValueOrNull($this->hour4, $this->hour5);

        if (strtotime($hoursIntervalRegister) < strtotime($hoursIntervalTolerance)) {
            return Time::diffHours($hoursIntervalRegister, $hoursInterval);
        }
    }

    public function overtimeInterval3() {

        $hoursInterval = Time::diffValueOrNull($this->schedules->hour6, $this->schedules->hour7);
        $hoursIntervalTolerance = Time::sub($hoursInterval, $this->tolerance);
        $hoursIntervalRegister = Time::diffValueOrNull($this->hour6, $this->hour7);

        if (strtotime($hoursIntervalRegister) < strtotime($hoursIntervalTolerance)) {
            return Time::diffHours($hoursIntervalRegister, $hoursInterval);
        }
    }

    /**
     * Dividindo extras em partes para depois unir no overtime()
     */
    public function overdueHour1() {

        if ($this->hour1 > $this->toleranceLess($this->schedules->hour1)) {

            $interval = Time::diffValueOrNull($this->hour1, $this->schedules->hour1);

            return $interval;
        }
    }

    public function overdueHour2() {

        if ($this->hour2 < $this->toleranceLess($this->schedules->hour2)) {

            $interval = Time::diffValueOrNull($this->hour2, $this->schedules->hour2);

            return $interval;
        }
    }

    public function overdueHour4() {

        if ($this->hour4 < $this->toleranceLess($this->schedules->hour4)) {

            $interval = Time::diffValueOrNull($this->hour4, $this->schedules->hour4);

            return $interval;
        }
    }

    public function overdueHour6() {

        if ($this->hour6 < $this->toleranceLess($this->schedules->hour6)) {

            $interval = Time::diffValueOrNull($this->hour6, $this->schedules->hour6);

            return $interval;
        }
    }

    public function overdueHour8() {

        if ($this->hour8 < $this->toleranceLess($this->schedules->hour8)) {

            $interval = Time::diffValueOrNull($this->hour8, $this->schedules->hour8);

            return $interval;
        }
    }

    /**
     * Período de intervalo - coletando atrasos de cada intervalo de forma dinâmica
     */
    public function overdueInterval1() {

        $hoursInterval = Time::diffValueOrNull($this->schedules->hour2, $this->schedules->hour3);

        $hoursIntervalTolerance = Time::sum($hoursInterval, $this->tolerance);
        $hoursIntervalRegister = Time::diffValueOrNull($this->hour2, $this->hour3);

        if (strtotime($hoursIntervalRegister) > strtotime($hoursIntervalTolerance)) {
            return Time::diffHours($hoursIntervalRegister, $hoursInterval);
        }
    }

    public function overdueInterval2() {

        $hoursInterval = Time::diffValueOrNull($this->schedules->hour4, $this->schedules->hour5);

        $hoursIntervalTolerance = Time::sum($hoursInterval, $this->tolerance);
        $hoursIntervalRegister = Time::diffValueOrNull($this->hour4, $this->hour5);

        if (strtotime($hoursIntervalRegister) > strtotime($hoursIntervalTolerance)) {
            return Time::diffHours($hoursIntervalRegister, $hoursInterval);
        }
    }

    public function overdueInterval3() {

        $hoursInterval = Time::diffValueOrNull($this->schedules->hour6, $this->schedules->hour7);

        $hoursIntervalTolerance = Time::sum($hoursInterval, $this->tolerance);
        $hoursIntervalRegister = Time::diffValueOrNull($this->hour6, $this->hour7);

        if (strtotime($hoursIntervalRegister) > strtotime($hoursIntervalTolerance)) {
            return Time::diffHours($hoursIntervalRegister, $hoursInterval);
        }
    }

    public function gethoursCount() {
        return $this->hoursCount;
    }

}
