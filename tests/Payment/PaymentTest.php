<?php
/**
 * Created by Roquie.
 * E-mail: roquie0@gmail.com
 * GitHub: Roquie
 * Date: 17/05/2017
 */

namespace Rusproj\Uniteller\Tests\Payment;

use Rusproj\Uniteller\Payment\Payment;
use Rusproj\Uniteller\Payment\UriInterface;
use Rusproj\Uniteller\Tests\TestCase;

class PaymentTest extends TestCase
{
    public function testCanPaymentRequestReceiveUri()
    {
        $payment = new Payment();
        $results = $payment->execute(['q' => 'banana'], ['base_uri' => 'https://google.com']);

        $this->assertInstanceOf(UriInterface::class, $results);
        $this->assertEquals('https://google.com/pay?q=banana', $results->getUri());
    }
}