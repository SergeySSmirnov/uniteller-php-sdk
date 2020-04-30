<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\PaymentConfirm;

use Rusproj\Uniteller\Signature\SignatureFieldsInterface;
use Rusproj\Uniteller\Exception\FieldIncorrectValueException;

/**
 * Параметры запроса подтверждения платежа с преавторизацией.
 *
 * @package Rusproj\Client\PaymentConfirm
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
    use \Rusproj\Uniteller\Payment\ReceiptTrait;

    /*
     * Импорт свойств с описанием подписи запроса.
     */
    use \Rusproj\Uniteller\Payment\SignatureTrait;


    /**
     * Идентификатор точки продажи в системе Uniteller.
     *
     * В Личном кабинете этот параметр называется Uniteller Point ID и
     * его значение доступно на странице «Точки продажи компании»
     * (пункт меню «Точки продажи») в столбце Uniteller Point ID.
     *
     * Формат: текст, содержащий либо латинские буквы и цифры в количестве
     * от 1 до 64, либо две группы латинских букв и цифр, разделенных «-»
     * (первая группа от 1 до 15 символов, вторая группа от 1 до 11 символов),
     * к регистру нечувствителен.
     *
     * @var string
     */
    private $ShopID = '';

    /**
     * Номер подтверждаемого заказа.
     *
     * @var string
     */
    private $OrderID = '';

    /**
     * Уточненная сумма покупки в валюте, оговорённой в договоре с банкомэквайером.
     * В качестве десятичного разделителя используется точка,
     * не более 2 знаков после разделителя. Например, 12.34.
     *
     * @var float|string
     */
    private $Subtotal = '';

    /**
     * Задаёт идентификатор точки продажи в системе Uniteller.
     *
     * В Личном кабинете этот параметр называется Uniteller Point ID и
     * его значение доступно на странице «Точки продажи компании»
     * (пункт меню «Точки продажи») в столбце Uniteller Point ID.
     *
     * Формат: текст, содержащий либо латинские буквы и цифры в количестве
     * от 1 до 64, либо две группы латинских букв и цифр, разделенных «-»
     * (первая группа от 1 до 15 символов, вторая группа от 1 до 11 символов),
     * к регистру нечувствителен.
     *
     * @param string $shopId Идентификатор точки продажи в системе Uniteller.
     * @return $this
     */
    public function setShopID($shopId)
    {
        $this->ShopID = $shopId;

        return $this;
    }

    /**
     * Номер подтверждаемого заказа.
     *
     * @param string $orderId Номер заказа.
     * @return $this
     * @throws \Rusproj\Uniteller\Exception\FieldIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 64 символов.
     */
    public function setOrderID($orderId)
    {
        if (mb_strlen($orderId) > 64)
        {
            throw new FieldIncorrectValueException("Wrong: OrderID = '{$orderId}'. Expected length of the OrderIdp <= 64.");
        }

        $this->OrderID = $orderId;

        return $this;
    }

    /**
     * Уточненная сумма покупки в валюте, оговорённой в договоре с банкомэквайером.
     * В качестве десятичного разделителя используется точка,
     * не более 2 знаков после разделителя. Например, 12.34.
     *
     * @param float|string $subtotal Сумма оплаты.
     * @return $this
     */
    public function setSubtotal($subtotal)
    {
        $this->Subtotal = $subtotal;

        return $this;
    }

    /**
     * Возвращает идентификатор точки продажи в системе Uniteller.
     *
     * В Личном кабинете этот параметр называется Uniteller Point ID и
     * его значение доступно на странице «Точки продажи компании»
     * (пункт меню «Точки продажи») в столбце Uniteller Point ID.
     *
     * Формат: текст, содержащий либо латинские буквы и цифры в количестве
     * от 1 до 64, либо две группы латинских букв и цифр, разделенных «-»
     * (первая группа от 1 до 15 символов, вторая группа от 1 до 11 символов),
     * к регистру нечувствителен.
     *
     * @return string
     */
    public function getShopID()
    {
        return $this->ShopID;

        return $this;
    }

    /**
     * Номер подтверждаемого заказа.
     *
     * @return string
     */
    public function getOrderID()
    {
        return $this->OrderID;

        return $this;
    }

    /**
     * Уточненная сумма покупки в валюте, оговорённой в договоре с банкомэквайером.
     * В качестве десятичного разделителя используется точка,
     * не более 2 знаков после разделителя. Например, 12.34.
     *
     * @return float|string
     */
    public function getSubtotal()
    {
        return $this->Subtotal;

        return $this;
    }

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
