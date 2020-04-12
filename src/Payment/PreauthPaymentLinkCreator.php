<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Payment;

use Rusproj\Uniteller\Http\Uri;

/**
 * Механизм генерации ссылки для перехода к странице преавторизации оплаты.
 *
 * @package Rusproj\Client\Payment
 */
class PreauthPaymentLinkCreator implements PaymentLinkCreatorInterface
{

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Payment\PaymentLinkCreatorInterface::execute()
     */
    public function create($baseGatewayUri, $parameters)
    {
        $uri = sprintf('%s/v1/preauth?%s', $baseGatewayUri, http_build_query($parameters));

        return new Uri($uri);
    }

}
