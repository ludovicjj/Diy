<?php


namespace Tests\Controller;


use App\Controller\LeapYearController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class LeapYearControllerTest extends TestCase
{
    /** @var LeapYearController $controller */
    protected $controller;

    /** @var Request $request */
    protected $request;

    public function setUp(): void
    {
        $this->controller = new LeapYearController();
        $this->request = new Request();
    }

    public function testIndexWithDefaultYear(): void
    {
        $this->requestAddAttributes(['year' => null]);
        $response = $this->controller->index($this->request);

        $this->assertEquals('Yep, this is a leap year!', $response->getContent());
    }

    public function testIndexWithCustomYear()
    {
        $this->requestAddAttributes(['year' => '1995']);
        $response = $this->controller->index($this->request);
        $this->assertEquals('Nope, this is not a leap year.', $response->getContent());
    }

    public function testIndexWithCustomLeapYear()
    {
        $this->requestAddAttributes(['year' => '2012']);
        $response = $this->controller->index($this->request);
        $this->assertEquals('Yep, this is a leap year!', $response->getContent());
    }

    private function requestAddAttributes(array $params)
    {
        $this->request->attributes->add($params);
    }
}