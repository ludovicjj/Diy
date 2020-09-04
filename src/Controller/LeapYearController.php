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
    public function index(Request $request): Response
    {
        $calendar = new Calendar();

        if ($calendar->isLeapYear($request->attributes->get('year'))) {
            $response = new Response('Yep, this is a leap year!');
        } else {
            $response = new Response('Nope, this is not a leap year.');
        }
        $response
            ->setPublic()
            ->setEtag(md5($response->getContent()));
        return $response;
    }
}