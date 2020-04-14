<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Signature;

use Rusproj\Uniteller\ClassConversion\ArraybleInterface;

/**
 * Интерфейс, описывающий механизм получения списка полей, участвующих в вычислении сигнатуры.
 */
interface SignatureFieldsInterface extends ArraybleInterface
{
    /**
     * Возвращает массив подписей, гарантирующих неизменность критичных данных.
     * Например, ['Key_1' => 'nfuy45fhn5v5g', 'Key_2' => 'f5irv6t436564'].
     *
     * @return string[]
     */
    public function getSignatureVals();

    /**
     * Возвращает список полей, участвующих в вычислении сигнатуры.
     *
     * Должен содержать массив-массивов данных в формате:
     * ['Ключ' => ['HashFcn' => 'ТипХэша', 'Keys' => [СписокПолей]]], где
     * Ключ - название поля, которое хранит вычисленное значение сигнатуры (в него будет записан результат вычисления сигнатуры);
     * ТипХэша - название функции для вычисления хэша;
     * СписокПолей - массив, содержащий непосредственно список полей участвующих в вычислении сигнатуры.
     *
     * @return array
     */
    public function getSignatureFields();

    /**
     * Обновляет значение указанного поля.
     * @param string $name Название поля.
     * @param string $val Значение.
     */
    public function updateField($name, $val);
}

