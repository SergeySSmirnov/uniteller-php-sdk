<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Tests\Payment;

use Rusproj\Uniteller\Payment\PaymentLinkCreatorWithFiscalization;
use Rusproj\Uniteller\Payment\PreauthPaymentLinkCreator;
use Rusproj\Uniteller\Tests\BaseLinkCreatorTest;

class LinkCreatorTest extends BaseLinkCreatorTest
{

    public function testPaymentLinkCreatorWithFiscalization()
    {
        $this->doTestBaseBananaLink(new PaymentLinkCreatorWithFiscalization(), 'https://google.com/v2/pay?q=banana');
    }

    public function testPreauthPaymentLinkCreator()
    {
        $this->doTestBaseBananaLink(new PreauthPaymentLinkCreator(), 'https://google.com/v1/preauth?q=banana');
    }

}
