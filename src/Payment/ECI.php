<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Tmconsulting\Uniteller\Payment;

/**
 * Информация о 3DS.
 *
 * @package Tmconsulting\Client\Payment
 */
class ECI
{
    /**
     * 3DS Full.
     * @var integer
     */
    const FULL = 5;

    /**
     * 3DS-Acquirer only.
     * @var integer
     */
    const ACQUIRER_ONLY = 6;

    /**
     * E-commerce без 3DS.
     * @var integer
     */
    const E_COMMERCE = 7;
}

