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

namespace Tmconsulting\Uniteller;

/**
 * Интерфейс преобразования экземпляров классов в {@see array}.
 *
 * @package Tmconsulting\Client
 */
interface ArraybleInterface
{
    /**
     * Преобразует экземпляр класса в {@see array}, включая все свойства (в т.ч. приватные).
     *
     * @return array
     */
    public function toArray();
}