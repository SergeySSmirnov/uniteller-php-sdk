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
 * Информация о товаре в фискальном чеке.
 *
 * Так как фискальный накопитель хранит данные в кодировке CP866, а передаются они в
 * кодировке UTF-8, то в поле “name” («Наименование позиции») можно указывать только те
 * Unicode-символы, для которых есть соответствие в CP866.
 *
 * @package Rusproj\Uniteller\FiscalCheck
 */
class ProductLine implements ObjectableInterface
{

    /*
     * Импорт метода toObject().
     */
    use \Rusproj\Uniteller\ClassConversion\ObjectableTrait;

    /**
     * Наименование позиции.
     *
     * @var string
     */
    private $name = '';

    /**
     * Цена за единицу измерения.
     *
     * @var float|string
     */
    private $price = '';

    /**
     * Количество.
     *
     * @var integer|string
     */
    private $qty = '';

    /**
     * Сумма.
     *
     * @var float|string
     */
    private $sum = '';

    /**
     * Код ставки налогообложения.
     * Для указания значения используйте {@see \Rusproj\Uniteller\Enum\VatRateTypes}.
     *
     * @var integer
     */
    private $vat = -1000;

    /**
     * Признак способа расчета.
     *
     * Для указания значения используйте {@see \Rusproj\Uniteller\Enum\CalculationMethodTypes}.
     *
     * @var int
     */
    private $payattr = -1000;

    /**
     * Признак предмета расчета.
     *
     * Для указания значения используйте {@see \Rusproj\Uniteller\Enum\CalculationSubjectTypes}.
     *
     * @var int
     */
    private $lineattr = -1000;

    /**
     * [* Опционально]
     * Дополнительные сведения о продукте.
     *
     * @var null|\Rusproj\Uniteller\FiscalCheck\AdditionalProductInfo
     */
    private $product = null;

    /**
     * [* Опционально]
     * Данные агента.
     *
     * @var null|\Rusproj\Uniteller\FiscalCheck\Agent
     */
    private $agent = null;

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
     * @throws \Rusproj\Uniteller\Exception\FieldIncorrectValueException Исключение генерируется если длина строки параметра больше 128 символов.
     */
    public function setName($name)
    {
        if (mb_strlen($name) > 128) {
            throw new FieldIncorrectValueException('Длина строки с Названием продукта должна быть 0-128 символов включительно.');
        }
        $this->name = $name;
        return $this;
    }

    /**
     * Возвращает цена за единицу измерения.
     *
     * @return float|string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Задаёт цена за единицу измерения.
     *
     * @param float|string $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Возвращает количество.
     *
     * @return integer|string
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Задаёт количество.
     *
     * @param integer|string $qty
     * @return $this
     */
    public function setQty($qty)
    {
        $this->qty = $qty;
        return $this;
    }

    /**
     * Возвращает сумму.
     *
     * @return float|string
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Задаёт сумму.
     *
     * @param float|string $sum
     * @return $this
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
        return $this;
    }

    /**
     * Возвращает код ставки налогообложения.
     *
     * Для разрешения значения используйте {@see \Rusproj\Uniteller\Enum\VatRateTypes}.
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
     * Для указания значения используйте {@see \Rusproj\Uniteller\Enum\VatRateTypes}.
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
     * Для разрешения значения используйте {@see \Rusproj\Uniteller\Enum\CalculationMethodTypes}.
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
     * Для указания значения используйте {@see \Rusproj\Uniteller\Enum\CalculationMethodTypes}.
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
     * Для разрешения значения используйте {@see \Rusproj\Uniteller\Enum\CalculationSubjectTypes}.
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
     * Для указания значения используйте {@see \Rusproj\Uniteller\Enum\CalculationSubjectTypes}.
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
     * [* Опционально]
     * Дополнительные сведения о продукте.
     *
     * @return \Rusproj\Uniteller\FiscalCheck\AdditionalProductInfo
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * [* Опционально]
     * Дополнительные сведения о продукте.
     *
     * @param \Rusproj\Uniteller\FiscalCheck\AdditionalProductInfo $product
     * @return $this
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * [* Опционально]
     * Данные агента.
     *
     * @return \Rusproj\Uniteller\FiscalCheck\Agent
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * [* Опционально]
     * Данные агента.
     *
     * @param \Rusproj\Uniteller\FiscalCheck\Agent $agent
     * @return $this
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;
        return $this;
    }

}
