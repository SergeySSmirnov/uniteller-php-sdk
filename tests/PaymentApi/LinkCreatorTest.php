<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Tests\PaymentApi;

use Rusproj\Uniteller\PaymentApi\ApiCheckLinkCreator;
use Rusproj\Uniteller\PaymentApi\ApiPayLinkCreator;
use Rusproj\Uniteller\Tests\BaseLinkCreatorTest;

class PaymentLinkCreatorTest extends BaseLinkCreatorTest
{

    public function testPaymentApiCheckLinkCreator()
    {
        $this->doTestBaseBananaLink(new ApiCheckLinkCreator(), 'https://google.com/v2/api/iacheck?q=banana');
    }

    public function testPaymentApiPayLinkCreator()
    {
        $this->doTestBaseBananaLink(new ApiPayLinkCreator(), 'https://google.com/v2/api/iapay?q=banana');
    }

}
