<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Callback;

use Rusproj\Uniteller\Signature\SignatureFieldsInterface;

/**
 * Параметры запроса-уведомления об изменении статуса заказа.
 *
 * @package Rusproj\Uniteller\Enum
 */
class CallbackBuilder implements SignatureFieldsInterface
{

    /*
     * Импорт метода toArray().
     */
    use \Rusproj\Uniteller\ClassConversion\ArraybleTrait;

    /**
     * Номер заказа в системе расчётов интернет-магазина.
     *
     * @var string
     */
    private $Order_ID = '';

    /**
     * Статус заказа.
     * Для указания значения используйте {@see \Rusproj\Uniteller\Enum\OrderStatusTypes}.
     *
     * @var string
     */
    private $Status = '';

    /**
     * Цифровая подпись запроса.
     *
     * @var string
     */
    private $Signature = '';

    /**
     * Идентификатор банка-эквайера в системе Uniteller.
     *
     * @var string
     */
    private $AcquirerID = null;

    /**
     * Код подтверждения транзакции от процессингового центра.
     *
     * @var string
     */
    private $ApprovalCode = null;

    /**
     * Номер платежа в системе Uniteller (RRN)
     *
     * @var string
     */
    private $BillNumber = null;

    /**
     * Идентификатор зарегистрированной карты (передаётся только для уже зарегистрированных в Uniteller карт).
     *
     * @var string
     */
    private $Card_IDP= null;

    /**
     * Маскированый номер карты (передается только для операций с картой).
     *
     * @var string
     */
    private $CardNumber = null;

    /**
     * Идентификатор Покупателя.
     *
     * @var string
     */
    private $Customer_IDP = null;

    /**
     * Информайция о 3DS (передается только для операций с картой).
     * Возможные значения смотрите в {@see \Rusproj\Uniteller\Enum\EciTypes}.
     *
     * @var int
     */
    private $ECI = null;

    /**
     * Тип электронной валюты (передается только для операций с электоронной валютой).
     * Возможные значения смотрите в {@see \Rusproj\Uniteller\Enum\EMoneyTypes}.
     *
     * @var int
     */
    private $EMoneyType = null;

    /**
     * Тип оплаты.
     * Возможные значения смотрите в {@see \Rusproj\Uniteller\Enum\PaymentTypes}.
     *
     * @var int
     */
    private $PaymentType = null;

    /**
     * Сумма всех средств, уплаченных по одному заказу.
     *
     * @var float
     */
    private $Total = null;

    /**
     * Описание чека фискализации.
     *
     * @var string
     */
    private $Receipt = '';

    /**
     * Подпись поля Receipt.
     *
     * @var string
     */
    private $ReceiptSignature = '';

    /**
     * Значения дополнительных полей для верификации.
     *
     * @var array
     */
    private $verificationFieldsList = [];

    /**
     * Инициализирует экземпляр класса {@see \Rusproj\Uniteller\Callback\CallbackBuilder}.
     *
     * @param array $fields
     */
    public function __construct($fields)
    {
        if (is_array($fields)) {
            foreach ($fields as $_key => $_val) {
                $this->$_key = $_val;

                $_exceptAdditionalVerificationFields = ['Order_ID', 'Status', 'Signature', 'Receipt', 'ReceiptSignature'];

                if (!in_array($_key, $_exceptAdditionalVerificationFields)) {
                    $this->verificationFieldsList[] = $_val;
                }
            }
        }
    }

    /**
     * Номер заказа в системе расчётов интернет-магазина.
     *
     * @return string
     */
    public function getOrderID()
    {
        return $this->Order_ID;
    }

    /**
     * Номер заказа в системе расчётов интернет-магазина.
     *
     * @param string $Order_ID
     * @return \Rusproj\Uniteller\Callback\CallbackBuilder
     */
    public function setOrderID($Order_ID)
    {
        $this->Order_ID = $Order_ID;
        return $this;
    }

