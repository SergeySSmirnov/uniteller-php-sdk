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

namespace Rusproj\Uniteller\Exception;

use Http\Client\Exception\HttpException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Исключение, выбрасываемое при взаимодействии с Uniteller.
 */
class UnitellerException extends HttpException
{
    /**
     * Код ошибки.
     *
     * @var string
     */
    private $errorCode;

    /**
     * Сообщение об ошибке.
     *
     * @var string
     */
    private $errorMessage;

    /**
     * Код ошибки.
     *
     * @return string
     */
    public function getErrorCode() {
        return $this->errorCode;
    }

    /**
     * Сообщение об ошибке.
     *
     * @return string
     */
    public function getErrorMessage() {
        return $this->errorMessage;
    }

    /**
     * Код ошибки.
     *
     * @param string $errorCode
     * @return void
     */
    public function setErrorCode($errorCode) {
        $this->errorCode = $errorCode;
    }

    /**
     * Сообщение об ошибке.
     *
     * @param string $errorMessage
     * @return void
     */
    public function setErrorMessage($errorMessage) {
        $this->errorMessage = $errorMessage;
    }

    /**
     * Инициализирует экземпляр класса {@see Rusproj\Uniteller\Exception\UnitellerException}.
     *
     * @param \Psr\Http\Message\RequestInterface $request Запрос.
     * @param \Psr\Http\Message\ResponseInterface $response Ответ.
     * @param \Exception $previous Предыдущее исключение.
     * @param string $code Код ошибки.
     * @param string $message Сообщение ошибки.
     * @return \Rusproj\Uniteller\Exception\UnitellerException
     */
    public static function create(
        RequestInterface $request,
        ResponseInterface $response,
        \Exception $previous = null,
        $code = '',
        $message = ''
    ) {
        if (!empty($code) || !empty($message)) {
            $message = sprintf('[code] %s [message] %s ', $code, $message);
        }
        $message = sprintf(
            '%s[url] %s [http method] %s [body] %s [status code] %s [reason phrase] %s',
            $message,
            $request->getRequestTarget(),
            $request->getMethod(),
            $request->getBody(),
            $response->getStatusCode(),
            $response->getReasonPhrase()
        );

        $_instance = new static($message, $request, $response, $previous);
        $_instance->setErrorCode($code);
        $_instance->setErrorMessage($message);

        return $_instance;
    }

}
