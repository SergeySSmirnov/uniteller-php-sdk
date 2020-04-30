<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\PaymentConfirm;

use Rusproj\Uniteller\Signature\SignatureFieldsInterface;

/**
 * Параметры запроса подтверждения платежа с преавторизацией.
 */
class PreauthConfirmBuilder implements SignatureFieldsInterface
{

    /*
     * Импорт метода toArray().
     */
    use \Rusproj\Uniteller\ClassConversion\ArraybleTrait;

    /*
     * Импорт свойств с описанием чека фискализации.
     */
    use \Rusproj\Uniteller\Payment\ReceiptPropertiesTrait;

    /*
     * Импорт свойств с описанием подписи запроса.
     */
    use \Rusproj\Uniteller\Payment\SignaturePropertiesTrait;

    /*
     * Импорт свойств с описанием идентификатора точки продажи.
     */
    use \Rusproj\Uniteller\Payment\ShopPropertiesTrait;

    /*
     * Импорт свойств с описанием номера заказа.
     */
    use \Rusproj\Uniteller\Payment\OrderPropertiesTrait;

    /*
     * Импорт свойств с описанием суммы покупки.
     */
    use \Rusproj\Uniteller\Payment\SubtotalPropertiesTrait;


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
     * @see \Rusproj\Uniteller\Signature\SignatureFieldsInterface::getSignatureFields()
     */
    public function getSignatureFields()
    {
        $this->setReceipt(base64_encode($this->getReceipt()->generate()));

        $_result_1 = [
            $this->getShopID(),
            $this->getOrderID(),
            $this->getSubtotal()
        ];

        $_result_2 = [
            $this->getShopID(),
            $this->getOrderID(),
            $this->getSubtotal(),
            $this->getReceipt()
        ];

        return [
            'Signature' => ['CalcHashForEachField' => true, 'ConcatSymbol' => '', 'HashFcn' => 'md5', 'Keys' => $_result_1],
            'ReceiptSignature' => ['CalcHashForEachField' => true, 'ConcatSymbol' => '&', 'HashFcn' => 'sha256', 'Keys' => $_result_2]
        ];
    }

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Signature\SignatureFieldsInterface::updateField()
     */
    public function updateField($name, $val) {
        $this->$name = $val;
    }

}
