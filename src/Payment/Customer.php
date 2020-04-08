<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Tmconsulting\Uniteller\Payment;

use Tmconsulting\Uniteller\ObjectableInterface;

/**
 * Контакты плательщика для отправки текста фискального чека.
 * Этот блок может отсутствовать целиком, или в нем могут отсутствовать какие-то элементы.
 */
class Customer implements ObjectableInterface
{
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

    /**
     * {@inheritDoc}
     * @see \Tmconsulting\Uniteller\ObjectableInterface::toObject()
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
