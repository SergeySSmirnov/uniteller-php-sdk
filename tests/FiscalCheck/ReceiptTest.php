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
     * @return \Rusproj\Uniteller\FiscalCheck\AdditionalProductInfo
     */
    public static function getReceiptTestInstance()
    {
        $_receipt = new Receipt();
        $_receipt
            ->setCustomer(CustomerTest::getCustomerTestInstance())
            ->setLines([
                ProductLineTest::getProductLineTestInstance(),
                ProductLineTest::getProductLineTestInstance()
            ])
            ->setPayments(PaymentTest::getPaymentTestInstance())
            ->setTaxmode(TaxModeTypes::TAX_0)
            ->setTotal('98.32')
            ->setCashier(CashierTest::getCashierTestInstance())
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
            ->setCustomer(CustomerTest::getCustomerTestInstance())
            ->setLines([
                ProductLineTest::getProductLineTestInstance(),
                ProductLineTest::getProductLineTestInstance()
            ])
            ->setPayments([PaymentTest::getPaymentTestInstance()])
            ->setTaxmode(TaxModeTypes::TAX_0)
            ->setTotal('98.32');

        $_objectableResult = $_receipt->toObject();
        $this->assertTrue($_objectableResult instanceof \stdClass);
        $this->assertTrue(count((array)$_objectableResult) === 5);

        $this->assertObjectHasAttribute('taxmode', $_objectableResult);
        $this->assertTrue($_objectableResult->taxmode === TaxModeTypes::TAX_0);
        $this->assertObjectHasAttribute('total', $_objectableResult);
        $this->assertTrue($_objectableResult->total === '98.32');

        $this->assertObjectHasAttribute('customer', $_objectableResult);
        $this->assertTrue($_objectableResult->customer instanceof  \stdClass);
        $this->assertTrue(count((array)$_objectableResult->customer) === 5);

        $this->assertObjectHasAttribute('lines', $_objectableResult);
        $this->assertTrue(is_array($_objectableResult->lines));
        $this->assertTrue(count($_objectableResult->lines) === 2);
        $this->assertTrue($_objectableResult->lines[0] instanceof  \stdClass);
        $this->assertTrue($_objectableResult->lines[1] instanceof  \stdClass);

        $this->assertObjectHasAttribute('payments', $_objectableResult);
        $this->assertTrue(is_array($_objectableResult->payments));
        $this->assertTrue(count($_objectableResult->payments) === 1);
        $this->assertTrue($_objectableResult->payments[0] instanceof  \stdClass);

        $_receipt
            ->setCashier(CashierTest::getCashierTestInstance())
            ->setPlace('IVA')
            ->setOptional((object)['val' => 'Some merchant data']);

        $_objectableResult = $_receipt->toObject();
        $this->assertTrue($_objectableResult instanceof \stdClass);
        $this->assertTrue(count((array)$_objectableResult) === 8);

        $this->assertObjectHasAttribute('cashier', $_objectableResult);
        $this->assertTrue($_objectableResult->cashier instanceof  \stdClass);
        $this->assertTrue(count((array)$_objectableResult->cashier) === 2);

        $this->assertObjectHasAttribute('optional', $_objectableResult);
        $this->assertTrue($_objectableResult->optional instanceof  \stdClass);
        $this->assertTrue(count((array)$_objectableResult->optional) === 1);
        $this->assertObjectHasAttribute('val', $_objectableResult->optional);
        $this->assertTrue($_objectableResult->optional->val === 'Some merchant data');

        $this->assertObjectHasAttribute('params', $_objectableResult);
        $this->assertTrue($_objectableResult->params instanceof  \stdClass);
        $this->assertTrue(count((array)$_objectableResult->params) === 1);
        $this->assertObjectHasAttribute('place', $_objectableResult->params);
        $this->assertTrue($_objectableResult->params->place === 'IVA');
    }

}
