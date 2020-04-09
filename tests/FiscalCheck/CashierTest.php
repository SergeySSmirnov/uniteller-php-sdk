<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Tests\FiscalCheck;

use PHPUnit\Framework\TestCase;
use Rusproj\Uniteller\FiscalCheck\Cashier;
use Rusproj\Uniteller\Exception\FieldIncorrectValueException;

/**
 * Cashier test case.
 */
class CashierTest extends TestCase
{
    /**
     * @return \Rusproj\Uniteller\FiscalCheck\Cashier
     */
    public static function createCashierTestInstance()
    {
        $_cashier = new Cashier();
        $_cashier
            ->setName('Cashier')
            ->setInn('123456789012');
        return $_cashier;
    }

    public function testWrongValInNameSetter()
    {
        $_name = '';
        for ($_i = 0; $_i < 241; $_i++) {
            $_name .= rand(0, 9);
        }

        $this->expectException(FieldIncorrectValueException::class);
        $_cashier = new Cashier();
        $_cashier->setName($_name);
    }

    public function testWrongValInInnSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_cashier = new Cashier();
        $_cashier->setInn(123);
    }

    public function testCashierObjectable()
    {
        $_cashier = self::createCashierTestInstance();

        $_objectableResult = $_cashier->toObject();
        $this->assertInstanceOf(\stdClass::class, $_objectableResult);
        $this->assertTrue(count((array)$_objectableResult) === 2);

        $this->assertObjectHasAttribute('name', $_objectableResult);
        $this->assertTrue($_objectableResult->name === 'Cashier');
        $this->assertObjectHasAttribute('inn', $_objectableResult);
        $this->assertTrue($_objectableResult->inn === '123456789012');
    }

}
