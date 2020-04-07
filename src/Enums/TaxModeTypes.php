<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Tmconsulting\Uniteller\Enums;

/**
 * Виды систем налогообложения.
 *
 * @package Tmconsulting\Uniteller\Enums
 */
class TaxModeTypes
{

    /**
     * Общая система налогообложения.
     *
     * @var integer
     */
    const TAX_0 = 0;

    /**
     * Упрощённая система налогообложения (Доход).
     *
     * @var integer
     */
    const TAX_1 = 1;

    /**
     * Упрощённая СН (Доход минус Расход).
     *
     * @var integer
     */
    const TAX_2 = 2;

    /**
     * Единый налог на вмененный доход.
     *
     * @var integer
     */
    const TAX_3 = 3;

    /**
     * Единый сельскохозяйственный налог.
     *
     * @var integer
     */
    const TAX_4 = 4;

    /**
     * Патентная система налогообложения.
     *
     * @var integer
     */
    const TAX_5 = 5;

}
