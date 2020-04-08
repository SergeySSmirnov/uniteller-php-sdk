<?php
/**
 * Created by Roquie.
 * E-mail: roquie0@gmail.com
 * GitHub: Roquie
 */

namespace Rusproj\Uniteller\Exception;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Rusproj\Uniteller\Error\Error;

class AuthConfirmIsNotAllowedException extends ErrorException
{
    /**
     * @param string            $message
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param \Exception|null   $previous
     */
    public function __construct(
        $message,
        RequestInterface $request,
        ResponseInterface $response,
        \Exception $previous = null
    ) {
        parent::__construct($message, $request, $response, $previous);

        $this->errorCode = Error::AUTH_CONFIRM_IS_NOT_ALLOWED;
    }
}