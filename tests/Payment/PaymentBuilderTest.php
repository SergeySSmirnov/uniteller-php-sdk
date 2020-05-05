<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Tests\Payment;

use PHPUnit\Framework\TestCase;
use Rusproj\Uniteller\Exception\FieldIncorrectValueException;
use Rusproj\Uniteller\Payment\PaymentBuilder;
use Rusproj\Uniteller\Enum\CurrencyTypes;

/**
 * PaymentBuilder test case.
 */
class PaymentBuilderTest extends TestCase
{

    /**
     * @return \Rusproj\Uniteller\FiscalCheck\AdditionalProductInfo
     */
    public static function getPaymentBuilderTestInstance()
    {
        $_paymentBuilder = new PaymentBuilder();
        $_paymentBuilder
            ->setCurrency(CurrencyTypes::RUB)
            ->setOrderIdp('12345')
            ->setShopIdp('012345-67890')
            ->setSubtotalP('100.30')
            ->setUrlReturnOk('http://mysite.com/success')
            ->setUrlReturnNo('http://mysite.com/error');
        return $_paymentBuilder;
    }

    public function testWrongValInOrderIdpSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new PaymentBuilder();
        $_builder->setOrderIdp(self::generateFieldVal(130));
    }

    public function testWrongValInEmailSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new PaymentBuilder();
        $_builder->setEmail(self::generateFieldVal(65));
    }

    public function testWrongValInOrderLifetimeSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new PaymentBuilder();
        $_builder->setOrderLifetime(-3);
    }

    public function testWrongValInCustomerIdpSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new PaymentBuilder();
        $_builder->setCustomerIdp(self::generateFieldVal(65));
    }

    public function testWrongValCardIdpInSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new PaymentBuilder();
        $_builder->setCardIdp(self::generateFieldVal(65));
    }

    public function testWrongValInBillLifetimeSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new PaymentBuilder();
        $_builder->setBillLifetime(2000);
    }

    public function testWrongValInLanguageSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new PaymentBuilder();
        $_builder->setLanguage('ABC');
    }

    public function testWrongValInCommentSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new PaymentBuilder();
        $_builder->setComment(self::generateFieldVal(1025));
    }

    public function testWrongValInFirstNameSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new PaymentBuilder();
        $_builder->setFirstName(self::generateFieldVal(65));
    }

    public function testWrongValInLastNameSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new PaymentBuilder();
        $_builder->setLastName(self::generateFieldVal(65));
    }

    public function testWrongValInMiddleSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new PaymentBuilder();
        $_builder->setMiddleName(self::generateFieldVal(65));
    }

    public function testWrongValInPhoneSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new PaymentBuilder();
        $_builder->setPhone(self::generateFieldVal(65));
    }

    public function testWrongValInPhoneVerifiedSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new PaymentBuilder();
        $_builder->setPhoneVerified(self::generateFieldVal(65));
    }

    public function testWrongValInAddressSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new PaymentBuilder();
        $_builder->setAddress(self::generateFieldVal(129));
    }

    public function testWrongValInCountrySetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new PaymentBuilder();
        $_builder->setCountry(self::generateFieldVal(65));
    }

    public function testWrongValInStateSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new PaymentBuilder();
        $_builder->setState('IVAA');
    }

    public function testWrongValInCitySetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new PaymentBuilder();
        $_builder->setCity(self::generateFieldVal(65));
    }

    public function testWrongValInZipSetter()
    {
        $this->expectException(FieldIncorrectValueException::class);
        $_builder = new PaymentBuilder();
        $_builder->setZip(self::generateFieldVal(65));
    }

    public function testPaymentBuilder()
    {
        $_paymentBuilder = new PaymentBuilder();
        $_paymentBuilder
            ->setCurrency(CurrencyTypes::RUB)
            ->setOrderIdp('12345')
            ->setShopIdp('012345-67890')
            ->setSubtotalP('100.30')
            ->setUrlReturnOk('http://mysite.com/success')
            ->setUrlReturnNo('http://mysite.com/error');

        $_arraybleResult = $_paymentBuilder->toArray();

        $this->assertTrue(is_array($_arraybleResult));
        $this->assertTrue(count($_arraybleResult) === 8);

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
    }

    public static function generateFieldVal($length)
    {
        $_result = '';
        for ($_i = 0; $_i < $length; $_i++) {
            $_result .= mb_chr(rand(1, 255));
        }
        return $_result;
    }

}
