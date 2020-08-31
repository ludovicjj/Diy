<?php


namespace App\Model;


class Calendar
{
    /**
     * @param string|null $year
     * @return bool
     */
    public function isLeapYear(?string $year)
    {
        if ($year === null) {
            $year = date('Y');
        }
        return ($year % 4 === 0 && $year % 100 !== 0) || $year % 400 === 0;
    }
}