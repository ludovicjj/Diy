<?php

use PHPUnit\Framework\TestCase;

class indexTest extends TestCase
{
    /**
     * @return void
     */
    public function testHello()
    {
        $_GET['name'] = 'Ludovic';

        ob_start();
        include 'index.php';
        $content = ob_get_clean();

        $this->assertEquals('Hello Ludovic', $content);
    }
}