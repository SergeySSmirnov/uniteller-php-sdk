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
class ApiBuilder implements ApiBuilderInterface
{

    /*
     * Импорт свойств с описанием идентификатора точки продажи.
     */
    use \Rusproj\Uniteller\Payment\ShopPropertiesTrait;

    /*
     * Импорт свойств с описанием номера заказа.
     */
    use \Rusproj\Uniteller\Payment\OrderPropertiesTrait;

    /*
     * Импорт свойств с описанием суммы заказа.
     */
    use \Rusproj\Uniteller\Payment\SubtotalPropertiesTrait;

    /*
     * Импорт свойств с описанием чека фискализации.
     */
    use \Rusproj\Uniteller\Payment\ReceiptPropertiesTrait;
}
