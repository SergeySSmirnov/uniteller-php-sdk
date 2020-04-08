<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Tmconsulting\Uniteller\Payment;

use Tmconsulting\Uniteller\ObjectableInterface;
use Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException;

/**
 * Информация о товаре в фискальном чеке.
 *
 * Так как фискальный накопитель хранит данные в кодировке CP866, а передаются они в
 * кодировке UTF-8, то в поле “name” («Наименование позиции») можно указывать только те
 * Unicode-символы, для которых есть соответствие в CP866.
 *
 * @package Tmconsulting\Uniteller\Payment
 */
class Product implements ObjectableInterface
{
    /**
     * Наименование позиции.
     *
     * @var string
     */
    private $name;

    /**
     * Цена за единицу измерения.
     *
     * @var float
     */
    private $price;

    /**
     * Количество.
     *
     * @var string
     */
    private $qty;

    /**
     * Сумма.
     *
     * @var string
     */
    private $sum;

    /**
     * Код системы налогообложения.
     *
     * Для указания значения используйте {@see \Tmconsulting\Uniteller\Enums\TaxModeTypes}.
     *
     * @var integer
     */
    private $taxmode;

    /**
     * Код ставки налогообложения.
     * Для указания значения используйте {@see \Tmconsulting\Uniteller\Enums\VatRateTypes}.
     *
     * @var integer
     */
    private $vat;

    /**
     * Признак способа расчета.
     *
     * Для указания значения используйте {@see \Tmconsulting\Uniteller\Enums\CalculationMethodTypes}.
     *
     * @var int
     */
    private $payattr;

    /**
     * Признак предмета расчета.
     *
     * Для указания значения используйте {@see \Tmconsulting\Uniteller\Enums\CalculationSubjectTypes}.
     *
     * @var int
     */
    private $lineattr;

    /**
     * Возвращает наименование позиции.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Задаёт наименование позиции.
     *
     * @param string $name
     * @return $this
     * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 128 символов.
     */
    public function setName($name)
    {
        if (strlen($name) > 128)
        {
            throw new BuilderIncorrectValueException("Wrong: Name = '{$name}'. Expected length of the Name <= 128.");
        }

        $this->name = $name;
        return $this;
    }

    /**
     * Возвращает цена за единицу измерения.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Задаёт цена за единицу измерения.
     *
     * @param string $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Возвращает количество.
     *
     * @return string
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Задаёт количество.
     *
     * @param string $qty
     * @return $this
     */
    public function setQty($qty)
    {
        $this->qty = $qty;
        return $this;
    }

    /**
     * Возвращает количество.
     *
     * @return string
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Задаёт количество.
     *
     * @param string $sum
     * @return $this
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
        return $this;
    }

    /**
     * Возвращает код системы налогообложения.
     *
     * Для разрешения значения используйте {@see \Tmconsulting\Uniteller\Enums\TaxModeTypes}.
     *
     * @return number
     */
    public function getTaxmode()
    {
        return $this->taxmode;
    }

    /**
     * Задаёт код системы налогообложения.
     *
     * Для указания значения используйте {@see \Tmconsulting\Uniteller\Enums\TaxModeTypes}.
     *
     * @param number $taxmode
     * @return $this
     */
    public function setTaxmode($taxmode)
    {
        $this->taxmode = $taxmode;
        return $this;
    }

    /**
     * Возвращает код ставки налогообложения.
     *
     * Для разрешения значения используйте {@see \Tmconsulting\Uniteller\Enums\VatRateTypes}.
     *
     * @return number
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * Задаёт код ставки налогообложения.
     *
     * Для указания значения используйте {@see \Tmconsulting\Uniteller\Enums\VatRateTypes}.
     *
     * @param number $vat
     * @return $this
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
        return $this;
    }

    /**
     * Возвращает признак способа расчета.
     *
     * Для разрешения значения используйте {@see \Tmconsulting\Uniteller\Enums\CalculationMethodTypes}.
     *
     * @return number
     */
    public function getPayattr()
    {
        return $this->payattr;
    }

    /**
     * Задаёт признак способа расчета.
     *
     * Для указания значения используйте {@see \Tmconsulting\Uniteller\Enums\CalculationMethodTypes}.
     *
     * @param number $payattr
     * @return $this
     */
    public function setPayattr($payattr)
    {
        $this->payattr = $payattr;
        return $this;
    }

    /**
     * Возвращает признак предмета расчета.
     *
     * Для разрешения значения используйте {@see \Tmconsulting\Uniteller\Enums\CalculationSubjectTypes}.
     *
     * @return number
     */
    public function getLineattr()
    {
        return $this->lineattr;
    }

    /**
     * Задаёт признак предмета расчета.
     *
     * Для указания значения используйте {@see \Tmconsulting\Uniteller\Enums\CalculationSubjectTypes}.
     *
     * @param number $lineattr
     * @return $this
     */
    public function setLineattr($lineattr)
    {
        $this->lineattr = $lineattr;
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
