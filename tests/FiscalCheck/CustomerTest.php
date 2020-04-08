<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Tests\FiscalCheck;

use PHPUnit\Framework\TestCase;
use Rusproj\Uniteller\FiscalCheck\Customer;
use Rusproj\Uniteller\Exception\FieldIncorrectValueException;

/**
 * Customer test case.
 */
class CustomerTest extends TestCase
{

    public function testWrongName()
    {
        $_name = '';
        for ($_i = 0; $_i < 244; $_i++) {
            $_name .= rand(0, 9);
        }

        $this->expectException(FieldIncorrectValueException::class);
        $_cashier = new Customer();
        $_cashier->setName($_name);
    }

    public function testWrongInn()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_cashier = new Customer();
        $_cashier->setInn(123);
    }

    public function testCustomerObjectable()
    {
        $_customer = new Customer();
        $_customer
            ->setEmail('test@test.tt')
            ->setId(12345)
            ->setPhone('+71234567890');

        $_objectableResult = $_customer->toObject();
        $this->assertTrue($_objectableResult instanceof \stdClass);
        $this->assertTrue(count((array)$_objectableResult) === 3);

        $this->assertObjectHasAttribute('email', $_objectableResult);
        $this->assertTrue($_objectableResult->email === 'test@test.tt');
        $this->assertObjectHasAttribute('id', $_objectableResult);
        $this->assertTrue($_objectableResult->id === 12345);
        $this->assertObjectHasAttribute('phone', $_objectableResult);
        $this->assertTrue($_objectableResult->phone === '+71234567890');

        $_customer
            ->setName('Client')
            ->setInn('123456789012');

        $_objectableResult = $_customer->toObject();
        $this->assertTrue($_objectableResult instanceof \stdClass);
        $this->assertTrue(count((array)$_objectableResult) === 5);

        $this->assertObjectHasAttribute('email', $_objectableResult);
        $this->assertTrue($_objectableResult->email === 'test@test.tt');
        $this->assertObjectHasAttribute('id', $_objectableResult);
        $this->assertTrue($_objectableResult->id === 12345);
        $this->assertObjectHasAttribute('phone', $_objectableResult);
        $this->assertTrue($_objectableResult->phone === '+71234567890');
        $this->assertObjectHasAttribute('name', $_objectableResult);
        $this->assertTrue($_objectableResult->name === 'Client');
        $this->assertObjectHasAttribute('inn', $_objectableResult);
        $this->assertTrue($_objectableResult->inn === '123456789012');
    }

}
