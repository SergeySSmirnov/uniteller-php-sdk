<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\PaymentApi;

/**
 * Параметры запроса платежа ДПС в системе Uniteller.
 */
interface ApiBuilderInterface
{

    /**
     * Возвращает идентификатор точки продажи в системе Uniteller.
     *
     * В Личном кабинете этот параметр называется Uniteller Point ID и
     * его значение доступно на странице «Точки продажи компании»
     * (пункт меню «Точки продажи») в столбце Uniteller Point ID.
     *
     * Формат: текст, содержащий либо латинские буквы и цифры в количестве
     * от 1 до 64, либо две группы латинских букв и цифр, разделенных «-»
     * (первая группа от 1 до 15 символов, вторая группа от 1 до 11 символов),
     * к регистру нечувствителен.
     *
     * @return string
     */
    public function getShopID();

    /**
     * Номер подтверждаемого заказа.
     *
     * @return string
     */
    public function getOrderID();

    /**
     * Уточненная сумма покупки в валюте, оговорённой в договоре с банкомэквайером.
     * В качестве десятичного разделителя используется точка,
     * не более 2 знаков после разделителя. Например, 12.34.
     *
     * @return float|string
     */
    public function getSubtotal();

    /**
     * Описание чека фискализации.
     *
     * @return \Rusproj\Uniteller\FiscalCheck\ReceiptInterface
     */
    public function getReceipt();

}
