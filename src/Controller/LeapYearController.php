<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LeapYearController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        if ($this->IsLeapYear($request->attributes->get('year'))) {
            return new Response('Yep, this is a leap year!');
        }
        return new Response('Nope, this is not a leap year.');
    }

    /**
     * @param string|null $year
     * @return bool
     */
    private function IsLeapYear(?string $year): bool
    {
        if ($year === null) {
            $year = date('Y');
        }
        return ($year % 4 === 0 && $year % 100 !== 0) || $year % 400 === 0;
    }
}