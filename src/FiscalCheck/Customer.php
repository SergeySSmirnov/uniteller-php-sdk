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
 * Контакты плательщика для отправки текста фискального чека.
 * Этот блок может отсутствовать целиком, или в нем могут отсутствовать какие-то элементы.
 *
 * @package Rusproj\Uniteller\FiscalCheck
 */
class Customer implements ObjectableInterface
{

    /*
     * Импорт метода toObject().
     */
    use \Rusproj\Uniteller\ClassConversion\ObjectableTrait;

    /**
     * Номер телефона плательщика.
     *
     * @var string
     */
    private $phone = '';

    /**
     * Адрес электронной почты плательщика.
     *
     * @var string
     */
    private $email = '';

    /**
     * Идентификатор плательщика, присвоенный мерчантом.
     *
     * @var string
     */
    private $id = '';

    /**
     * [* Опционально]
     * Название покупателя.
     *
     * @var null|string
     */
    private $name = null;

    /**
     * [* Опционально]
     * ИНН покупателя.
     *
     * @var null|string
     */
    private $inn = null;


    /**
     * Номер телефона плательщика.
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Номер телефона плательщика.
     *
     * @param string $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Адрес электронной почты плательщика.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Адрес электронной почты плательщика.
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Идентификатор плательщика, присвоенный мерчантом.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Идентификатор плательщика, присвоенный мерчантом.
     *
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * [* Опционально]
     * Название покупателя.
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * [* Опционально]
     * Название покупателя.
     *
     * @param string $name
     * @return $this
     * @throws \Rusproj\Uniteller\Exception\FieldIncorrectValueException Исключение генерируется если длина строки параметра больше 243 символов.
     */
    public function setName($name) {
        if (mb_strlen($name) > 243) {
            throw new FieldIncorrectValueException('Длина строки значения должна быть 0-243 символов включительно.');
        }
        $this->name = $name;
        return $this;
    }

    /**
     * [* Опционально]
     * ИНН покупателя.
     *
     * @return string
     */
    public function getInn() {
        return $this->inn;
    }

    /**
     * [* Опционально]
     * ИНН покупателя.
     *
     * @param string $inn
     * @return $this
     * @throws \Rusproj\Uniteller\Exception\FieldIncorrectValueException Исключение генерируется если длина строки параметра не 10-12 цифр и не пусто.
     */
    public function setInn($inn) {
        $_innLen = mb_strlen($inn);
        if (!empty($inn) && ($_innLen < 10 || $_innLen > 12)) {
            throw new FieldIncorrectValueException('Длина строки значения должна быть 10-12 символов включительно или пусто.');
        }
        $this->inn = $inn;
        return $this;
    }

}
