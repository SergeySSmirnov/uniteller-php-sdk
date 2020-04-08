<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Tests\FiscalCheck;

use PHPUnit\Framework\TestCase;
use Rusproj\Uniteller\FiscalCheck\AdditionalProductInfo;

/**
 * AdditionalProductInfo test case.
 */
class AdditionalProductInfoTest extends TestCase
{

    /**
     * @return \Rusproj\Uniteller\FiscalCheck\AdditionalProductInfo
     */
    public static function getAdditionalProductInfoTestInstance()
    {
        $_additiionalProductInfo = new AdditionalProductInfo();
        $_additiionalProductInfo
            ->setCoc('Код товара')
            ->setExc('Акциз')
            ->setKt('RU')
            ->setNcd('123456');
        return $_additiionalProductInfo;
    }

    public function testAdditionalProductInfoObjectable()
    {
        $_additiionalProductInfo = new AdditionalProductInfo();
        $_additiionalProductInfo
            ->setCoc('Код товара')
            ->setExc('Акциз');

        $_objectableResult = $_additiionalProductInfo->toObject();
        $this->assertTrue($_objectableResult instanceof \stdClass);
        $this->assertTrue(count((array)$_objectableResult) === 4);

        $this->assertObjectHasAttribute('coc', $_objectableResult);
        $this->assertTrue($_objectableResult->coc === 'Код товара');
        $this->assertObjectHasAttribute('exc', $_objectableResult);
        $this->assertTrue($_objectableResult->exc === 'Акциз');
        $this->assertObjectHasAttribute('kt', $_objectableResult);
        $this->assertTrue($_objectableResult->kt === '');
        $this->assertObjectHasAttribute('ncd', $_objectableResult);
        $this->assertTrue($_objectableResult->ncd === '');

        $_additiionalProductInfo
            ->setKt('RU')
            ->setNcd('123456');

        $_objectableResult = $_additiionalProductInfo->toObject();
        $this->assertTrue($_objectableResult instanceof \stdClass);
        $this->assertTrue(count((array)$_objectableResult) === 4);

        $this->assertObjectHasAttribute('coc', $_objectableResult);
        $this->assertTrue($_objectableResult->coc === 'Код товара');
        $this->assertObjectHasAttribute('exc', $_objectableResult);
        $this->assertTrue($_objectableResult->exc === 'Акциз');
        $this->assertObjectHasAttribute('kt', $_objectableResult);
        $this->assertTrue($_objectableResult->kt === 'RU');
        $this->assertObjectHasAttribute('ncd', $_objectableResult);
        $this->assertTrue($_objectableResult->ncd === '123456');
    }

}

