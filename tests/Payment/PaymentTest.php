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

use Rusproj\Uniteller\Payment\Payment;
use Rusproj\Uniteller\Payment\UriInterface;
use Rusproj\Uniteller\Tests\TestCase;
use Rusproj\Uniteller\Client;

class PaymentTest extends TestCase
{

    public function testCanPaymentRequestReceiveUri()
    {
        $_client = new Client();
        $_client->setBaseUri('https://google.com');

        $payment = new Payment();
        $results = $payment->execute(['q' => 'banana'], $_client);

        $this->assertInstanceOf(UriInterface::class, $results);
        $this->assertEquals('https://google.com/pay?q=banana', $results->getUri());
    }

}