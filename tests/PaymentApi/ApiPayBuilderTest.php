<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Tests\PaymentApi;

use PHPUnit\Framework\TestCase;
use Rusproj\Uniteller\Exception\FieldIncorrectValueException;
use Rusproj\Uniteller\PaymentApi\ApiPayBuilder;
use Rusproj\Uniteller\Tests\Payment\PaymentBuilderTest;

/**
 * ApiPayBuilder test case.
 */
class ApiPayBuilderTest extends TestCase
{

    public static function createBuilderTestInstance()
    {
        $_builder = new ApiPayBuilder();
        $_builder
            ->setShopID('012345-67890')
            ->setSubtotal(12.95)
            ->setPaymentAttemptID('1234567890QAZ');
        return $_builder;
    }

    public function testWrongValInPaymentAttemptIDSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new ApiPayBuilder();
        $_builder->setPaymentAttemptID(PaymentBuilderTest::generateFieldVal(70));
    }

    public function testPaymentBuilder()
    {
        $_builder = self::createBuilderTestInstance();

        $_arraybleResult = $_builder->toArray();

        $this->assertTrue(is_array($_arraybleResult));
        $this->assertEquals(4, count($_arraybleResult));

        $this->assertArrayHasKey('ShopID', $_arraybleResult);
        $this->assertEquals('012345-67890', $_arraybleResult['ShopID']);

        $this->assertArrayHasKey('Subtotal', $_arraybleResult);
        $this->assertEquals(12.95, $_arraybleResult['Subtotal']);

        $this->assertArrayHasKey('PaymentAttemptID', $_arraybleResult);
        $this->assertEquals('1234567890QAZ', $_arraybleResult['PaymentAttemptID']);

        $this->assertArrayHasKey('Signature', $_arraybleResult);
        $this->assertEquals('', $_arraybleResult['Signature']);
    }

}
