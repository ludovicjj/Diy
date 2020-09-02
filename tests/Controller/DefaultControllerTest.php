<?php


namespace Tests\Controller;


use App\Controller\DefaultController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class DefaultControllerTest extends TestCase
{
    public function testTemplate()
    {
        $request = new Request();
        $request->attributes->add([
            '_route' => 'bye'
        ]);
        $controller = new DefaultController;
        $response = $controller($request);
        $this->assertEquals('<h1>Goodbye !</h1>', $response->getContent());
    }

    public function testTemplateWithParams()
    {
        $request = new Request();
        $request->attributes->add([
            '_route' => 'hello',
            'name' => 'John'
        ]);
        $controller = new DefaultController;
        $response = $controller($request);

        $this->assertSimilar('Hello John', $response->getContent());
    }

    private function assertSimilar(string $expected, string $actual): void
    {
        $this->assertEquals($this->trim($expected), $this->trim($actual));
    }

    /**
     * @param string $lines
     * @return string
     */
    private function trim(string $lines): string
    {
        $arrayLines = explode(PHP_EOL, $lines);
        return  implode('', array_map(function ($value) {
            return trim($value);
        }, $arrayLines));
    }
}