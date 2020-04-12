<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Enum;

/**
 * Виды предметов расчёта.
 *
 * @package Rusproj\Uniteller\Enum
 */
final class CalculationSubjectTypes
{

    /**
     * О реализуемом товаре, за исключением подакцизного товара (наименование и иные сведения, описывающие товар)
     *
     * @var integer
     */
    const CALC_SUBJECT_1 = 1;

    /**
     * О реализуемом подакцизном товаре (наименование и иные сведения, описывающие товар).
     *
     * @var integer
     */
    const CALC_SUBJECT_2 = 2;

    /**
     * Выполняемой работе (наименование и иные сведения, описывающие работу).
     *
     * @var integer
     */
    const CALC_SUBJECT_3 = 3;

    /**
     * Об оказываемой услуге (наименование и иные сведения, описывающие услугу).
     *
     * @var integer
     */
    const CALC_SUBJECT_4 = 4;

    /**
     * О приёме ставок при осуществлении деятельности по проведению азартных игр.
     *
     * @var integer
     */
    const CALC_SUBJECT_5 = 5;

    /**
     * О выплате денежных средств в виде выигрыша при осуществлении деятельности по проведению азартных игр.
     *
     * @var integer
     */
    const CALC_SUBJECT_6 = 6;

    /**
     * О приёме денежных средств при реализации лотерейных билетов, электронных лотерейных билетов,
     * приёме лотерейных ставок при осуществлении деятельности по проведению лотерей.
     *
     * @var integer
     */
    const CALC_SUBJECT_7 = 7;

    /**
     * О выплате денежных средств в виде выигрыша при осуществлении деятельности по проведению лотерей.
     *
     * @var integer
     */
    const CALC_SUBJECT_8 = 8;

    /**
     * О предоставлении прав на использование результатов интеллектуальной деятельности или средств индивидуализации.
     *
     * @var integer
     */
    const CALC_SUBJECT_9 = 9;

    /**
     * Об авансе, задатке, предоплате, кредите, взносе в счёт оплаты, пени, штрафе, вознаграждении, бонусе и ином аналогичном предмете расчёта.
     *
     * @var integer
     */
    const CALC_SUBJECT_10 = 10;

    /**
     * О вознаграждении пользователя, являющегося платёжным агентом (субагентом),
     * банковским платёжным агентом (субагентом), комиссионером, поверенным или иным агентом.
     *
     * @var integer
     */
    const CALC_SUBJECT_11 = 11;

    /**
     * О предмете расчёта, состоящем из предметов, каждому из которых может быть присвоено значение от «1» до «11».
     *
     * @var integer
     */
    const CALC_SUBJECT_12 = 12;

    /**
     * О предмете расчёта, не относящемуся к предметам расчёта, которым может быть присвоено значение от «1» до «12» и от «14» до «18».
     *
     * @var integer
     */
    const CALC_SUBJECT_13 = 13;

    /**
     * О передаче имущественных прав.
     *
     * @var integer
     */
    const CALC_SUBJECT_14 = 14;

    /**
     * О внереализационном доходе.
     *
     * @var integer
     */
    const CALC_SUBJECT_15 = 15;

    /**
     * О суммах расходов, уменьшающих сумму налога (авансовых платежей) в соответствии с
     * пунктом 3.1 статьи 346.21 Налогового кодекса Российской Федерации.
     *
     * @var integer
     */
    const CALC_SUBJECT_16 = 16;

    /**
     * О суммах уплаченного торгового сбора.
     *
     * @var integer
     */
    const CALC_SUBJECT_17 = 17;

    /**
     * О курортном сборе.
     *
     * @var integer
     */
    const CALC_SUBJECT_18 = 18;

    /**
     * О залоге.
     *
     * @var integer
     */
    const CALC_SUBJECT_19 = 19;

}