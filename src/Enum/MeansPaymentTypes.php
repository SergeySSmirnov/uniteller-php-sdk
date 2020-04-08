<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Enum;

/**
 * Виды дополнительных платёжных средств.
 *
 * @package Rusproj\Uniteller\Enum
 */
final class MeansPaymentTypes
{

    /**
     * Подарочные карты Мерчанта.
     *
     * @var integer
     */
    const AMPT_1 = 1;

    /**
     * Бонусы-авансы Мерчанта.
     *
     * @var integer
     */
    const AMPT_2 = 2;

    /**
     * Прямой аванс Мерчанта.
     *
     * @var integer
     */
    const AMPT_3 = 3;

    /**
     * Использование авансов/билетов.
     *
     * @var integer
     */
    const AMPT_4 = 4;

    /**
     * Платеж через кредитную организацию (банкомат).
     *
     * @var integer
     */
    const AMPT_5 = 5;

    /**
     * Платеж через кредитную организацию (online).
     *
     * @var integer
     */
    const AMPT_6 = 6;

    /**
     * Безналичное перечисление через банк.
     *
     * @var integer
     */
    const AMPT_7 = 7;

    /**
     * Оплата «онлайн кредитом».
     *
     * @var integer
     */
    const AMPT_8 = 8;

    /**
     * Оплата по СМС.
     *
     * @var integer
     */
    const AMPT_9 = 9;

    /**
     * Эквайринг внешний.
     *
     * @var integer
     */
    const AMPT_10 = 10;

    /**
     * Платеж через терминал электронными.
     *
     * @var integer
     */
    const AMPT_11 = 11;

    /**
     * Платеж через терминал наличными.
     *
     * @var integer
     */
    const AMPT_12 = 12;

    /**
     * Наличные.
     *
     * @var integer
     */
    const AMPT_13 = 13;

    /**
     * Продажа в кредит.
     *
     * @var integer
     */
    const AMPT_14 = 14;

}
