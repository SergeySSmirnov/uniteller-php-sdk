<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Tests\FiscalCheck;

use PHPUnit\Framework\TestCase;
use Rusproj\Uniteller\FiscalCheck\Payment;
use Rusproj\Uniteller\Enum\PaymentInstrumentTypes;
use Rusproj\Uniteller\Enum\MeansPaymentTypes;

/**
 * AdditionalProductInfo test case.
 */
class PaymentTest extends TestCase
{

    /**
     * @return \Rusproj\Uniteller\FiscalCheck\Payment
     */
    public static function createPaymentTestInstance()
    {
        $_paymentInfo = new Payment();
        $_paymentInfo
            ->setAmount('152.65')
            ->setKind(PaymentInstrumentTypes::BANK_CARD)
            ->setType(MeansPaymentTypes::AMPT_4)
            ->setId('0035464');
        return $_paymentInfo;
    }

    public function testAdditionalProductInfoObjectable()
    {
        $_paymentInfo = new Payment();
        $_paymentInfo
            ->setAmount('152.65')
            ->setKind(PaymentInstrumentTypes::BANK_CARD)
            ->setType(MeansPaymentTypes::AMPT_4);

        $_objectableResult = $_paymentInfo->toObject();
        $this->assertTrue($_objectableResult instanceof \stdClass);
        $this->assertTrue(count((array)$_objectableResult) === 3);

        $this->assertObjectHasAttribute('amount', $_objectableResult);
        $this->assertTrue($_objectableResult->amount === '152.65');
        $this->assertObjectHasAttribute('kind', $_objectableResult);
        $this->assertTrue($_objectableResult->kind === PaymentInstrumentTypes::BANK_CARD);
        $this->assertObjectHasAttribute('type', $_objectableResult);
        $this->assertTrue($_objectableResult->type === MeansPaymentTypes::AMPT_4);

        $_paymentInfo
            ->setId('0035464');

        $_objectableResult = $_paymentInfo->toObject();
        $this->assertTrue($_objectableResult instanceof \stdClass);
        $this->assertTrue(count((array)$_objectableResult) === 4);

        $this->assertObjectHasAttribute('amount', $_objectableResult);
        $this->assertTrue($_objectableResult->amount === '152.65');
        $this->assertObjectHasAttribute('kind', $_objectableResult);
        $this->assertTrue($_objectableResult->kind === PaymentInstrumentTypes::BANK_CARD);
        $this->assertObjectHasAttribute('type', $_objectableResult);
        $this->assertTrue($_objectableResult->type === MeansPaymentTypes::AMPT_4);
        $this->assertObjectHasAttribute('id', $_objectableResult);
        $this->assertTrue($_objectableResult->id === '0035464');
    }

}
