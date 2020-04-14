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
     * ['Ключ' => ['CalcHashForEachField' => true, 'ConcatSymbol' => '&', 'HashFcn' => 'ТипХэша', 'Keys' => [СписокПолей]]], где
     * CalcHashForEachField - признак необходимости вычислять хэш для каждого поля;
     * ConcatSymbol - символ конкатенации хэшей полей для вычисления общего хэша;
     * Ключ - название поля, которое хранит вычисленное значение сигнатуры (в него будет записан результат вычисления сигнатуры);
     * HashFcn - название функции для вычисления хэша (md5, sha256);
     * Keys - массив, содержащий непосредственно список полей участвующих в вычислении сигнатуры.
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

