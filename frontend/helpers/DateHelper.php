<?php

namespace frontend\helpers;

use Faker\Provider\cs_CZ\DateTime;

class DateHelper {

    public static function formatDate($date)
    {
        $formatDate = new \DateTime($date);
        return $formatDate->format('Y-m-d');
    }
}