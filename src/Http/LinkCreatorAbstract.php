<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Http;

/**
 * Абстрактный механизм формирования ссылок.
 *
 * @package Rusproj\Uniteller\Http
 */
abstract class LinkCreatorAbstract implements LinkCreatorInterface
{

    /**
     * Возвращает строку, содержащую путь к ресурсу на базовом шлюзе.
     * Например, "api/version/action".
     *
     * @return string
     */
    protected abstract function getPath();

    /**
     * (non-PHPdoc)
     * @see \Rusproj\Uniteller\Http\LinkCreatorInterface::create()
     */
    public function create($baseGatewayUri, $parameters = null)
    {
        if (is_array($parameters)) {
            $uri = sprintf('%s/%s?%s', $baseGatewayUri, $this->getPath(), http_build_query($parameters));
        } elseif (is_string($parameters)) {
            $uri = sprintf('%s/%s?%s', $baseGatewayUri, $this->getPath(), $parameters);
        } else {
            $uri = sprintf('%s/%s', $baseGatewayUri, $this->getPath());
        }

        return new Uri($uri);
    }
}

