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

namespace Rusproj\Uniteller\Http;

/**
 * Интерфейс генерации ссылки для страницы выполнения некоторого действия.
 *
 * @package Rusproj\Uniteller\Http
 */
interface LinkCreatorInterface
{
    /**
     * Генерирует и возвращает ссылку.
     *
     * @param string $baseGatewayUri Базовый Uri платёжного шлюза.
     * @param array $parameters Параметры для генерации ссылки.
     * @return \Rusproj\Uniteller\Http\UriInterface
     */
    public function create($baseGatewayUri, $parameters = null);
}