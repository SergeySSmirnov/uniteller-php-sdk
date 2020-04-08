<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Tmconsulting\Uniteller;

/**
 * Интерфейс преобразования экземпляров классов в {@see \stdClass}.
 *
 * @package Tmconsulting\Client
 */
interface ObjectableInterface
{
    /**
     * Преобразует экземпляр класса в {@see \stdClass}, включая все свойства (в т.ч. приватные).
     *
     * @return object
     */
    public function toObject();
}