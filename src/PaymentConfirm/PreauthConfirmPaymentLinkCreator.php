<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\PaymentConfirm;

use Rusproj\Uniteller\Http\LinkCreatorAbstract;

/**
 * Механизм генерации ссылки для подтверждения платежа с преавторизацией.
 *
 * @package Rusproj\Client\PaymentConfirm
 */
class PreauthConfirmPaymentLinkCreator extends LinkCreatorAbstract
{

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Http\LinkCreatorAbstract::getPath()
     */
    protected function getPath()
    {
        return 'v2/api/iaconfirm';
    }

}
