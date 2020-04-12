<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Tests\FiscalCheck;

use PHPUnit\Framework\TestCase;
use Rusproj\Uniteller\FiscalCheck\Receipt;
use Rusproj\Uniteller\Enum\TaxModeTypes;
use Rusproj\Uniteller\Exception\FieldIncorrectValueException;
use Rusproj\Uniteller\FiscalCheck\ProductLine;
use Rusproj\Uniteller\FiscalCheck\Payment;

/**
 * Receipt test case.
 */
class ReceiptTest extends TestCase
{

    /**
     * @return \Rusproj\Uniteller\FiscalCheck\Receipt
     */
    public static function createReceiptTestInstance()
    {
        $_receipt = new Receipt();
        $_receipt
            ->setCustomer(CustomerTest::createCustomerTestInstance())
            ->setLines([
                ProductLineTest::createProductLineTestInstance(),
                ProductLineTest::createProductLineTestInstance()
            ])
            ->setPayments([PaymentTest::createPaymentTestInstance()])
            ->setTaxmode(TaxModeTypes::TAX_0)
            ->setTotal('98.32')
            ->setCashier(CashierTest::createCashierTestInstance())
            ->setPlace('IVA')
            ->setOptional((object)['val' => 'Some merchant data']);
        return $_receipt;
    }

    public function testWrongValInLinesSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_receipt = new Receipt();
        $_receipt->setLines(new ProductLine());
    }

    public function testWrongValInPaymentsSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_receipt = new Receipt();
        $_receipt->setLines(new Payment());
    }

    public function testReceiptObjectable()
    {
        $_receipt = new Receipt();
        $_receipt
            ->setCustomer(CustomerTest::createCustomerTestInstance())
            ->setLines([
                ProductLineTest::createProductLineTestInstance(),
                ProductLineTest::createProductLineTestInstance()
            ])
            ->setPayments([PaymentTest::createPaymentTestInstance()])
            ->setTaxmode(TaxModeTypes::TAX_0)
            ->setTotal('98.32');

        $_objectableResult = $_receipt->toObject();
        $this->assertInstanceOf(\stdClass::class, $_objectableResult);
        $this->assertTrue(count((array)$_objectableResult) === 5);

        $this->assertObjectHasAttribute('taxmode', $_objectableResult);
        $this->assertTrue($_objectableResult->taxmode === TaxModeTypes::TAX_0);
        $this->assertObjectHasAttribute('total', $_objectableResult);
        $this->assertTrue($_objectableResult->total === '98.32');

        $this->assertObjectHasAttribute('customer', $_objectableResult);
        $this->assertInstanceOf(\stdClass::class, $_objectableResult->customer);
        $this->assertTrue(count((array)$_objectableResult->customer) === 5);

        $this->assertObjectHasAttribute('lines', $_objectableResult);
        $this->assertTrue(is_array($_objectableResult->lines));
        $this->assertTrue(count($_objectableResult->lines) === 2);
        $this->assertInstanceOf(\stdClass::class, $_objectableResult->lines[0]);
        $this->assertInstanceOf(\stdClass::class, $_objectableResult->lines[1]);

        $this->assertObjectHasAttribute('payments', $_objectableResult);
        $this->assertTrue(is_array($_objectableResult->payments));
        $this->assertTrue(count($_objectableResult->payments) === 1);
        $this->assertInstanceOf(\stdClass::class, $_objectableResult->payments[0]);

        $_receipt
            ->setCashier(CashierTest::createCashierTestInstance())
            ->setPlace('IVA')
            ->setOptional((object)['val' => 'Some merchant data']);

        $_objectableResult = $_receipt->toObject();
        $this->assertInstanceOf(\stdClass::class, $_objectableResult);
        $this->assertTrue(count((array)$_objectableResult) === 8);

        $this->assertObjectHasAttribute('cashier', $_objectableResult);
        $this->assertInstanceOf(\stdClass::class, $_objectableResult->cashier);
        $this->assertTrue(count((array)$_objectableResult->cashier) === 2);

        $this->assertObjectHasAttribute('optional', $_objectableResult);
        $this->assertInstanceOf(\stdClass::class, $_objectableResult->optional);
        $this->assertTrue(count((array)$_objectableResult->optional) === 1);
        $this->assertObjectHasAttribute('val', $_objectableResult->optional);
        $this->assertTrue($_objectableResult->optional->val === 'Some merchant data');

        $this->assertObjectHasAttribute('params', $_objectableResult);
        $this->assertInstanceOf(\stdClass::class, $_objectableResult->params);
        $this->assertTrue(count((array)$_objectableResult->params) === 1);
        $this->assertObjectHasAttribute('place', $_objectableResult->params);
        $this->assertTrue($_objectableResult->params->place === 'IVA');
    }

}