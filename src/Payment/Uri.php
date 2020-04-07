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

namespace Tmconsulting\Uniteller\Payment;

/**
 * Uri для перехода на страницу оплаты.
 *
 * @package Tmconsulting\Client\Payment
 */
final class Uri implements UriInterface
{
    /**
     * Uri на страницу оплаты.
     * @var string
     */
    private $uri;

    /**
     * Инициализирует новый экземпляр класса @see \Tmconsulting\Uniteller\Payment\Uri.
     *
     * @param $uri
     */
    public function __construct($uri)
    {
        $this->uri = $uri;
    }

    /**
     * Возвращает строку с ссылкой на страницу оплаты.
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Устанавливает заголовок ответа "Location" в значение @see \Tmconsulting\Uniteller\Payment\Uri::getUri().
     * @return void
     */
    public function go()
    {
        header(sprintf('Location: %s', $this->uri));
    }
}