    /**
     * Статус заказа.
     * Для указания значения используйте {@see \Rusproj\Uniteller\Enum\OrderStatusTypes}.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * Статус заказа.
     * Для указания значения используйте {@see \Rusproj\Uniteller\Enum\OrderStatusTypes}.
     *
     * @param string $Status
     * @return \Rusproj\Uniteller\Callback\CallbackBuilder
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
        return $this;
    }

    /**
     * Идентификатор банка-эквайера в системе Uniteller.
     *
     * @return string
     */
    public function getAcquirerID()
    {
        return $this->AcquirerID;
    }

    /**
     * Идентификатор банка-эквайера в системе Uniteller.
     *
     * @param string $AcquirerID
     * @return \Rusproj\Uniteller\Callback\CallbackBuilder
     */
    public function setAcquirerID($AcquirerID)
    {
        $this->AcquirerID = $AcquirerID;
        return $this;
    }

    /**
     * Код подтверждения транзакции от процессингового центра.
     *
     * @return string
     */
    public function getApprovalCode()
    {
        return $this->ApprovalCode;
    }

    /**
     * Код подтверждения транзакции от процессингового центра.
     *
     * @param string $ApprovalCode
     * @return \Rusproj\Uniteller\Callback\CallbackBuilder
     */
    public function setApprovalCode($ApprovalCode)
    {
        $this->ApprovalCode = $ApprovalCode;
        return $this;
    }

    /**
     * Номер платежа в системе Uniteller (RRN)
     *
     * @return string
     */
    public function getBillNumber()
    {
        return $this->BillNumber;
    }

    /**
     * Номер платежа в системе Uniteller (RRN)
     *
     * @param string $BillNumber
     * @return \Rusproj\Uniteller\Callback\CallbackBuilder
     */
    public function setBillNumber($BillNumber)
    {
        $this->BillNumber = $BillNumber;
        return $this;
    }

    /**
     * Идентификатор зарегистрированной карты (передаётся только для уже зарегистрированных в Uniteller карт).
     *
     * @return string
     */
    public function getCardIDP()
    {
        return $this->Card_IDP;
    }

    /**
     * Идентификатор зарегистрированной карты (передаётся только для уже зарегистрированных в Uniteller карт).
     *
     * @param string $Card_IDP
     * @return \Rusproj\Uniteller\Callback\CallbackBuilder
     */
    public function setCardIDP($Card_IDP)
    {
        $this->Card_IDP = $Card_IDP;
        return $this;
    }

    /**
     * Маскированый номер карты (передается только для операций с картой).
     *
     * @return string
     */
    public function getCardNumber()
    {
        return $this->CardNumber;
    }

    /**
     * Маскированый номер карты (передается только для операций с картой).
     *
     * @param string $CardNumber
     * @return \Rusproj\Uniteller\Callback\CallbackBuilder
     */
    public function setCardNumber($CardNumber)
    {
        $this->CardNumber = $CardNumber;
        return $this;
    }

    /**
     * Идентификатор Покупателя.
     *
     * @return string
     */
    public function getCustomerIDP()
    {
        return $this->Customer_IDP;
    }

    /**
     * Идентификатор Покупателя.
     *
     * @param string $Customer_IDP
     * @return \Rusproj\Uniteller\Callback\CallbackBuilder
     */
    public function setCustomerIDP($Customer_IDP)
    {
        $this->Customer_IDP = $Customer_IDP;
        return $this;
    }

    /**
     * Информайция о 3DS (передается только для операций с картой).
     * Возможные значения смотрите в {@see \Rusproj\Uniteller\Enum\EciTypes}.
     *
     * @return number
     */
    public function getECI()
    {
        return $this->ECI;
    }

    /**
     * Информайция о 3DS (передается только для операций с картой).
     * Возможные значения смотрите в {@see \Rusproj\Uniteller\Enum\EciTypes}.
     *
     * @param number $ECI
     * @return \Rusproj\Uniteller\Callback\CallbackBuilder
     */
    public function setECI($ECI)
    {
        $this->ECI = $ECI;
        return $this;
    }

