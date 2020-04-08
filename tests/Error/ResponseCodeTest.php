<?php
/**
 * Created by Roquie.
 * E-mail: roquie0@gmail.com
 * GitHub: Roquie
 * Date: 17/05/2017
 */

namespace Rusproj\Uniteller\Tests\Error;

use Rusproj\Uniteller\Error\ResponseCode;
use Rusproj\Uniteller\Tests\TestCase;

class ResponseCodeTest extends TestCase
{
    public function provideParametersToConverter()
    {
        return [
            ['AS000'],
            ['AS100'],
            ['AS101'],
            ['AS102'],
            ['AS104'],
            ['AS105'],
            ['AS107'],
            ['AS108'],
            ['AS109'],
            ['AS200'],
            ['AS998'],
            ['UNKNOWN'],
        ];
    }

    /**
     * @dataProvider provideParametersToConverter
     * @param $code
     */
    public function testShouldBeConvertErrorCodeToHumanMessage($code)
    {
        $method = $code === 'UNKNOWN' ? 'assertNull' : 'assertNotEmpty';
        $this->{$method}(ResponseCode::message($code));
    }
}