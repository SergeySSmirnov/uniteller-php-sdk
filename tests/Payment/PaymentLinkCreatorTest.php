<?php
/**
 * Created by Roquie.
 * E-mail: roquie0@gmail.com
 * GitHub: Roquie
 * Date: 17/05/2017
 *
 * Modified by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Tests\Payment;

use Rusproj\Uniteller\Payment\PaymentLinkCreator;
use Rusproj\Uniteller\Payment\UriInterface;
use Rusproj\Uniteller\Tests\TestCase;
use Rusproj\Uniteller\Client;
use Rusproj\Uniteller\Payment\PaymentLinkCreatorWithFiscalization_V1;
use Rusproj\Uniteller\Payment\PaymentLinkCreatorWithFiscalization_V2;
use Rusproj\Uniteller\Payment\PreauthPaymentLinkCreator;

class PaymentLinkCreatorTest extends TestCase
{

    public function testCreateUriPayment()
    {
        $_client = new Client();
        $_client->setBaseUri('https://google.com');

        $_payment = new PaymentLinkCreator();
        $_results = $_payment->create($_client->getBaseUri(), ['q' => 'banana']);

        $this->assertInstanceOf(UriInterface::class, $_results);
        $this->assertEquals('https://google.com/pay?q=banana', $_results->getUri());
    }

    public function testCreateUriPaymentWithFiscalizationV1()
    {
        $_client = new Client();
        $_client->setBaseUri('https://google.com');

        $_payment = new PaymentLinkCreatorWithFiscalization_V1();
        $_results = $_payment->create($_client->getBaseUri(), ['q' => 'banana']);

        $this->assertInstanceOf(UriInterface::class, $_results);
        $this->assertEquals('https://google.com/v1/pay?q=banana', $_results->getUri());
    }

    public function testCreateUriPaymentWithFiscalizationV2()
    {
        $_client = new Client();
        $_client->setBaseUri('https://google.com');

        $_payment = new PaymentLinkCreatorWithFiscalization_V2();
        $_results = $_payment->create($_client->getBaseUri(), ['q' => 'banana']);

        $this->assertInstanceOf(UriInterface::class, $_results);
        $this->assertEquals('https://google.com/v2/pay?q=banana', $_results->getUri());
    }

    public function testCreateUriPreauthPayment()
    {
        $_client = new Client();
        $_client->setBaseUri('https://google.com');

        $_payment = new PreauthPaymentLinkCreator();
        $_results = $_payment->create($_client->getBaseUri(), ['q' => 'banana']);

        $this->assertInstanceOf(UriInterface::class, $_results);
        $this->assertEquals('https://google.com/v1/preauth?q=banana', $_results->getUri());
    }
}