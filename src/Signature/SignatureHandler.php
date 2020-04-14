<?php
/**
 * Created by Roquie.
 * E-mail: roquie0@gmail.com
 * GitHub: Roquie
 *
 * Modified by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Signature;

/**
 * Механизм вычисления сигнатуры запроса.
 *
 * @package Rusproj\Client
 */
class SignatureHandler implements SignatureHandlerInterface
{

    /**
     * Выполняет расчёт сигнатуры и возвращает список обновлённых полей.
     *
     * @param \Rusproj\Uniteller\Signature\SignatureFieldsInterface $fields Объект, содержащий поля, которые должны участвовать в вычислении сигнатуры.
     * @param string $passwd Пароль для расчёта сигнатуры.
     * @param bool $simpleCalculation Использовать упрощённое вычисление сигнатуры.
     * @return \Rusproj\Uniteller\Signature\SignatureFieldsInterface
     */
    private function updateSignatureFields($fields, $passwd, $simpleCalculation)
    {
        $_items = $fields->getSignatureFields();

        foreach ($_items as $_key => $_params) {
            $_hashType = $_params['HashFcn'];
            $_keys = $_params['Keys'];
            $_keys[] = $passwd;

            if ($simpleCalculation) {
                $_signature = join('', $_keys);
            } else {
                $_signature = join('&', array_map(function ($item) use($_hashType) {
                        return hash($_hashType, $item);
                }, $_keys));
            }

            $_signature = strtoupper(hash($_hashType, $_signature));

            $fields->updateField($_key, $_signature);
        }

        return $fields;
    }

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Signature\SignatureHandlerInterface::sign()
     */
    public function sign($fields, $passwd)
    {
        return $this->updateSignatureFields($fields, $passwd, false)->toArray();
    }

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\Signature\SignatureHandlerInterface::verify()
     */
    public function verify($fields, $passwd, $signatures)
    {
        if (!is_array($signatures)) {
            return false;
        }

        $_validSignatures = $this->updateSignatureFields($fields, $passwd, true)->getSignatureVals();

        if (count($_validSignatures) !== count($signatures)) {
            return false;
        }

        foreach ($_validSignatures as $_key => $_val) {
            if (!array_key_exists($_key, $signatures)) {
                return false;
            }

            if ($_val !== $signatures[$_key]) {
                return false;
            }
        }

        return true;
    }

}
