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
 * Интерфейс для формирования ссылки перехода на страницу оплаты.
 */
interface UriInterface
{
    /**
     * Возвращает строку с ссылкой на страницу оплаты.
     * @return string
     */
    public function getUri();

    /**
     * Осуществляет переход на страницу оплаты.
     * @return void
     */
    public function go();
}