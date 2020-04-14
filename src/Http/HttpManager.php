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

namespace Rusproj\Uniteller\Http;

use GuzzleHttp\Psr7\Request;
use Http\Client\Exception\RequestException;
use Http\Client\HttpClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Rusproj\Uniteller\Exception\UnitellerException;

/**
 * Менеджер взаимодействия с шлюзом.
 *
 * @package Rusproj\Client\Http
 */
class HttpManager implements HttpManagerInterface
{
    /**
     * HTTP-клиент для выполнения запросов и обработки результатов.
     *
     * @var \Http\Client\HttpClient
     */
    protected $httpClient;

    /**
     * Опции запроса.
     *
     * @var array
     */
    protected $options;

    /**
     * Инициализирует экземпляр класса {@see HttpManager}.
     *
     * @param \Http\Client\HttpClient $httpClient HTTP-клиент для выполнения запросов и обработки результатов.
     * @param array $options Опции запроса.
     */
    public function __construct(HttpClient $httpClient, array $options = [])
    {
        $this->httpClient = $httpClient;
        $this->options = $options;
    }

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Http\HttpManagerInterface::request()
     * @throw \Rusproj\Uniteller\Exception\UnitellerException
     */
    public function request($uri, $method = 'POST', $data = null, array $headers = [])
    {
        if (!isset($headers['Content-Type'])) {
            $headers['Content-Type'] = 'application/x-www-form-urlencoded';
        }

        $_request = new Request($method, $uri->getUri(), $headers, $data);

        try {
            $_response = $this->httpClient->sendRequest($_request);
        }
        catch (RequestException $e) {
            throw UnitellerException::create($_request, $e->getResponse());
        }

        $this->handleRequestError($_request, $_response);
        $body = $_response->getBody()->getContents();
        $this->handleResponseError($body, $_request, $_response);

        return $body;
    }

    /**
     * Осуществляет проверку ответа на наличие сообщения об ошибке.
     *
     * @param string $body Тело ответа.
     * @param \Psr\Http\Message\RequestInterface $request Запрос.
     * @param \Psr\Http\Message\ResponseInterface $response Ответ.
     * @throws \Rusproj\Uniteller\Exception\UnitellerException Исключение будет сгенерировано в случае наличие информации об ошибке в теле ответа.
     */
    protected function handleResponseError($body, RequestInterface $request, ResponseInterface $response)
    {
        $_xml = new \SimpleXMLElement($body);

        $_code = $_xml->Result;
        $_errorMessage = $_xml->ErrorMessage;

        if ($_code == 0 && empty($_errorMessage)) {
            return;
        }

        throw UnitellerException::create($request, $response, null, $_code, $_errorMessage);
    }

    /**
     * Проверяет успешность запроса и в случае ошибки генерирует исключение.
     *
     * @param \Psr\Http\Message\RequestInterface $request Объект запроса.
     * @param \Psr\Http\Message\ResponseInterface $response Объект ответа.
     * @throws \Rusproj\Uniteller\Exception\UnitellerException Генерируется в случае ошибки выполнения запроса.
     */
    protected function handleRequestError(RequestInterface $request, ResponseInterface $response)
    {
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            return;
        }

        throw UnitellerException::create($request, $response);
    }

}
