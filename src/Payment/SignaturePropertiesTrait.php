<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Payment;

/**
 * Свойства для описания подписи запроса.
 */
trait SignaturePropertiesTrait
{

    /**
     * Подпись запроса, гарантирующая неизменность критичных данных оплаты.
     *
     * @var string
     */
    protected $Signature = '';

    /**
     * Подпись запроса, гарантирующая неизменность критичных данных оплаты.
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->Signature;
    }

    /**
     * Подпись запроса, гарантирующая неизменность критичных данных оплаты.
     *
     * @param string $signature
     * @return $this
     */
    public function setSignature($signature)
    {
        $this->Signature = $signature;

        return $this;
    }

}
