<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Payment;

/**
 * Свойства для описания чека фискализации.
 */
trait ReceiptPropertiesTrait
{

    /**
     * Описание чека фискализации.
     *
     * @var \Rusproj\Uniteller\FiscalCheck\ReceiptInterface
     */
    private $Receipt = '';

    /**
     * Подпись поля Receipt.
     *
     * @var string
     */
    private $ReceiptSignature = '';

    /**
     * Описание чека фискализации.
     *
     * @param \Rusproj\Uniteller\FiscalCheck\ReceiptInterface $receipt
     * @return $this
     */
    public function setReceipt($receipt)
    {
        $this->Receipt = $receipt;

        return $this;
    }

    /**
     * Описание чека фискализации.
     *
     * @return \Rusproj\Uniteller\FiscalCheck\ReceiptInterface
     */
    public function getReceipt()
    {
        return $this->Receipt;
    }

    /**
     * Подпись поля Receipt.
     *
     * @param string $ReceiptSignature
     * @return $this
     */
    public function setReceiptSignature($ReceiptSignature)
    {
        $this->ReceiptSignature = $ReceiptSignature;

        return $this;
    }

    /**
     * Подпись поля Receipt.
     *
     * @return string
     */
    public function getReceiptSignature()
    {
        return $this->ReceiptSignature;
    }

}
