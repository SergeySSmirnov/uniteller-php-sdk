<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\FiscalCheck;

use Rusproj\Uniteller\ClassConversion\ObjectableInterface;

/**
 * Блок информации об оплате дополнительными платежными средствами.
 *
 * @package Rusproj\Uniteller\FiscalCheck
 */
class Payment implements ObjectableInterface
{

    /*
     * Импорт метода toObject().
     */
    use \Rusproj\Uniteller\ClassConversion\ObjectableTrait;

    /**
     * Вид платежного средства.
     *
     * Для указания значения используйте {@see \Rusproj\Uniteller\Enum\PaymentInstrumentTypes}.
     *
     * @var integer
     */
    private $kind = -1000;

    /**
     * Тип платёжного средства.
     *
     * Для указания значения используйте {@see \Rusproj\Uniteller\Enum\MeansPaymentTypes}.
     *
     * @var integer
     */
    private $type = -1000;

    /**
     * [* Опционально]
     * Идентификатор платежного средства, например, номер бонусной карты,
     * номер подарочного сертификата, номер лицевого счета.
     *
     * @var null|string
     */
    private $id = null;

    /**
     * Сумма оплаты платёжным средсвом.
     *
     * @var float
     */
    private $amount = 0;

    /**
     * Вид платежного средства.
     *
     * Для указания значения используйте {@see \Rusproj\Uniteller\Enum\PaymentInstrumentTypes}.
     *
     * @return integer
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * Вид платежного средства.
     *
     * Для указания значения используйте {@see \Rusproj\Uniteller\Enum\PaymentInstrumentTypes}.
     *
     * @param integer $kind
     * @return $this
     */
    public function setKind($kind)
    {
        $this->kind = $kind;
        return $this;
    }

    /**
     * Тип платёжного средства.
     *
     * Для указания значения используйте {@see \Rusproj\Uniteller\Enum\MeansPaymentTypes}.
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Тип платёжного средства.
     *
     * Для указания значения используйте {@see \Rusproj\Uniteller\Enum\MeansPaymentTypes}.
     *
     * @param integer $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * [* Опционально]
     * Идентификатор платежного средства, например, номер бонусной карты,
     * номер подарочного сертификата, номер лицевого счета.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * [* Опционально]
     * Идентификатор платежного средства, например, номер бонусной карты,
     * номер подарочного сертификата, номер лицевого счета.
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
     * Сумма оплаты платёжным средсвом.
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Сумма оплаты платёжным средсвом.
     *
     * @param float $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

}
