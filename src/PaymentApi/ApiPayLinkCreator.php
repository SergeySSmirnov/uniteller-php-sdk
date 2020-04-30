<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\PaymentApi;

use Rusproj\Uniteller\Http\LinkCreatorAbstract;

/**
 * Механизм оплаты через API v. 2.0 (Оплата).
 */
class ApiPayLinkCreator extends LinkCreatorAbstract
{

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Http\LinkCreatorAbstract::getPath()
     */
    protected function getPath() {
        return 'v2/api/iapay';
    }

}
