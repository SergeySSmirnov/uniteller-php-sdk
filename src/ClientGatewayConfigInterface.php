<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Tmconsulting\Uniteller;

/**
 * Интерфейс для получения настроек доступа к платёжному шлюзу.
 *
 * @package Tmconsulting\Uniteller
 */
interface ClientGatewayConfigInterface
{
    /**
     * Возвращает Uri платёжного шлюза.
     * @return string
     */
    public function getBaseUri();
}