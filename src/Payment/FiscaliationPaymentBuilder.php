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
 * @package Tmconsulting\Client\Payment
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
     * @var \Rusproj\Uniteller\Payment\ReceiptInterface
     */
    private $Receipt;

    /**
     * Подпись поля Receipt.
     *
     * @var string
     */
    private $ReceiptSignature;

    /**
     * Возвращает описание чека для фискализации.
     *
     * @return \Rusproj\Uniteller\Payment\ReceiptInterface
     */
    public function getReceipt() {
        return $this->Receipt;
    }

    /**
     * Задаёт описание чека для фискализации.
     *
     * @param \Rusproj\Uniteller\Payment\ReceiptInterface $receipt
     * @return $this
     */
    public function setReceipt($receipt) {
        $this->Receipt = $receipt;
        return $this;
    }

    /**
     * Возвращает подпись поля Receipt.
     *
     * @return string
     */
    public function getReceiptSignature()
    {
        return $this->ReceiptSignature;
    }

    /**
     * Задаёт подпись поля Receipt.
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

