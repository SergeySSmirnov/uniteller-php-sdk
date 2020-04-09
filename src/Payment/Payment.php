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
class Payment implements PaymentInterface
{

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Payment\PaymentInterface::execute()
     */
    public function execute($baseGatewayUri, $parameters)
    {
        $uri = sprintf('%s/pay?%s', $baseGatewayUri, http_build_query($parameters));

        return new Uri($uri);
    }

}