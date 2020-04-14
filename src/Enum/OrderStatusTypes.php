<?php
namespace Rusproj\Uniteller\Enum;

/**
 * Статусы платежей.
 *
 * @package Rusproj\Uniteller\Enum
 */
final class OrderStatusTypes
{

    /**
     * Средства успешно заблокированы (выполнена авторизационная транзакция).
     *
     * @var string
     */
    const AUTHORIZED = 'authorized';

    /**
     * Оплачен (выполнена финансовая транзакция или заказ оплачен в электронной платёжной системе).
     *
     * @var string
     */
    const PAID = 'paid';

    /**
     * Ожидается оплата выставленного счёта. Статус используется только для оплат электронными валютами,
     * при которых процесс оплаты может содержать этап выставления через систему Client счёта на оплату
     * и этап фактической оплаты этого счёта Покупателем, которые существенно разнесённы во времени.
     *
     * @var string
     */
    const WAITING = 'waiting';

    /**
     * Отменён (выполнена транзакция разблокировки средств или выполнена операция по возврату
     * платежа после списания средств).
     *
     * @var string
     */
    const CANCELLED = 'canceled';

    /**
     * Преобразует текстовое представление статуса оплаты в константу.
     *
     * @param string $status Статус, который необходимо разрешить.
     * @return string
     */
    public static function ResolveFromPaymentStatus($status) {
        switch (mb_strtolower($status)) {
            case 'authorized':
                return self::AUTHORIZED;
            case 'paid':
                return self::PAID;
            case 'canceled':
                return self::CANCELLED;
            case 'waiting':
                return self::WAITING;
            default:
                return '';
        }
    }

}
