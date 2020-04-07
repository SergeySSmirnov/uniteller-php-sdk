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
 * Тип электронной валюты.
 *
 * @package Tmconsulting\Client\Payment
 */
final class EMoneyType
{
    /**
     * Любая система электронных платежей.
     * @var integer
     */
    const ANY = 0;

    /**
     * Яндекс.Деньги.
     * @var integer
     */
    const YANDEX_MONEY = 1;

    /**
     * Оплата наличными (Евросеть, Яндекс.Деньги и пр.).
     * @var integer
     */
    const CASH = 13;

    /**
     * QIWI Кошелек REST (по протоколу REST).
     * @var integer
     */
    const QIWI_REST = 18;

    /**
     * MOBI.Деньги.
     * @var integer
     */
    const MOBI_MONEY = 19;

    /**
     * WebMoney WMR.
     * @var integer
     */
    const WEBMONEY_WMR = 29;
}
