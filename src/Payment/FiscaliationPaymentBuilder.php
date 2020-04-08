<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Tmconsulting\Uniteller\Payment;

/**
 * Параметры запроса для генерации ссылки для оплаты с фискализацией.
 *
 * @package Tmconsulting\Client\Payment
 */
class FiscaliationPaymentBuilder extends PaymentBuilder
{

    /**
     * Описание чека для фискализации.
     *
     * @var \Tmconsulting\Uniteller\Payment\ReceiptInterface
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
     * @return \Tmconsulting\Uniteller\Payment\ReceiptInterface
     */
    public function getReceipt() {
        return $this->Receipt;
    }

    /**
     * Задаёт описание чека для фискализации.
     *
     * @param \Tmconsulting\Uniteller\Payment\ReceiptInterface $receipt
     * @return void
     */
    public function setReceipt($receipt) {
        $this->Receipt = $receipt;
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
     * @see \Tmconsulting\Uniteller\Payment\PaymentBuilder::getSignatureFields()
     */
    public function getSignatureFields() {
        $_result = parent::getSignatureFields();
        $_result['ReceiptSignature'] = ['HashFcn' => 'sha256', 'Keys' => [
            $this->getShopIdp(),
            $this->getOrderIdp(),
            $this->getSubtotalP(),
            base64_encode($this->getReceipt()->generate())
        ]];
        return $_result;
    }

}

