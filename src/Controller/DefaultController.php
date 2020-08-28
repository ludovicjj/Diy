<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $params = $request->attributes->all();
        extract($params);
        ob_start();
        /**
         * @var $_route string
         * @noinspection PhpIncludeInspection
         */
        include sprintf(__DIR__.'/../pages/%s.php', $_route);
        return new Response(ob_get_clean());
    }
}
