<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Tests\PaymentConfirm;

use Rusproj\Uniteller\PaymentConfirm\PreauthConfirmPaymentLinkCreator;
use Rusproj\Uniteller\Tests\BaseLinkCreatorTest;

class PaymentLinkCreatorTest extends BaseLinkCreatorTest
{

    public function testPaymentApiPayLinkCreator()
    {
        $this->doTestBaseBananaLink(new PreauthConfirmPaymentLinkCreator(), 'https://google.com/v2/api/iaconfirm?q=banana');
    }

}
