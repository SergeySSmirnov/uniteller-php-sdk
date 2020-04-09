<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\FiscalCheck;

/**
 * Интерфейс получения чека для фискализации.
 *
 * @package Rusproj\Uniteller\FiscalCheck
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

