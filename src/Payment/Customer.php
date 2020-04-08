<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Payment;

use Rusproj\Uniteller\ClassConversion\ObjectableInterface;

/**
 * Контакты плательщика для отправки текста фискального чека.
 * Этот блок может отсутствовать целиком, или в нем могут отсутствовать какие-то элементы.
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
     * Возвращает номер телефона плательщика.
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Задаёт номер телефона плательщика.
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
     * Возвращает адрес электронной почты плательщика.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Задаёт адрес электронной почты плательщика.
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
     * Возвращает идентификатор плательщика, присвоенный мерчантом.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Задаёт идентификатор плательщика, присвоенный мерчантом.
     *
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

}
