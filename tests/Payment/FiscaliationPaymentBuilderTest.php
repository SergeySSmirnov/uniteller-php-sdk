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
        $this->assertTrue(count($_arraybleResult) === 9);

        $this->assertArrayHasKey('Currency', $_arraybleResult);
        $this->assertTrue($_arraybleResult['Currency'] === 'RUB');

        $this->assertArrayHasKey('Order_IDP', $_arraybleResult);
        $this->assertTrue($_arraybleResult['Order_IDP'] === '12345');

        $this->assertArrayHasKey('Shop_IDP', $_arraybleResult);
        $this->assertTrue($_arraybleResult['Shop_IDP'] === '012345-67890');

        $this->assertArrayHasKey('Subtotal_P', $_arraybleResult);
        $this->assertTrue($_arraybleResult['Subtotal_P'] === '100.30');

        $this->assertArrayHasKey('URL_RETURN_OK', $_arraybleResult);
        $this->assertTrue($_arraybleResult['URL_RETURN_OK'] === 'http://mysite.com/success');

        $this->assertArrayHasKey('URL_RETURN_NO', $_arraybleResult);
        $this->assertTrue($_arraybleResult['URL_RETURN_NO'] === 'http://mysite.com/error');

        $this->assertArrayHasKey('IsRecurrentStart', $_arraybleResult);
        $this->assertTrue($_arraybleResult['IsRecurrentStart'] === '');

        $this->assertArrayHasKey('Signature', $_arraybleResult);
        $this->assertTrue($_arraybleResult['Signature'] === '');

        $this->assertArrayHasKey('Receipt', $_arraybleResult);
        $this->assertTrue($_arraybleResult['Receipt'] instanceof \stdClass);
        $this->assertTrue(count((array)$_arraybleResult['Receipt']) === 8);
    }

}
