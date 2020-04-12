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
use Rusproj\Uniteller\Exception\ExceptionFactory;
use Rusproj\Uniteller\Exception\UnitellerException;
use function Rusproj\Uniteller\csv_to_array;

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
     * Возвращает массив заголовков по-умолчанию в зависимости от требуемого формата.
     *
     * @param string $format Формат запроса
     * @return array
     */
    protected function getDefaultHeaders($format)
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        switch ($format) {
            case 'xml':
                $headers['Accept'] = 'application/xml';
                break;
            case 'csv':
                $headers['Accept'] = 'text/csv';
                break;
            case 'json':
                $headers['Accept'] = 'application/json';
                break;
        }

        return $headers;
    }

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Http\HttpManagerInterface::request()
     */
    public function request($uri, $method = 'POST', $data = null, array $headers = [], $format='xml')
    {
        $_request = new Request($method, $uri->getUri(), array_merge($this->getDefaultHeaders($format), $headers), $data);

        try {
            $_response = $this->httpClient->sendRequest($_request);
        }
        catch (RequestException $e) {
            throw UnitellerException::create($_request, $e->getResponse());
        }

        $this->basicError($_request, $_response);
        $body = $_response->getBody()->getContents();
        $this->providerError($body, $_request, $_response, $format);

        return $body;
    }

    /**
     * @param $body
     * @param $request
     * @param $response
     * @throws \ErrorException
     */
    protected function providerError($body, RequestInterface $request, ResponseInterface $response, $format='xml')
    {
        if ($format === 'csv') {
            $data = csv_to_array($body, true);

            if (isset($data['ErrorMessage'])) {
                throw ExceptionFactory::createFromMessage(
                    $data['ErrorMessage'], $request, $response
                );
            }

        }
        elseif ($format === 'xml') {

            if (substr($body, 0, 6) === 'ERROR:') {
                throw ExceptionFactory::createFromMessage(
                    substr($body, 7), $request, $response
                );
            }

            $xml = new \SimpleXMLElement((string)$body);
            if (($firstCode = (string)$xml->attributes()['firstcode']) == 0) {
                return;
            }

            $secondCode = (string)$xml->attributes()['secondcode'];

            throw ExceptionFactory::create(
                $firstCode, $secondCode, $request, $response
            );

        }
    }

    /**
     * Проверяет успешность запроса и в случае ошибки генерирует исключение.
     *
     * @param \Psr\Http\Message\RequestInterface $request Объект запроса.
     * @param \Psr\Http\Message\ResponseInterface $response Объект ответа.
     * @throws \Rusproj\Uniteller\Exception\UnitellerException Генерируется в случае ошибки выполнения запроса.
     */
    protected function basicError(RequestInterface $request, ResponseInterface $response)
    {
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            return;
        }

        throw UnitellerException::create($request, $response);
    }

}
