<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller;

/**
 * Интерфейс для получения настроек доступа к платёжному шлюзу.
 *
 * @package Rusproj\Uniteller
 */
interface ClientGatewayConfigInterface
{
    /**
     * Возвращает Uri платёжного шлюза.
     * @return string
     */
    public function getBaseUri();
}