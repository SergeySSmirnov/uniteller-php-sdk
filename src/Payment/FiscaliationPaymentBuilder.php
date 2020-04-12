<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Payment;

/**
 * Параметры запроса для генерации ссылки для оплаты с фискализацией.
 *
 * @package Rusproj\Client\Payment
 */
class FiscaliationPaymentBuilder extends PaymentBuilder
{

    /*
     * Импорт метода toArray().
     */
    use \Rusproj\Uniteller\ClassConversion\ArraybleTrait;

    /**
     * Описание чека для фискализации.
     *
     * @var \Rusproj\Uniteller\FiscalCheck\ReceiptInterface
     */
    private $Receipt;

    /**
     * Подпись поля Receipt.
     *
     * @var string
     */
    private $ReceiptSignature;

    /**
     * Описание чека для фискализации.
     *
     * @return \Rusproj\Uniteller\FiscalCheck\ReceiptInterface
     */
    public function getReceipt() {
        return $this->Receipt;
    }

    /**
     * Описание чека для фискализации.
     *
     * @param \Rusproj\Uniteller\FiscalCheck\ReceiptInterface $receipt
     * @return $this
     */
    public function setReceipt($receipt) {
        $this->Receipt = $receipt;
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
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Payment\PaymentBuilder::getSignatureFields()
     */
    public function getSignatureFields() {
        $this->setReceipt(base64_encode($this->getReceipt()->generate()));

        $_result = parent::getSignatureFields();
        $_result['ReceiptSignature'] = ['HashFcn' => 'sha256', 'Keys' => [
            $this->getShopIdp(),
            $this->getOrderIdp(),
            $this->getSubtotalP(),
            $this->getReceipt()
        ]];
        return $_result;
    }

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Signature\SignatureFieldsInterface::updateField()
     */
    public function updateField($name, $val) {
        $this->$name = $val;
    }

}
