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
 * Механизм генерации ссылки для перехода к странице преавторизации оплаты.
 *
 * @package Rusproj\Client\Payment
 */
class PreauthPaymentLinkCreator implements LinkCreatorInterface
{

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Http\LinkCreatorInterface.php::execute()
     */
    public function create($baseGatewayUri, $parameters)
    {
        $uri = sprintf('%s/v1/preauth?%s', $baseGatewayUri, http_build_query($parameters));

        return new Uri($uri);
    }

}