    /**
     * Тип электронной валюты (передается только для операций с электоронной валютой).
     * Возможные значения смотрите в {@see \Rusproj\Uniteller\Enum\EMoneyTypes}.
     *
     * @return number
     */
    public function getEMoneyType()
    {
        return $this->EMoneyType;
    }

    /**
     * Тип электронной валюты (передается только для операций с электоронной валютой).
     * Возможные значения смотрите в {@see \Rusproj\Uniteller\Enum\EMoneyTypes}.
     *
     * @param number $EMoneyType
     * @return \Rusproj\Uniteller\Callback\CallbackBuilder
     */
    public function setEMoneyType($EMoneyType)
    {
        $this->EMoneyType = $EMoneyType;
        return $this;
    }

    /**
     * Тип оплаты.
     * Возможные значения смотрите в {@see \Rusproj\Uniteller\Enum\PaymentTypes}.
     *
     * @return number
     */
    public function getPaymentType()
    {
        return $this->PaymentType;
    }

    /**
     * Тип оплаты.
     * Возможные значения смотрите в {@see \Rusproj\Uniteller\Enum\PaymentTypes}.
     *
     * @param number $PaymentType
     * @return \Rusproj\Uniteller\Callback\CallbackBuilder
     */
    public function setPaymentType($PaymentType)
    {
        $this->PaymentType = $PaymentType;
        return $this;
    }

    /**
     * Сумма всех средств, уплаченных по одному заказу.
     *
     * @return number
     */
    public function getTotal()
    {
        return $this->Total;
    }

    /**
     * Сумма всех средств, уплаченных по одному заказу.
     *
     * @param number $Total
     * @return \Rusproj\Uniteller\Callback\CallbackBuilder
     */
    public function setTotal($Total)
    {
        $this->Total = $Total;
        return $this;
    }

    /**
     * Цифровая подпись запроса.
     *
     * @param string $Signature
     * @return \Rusproj\Uniteller\Callback\CallbackBuilder
     */
    public function setSignature($Signature)
    {
        $this->Signature = $Signature;
        return $this;
    }

    /**
     * Цифровая подпись запроса.
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->Signature;
    }

    /**
     * Описание чека фискализации.
     *
     * @param string $receipt
     * @return $this
     */
    public function setReceipt($receipt) {
        $this->Receipt = $receipt;

        return $this;
    }

    /**
     * Описание чека фискализации.
     *
     * @param bool $asObject Если true, то исходная строка будет десериализована и возвращена в виде объекта.
     * @return string|object
     */
    public function getReceipt($asObject = true) {
        return $asObject ? json_decode(base64_decode($this->Receipt)) : $this->Receipt;
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

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Signature\SignatureFieldsInterface::getSignatureVals()
     */
    public function getSignatureVals()
    {
        $_result = ['Signature' => $this->getSignature()];
        if (!empty($this->getReceiptSignature())) {
            $_result['ReceiptSignature'] = $this->getReceiptSignature();
        }
        return $_result;
    }

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Signature\SignatureFieldsInterface::getSignatureFields()
     */
    public function getSignatureFields()
    {
        $_keys_1 = array_merge([
            $this->getOrderID(),
            $this->getStatus()
        ], $this->verificationFieldsList);

        $_result = ['Signature' => ['HashFcn' => 'md5', 'Keys' => $_keys_1]];

        if (!empty($this->getReceiptSignature())) {
            $_keys_2 = [
                $this->getOrderID(),
                $this->getStatus(),
                $this->getReceipt(false)
            ];

            $_result['ReceiptSignature'] = ['HashFcn' => 'sha256', 'Keys' => $_keys_2];
        }

        return $_result;
    }

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Signature\SignatureFieldsInterface::updateField()
     */
    public function updateField($name, $val)
    {
        $this->$name = $val;
    }

}
