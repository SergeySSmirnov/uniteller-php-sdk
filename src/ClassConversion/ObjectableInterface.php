<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Tmconsulting\Uniteller\ClassConversion;

/**
 * Интерфейс преобразования экземпляров классов в {@see \stdClass}.
 *
 * @package Tmconsulting\Uniteller\ClassConversion
 */
interface ObjectableInterface
{

    /**
     * Преобразует экземпляр текущего класса в {@see \stdClass}, включая все свойства (в т.ч. приватные).
     *
     * @return object
     */
    public function toObject();

}