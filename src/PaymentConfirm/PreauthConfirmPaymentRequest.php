<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\PaymentConfirm;

use Rusproj\Uniteller\Request\RequestInterface;

/**
 * Механизм формирования запроса подтверждения платежа с преавторизацией.
 */
class PreauthConfirmPaymentRequest implements RequestInterface
{

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Request\RequestInterface::execute()
     */
    public function execute($httpManager, $uri, array $parameters = [])
    {
        $_response = $httpManager->request($uri, 'POST', http_build_query($parameters));

        $_xml = new \SimpleXMLElement($_response);

        return json_decode(base64_decode((string)$_xml->Receipt));
    }

}

