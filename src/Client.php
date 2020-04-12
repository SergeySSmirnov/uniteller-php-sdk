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
use Rusproj\Uniteller\Payment\PaymentLinkCreatorInterface;
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
use Rusproj\Uniteller\Payment\PaymentLinkCreatorWithFiscalization_V2;

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
     * Объект, отвечающий за генерацию ссылки для перехода на страницу оплаты.
     *
     * @var \Rusproj\Uniteller\Payment\PaymentLinkCreatorInterface
     */
    protected $paymentLinkCreator;

    /**
     * Объект, отвечающий за вычисление сигнатуры параметров запроса.
     *
     * @var \Rusproj\Uniteller\Signature\SignatureHandlerInterface
     */
    protected $signatureHandler;

    /**
     * @var RequestInterface
     */
    protected $cancelRequest;

    /**
     * @var RequestInterface
     */
    protected $resultsRequest;

    /**
     * @var RequestInterface
     */
    protected $recurrentRequest;

    /**
     * @var HttpManagerInterface
     */
    protected $httpManager;

    /**
     * Инициализирует экземпляр класса {@see \Rusproj\Uniteller\Client}.
     */
    public function __construct()
    {


        $this->registerCancelRequest(new CancelRequest());
        $this->registerResultsRequest(new ResultsRequest());
        $this->registerRecurrentRequest(new RecurrentRequest());
    }

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
     * @param HttpManagerInterface $httpManager
     * @return $this
     */
    public function setHttpManager(HttpManagerInterface $httpManager)
    {
        $this->httpManager = $httpManager;

        return $this;
    }

    /**
     * Объект, отвечающий за генерацию ссылки для перехода на страницу оплаты.
     *
     * @param \Rusproj\Uniteller\Payment\PaymentLinkCreatorInterface $payment
     * @return $this
     */
    public function registerPaymentLinkCreator(PaymentLinkCreatorInterface $payment)
    {
        $this->paymentLinkCreator = $payment;

        return $this;
    }

    /**
     * @param RequestInterface $cancel
     * @return $this
     */
    public function registerCancelRequest(RequestInterface $cancel)
    {
        $this->cancelRequest = $cancel;

        return $this;
    }

    /**
     * @param RequestInterface $request
     * @return $this
     */
    public function registerResultsRequest(RequestInterface $request)
    {
        $this->resultsRequest = $request;

        return $this;
    }

    /**
     * @param RequestInterface $request
     * @return $this
     */
    public function registerRecurrentRequest(RequestInterface $request)
    {
        $this->recurrentRequest = $request;

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
     * Объект, отвечающий за генерацию ссылки для перехода на страницу оплаты.
     *
     * Если значение не было задано ранее, то вернёт экземпляр класса {@see \Rusproj\Uniteller\Payment\PaymentLinkCreatorWithFiscalization_V2}.
     *
     * @return \Rusproj\Uniteller\Payment\PaymentLinkCreatorInterface
     */
    public function getPaymentLinkCreator()
    {
        if (is_null($this->paymentLinkCreator)) {
            $this->paymentLinkCreator = new PaymentLinkCreatorWithFiscalization_V2();
        }
        return $this->paymentLinkCreator;
    }

    /**
     * @return \Rusproj\Uniteller\Request\RequestInterface
     */
    public function getCancelRequest()
    {
        return $this->cancelRequest;
    }

    /**
     * @return \Rusproj\Uniteller\Request\RequestInterface
     */
    public function getResultsRequest()
    {
        return $this->resultsRequest;
    }

    /**
     * @return \Rusproj\Uniteller\Request\RequestInterface
     */
    public function getRecurrentRequest()
    {
        return $this->recurrentRequest;
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
     * @return \Rusproj\Uniteller\Http\HttpManagerInterface
     */
    public function getHttpManager()
    {
        return $this->httpManager;
    }

    /**
     * Генерирует URI для перехода на страницу оплаты.
     *
     * Если не задано значение свойства SignatureHandler, то будет использован {@see \Rusproj\Uniteller\Signature\SignatureHandler}.
     * Если не задано значение свойства PaymentLinkCreator, то будет использован {@see \Rusproj\Uniteller\Payment\PaymentLinkCreatorWithFiscalization_V2}.
     *
     * @param \Rusproj\Uniteller\Signature\SignatureFieldsInterface $parameters Параметры запроса. Для формирования параметров используйте {@see \Tmconsulting\Client\Payment\PaymentBuilder}.
     * @return \Rusproj\Uniteller\Payment\UriInterface
     */
    public function createPymentLink($parameters)
    {
        $_fields = $this
            ->getSignatureHandler()
            ->sign($parameters, $this->getPassword());

        return $this
            ->getPaymentLinkCreator()
            ->create($this->getBaseUri(), $_fields);
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
        return $this->callRequestFor('cancel', $parameters);
    }

    /**
     * @param \Rusproj\Uniteller\Cancel\CancelBuilder|array $parameters
     * @return Order
     */
    public function results($parameters)
    {
        return $this->callRequestFor('results', $parameters);
    }

    /**
     * @param \Rusproj\Uniteller\Recurrent\RecurrentBuilder|array $parameters
     * @return mixed
     * @throws \Rusproj\Uniteller\Exception\NotImplementedException
     */
    public function recurrent($parameters)
    {
        $array = $this->getParameters($parameters);
        $array['Shop_IDP'] = $this->getShopId();

        $this->signatureRecurrent
            ->setShopIdp(array_get($array, 'Shop_IDP'))
            ->setOrderIdp(array_get($array, 'Order_IDP'))
            ->setSubtotalP(array_get($array, 'Subtotal_P'))
            ->setParentOrderIdp(array_get($array, 'Parent_Order_IDP'))
            ->setPassword($this->getPassword());
        if (array_get($array, 'Parent_Shop_IDP')) {
            $this->signatureRecurrent->setParentShopIdp(array_get($array, 'Parent_Shop_IDP'));
        }

        $array['Signature'] = $this->signatureRecurrent->create();

        return $this->callRequestFor('recurrent', $array);
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Rusproj\Uniteller\Exception\NotImplementedException
     */
    public function confirm($parameters)
    {
        throw new NotImplementedException(sprintf(
            'In current moment, feature [%s] not implemented.', __METHOD__
        ));
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Rusproj\Uniteller\Exception\NotImplementedException
     */
    public function card($parameters)
    {
        throw new NotImplementedException(sprintf(
            'In current moment, feature [%s] not implemented.', __METHOD__
        ));
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