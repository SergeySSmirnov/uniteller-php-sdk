<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Tests\PaymentApi;

use PHPUnit\Framework\TestCase;
use Rusproj\Uniteller\PaymentApi\ApiCheckBuilder;
use Rusproj\Uniteller\Exception\FieldIncorrectValueException;

/**
 * ApiCheckBuilder test case.
 */
class ApiCheckBuilderTest extends TestCase
{

    public static function createBuilderTestInstance()
    {
        $_builder = new ApiCheckBuilder();
        $_builder
            ->setShopID('012345-67890')
            ->setOrderID('12345');
        return $_builder;
    }

    public function testWrongValInOrderIdpSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new ApiCheckBuilder();
        $_builder->setOrderID($this->generateFieldVal(70));
    }

    public function testPaymentBuilder()
    {
        $_builder = self::createBuilderTestInstance();

        $_arraybleResult = $_builder->toArray();

        $this->assertTrue(is_array($_arraybleResult));
        $this->assertEquals(3, count($_arraybleResult));

        $this->assertArrayHasKey('ShopID', $_arraybleResult);
        $this->assertEquals('012345-67890', $_arraybleResult['ShopID']);

        $this->assertArrayHasKey('OrderID', $_arraybleResult);
        $this->assertEquals('12345', $_arraybleResult['OrderID']);

        $this->assertArrayHasKey('Signature', $_arraybleResult);
        $this->assertEquals('', $_arraybleResult['Signature']);

    }

}
