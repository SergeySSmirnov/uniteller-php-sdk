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

namespace Tmconsulting\Uniteller;

use Tmconsulting\Uniteller\Cancel\CancelRequest;
use Tmconsulting\Uniteller\Exception\NotImplementedException;
use Tmconsulting\Uniteller\Http\HttpManager;
use Tmconsulting\Uniteller\Http\HttpManagerInterface;
use Tmconsulting\Uniteller\Order\Order;
use Tmconsulting\Uniteller\Payment\Payment;
use Tmconsulting\Uniteller\Payment\PaymentInterface;
use Tmconsulting\Uniteller\Recurrent\RecurrentRequest;
use Tmconsulting\Uniteller\Request\RequestInterface;
use Tmconsulting\Uniteller\Results\ResultsRequest;
use Tmconsulting\Uniteller\Signature\SignatureCallback;
use Tmconsulting\Uniteller\Signature\SignatureHandlerInterface;
use Tmconsulting\Uniteller\Signature\SignatureRecurrent;
use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Tmconsulting\Uniteller\Signature\SignatureHandler;
use Tmconsulting\Uniteller\ClassConversion\ArraybleInterface;

/**
 * Class Client
 *
 * @package Tmconsulting\Uniteller
 */
class Client implements ClientInterface, ClientGatewayConfigInterface
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var PaymentInterface
     */
    protected $payment;

    /**
     * @var SignatureHandlerInterface
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
     * Client constructor.
     */
    public function __construct()
    {
        $this->registerSignatureHandler(new SignatureHandler());
        $this->registerPayment(new Payment());

        $this->registerCancelRequest(new CancelRequest());
        $this->registerResultsRequest(new ResultsRequest());
        $this->registerRecurrentRequest(new RecurrentRequest());

    }

    /**
     * Устанавливает значение базового Uri платёжного шлюза.
     * @param string $uri Uri платёжного шлюза.
     * @return $this
     */
    public function setBaseUri($uri)
    {
        $this->options['base_uri'] = $uri;

        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setPassword($value)
    {
        $this->options['password'] = $value;

        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setShopId($value)
    {
        $this->options['shop_id'] = $value;

        return $this;
    }

    /**
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
     * Регистрирует объект, отвечающий за генерацию ссылки для перехода на страницу оплаты.
     *
     * @param PaymentInterface $payment
     * @return $this
     */
    public function registerPayment(PaymentInterface $payment)
    {
        $this->payment = $payment;

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
     * Осуществляет регистрацию объекта, отвечающего за вычисление сигнатуры параметров запроса.
     *
     * @param \Tmconsulting\Uniteller\Signature\SignatureHandlerInterface $signature
     * @return $this
     */
    public function registerSignatureHandler(SignatureHandlerInterface $signature)
    {
        $this->signatureHandler = $signature;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param $key
     * @param null $default
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
     * Возвращает Uri платёжного шлюза.
     * @return string
     */
    public function getBaseUri()
    {
        return $this->getOption('base_uri');
    }

    /**
     * @return string
     */
    public function getShopId()
    {
        return $this->getOption('shop_id');
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->getOption('password');
    }

    /**
     * Возвращает объект, отвечающий за генерацию ссылки для перехода на страницу оплаты.
     *
     * @return \Tmconsulting\Uniteller\Payment\PaymentInterface
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @return \Tmconsulting\Uniteller\Request\RequestInterface
     */
    public function getCancelRequest()
    {
        return $this->cancelRequest;
    }

    /**
     * @return \Tmconsulting\Uniteller\Request\RequestInterface
     */
    public function getResultsRequest()
    {
        return $this->resultsRequest;
    }

    /**
     * @return \Tmconsulting\Uniteller\Request\RequestInterface
     */
    public function getRecurrentRequest()
    {
        return $this->recurrentRequest;
    }

    /**
     * Возвращает объект, отвечающий за генерацию сигнатуры параметров запроса.
     *
     * @return \Tmconsulting\Uniteller\Signature\SignatureHandlerInterface
     */
    public function getSignatureHandler()
    {
        return $this->signatureHandler;
    }

    /**
     * @return \Tmconsulting\Uniteller\Http\HttpManagerInterface
     */
    public function getHttpManager()
    {
        return $this->httpManager;
    }

    /**
     * {@inheritDoc}
     * @see \Tmconsulting\Uniteller\ClientInterface::payment()
     */
    public function payment($parameters)
    {
        $_fields = $this
            ->getSignatureHandler()
            ->sign($parameters, $this->getPassword());

        return $this
            ->getPayment()
            ->execute($_fields, $this);
    }

    /**
     * Отмена платежа.
     *
     * @param \Tmconsulting\Uniteller\Cancel\CancelBuilder|array $parameters
     * @return mixed
     * @internal param  $builder
     */
    public function cancel($parameters)
    {
        return $this->callRequestFor('cancel', $parameters);
    }

    /**
     * @param \Tmconsulting\Uniteller\Cancel\CancelBuilder|array $parameters
     * @return Order
     */
    public function results($parameters)
    {
        return $this->callRequestFor('results', $parameters);
    }

    /**
     * @param \Tmconsulting\Uniteller\Recurrent\RecurrentBuilder|array $parameters
     * @return mixed
     * @throws \Tmconsulting\Uniteller\Exception\NotImplementedException
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
     * @throws \Tmconsulting\Uniteller\Exception\NotImplementedException
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
     * @throws \Tmconsulting\Uniteller\Exception\NotImplementedException
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