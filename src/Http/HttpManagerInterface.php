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

/**
 * Интерфейс выполнения запросов к шлюзу.
 *
 * @package Rusproj\Uniteller\Http
 */
interface HttpManagerInterface
{
    /**
     * Выполняет запрос к шлюзу.
     *
     * @param \Rusproj\Uniteller\Http\UriInterface $uri Uri-объект.
     * @param string $method Метод запроса.
     * @param string|null $data Данные запроса.
     * @param array $headers Заголовка запроса
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function request($uri, $method = 'POST', $data = null, array $headers = []);
}