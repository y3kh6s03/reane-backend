<?php

namespace App\Services;

class DateCalcService
{
  public static function calcDate($createdDate)
  {
    $createdDate = strtotime($createdDate);
    $currentDate = strtotime(date("Y/m/d"));
    $date = ($currentDate - $createdDate) / (24 * 60 * 60);

    return $date;
  }
}
