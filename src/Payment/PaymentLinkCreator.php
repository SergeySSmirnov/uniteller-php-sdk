<?php
/**
 * Created by Roquie.
 * E-mail: roquie0@gmail.com
 * GitHub: Roquie
 *
 * Modified by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Payment;

/**
 * Механизм генерации ссылки для перехода к странице оплаты.
 *
 * @package Tmconsulting\Client\Payment
 */
class PaymentLinkCreator implements PaymentLinkCreatorInterface
{

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Payment\PaymentLinkCreatorInterface::execute()
     */
    public function create($baseGatewayUri, $parameters)
    {
        $uri = sprintf('%s/pay?%s', $baseGatewayUri, http_build_query($parameters));

        return new Uri($uri);
    }

}
