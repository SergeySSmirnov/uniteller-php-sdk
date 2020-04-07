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
 * Платёжная система кредитной карты.
 *
 * @package Tmconsulting\Client\Payment
 */
final class MeanType
{
    /**
     * Любая.
     * @var integer
     */
    const ANY = 0;

    /**
     * VISA.
     * @var integer
     */
    const VISA = 1;

    /**
     * MasterCard.
     * @var integer
     */
    const MASTERCARD = 2;

    /**
     * Diners Club.
     * @var integer
     */
    const DINERS_CLUB = 3;

    /**
     * JCB.
     * @var integer
     */
    const JCB = 4;

    /**
     * American Express.
     * @var integer
     */
    const AMERICAN_EXPRESS = 5;
}
