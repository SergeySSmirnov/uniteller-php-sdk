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

namespace Tmconsulting\Uniteller\Signature;

/**
 * Механизм вычисления сигнатуры запроса.
 *
 * @package Tmconsulting\Client
 */
class Signature implements SignatureInterface
{

    /**
     * Выполняет расчёт сигнатуры и возвращает список обновлённых полей.
     *
     * @param \Tmconsulting\Uniteller\Signature\SignatureFieldsInterface $fields Объект, содержащий поля, которые должны участвовать в вычислении сигнатуры.
     * @param string $passwd Пароль для расчёта сигнатуры.
     * @return \Tmconsulting\Uniteller\Signature\SignatureFieldsInterface
     */
    private function updateSignatureFields($fields, $passwd)
    {
        $_items = $fields->getSignatureFields();

        foreach ($_items as $_key => $_params) {
            $_hashType = $_params['HashFcn'];
            $_keys = $_params['Keys'];
            $_keys[] = $passwd;

            $_signature = join('&', array_map(function ($item) use($_hashType) {
                    return hash($_hashType, $item);
            }, $_keys));

            $_signature = strtoupper(hash($_hashType, $_signature));

            $fields->updateField($_key, $_signature);
        }

        return $fields;
    }

    /**
     * {@inheritDoc}
     * @see \Tmconsulting\Uniteller\Signature\SignatureInterface::sign()
     */
    public function sign($fields, $passwd)
    {
        return $this->updateSignatureFields($fields, $passwd)->toArray();
    }

    /**
     * {@inheritDoc}
     * @see \Tmconsulting\Uniteller\Signature\SignatureInterface::verify()
     */
    public function verify($fields, $passwd, $signature)
    {
        return $this->updateSignatureFields($fields, $passwd)->getSignature() === $signature;
    }

}
