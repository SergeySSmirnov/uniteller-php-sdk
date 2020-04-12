<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Payment;

use Rusproj\Uniteller\Http\Uri;
use Rusproj\Uniteller\Http\LinkCreatorInterface;

/**
 * Механизм генерации ссылки для перехода к странице оплаты с фискализацией API v. 2.
 *
 * @package Rusproj\Client\Payment
 */
class PaymentLinkCreatorWithFiscalization implements LinkCreatorInterface
{

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Http\LinkCreatorInterface::execute()
     */
    public function create($baseGatewayUri, $parameters)
    {
        $uri = sprintf('%s/v2/pay?%s', $baseGatewayUri, http_build_query($parameters));

        return new Uri($uri);
    }

}
