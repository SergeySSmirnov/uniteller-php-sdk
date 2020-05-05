<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\PaymentApi;

use Rusproj\Uniteller\Signature\SignatureFieldsInterface;
use Rusproj\Uniteller\Exception\FieldIncorrectValueException;

/**
 * Параметры платежа ДПС в системе Uniteller.
 */
class ApiPayBuilder implements SignatureFieldsInterface
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
     * Импорт свойств с описанием суммы заказа.
     */
    use \Rusproj\Uniteller\Payment\SubtotalPropertiesTrait;


    /**
     * Идентификатор попытки оплаты в системе Uniteller.
     * Строка, состоящая из цифр длиной до 64 символов.
     *
     * @var string
     */
    private $PaymentAttemptID = '';

    /**
     * Идентификатор попытки оплаты в системе Uniteller.
     * Строка, состоящая из цифр длиной до 64 символов.
     *
     * @param string $paymentAttemptID
     * @return $this
     * @throws \Rusproj\Uniteller\Exception\FieldIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 64 символов.
     */
    public function setPaymentAttemptID($paymentAttemptID)
    {
        if (mb_strlen($paymentAttemptID) > 64)
        {
            throw new FieldIncorrectValueException("Wrong: PaymentAttemptID = '{$paymentAttemptID}'. Expected length of the PaymentAttemptID <= 64.");
        }

        $this->PaymentAttemptID = $paymentAttemptID;

        return $this;
    }

    /**
     * Идентификатор попытки оплаты в системе Uniteller.
     * Строка, состоящая из цифр длиной до 64 символов.
     *
     * @return string
     */
    public function getPaymentAttemptID()
    {
        return $this->PaymentAttemptID;

        return $this;
    }

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
            $this->getPaymentAttemptID(),
            $this->getSubtotal()
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
