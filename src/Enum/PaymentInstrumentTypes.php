<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Enum;

/**
 * Виды платежных средств.
 *
 * @package Rusproj\Uniteller\Enum
 */
final class PaymentInstrumentTypes
{

    /**
     * Оплата банковской картой
     *
     * @var integer
     */
    const BANK_CARD = 1;

    /**
     * Оплата электронной валютой.
     *
     * @var integer
     */
    const E_MONEY = 2;

    /**
     * Оплата с помощью кредитной организации.
     *
     * @var integer
     */
    const CREDIT_INSTITUTE = 3;

    /**
     * Оплата дополнительным платежным средством.
     *
     * @var integer
     */
    const PAYMENT_WITH_ADDITIONAL = 4;

}
