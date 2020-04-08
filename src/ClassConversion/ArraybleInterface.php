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

namespace Tmconsulting\Uniteller\ClassConversion;

/**
 * Интерфейс преобразования экземпляров классов в {@see array}.
 *
 * @package Tmconsulting\Uniteller\ClassConversion
 */
interface ArraybleInterface
{

    /**
     * Преобразует экземпляр текущего класса в {@see array}, включая все свойства (в т.ч. приватные).
     *
     * @return array
     */
    public function toArray();

}