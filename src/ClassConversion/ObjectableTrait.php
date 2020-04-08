<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Tmconsulting\Uniteller\ClassConversion;

/**
 * Базовая реализация метода toObject.
 */
trait ObjectableTrait
{

    /**
     * Преобразует экземпляр класса в {@see array}, включая все свойства (в т.ч. приватные).
     *
     * @return array
     */
    public function toObject()
    {
        $_result = [];
        foreach ($this as $_key => $_val)
        {
            $_result[$_key] = $_val;
        }
        return (object)$_result;
    }

}

