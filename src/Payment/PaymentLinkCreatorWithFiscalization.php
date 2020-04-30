<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Payment;

use Rusproj\Uniteller\Http\LinkCreatorAbstract;

/**
 * Механизм генерации ссылки для перехода к странице оплаты с фискализацией API v. 2.
 */
class PaymentLinkCreatorWithFiscalization extends LinkCreatorAbstract
{

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Http\LinkCreatorAbstract::getPath()
     */
    protected function getPath() {
        return 'v2/pay';
    }

}
