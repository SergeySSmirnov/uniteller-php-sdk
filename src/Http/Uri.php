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
 * Uri для перехода на страницу оплаты.
 *
 * @package Rusproj\Uniteller\Http
 */
final class Uri implements UriInterface
{
    /**
     * Uri.
     * @var string
     */
    private $uri;

    /**
     * Инициализирует новый экземпляр класса {@see \Rusproj\Uniteller\Http\Uri}.
     *
     * @param $uri
     */
    public function __construct($uri)
    {
        $this->uri = $uri;
    }

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Http\UriInterface::getUri()
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Http\UriInterface::go()
     */
    public function go()
    {
        header(sprintf('Location: %s', $this->uri));
    }
}
