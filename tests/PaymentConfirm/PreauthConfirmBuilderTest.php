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
        $this->assertTrue(count($_arraybleResult) === 6);

        $this->assertArrayHasKey('OrderID', $_arraybleResult);
        $this->assertTrue($_arraybleResult['OrderID'] === '12345');

        $this->assertArrayHasKey('ShopID', $_arraybleResult);
        $this->assertTrue($_arraybleResult['ShopID'] === '012345-67890');

        $this->assertArrayHasKey('Subtotal', $_arraybleResult);
        $this->assertTrue($_arraybleResult['Subtotal'] === '98.32');

        $this->assertArrayHasKey('Signature', $_arraybleResult);
        $this->assertTrue($_arraybleResult['Signature'] === '');

        $this->assertArrayHasKey('ReceiptSignature', $_arraybleResult);
        $this->assertTrue($_arraybleResult['ReceiptSignature'] === '');

        $this->assertArrayHasKey('Receipt', $_arraybleResult);
        $this->assertInstanceOf(\stdClass::class, $_arraybleResult['Receipt']);
        $this->assertTrue(count((array)$_arraybleResult['Receipt']) === 8);
    }

}
