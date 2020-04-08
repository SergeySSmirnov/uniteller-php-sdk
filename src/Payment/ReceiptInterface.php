<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Tmconsulting\Uniteller\Payment;

/**
 * Интерфейс получения чека для фискализации.
 */
interface ReceiptInterface
{
    /**
     * Генерировать содержимое чека для фискализации.
     *
     * @return string
     */
    public function generate();
}

