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

use Rusproj\Uniteller\Cancel\CancelRequest;
use Rusproj\Uniteller\Exception\NotImplementedException;
use Rusproj\Uniteller\Http\HttpManager;
use Rusproj\Uniteller\Http\HttpManagerInterface;
use Rusproj\Uniteller\Order\Order;
use Rusproj\Uniteller\Http\LinkCreatorInterface;
use Rusproj\Uniteller\Recurrent\RecurrentRequest;
use Rusproj\Uniteller\Request\RequestInterface;
use Rusproj\Uniteller\Results\ResultsRequest;
use Rusproj\Uniteller\Signature\SignatureCallback;
use Rusproj\Uniteller\Signature\SignatureHandlerInterface;
use Rusproj\Uniteller\Signature\SignatureRecurrent;
use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Rusproj\Uniteller\Signature\SignatureHandler;
use Rusproj\Uniteller\ClassConversion\ArraybleInterface;
use Rusproj\Uniteller\Payment\PaymentLinkCreatorWithFiscalization;
use Rusproj\Uniteller\PaymentConfirm\PreauthConfirmPaymentLinkCreator;
use Rusproj\Uniteller\PaymentConfirm\PreauthConfirmPaymentRequest;

/**
 * Class Client
 *
 * @package Rusproj\Uniteller
 */
class Client implements ClientInterface
{
    /**
     * Опции запроса.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Объект, отвечающий за генерацию Uri-адресов.
     *
     * @var \Rusproj\Uniteller\Http\LinkCreatorInterface
     */
    protected $linkCreator = null;

    /**
     * Объект, отвечающий за вычисление сигнатуры параметров запроса.
     *
     * @var \Rusproj\Uniteller\Signature\SignatureHandlerInterface
     */
    protected $signatureHandler = null;

    /**
     * Объект, представляющий запрос к шлюзу.
     *
     * @var RequestInterface
     */
    protected $request = null;

    /**
     * Менеджер для выполнения запросов к шлюзу.
     *
     * @var HttpManagerInterface
     */
    protected $httpManager = null;

    /**
     * Базовый Uri платёжного шлюза.
     *
     * @param string $uri
     * @return $this
     */
    public function setBaseUri($uri)
    {
        $this->options['base_uri'] = $uri;

        return $this;
    }

    /**
     * Пароль.
     *
     * @param $value
     * @return $this
     */
    public function setPassword($value)
    {
        $this->options['password'] = $value;

        return $this;
    }

    /**
     * Идентификатор магазина в системе Uniteller.
     *
     * @param $value
     * @return $this
     */
    public function setShopId($value)
    {
        $this->options['shop_id'] = $value;

        return $this;
    }

    /**
     * Опции запроса.
     *
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * Менеджер для выполнения запросов к шлюзу.
     *
     * @param HttpManagerInterface $httpManager
     * @return $this
     */
    public function setHttpManager(HttpManagerInterface $httpManager)
    {
        $this->httpManager = $httpManager;

        return $this;
    }

    /**
     * Объект, отвечающий за генерацию Uri-адресов.
     *
     * @param \Rusproj\Uniteller\Http\LinkCreatorInterface $payment
     * @return $this
     */
    public function setLinkCreator(LinkCreatorInterface $payment)
    {
        $this->linkCreator = $payment;

        return $this;
    }

    /**
     * Объект, представляющий запрос к шлюзу.
     *
     * @param RequestInterface $cancel
     * @return $this
     */
    public function setRequest(RequestInterface $cancel)
    {
        $this->request = $cancel;

        return $this;
    }

    /**
     * Объект, отвечающий за вычисление сигнатуры параметров запроса.
     *
     * @param \Rusproj\Uniteller\Signature\SignatureHandlerInterface $signature
     * @return $this
     */
    public function registerSignatureHandler(SignatureHandlerInterface $signature)
    {
        $this->signatureHandler = $signature;

        return $this;
    }

    /**
     * Опции запроса.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Возвращает значение указанной опции запроса.
     *
     * @param string $key Ключ опции.
     * @param null|string $default Значение по-умолчанию в случае отсутствия ключа.
     * @return string|mixed
     */
    public function getOption($key, $default = null)
    {
        if (array_key_exists($key, $this->options)) {
            return $this->options[$key];
        }

        return $default;
    }

    /**
     * Базовый Uri платёжного шлюза.
     *
     * @return string
     */
    public function getBaseUri()
    {
        return $this->getOption('base_uri');
    }

    /**
     * Идентификатор магазина в системе Uniteller.
     *
     * @return string
     */
    public function getShopId()
    {
        return $this->getOption('shop_id');
    }

    /**
     * Пароль.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->getOption('password');
    }

    /**
     * Объект, отвечающий за генерацию Uri-адресов.
     *
     * @return \Rusproj\Uniteller\Http\LinkCreatorInterface
     */
    public function getLinkCreator()
    {
        return $this->linkCreator;
    }

    /**
     * Объект, представляющий запрос к шлюзу.
     *
     * @return \Rusproj\Uniteller\Request\RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Объект, отвечающий за вычисление сигнатуры параметров запроса.
     *
     * Если значение не было задано ранее, то вернёт экземпляр класса {@see \Rusproj\Uniteller\Signature\SignatureHandler}.
     *
     * @return \Rusproj\Uniteller\Signature\SignatureHandlerInterface
     */
    public function getSignatureHandler()
    {
        if (is_null($this->signatureHandler)) {
            $this->signatureHandler = new SignatureHandler();
        }
        return $this->signatureHandler;
    }

