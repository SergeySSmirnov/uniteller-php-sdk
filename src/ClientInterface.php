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

namespace Rusproj\Uniteller;

use Rusproj\Uniteller\Order\Order;
use Rusproj\Uniteller\Http\UriInterface;

/**
 * Interface ClientInterface
 *
 * @package Rusproj\Uniteller
 */
interface ClientInterface
{

    /**
     * Генерирует URI для перехода на страницу оплаты.
     *
     * @param \Rusproj\Uniteller\Signature\SignatureFieldsInterface $parameters Параметры запроса. Для формирования параметров используйте {@see \Rusproj\Client\Payment\PaymentBuilder}.
     * @return \Rusproj\Uniteller\Http\UriInterface
     */
    public function createPymentLink($parameters);

    /**
     * @param \Rusproj\Uniteller\Cancel\CancelBuilder|array $parameters
     * @return Order
     */
    public function cancel($parameters);

    /**
     * @param \Rusproj\Uniteller\Cancel\CancelBuilder|array $parameters
     * @return Order
     */
    public function results($parameters);

    /**
     * @param array $parameters
     * @return mixed
     */
    public function recurrent($parameters);

    /**
     * @param array $parameters
     * @return mixed
     */
    public function confirm($parameters);

    /**
     * @param array $parameters
     * @return mixed
     */
    public function card($parameters);

    /**
     * Verify signature when Client will be send callback request.
     *
     * @param array $params
     * @return bool
     */
    public function verifyCallbackRequest(array $params);
}
