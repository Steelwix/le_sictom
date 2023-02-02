<?php

namespace App\Service;

use DateTime;

class DateCompare
{
    public function compareDayWithToday(DateTime $yourDate)
    {
        $datetime = new DateTime();
        $stringDatetime = $datetime->format('d-m-Y H:i:s');
        $today = date('Y-m-d', strtotime($stringDatetime));

        $stringDatetime = $yourDate->format('d-m-Y H:i:s');
        $compareToToday = date('Y-m-d', strtotime($stringDatetime));
        if ($today == $compareToToday) {
            return true;
        }
        return false;
    }
}