    /**
     * Менеджер для выполнения запросов к шлюзу.
     *
     * Если значение не было задано ранее, то вернёт {@see \Rusproj\Uniteller\Http\HttpManager}.
     *
     * @return \Rusproj\Uniteller\Http\HttpManagerInterface
     */
    public function getHttpManager()
    {
        if (is_null($this->httpManager)) {
            $_httpClient = new GuzzleAdapter(new GuzzleClient());
            $this->httpManager = new HttpManager($_httpClient, $this->getOptions());
        }

        return $this->httpManager;
    }

    /**
     * Генерирует Uri для перехода на страницу оплаты.
     *
     * Если не задано значение свойства SignatureHandler, то будет использован {@see \Rusproj\Uniteller\Signature\SignatureHandler}.
     * Если не задано значение свойства LinkCreator, то будет использован {@see \Rusproj\Uniteller\Payment\PaymentLinkCreatorWithFiscalization}.
     *
     * @param \Rusproj\Uniteller\Signature\SignatureFieldsInterface $parameters Параметры запроса. Для формирования параметров используйте {@see \Rusproj\Client\Payment\PaymentBuilder}.
     * @return \Rusproj\Uniteller\Http\UriInterface
     */
    public function createPaymentLink($parameters)
    {
        $_fields = $this
            ->getSignatureHandler()
            ->sign($parameters, $this->getPassword());

        $_paymentLinkCreator = $this->getLinkCreator();

        if (is_null($_paymentLinkCreator)) {
            $_paymentLinkCreator = new PaymentLinkCreatorWithFiscalization();
        }

        $_paymentLinkCreator->create($this->getBaseUri(), $_fields);
    }

    /**
     * Отправляет запрос на подтверждение платежа с преавторизацией.
     *
     * @param \Rusproj\Uniteller\Signature\SignatureFieldsInterface $parameters Параметры запроса. Для формирования параметров используйте {@see \Rusproj\Client\PaymentConfirm\PreauthConfirmBuilder}.
     * @return mixed
     */
    public function submitPreauthPayment($parameters)
    {
        $_fields = $this
            ->getSignatureHandler()
            ->sign($parameters, $this->getPassword());

        $_paymentLinkCreator = $this->getLinkCreator();
        if (is_null($_paymentLinkCreator)) {
            $_paymentLinkCreator = new PreauthConfirmPaymentLinkCreator();
        }
        $_uri = $_paymentLinkCreator->create($this->getBaseUri());

        $_request = $this->getRequest();
        if (is_null($_request)) {
            $_request = new PreauthConfirmPaymentRequest();
        }

        return $_request->execute($this->getHttpManager(), $_uri, $_fields);
    }

    /**
     * Отмена платежа.
     *
     * @param \Rusproj\Uniteller\Cancel\CancelBuilder|array $parameters
     * @return mixed
     * @internal param  $builder
     */
    public function cancel($parameters)
    {
        throw new NotImplementedException();
//         return $this->callRequestFor('cancel', $parameters);
    }

    /**
     * @param \Rusproj\Uniteller\Cancel\CancelBuilder|array $parameters
     * @return Order
     */
    public function results($parameters)
    {
        throw new NotImplementedException();
//         return $this->callRequestFor('results', $parameters);
    }

    /**
     * @param \Rusproj\Uniteller\Recurrent\RecurrentBuilder|array $parameters
     * @return mixed
     * @throws \Rusproj\Uniteller\Exception\NotImplementedException
     */
    public function recurrent($parameters)
    {
        throw new NotImplementedException();

//         $array = $this->getParameters($parameters);
//         $array['Shop_IDP'] = $this->getShopId();

//         $this->signatureRecurrent
//             ->setShopIdp(array_get($array, 'Shop_IDP'))
//             ->setOrderIdp(array_get($array, 'Order_IDP'))
//             ->setSubtotalP(array_get($array, 'Subtotal_P'))
//             ->setParentOrderIdp(array_get($array, 'Parent_Order_IDP'))
//             ->setPassword($this->getPassword());
//         if (array_get($array, 'Parent_Shop_IDP')) {
//             $this->signatureRecurrent->setParentShopIdp(array_get($array, 'Parent_Shop_IDP'));
//         }

//         $array['Signature'] = $this->signatureRecurrent->create();

//         return $this->callRequestFor('recurrent', $array);
    }

    /**
     * Подгружаем собственный HttpManager с газлом в качестве клиента, если
     * не был задан свой, перед выполнением запроса.
     *
     * @param $name
     * @param $parameters
     * @return Order|mixed
     */
    private function callRequestFor($name, $parameters)
    {
        if (! $this->getHttpManager()) {
            $httpClient = new GuzzleAdapter(new GuzzleClient());
            $this->setHttpManager(new HttpManager($httpClient, $this->getOptions()));
        }

        /** @var RequestInterface $request */
        $request = $this->{'get' . ucfirst($name) . 'Request'}();

        return $request->execute(
            $this->getHttpManager(),
            $this->getParameters($parameters)
        );
    }

    /**
     * @param $parameters
     * @return mixed
     */
    private function getParameters($parameters)
    {
        if ($parameters instanceof ArraybleInterface) {
            return $parameters->toArray();
        }

        return $parameters;
    }

    /**
     * Verify signature when Client will be send callback request.
     *
     * @param array $params
     * @return bool
     */
    public function verifyCallbackRequest(array $params)
    {
        return $this->signatureCallback
            ->setOrderId(array_get($params, 'Order_ID'))
            ->setStatus(array_get($params, 'Status'))
            ->setFields(array_except($params, ['Order_ID', 'Status', 'Signature']))
            ->setPassword($this->getPassword())
            ->verify(array_get($params, 'Signature'));
    }

}