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
     * Возвращает основную подпись, гарантирующую неизменность критичных данных оплаты.
     *
     * @return string
     */
    public function getSignature();

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

