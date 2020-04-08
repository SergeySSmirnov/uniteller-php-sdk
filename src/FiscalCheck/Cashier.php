<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\FiscalCheck;

use Rusproj\Uniteller\ClassConversion\ObjectableInterface;
use Rusproj\Uniteller\Exception\FieldIncorrectValueException;

/**
 * Информация о кассире.
 * Этот блок может отсутствовать целиком.
 *
 * @package Rusproj\Uniteller\FiscalCheck
 */
class Cashier implements ObjectableInterface
{

    /*
     * Импорт метода toObject().
     */
    use \Rusproj\Uniteller\ClassConversion\ObjectableTrait;

    /**
     * Ф.И.О. кассира.
     *
     * @var string
     */
    private $name = null;

    /**
     * ИНН кассира.
     *
     * @var string
     */
    private $inn = null;

    /**
     * Ф.И.О. кассира.
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Ф.И.О. кассира.
     *
     * @param string $name
     * @return $this
     * @throws \Rusproj\Uniteller\Exception\FieldIncorrectValueException Исключение генерируется если длина строки параметра больше 240 символов.
     */
    public function setName($name) {
        if (strlen($name) > 240) {
            throw new FieldIncorrectValueException('Длина строки с Ф.И.О. кассира должна быть 0-240 символов включительно.');
        }
        $this->name = $name;
        return $this;
    }

    /**
     * ИНН кассира.
     *
     * @return string
     */
    public function getInn() {
        return $this->inn;
    }

    /**
     * ИНН кассира.
     *
     * @param string $inn
     * @return $this
     * @throws \Rusproj\Uniteller\Exception\FieldIncorrectValueException Исключение генерируется если длина строки параметра не 12 цифр и не пусто.
     */
    public function setInn($inn) {
        if (!empty($inn) && strlen($inn) !== 12) {
            throw new FieldIncorrectValueException('Длина строки с ИНН кассира должна быть 12 символов или пусто.');
        }
        $this->inn = $inn;
        return $this;
    }

}
