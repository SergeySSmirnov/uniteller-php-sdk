<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Payment;

/**
 * Параметры запроса для генерации ссылки на форму оплаты с фискализацией.
 */
class FiscaliationPaymentBuilder extends PaymentBuilder
{

    /*
     * Импорт метода toArray().
     */
    use \Rusproj\Uniteller\ClassConversion\ArraybleTrait;

    /*
     * Импорт свойств с описанием чека фискализации.
     */
    use \Rusproj\Uniteller\Payment\ReceiptPropertiesTrait;


    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Signature\SignatureFieldsInterface::getSignatureVals()
     */
    public function getSignatureVals()
    {
        return [
            'Signature' => $this->getSignature(),
            'ReceiptSignature' => $this->getReceiptSignature()
        ];
    }

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Payment\PaymentBuilder::getSignatureFields()
     */
    public function getSignatureFields() {
        $this->setReceipt(base64_encode($this->getReceipt()->generate()));

        $_result = parent::getSignatureFields();
        $_result['ReceiptSignature'] = ['CalcHashForEachField' => true, 'ConcatSymbol' => '&', 'HashFcn' => 'sha256', 'Keys' => [
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
