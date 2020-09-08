<?php


namespace App\Controller;


use App\Model\Calendar;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LeapYearController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $calendar = new Calendar();
        $response = new Response();
        if ($calendar->isLeapYear($request->attributes->get('year'))) {
            $response->setContent('Yep, this is a leap year!');
        } else {
            $response->setContent('Nope, this is not a leap year.');
        }

        $response
            ->setPublic()
            ->setEtag(md5($response->getContent()));
        return $response;

    }
}