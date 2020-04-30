<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Payment;

use Rusproj\Uniteller\Http\LinkCreatorAbstract;

/**
 * Механизм генерации ссылки для перехода к странице преавторизации оплаты.
 */
class PreauthPaymentLinkCreator extends LinkCreatorAbstract
{

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Http\LinkCreatorAbstract::getPath()
     */
    protected function getPath() {
        return 'v1/preauth';
    }

}
