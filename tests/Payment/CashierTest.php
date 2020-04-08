<?php

namespace Rusproj\Uniteller\Tests\Payment;

use PHPUnit\Framework\TestCase;
use Rusproj\Uniteller\FiscalCheck\Cashier;
use Rusproj\Uniteller\Exception\FieldIncorrectValueException;

/**
 * Cashier test case.
 */
class CashierTest extends TestCase
{

    public function testWrongName()
    {
        $_name = '';
        for ($_i = 0; $_i < 241; $_i++) {
            $_name .= rand(0, 9);
        }

        $this->expectException(FieldIncorrectValueException::class);
        $_cashier = new Cashier();
        $_cashier->setName($_name);

    }

    public function testWrongInn()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_cashier = new Cashier();
        $_cashier->setInn(123);

    }

    public function testCashierObjectable()
    {

        $_cashier = new Cashier();
        $_cashier
            ->setName('Cashier')
            ->setInn('123456789012');

        $_objectableResult = $_cashier->toObject();
        $this->assertTrue($_objectableResult instanceof \stdClass);
        $this->assertTrue(count((array)$_objectableResult) === 2);

        $this->assertObjectHasAttribute('name', $_objectableResult);
        $this->assertTrue($_objectableResult->name === 'Cashier');
        $this->assertObjectHasAttribute('inn', $_objectableResult);
        $this->assertTrue($_objectableResult->inn === '123456789012');
    }
}
