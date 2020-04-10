<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Payment;

/**
 * @deprecated Используйте {@see PaymentLinkCreatorWithFiscalization_V2}.
 *
 * Механизм генерации ссылки для перехода к странице оплаты с фискализацией API v. 1.
 *
 * @package Tmconsulting\Client\Payment
 */
class PaymentLinkCreatorWithFiscalization_V1 implements PaymentLinkCreatorInterface
{

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Payment\PaymentLinkCreatorInterface::execute()
     */
    public function create($baseGatewayUri, $parameters)
    {
        $uri = sprintf('%s/v1/pay?%s', $baseGatewayUri, http_build_query($parameters));

        return new Uri($uri);
    }

}
