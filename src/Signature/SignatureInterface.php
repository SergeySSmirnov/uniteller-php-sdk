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
 * Интерфейс вычисления сигнатуры запроса.
 *
 * @package Tmconsulting\Client
 */
interface SignatureInterface
{

    /**
     * Возвращает массив полей для формирования запроса.
     *
     * @param \Tmconsulting\Uniteller\Signature\SignatureFieldsInterface $fields Объект, содержащий поля, которые должны участвовать в вычислении сигнатуры.
     * @param string $passwd Пароль для расчёта сигнатуры.
     * @return array
     */
    public function sign($fields, $passwd);

    /**
     * Возвращает признак корректности сигнатуры запроса.
     *
     * @param \Tmconsulting\Uniteller\Signature\SignatureFieldsInterface $fields Объект, содержащий поля, которые должны участвовать в вычислении сигнатуры.
     * @param string $passwd Пароль для расчёта сигнатуры.
     * @param string $signature Строка сигнатуры запроса.
     * @return bool
     */
    public function verify($fields, $passwd, $signature);
}
