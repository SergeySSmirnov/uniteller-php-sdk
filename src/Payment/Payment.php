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

namespace Tmconsulting\Uniteller\Payment;

/**
 * Механизм генерации ссылки для перехода к странице оплаты.
 *
 * @package Tmconsulting\Client\Payment
 */
class Payment implements PaymentInterface
{
    /**
     * Генерирует и возвращает ссылку для перехода к странице оплаты.
     * @param array $parameters Параметры для генерации ссылки.
     * @param \Tmconsulting\Uniteller\ClientGatewayConfigInterface $gatewayConfig Настройки доступа к платёжному шлюзу.
     * @return \Tmconsulting\Uniteller\Payment\UriInterface
     */
    public function execute($parameters, $gatewayConfig)
    {
        $uri = sprintf('%s/pay?%s', $gatewayConfig->getBaseUri(), http_build_query($parameters));

        return new Uri($uri);
    }
}