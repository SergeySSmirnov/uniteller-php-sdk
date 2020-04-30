<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Tests\Payment;

use PHPUnit\Framework\TestCase;
use Rusproj\Uniteller\Enum\CurrencyTypes;
use Rusproj\Uniteller\Payment\FiscaliationPaymentBuilder;
use Rusproj\Uniteller\Tests\FiscalCheck\ReceiptTest;

/**
 * PaymentBuilder test case.
 */
class FiscaliationPaymentBuilderTest extends TestCase
{

    public static function createFiscaliationPaymentBuilderTestInstance()
    {
        $_builder = new FiscaliationPaymentBuilder();
        $_builder
            ->setCurrency(CurrencyTypes::RUB)
            ->setOrderIdp('12345')
            ->setShopIdp('012345-67890')
            ->setSubtotalP('100.30')
            ->setUrlReturnOk('http://mysite.com/success')
            ->setUrlReturnNo('http://mysite.com/error')
            ->setReceipt(ReceiptTest::createReceiptTestInstance());
        return $_builder;
    }

    public function testPaymentBuilder()
    {
        $_paymentBuilder = new FiscaliationPaymentBuilder();
        $_paymentBuilder
            ->setCurrency(CurrencyTypes::RUB)
            ->setOrderIdp('12345')
            ->setShopIdp('012345-67890')
            ->setSubtotalP('100.30')
            ->setUrlReturnOk('http://mysite.com/success')
            ->setUrlReturnNo('http://mysite.com/error')
            ->setReceipt(ReceiptTest::createReceiptTestInstance());

        $_arraybleResult = $_paymentBuilder->toArray();

        $this->assertTrue(is_array($_arraybleResult));
        $this->assertEquals(10, count($_arraybleResult));

        $this->assertArrayHasKey('Currency', $_arraybleResult);
        $this->assertEquals('RUB', $_arraybleResult['Currency']);

        $this->assertArrayHasKey('Order_IDP', $_arraybleResult);
        $this->assertEquals('12345', $_arraybleResult['Order_IDP']);

        $this->assertArrayHasKey('Shop_IDP', $_arraybleResult);
        $this->assertEquals('012345-67890', $_arraybleResult['Shop_IDP']);

        $this->assertArrayHasKey('Subtotal_P', $_arraybleResult);
        $this->assertEquals('100.30', $_arraybleResult['Subtotal_P']);

        $this->assertArrayHasKey('URL_RETURN_OK', $_arraybleResult);
        $this->assertEquals('http://mysite.com/success', $_arraybleResult['URL_RETURN_OK']);

        $this->assertArrayHasKey('URL_RETURN_NO', $_arraybleResult);
        $this->assertEquals('http://mysite.com/error', $_arraybleResult['URL_RETURN_NO']);

        $this->assertArrayHasKey('IsRecurrentStart', $_arraybleResult);
        $this->assertEquals('', $_arraybleResult['IsRecurrentStart']);

        $this->assertArrayHasKey('Signature', $_arraybleResult);
        $this->assertEquals('', $_arraybleResult['Signature']);

        $this->assertArrayHasKey('Receipt', $_arraybleResult);
        $this->assertInstanceOf(\stdClass::class, $_arraybleResult['Receipt']);
        $this->assertEquals(8, count((array)$_arraybleResult['Receipt']));

        $this->assertArrayHasKey('ReceiptSignature', $_arraybleResult);
        $this->assertEquals('', $_arraybleResult['ReceiptSignature']);
    }

}
