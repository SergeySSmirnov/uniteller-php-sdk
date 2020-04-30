<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Payment;

use Rusproj\Uniteller\Exception\FieldIncorrectValueException;

/**
 * Свойства для описания номера заказа.
 */
trait OrderPropertiesTrait
{

    /**
     * Номер подтверждаемого заказа.
     *
     * @var string
     */
    private $OrderID = '';

    /**
     * Номер подтверждаемого заказа.
     *
     * @param string $orderId Номер заказа.
     * @return $this
     * @throws \Rusproj\Uniteller\Exception\FieldIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 64 символов.
     */
    public function setOrderID($orderId)
    {
        if (mb_strlen($orderId) > 64)
        {
            throw new FieldIncorrectValueException("Wrong: OrderID = '{$orderId}'. Expected length of the OrderIdp <= 64.");
        }

        $this->OrderID = $orderId;

        return $this;
    }

    /**
     * Номер подтверждаемого заказа.
     *
     * @return string
     */
    public function getOrderID()
    {
        return $this->OrderID;

        return $this;
    }

}
