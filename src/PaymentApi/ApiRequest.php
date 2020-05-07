<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\PaymentApi;

use Rusproj\Uniteller\Request\RequestInterface;

/**
 * Механизм формирования запроса к API-оплате.
 */
class ApiRequest implements RequestInterface
{

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Request\RequestInterface::execute()
     */
    public function execute($httpManager, $uri, array $parameters = [])
    {
        $_response = $httpManager->request($uri, 'POST', http_build_query($parameters));

        return new \SimpleXMLElement($_response);
    }

}

