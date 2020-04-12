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
 * Интерфейс для формирования ссылки на ресурс.
 *
 * @package Rusproj\Uniteller\Http
 */
interface UriInterface
{
    /**
     * Возвращает строку с ссылкой.
     * @return string
     */
    public function getUri();

    /**
     * Осуществляет переход на страницу.
     * @return void
     */
    public function go();
}