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
interface PaymentLinkCreatorInterface
{
    /**
     * Генерирует и возвращает ссылку для перехода к странице оплаты.
     *
     * @param string $baseGatewayUri Базовый Uri платёжного шлюза.
     * @param array $parameters Параметры для генерации ссылки.
     * @return \Rusproj\Uniteller\Http\UriInterface
     */
    public function create($baseGatewayUri, $parameters);
}