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
 * Интерфейс вычисления сигнатуры запроса.
 *
 * @package Rusproj\Uniteller\Signature
 */
interface SignatureHandlerInterface
{

    /**
     * Возвращает массив полей для формирования запроса.
     *
     * @param \Rusproj\Uniteller\Signature\SignatureFieldsInterface $fields Объект, содержащий поля, которые должны участвовать в вычислении сигнатуры.
     * @param string $passwd Пароль для расчёта сигнатуры.
     * @return array
     */
    public function sign($fields, $passwd);

    /**
     * Возвращает признак корректности сигнатуры запроса.
     *
     * @param \Rusproj\Uniteller\Signature\SignatureFieldsInterface $fields Объект, содержащий поля, которые должны участвовать в вычислении сигнатуры.
     * @param string $passwd Пароль для расчёта сигнатуры.
     * @param string $signature Строка сигнатуры запроса.
     * @return bool
     */
    public function verify($fields, $passwd, $signature);
}
