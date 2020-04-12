<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Payment;

use Rusproj\Uniteller\Http\Uri;

/**
 * Механизм генерации ссылки для перехода к странице оплаты с фискализацией API v. 2.
 *
 * @package Rusproj\Client\Payment
 */
class PaymentLinkCreatorWithFiscalization implements PaymentLinkCreatorInterface
{

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Payment\PaymentLinkCreatorInterface::execute()
     */
    public function create($baseGatewayUri, $parameters)
    {
        $uri = sprintf('%s/v2/pay?%s', $baseGatewayUri, http_build_query($parameters));

        return new Uri($uri);
    }

}
