<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Payment;

/**
 * Свойства для описания суммы покупки.
 */
trait SubtotalPropertiesTrait
{

    /**
     * Уточненная сумма покупки в валюте, оговорённой в договоре с банкомэквайером.
     * В качестве десятичного разделителя используется точка,
     * не более 2 знаков после разделителя. Например, 12.34.
     *
     * @var float|string
     */
    private $Subtotal = '';

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

}
