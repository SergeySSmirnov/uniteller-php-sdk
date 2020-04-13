<?php
/**
 * Created by Roquie.
 * E-mail: roquie0@gmail.com
 * GitHub: Roquie
 */

namespace Rusproj\Uniteller\Request;

use Rusproj\Uniteller\Http\HttpManagerInterface;

/**
 * Interface RequestInterface
 *
 * @package Tmconsulting\Client
 */
interface RequestInterface
{
    /**
     * Изменение статуса регистрации карты
     */
    const REQUEST_CARD      = 'card';

    /**
     * Подтверждение платежа, проведённого с преавторизацией
     */
    const REQUEST_CONFIRM   = 'confirm';

    /**
     * Рекуррентные платежи
     */
    const REQUEST_RECURRENT = 'recurrent';

    /**
     * Отмена
     */
    const REQUEST_CANCEL    = 'unblock';

    /**
     * Запрос результата авторизации.
     */
    const REQUEST_RESULTS   = 'results';

    /**
     * Выполнение запроса к шлюзу.
     *
     * @param \Rusproj\Uniteller\Http\HttpManagerInterface $httpManager
     * @param \Rusproj\Uniteller\Http\Uri $uri
     * @param array $parameters
     * @return mixed
     */
    public function execute($httpManager, $uri, array $parameters = []);
}