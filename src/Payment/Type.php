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
 * Тип оплаты.
 *
 * @package Tmconsulting\Client\Payment
 */
final class Type
{
    /**
     * Оплата кредитной картой.
     * @var integer
     */
    const CREDIT_CARD = 1;

    /**
     * Оплата с помощью электронной валюты.
     * @var integer
     */
    const EMONEY = 3;
}