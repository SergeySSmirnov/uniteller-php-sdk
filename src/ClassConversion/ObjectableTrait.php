<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\ClassConversion;

/**
 * Базовая реализация метода toObject.
 */
trait ObjectableTrait
{

    /**
     * Преобразует экземпляр класса в {@see array}, включая все свойства (в т.ч. приватные).
     * Если значение свойства соответствует null, то оно не будет добавлено в результирующий объект.
     *
     * @return array
     */
    public function toObject()
    {
        $_result = [];
        foreach ($this as $_key => $_val)
        {
            if (!is_null($_val)) {
                $_result[$_key] = $_val;
            }
        }
        return (object)$_result;
    }

}

