<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\PaymentApi;

use Rusproj\Uniteller\Signature\SignatureFieldsInterface;

/**
 * Параметры запроса идентификатора оплаты в системе Uniteller.
 */
class ApiCheckBuilder implements SignatureFieldsInterface
{

    /*
     * Импорт метода toArray().
     */
    use \Rusproj\Uniteller\ClassConversion\ArraybleTrait;

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


    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Signature\SignatureFieldsInterface::getSignatureVals()
     */
    public function getSignatureVals()
    {
        return [
            'Signature' => $this->getSignature()
        ];
    }

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Signature\SignatureFieldsInterface::getSignatureFields()
     */
    public function getSignatureFields()
    {
        $_result_1 = [
            $this->getShopID(),
            $this->getOrderID()
        ];

        return [
            'Signature' => ['CalcHashForEachField' => true, 'ConcatSymbol' => '', 'HashFcn' => 'md5', 'Keys' => $_result_1]
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
