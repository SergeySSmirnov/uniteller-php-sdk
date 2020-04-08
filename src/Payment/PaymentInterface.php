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
 * Интерфейс генерации ссылки для перехода к странице оплаты.
 */
interface PaymentInterface
{
    /**
     * Генерирует и возвращает ссылку для перехода к странице оплаты.
     *
     * @param array $parameters Параметры для генерации ссылки.
     * @param \Rusproj\Uniteller\ClientGatewayConfigInterface $gatewayConfig Настройки доступа к платёжному шлюзу.
     * @return \Rusproj\Uniteller\Payment\UriInterface
     */
    public function execute($parameters, $gatewayConfig);
}