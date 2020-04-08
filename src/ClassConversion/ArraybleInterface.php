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

namespace Rusproj\Uniteller\ClassConversion;

/**
 * Интерфейс преобразования экземпляров классов в {@see array}.
 *
 * @package Rusproj\Uniteller\ClassConversion
 */
interface ArraybleInterface
{

    /**
     * Преобразует экземпляр текущего класса в {@see array}, включая все свойства (в т.ч. приватные).
     * Если значение свойства соответствует null, то оно не будет добавлено в результирующий массив.
     *
     * @return array
     */
    public function toArray();

}