<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Tests\PaymentConfirm;

use PHPUnit\Framework\TestCase;
use Rusproj\Uniteller\Tests\FiscalCheck\ReceiptTest;
use Rusproj\Uniteller\PaymentConfirm\PreauthConfirmBuilder;

/**
 * PreauthConfirmBuilder test case.
 */
class PreauthConfirmBuilderTest extends TestCase
{

    public static function createPreauthConfirmBuilderTestInstance()
    {
        $_builder = new PreauthConfirmBuilder();
        $_builder
            ->setOrderID('12345')
            ->setReceipt(ReceiptTest::createReceiptTestInstance())
            ->setShopID('012345-67890')
            ->setSubtotal('98.32');
        return $_builder;
    }

    public function testPaymentBuilder()
    {
        $_paymentBuilder = self::createPreauthConfirmBuilderTestInstance();

        $_arraybleResult = $_paymentBuilder->toArray();

        $this->assertTrue(is_array($_arraybleResult));
        $this->assertEquals(6, count($_arraybleResult));

        $this->assertArrayHasKey('OrderID', $_arraybleResult);
        $this->assertEquals('12345', $_arraybleResult['OrderID']);

        $this->assertArrayHasKey('ShopID', $_arraybleResult);
        $this->assertEquals('012345-67890', $_arraybleResult['ShopID']);

        $this->assertArrayHasKey('Subtotal', $_arraybleResult);
        $this->assertEquals('98.32', $_arraybleResult['Subtotal']);

        $this->assertArrayHasKey('Signature', $_arraybleResult);
        $this->assertEquals('', $_arraybleResult['Signature']);

        $this->assertArrayHasKey('ReceiptSignature', $_arraybleResult);
        $this->assertEquals('', $_arraybleResult['ReceiptSignature']);

        $this->assertArrayHasKey('Receipt', $_arraybleResult);
        $this->assertInstanceOf(\stdClass::class, $_arraybleResult['Receipt']);
        $this->assertEquals(8, count((array)$_arraybleResult['Receipt']));
    }

}
