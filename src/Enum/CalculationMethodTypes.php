<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Tmconsulting\Uniteller\Enum;

/**
 * Виды способов расчёта.
 *
 * @package Tmconsulting\Uniteller\Enum
 */
class CalculationMethodTypes
{

    /**
     * Полная предварительная оплата до момента передачи предмета расчёта.
     *
     * @var integer
     */
    const CALC_METHOD_1 = 1;

    /**
     * Частичная предварительная оплата до момента передачи предмета расчёта.
     *
     * @var integer
     */
    const CALC_METHOD_2 = 2;

    /**
     * Аванс.
     *
     * @var integer
     */
    const CALC_METHOD_3 = 3;

    /**
     * Полная оплата, в том числе с учётом аванса (предварительной оплаты) в момент передачи предмета расчёта.
     *
     * @var integer
     */
    const CALC_METHOD_4 = 4;

    /**
     * Частичная оплата предмета расчёта в момент его передачи с по-следующей оплатой в кредит.
     *
     * @var integer
     */
    const CALC_METHOD_5 = 5;

    /**
     * Передача предмета расчёта без его оплаты в момент его передачи с последующей оплатой в кредит.
     *
     * @var integer
     */
    const CALC_METHOD_6 = 6;

    /**
     * Оплата предмета расчёта после его передачи с оплатой в кредит (оплата кредита).
     *
     * @var integer
     */
    const CALC_METHOD_7 = 7;

}

