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

namespace Tmconsulting\Uniteller\Payment;

use Tmconsulting\Uniteller\ArraybleInterface;
use Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException;

/**
 * Параметры запроса для генерации ссылки для оплаты.
 *
 * @package Tmconsulting\Client\Payment
 */
class PaymentBuilder implements ArraybleInterface
{
    /**
     * Идентификатор точки продажи в системе Uniteller.
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
     * @var string
     */
    protected $shopIdp;

    /**
     * Номер заказа в системе расчётов интернет-магазина, соответствующий
     * данному платежу. Может быть любой непустой строкой максимальной
     * длиной 127 символов, не может содержать только пробелы.
     *
     * Значение Order_IDP должно быть уникальным для всех оплаченных
     * заказов (заказов, по которым успешно прошла блокировка средств) в
     * рамках одного магазина (одной точки продажи). Пока по заказу не
     * проведена блокировка средств (авторизация), допускается несколько
     * запросов с одинаковым Order_IDP (например, несколько попыток
     * оплаты одного и того же заказа). При использовании электронных валют
     * номер заказа должен быть уникальным для каждого запроса на оплату.
     *
     * @var string
     */
    protected $orderIdp;

    /**
     * Сумма покупки в валюте, оговоренной в договоре с банком-эквайером.
     * В качестве десятичного разделителя используется точка,
     * не более 2 знаков после разделителя. Например, 12.34.
     *
     * @var float|string
     */
    protected $subtotalP;

    /**
     * Подпись, гарантирующая неизменность критичных данных оплаты (суммы, Order_IDP).
     *
     * @var string
     */
    protected $signature;

    /**
     * URL страницы, на которую должен вернуться Покупатель
     * после успешного осуществления платежа в системе Client.
     *
     * @var string
     */
    protected $urlReturnOk;

    /**
     * URL страницы, на которую должен вернуться Покупатель
     * после неуспешного осуществления платежа в системе.
     *
     * @var string
     */
    protected $urlReturnNo;

    /**
     * Валюта платежа. Параметр обязателен для точек продажи, работающих c
     * валютой, отличной от российского рубля. Для оплат в российских рублях
     * параметр необязательный.
     *
     * Для указания значения используйте {@see \Tmconsulting\Uniteller\Enums\CurrencyTypes}.
     *
     * @var string
     */
    protected $currency;

    /**
     * Признак того, что платёж является «родительским» для последующих
     * рекуррентных платежей. Может принимать значение “1”.
     *
     * Примечание: обязателен для рекуррентных платежей при работе с
     * банком-эквайером ВТБ.
     *
     * @var bool
     */
    protected $IsRecurrentStart;

    /**
     * [* Опционально]
     * Адрес электронной почты.
     *
     * Параметры Email, Phone, переданные в запросе на оплату от сайта Мерчанта, автоматически
     * подставляются в соответствующие поля (скрытые) формы оплаты и не могут быть изменены
     * Покупателем (поведение устанавливается в Личном кабинете Uniteller на странице свойств Точки
     * продажи в настройках шаблона страницы оплаты). Если эти поля от Мерчанта не переданы, то
     * соответствующие им поля видны на странице оплаты и доступны для редактирования.
     *
     * Если процесс покупки и форма оплаты на сайте Мерчанта предусматривают заполнение
     * Покупателем поля Email, в целях повышения эффективности противодействия мошенническим
     * операциям рекомендуется передавать этот параметр в запросе на оплату. Не допускается
     * использовать один и тот же e-mail-адрес во всех запросах. Если алгоритм работы клиента не
     * предполагает передачу параметра Email, рекомендуется дополнительно согласовать с Uniteller
     * включение мерчанта в специальную группу правил фрод-мониторинга.
     *
     * @var string
     */
    protected $email;

    /**
     * [* Опционально]
     * Время жизни формы оплаты в секундах, начиная с момента её показа.
     * Должно быть целым положительным числом. Если Покупатель
     * использует форму дольше указанного времени, то форма оплаты будет
     * считаться устаревшей, и платёж не будет принят. Покупателю в этом
     * случае будет предложено вернуться на сайт Мерчанта для повторного
     * выполнения заказа.
     *
     * Значение параметра рекомендуется устанавливать не более 300 сек.
     *
     * @var int
     */
    protected $lifetime;

    /**
     * [* Опционально]
     * Время жизни (в секундах) заказа на оплату банковской картой, начиная с
     * момента первого вывода формы оплаты.
     *
     * Должно быть целым положительным числом. Если Покупатель пытается
     * оплатить заказ после истечения периода, указанного в OrderLifetime, то
     * платёж не будет принят. Покупателю в этом случае будет показано
     * сообщение: «Данный заказ не может быть оплачен. Заказ устарел.
     * Обратитесь к мерчанту».
     *
     * @var int
     */
    protected $orderLifetime;

    /**
     * [* Опционально]
     * Идентификатор Покупателя, используемый некоторыми интернет-магазинами.
     *
     * @var string
     */
    protected $customerIdp;

    /**
     * [* Опционально]
     * Идентификатор зарегистрированной карты.
     *
     * @var string
     */
    protected $cardIdp;

    /**
     * [* Опционально]
     * Тип платежа. Произвольная строка длиной до десяти символов включительно.
     * В подавляющем большинстве схем подключения интернет-магазинов этот параметр не используется.
     *
     * @var string
     */
    protected $ptCode;

    /**
     * [* Опционально]
     * Платёжная система кредитной карты.
     *
     * Для указания значения используйте {@see \Tmconsulting\Uniteller\Enums\MeanTypes}.
     *
     * @var integer
     */
    protected $meanType;

    /**
     * [* Опционально]
     * Тип электронной валюты.
     *
     * Для указания значения используйте {@see \Tmconsulting\Uniteller\Enums\EMoneyTypes}.
     *
     * @var integer
     */
    protected $eMoneyType;

    /**
     * [* Опционально]
     * Срок жизни заказа оплаты в электронной платёжной системе в часах (от 1 до 1080 часов).
     * Значение параметра BillLifetime учитывается только для QIWI-платежей.
     * Если BillLifetime не передаётся, то для QIWI-платежа срок жизни заказа на
     * оплату устанавливается по умолчанию — 72 часа.
     *
     * @var integer
     */
    protected $billLifetime;

    /**
     * [* Опционально]
     * Признак преавторизации платежа.
     * При использовании в запросе должен принимать значение “1”.
     *
     * @var bool
     */
    protected $preAuth;

    /**
     * [* Опционально]
     * Список дополнительных полей, передаваемых в уведомлении об изменении статуса заказа.
     * Строка, не более 29 символов. Поля должны быть разделены пробелами.
     *
     * Возможные значения: AcquirerID, ApprovalCode, BillNumber, Card_IDP, CardNumber, Customer_IDP, ECI, EMoneyType, PaymentType, Total.
     *
     * @var array
     */
    protected $callbackFields;

    /**
     * [* Опционально]
     * Запрашиваемый формат уведомления о статусе оплаты.
     * Eсли параметр имеет значение "json", то уведомление направляется
     * в json-формате. Во всех остальных случаях уведомление направляется в виде POST-запроса.
     *
     * @var string
     */
    protected $callbackFormat;

    /**
     * [* Опционально]
     * Код языка интерфейса платёжной страницы. Может быть en или ru.
     *
     * @var string
     */
    protected $language;

    /**
     * [* Опционально]
     * Комментарий к платежу (при использовании кириллицы использовать кодировку UTF-8).
     *
     * @var string
     */
    protected $comment;

    /**
     * [* Опционально]
     * Имя Покупателя, переданное с сайта Мерчанта (при использовании кириллицы использовать кодировку UTF-8).
     *
     * @var string
     */
    protected $firstName;

    /**
     * [* Опционально]
     * Фамилия Покупателя, переданная с сайта Мерчанта (при использовании кириллицы использовать кодировку UTF-8).
     *
     * @vars string
     */
    protected $lastName;

    /**
     * [* Опционально]
     * Отчество (при использовании кириллицы использовать кодировку UTF-8).
     *
     * @var string
     */
    protected $middleName;

    /**
     * [* Опционально]
     * Телефон (при использовании кириллицы использовать кодировку UTF-8).
     *
     * @var string
     */
    protected $phone;

    /**
     * [* Опционально]
     * Верифицированный мерчантом номер телефона.
     * Если передаётся, то значение Phone устанавливается равным PhoneVerified.
     * (при использовании кириллицы использовать кодировку UTF-8)
     *
     * @var string
     */
    protected $phoneVerified;

    /**
     * [* Опционально]
     * Адрес (при использовании кириллицы использовать кодировку UTF-8) (в стандартном шаблоне в настоящее время не используется).
     *
     * @var string
     */
    protected $address;

    /**
     * [* Опционально]
     * Название страны Покупателя (при использовании кириллицы использовать кодировку UTF-8) (в стандартном шаблоне в настоящее время не используется).
     *
     * @var string
     */
    protected $country;

    /**
     * [* Опционально]
     * Код штата/региона.
     *
     * @var string
     */
    protected $state;

    /**
     * [* Опционально]
     * Город (при использовании кириллицы использовать кодировку UTF-8) (в стандартном шаблоне в настоящее время не используется).
     *
     * @var string
     */
    protected $city;

    /**
     * [* Опционально]
     * Почтовый индекс.
     *
     * @var
     */
    protected $zip;

    /**
     * Задаёт идентификатор точки продажи в системе Uniteller.
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
     * @param string $shopIdp Идентификатор точки продажи в системе Uniteller.
     * @return $this
     */
    public function setShopIdp($shopIdp)
    {
        $this->shopIdp = $shopIdp;

        return $this;
    }

    /**
     * Устанавливает номер заказа в системе расчётов интернет-магазина, соответствующий
     * данному платежу. Может быть любой непустой строкой максимальной
     * длиной 127 символов, не может содержать только пробелы.
     *
     * Значение Order_IDP должно быть уникальным для всех оплаченных
     * заказов (заказов, по которым успешно прошла блокировка средств) в
     * рамках одного магазина (одной точки продажи). Пока по заказу не
     * проведена блокировка средств (авторизация), допускается несколько
     * запросов с одинаковым Order_IDP (например, несколько попыток
     * оплаты одного и того же заказа). При использовании электронных валют
     * номер заказа должен быть уникальным для каждого запроса на оплату.
     *
     * @param string $orderIdp Номер заказа.
     * @return $this
     * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 127 символов.
     */
    public function setOrderIdp($orderIdp)
    {
        if (strlen($orderIdp) > 127)
        {
            throw new BuilderIncorrectValueException("Wrong: OrderIdp = '{$orderIdp}'. Expected length of the OrderIdp <= 127.");
        }

        $this->orderIdp = $orderIdp;

        return $this;
    }

    /**
     * Возвращает сумму покупки в валюте, оговоренной в договоре с банком-эквайером.
     * В качестве десятичного разделителя используется точка,
     * не более 2 знаков после разделителя. Например, 12.34
     *
     * @param float|string $subtotalP Сумма оплаты.
     * @return $this
     */
    public function setSubtotalP($subtotalP)
    {
        $this->subtotalP = $subtotalP;

        return $this;
    }

    /**
     * Возвращает подпись, гарантирующую неизменность критичных данных оплаты (суммы, Order_IDP).
     *
     * @param string $signature
     * @return $this
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * Задаёт URL страницы, на которую должен вернуться Покупатель
     * после успешного осуществления платежа в системе Client.
     *
     * @param string $urlReturnOk URL страницы.
     * @return $this
     */
    public function setUrlReturnOk($urlReturnOk)
    {
        $this->urlReturnOk = $urlReturnOk;

        return $this;
    }

    /**
     * Задаёт URL страницы, на которую должен вернуться Покупатель
     * после неуспешного осуществления платежа в системе.
     *
     * @param string $urlReturnNo URL страницы.
     * @return $this
     */
    public function setUrlReturnNo($urlReturnNo)
    {
        $this->urlReturnNo = $urlReturnNo;

        return $this;
    }

    /**
     * Задаёт валюту платежа. Параметр обязателен для точек продажи, работающих с
     * валютой, отличной от российского рубля. Для оплат в российских рублях
     * параметр необязательный.
     *
     * Для указания значения параметра используйте {@see \Tmconsulting\Uniteller\Enums\CurrencyTypes}.
     *
     * @param integer $currency Валюта платежа.
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * [* Опционально]
     * Адрес электронной почты.
     *
     * Параметры Email, Phone, переданные в запросе на оплату от сайта Мерчанта, автоматически
     * подставляются в соответствующие поля (скрытые) формы оплаты и не могут быть изменены
     * Покупателем (поведение устанавливается в Личном кабинете Uniteller на странице свойств Точки
     * продажи в настройках шаблона страницы оплаты). Если эти поля от Мерчанта не переданы, то
     * соответствующие им поля видны на странице оплаты и доступны для редактирования.
     *
     * Если процесс покупки и форма оплаты на сайте Мерчанта предусматривают заполнение
     * Покупателем поля Email, в целях повышения эффективности противодействия мошенническим
     * операциям рекомендуется передавать этот параметр в запросе на оплату. Не допускается
     * использовать один и тот же e-mail-адрес во всех запросах. Если алгоритм работы клиента не
     * предполагает передачу параметра Email, рекомендуется дополнительно согласовать с Uniteller
     * включение мерчанта в специальную группу правил фрод-мониторинга.
     *
     * @param string $email
     * @return $this
     * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 64 символов.
     */
    public function setEmail($email)
    {
        if (strlen($email) > 64)
        {
            throw new BuilderIncorrectValueException("Wrong: OrderIdp = '{$email}'. Expected length of the OrderIdp <= 64.");
        }

        $this->email = $email;

        return $this;
    }

    /**
     * [* Опционально]
     * Время жизни формы оплаты в секундах, начиная с момента её показа.
     * Должно быть целым положительным числом. Если Покупатель
     * использует форму дольше указанного времени, то форма оплаты будет
     * считаться устаревшей, и платёж не будет принят. Покупателю в этом
     * случае будет предложено вернуться на сайт Мерчанта для повторного
     * выполнения заказа.
     *
     * Значение параметра рекомендуется устанавливать не более 300 сек.
     *
     * @param integer $lifetime
     * @return $this
     */
    public function setLifetime($lifetime)
    {
        $this->lifetime = $lifetime;

        return $this;
    }

    /**
     * [* Опционально]
     * Время жизни (в секундах) заказа на оплату банковской картой, начиная с
     * момента первого вывода формы оплаты.
     *
     * Должно быть целым положительным числом. Если Покупатель пытается
     * оплатить заказ после истечения периода, указанного в OrderLifetime, то
     * платёж не будет принят. Покупателю в этом случае будет показано
     * сообщение: «Данный заказ не может быть оплачен. Заказ устарел.
     * Обратитесь к мерчанту».
     *
     * @param integer $orderLifetime
     * @return $this
     * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра < 0 символов.
     */
    public function setOrderLifetime($orderLifetime)
    {
        if ($orderLifetime <= 0)
        {
            throw new BuilderIncorrectValueException("Wrong: orderLifetime = '{$orderLifetime}'. Expected orderLifetime > 0.");
        }

        $this->orderLifetime = $orderLifetime;

        return $this;
    }

    /**
     * [* Опционально]
     * Идентификатор Покупателя, используемый некоторыми интернет-магазинами.
     *
     * @param string $customerIdp
     * @return $this
     * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 64 символов.
     */
    public function setCustomerIdp($customerIdp)
    {
        if (strlen($customerIdp) > 64)
        {
            throw new BuilderIncorrectValueException("Wrong: customerIdp = '{$customerIdp}'. Expected length of the customerIdp <= 64.");
        }

        $this->customerIdp = $customerIdp;

        return $this;
    }

    /**
     * [* Опционально]
     * Идентификатор зарегистрированной карты.
     *
     * @param string $cardIdp
     * @return $this
     * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 64 символов.
     */
    public function setCardIdp($cardIdp)
    {
        if (strlen($cardIdp) > 64)
        {
            throw new BuilderIncorrectValueException("Wrong: cardIdp = '{$cardIdp}'. Expected length of the cardIdp <= 64.");
        }

        $this->cardIdp = $cardIdp;

        return $this;
    }

    /**
     * [* Опционально]
     * Тип платежа. Произвольная строка длиной до десяти символов включительно.
     * В подавляющем большинстве схем подключения интернет-магазинов этот параметр не используется.
     *
     * @param string $ptCode
     * @return $this
     */
    public function setPtCode($ptCode)
    {
        $this->ptCode = $ptCode;

        return $this;
    }

    /**
     * [* Опционально]
     * Платёжная система кредитной карты.
     *
     * Для указания значения параметра используйте {@see \Tmconsulting\Uniteller\Enums\MeanTypes}.
     *
     * @param integer $meanType
     * @return $this
     */
    public function setMeanType($meanType)
    {
        $this->meanType = $meanType;

        return $this;
    }

    /**
     * [* Опционально]
     * Тип электронной валюты.
     *
     * Для указания значения параметра используйте {@see \Tmconsulting\Uniteller\Enums\EMoneyTypes}.
     *
     * @param integer $eMoneyType
     * @return $this
     */
    public function setEMoneyType($eMoneyType)
    {
        $this->eMoneyType = $eMoneyType;

        return $this;
    }

    /**
     * [* Опционально]
     * Срок жизни заказа оплаты в электронной платёжной системе в часах (от 1 до 1080 часов).
     * Значение параметра BillLifetime учитывается только для QIWI-платежей.
     * Если BillLifetime не передаётся, то для QIWI-платежа срок жизни заказа на
     * оплату устанавливается по умолчанию — 72 часа.
     *
     * @param integer $billLifetime
     * @return $this
     * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 1080 символов.
     */
    public function setBillLifetime($billLifetime)
    {
        if ($billLifetime > 1080 || $billLifetime < 1)
        {
            throw new BuilderIncorrectValueException("Wrong: billLifetime = '{$billLifetime}'. Expected 1 <= billLifetime <= 1080.");
        }

        $this->billLifetime = $billLifetime;

        return $this;
    }

    /**
     * [* Опционально]
     * Признак преавторизации платежа.
     * При использовании в запросе должен принимать значение “1”.
     *
     * @return $this
     */
    public function usePreAuth()
    {
        $this->preAuth = true;

        return $this;
    }

    /**
     * Устанавливает признак того, что платёж является «родительским» для последующих
     * рекуррентных платежей. Может принимать значение “1”.
     *
     * Примечание: обязателен для рекуррентных платежей при работе с
     * банком-эквайером ВТБ.
     *
     * @return bool
     */
    public function useRecurrentPayment()
    {
        $this->IsRecurrentStart = true;

        return $this;
    }

    /**
     * [* Опционально]
     * Список дополнительных полей, передаваемых в уведомлении об изменении статуса заказа.
     * Строка, не более 29 символов. Поля должны быть разделены пробелами.
     *
     * Возможные значения: AcquirerID, ApprovalCode, BillNumber, Card_IDP, CardNumber, Customer_IDP, ECI, EMoneyType, PaymentType, Total.
     *
     * @param array $callbackFields
     * @return $this
     */
    public function setCallbackFields(array $callbackFields)
    {
        $this->callbackFields = join(' ', $callbackFields);

        return $this;
    }

    /**
     * [* Опционально]
     * Запрашиваемый формат уведомления о статусе оплаты.
     * Eсли параметр имеет значение "json", то уведомление направляется
     * в json-формате. Во всех остальных случаях уведомление направляется в виде POST-запроса.
     *
     * @param string $callbackFormat
     * @return $this
     */
    public function setCallbackFormat($callbackFormat)
    {
        $this->callbackFormat = $callbackFormat;

        return $this;
    }

    /**
     * [* Опционально]
     * Код языка интерфейса платёжной страницы. Может быть en или ru.
     *
     * @param string $language
     * @return $this
     * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 2 символов.
     */
    public function setLanguage($language)
    {
        if (strlen($language) != 2)
        {
            throw new BuilderIncorrectValueException("Wrong: language = '{$language}'. Expected length of the language == 2.");
        }

        $this->language = $language;

        return $this;
    }

    /**
     * [* Опционально]
     * Комментарий к платежу (при использовании кириллицы использовать кодировку UTF-8).
     *
     * @param string $comment
     * @return $this
     * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 1024 символов.
     */
    public function setComment($comment)
    {
        if (strlen($comment) > 1024)
        {
            throw new BuilderIncorrectValueException("Wrong: comment = '{$comment}'. Expected length of the comment <= 1024.");
        }

        $this->comment = $comment;

        return $this;
    }

    /**
     * [* Опционально]
     * Имя Покупателя, переданное с сайта Мерчанта (при использовании кириллицы использовать кодировку UTF-8).
     *
     * @param string $firstName
     * @return $this
     * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 64 символов.
     */
    public function setFirstName($firstName)
    {
        if (strlen($firstName) > 64)
        {
            throw new BuilderIncorrectValueException("Wrong: firstName = '{$firstName}'. Expected length of the firstName <= 64.");
        }

        $this->firstName = $firstName;

        return $this;
    }

    /**
     * [* Опционально]
     * Фамилия Покупателя, переданная с сайта Мерчанта (при использовании кириллицы использовать кодировку UTF-8).
     *
     * @param string $lastName
     * @return $this
     * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 64 символов.
     */
    public function setLastName($lastName)
    {
        if (strlen($lastName) > 64)
        {
            throw new BuilderIncorrectValueException("Wrong: lastName = '{$lastName}'. Expected length of the lastName <= 64.");
        }

        $this->lastName = $lastName;

        return $this;
    }

    /**
     * [* Опционально]
     * Отчество (при использовании кириллицы использовать кодировку UTF-8).
     *
     * @param string $middleName
     * @return $this
     * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 64 символов.
     */
    public function setMiddleName($middleName)
    {
        if (strlen($middleName) > 64)
        {
            throw new BuilderIncorrectValueException("Wrong: middleName = '{$middleName}'. Expected length of the middleName <= 64.");
        }

        $this->middleName = $middleName;

        return $this;
    }

    /**
     * [* Опционально]
     * Телефон (при использовании кириллицы использовать кодировку UTF-8).
     *
     * @param string $phone
     * @return $this
     * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 64 символов.
     */
    public function setPhone($phone)
    {
        if (strlen($phone) > 64)
        {
            throw new BuilderIncorrectValueException("Wrong: phone = '{$phone}'. Expected length of the phone <= 64.");
        }

        $this->phone = $phone;

        return $this;
    }

    /**
    * [* Опционально]
    * Верифицированный мерчантом номер телефона.
    * Если передаётся, то значение Phone устанавливается равным PhoneVerified.
    * (при использовании кириллицы использовать кодировку UTF-8)
    *
    * @param string $phone
    * @return $this
    * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 64 символов.
    */
    public function setPhoneVerified($phone)
    {
        if (strlen($phone) > 64)
        {
            throw new BuilderIncorrectValueException("Wrong: phone = '{$phone}'. Expected length of the phone <= 64.");
        }

        $this->phone = $phone;
        $this->phoneVerified = $phone;

        return $this;
    }


    /**
     * [* Опционально]
     * Адрес (при использовании кириллицы использовать кодировку UTF-8) (в стандартном шаблоне в настоящее время не используется).
     *
     * @param string $address
     * @return $this
     * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 128 символов.
     */
    public function setAddress($address)
    {
        if (strlen($address) > 128)
        {
            throw new BuilderIncorrectValueException("Wrong: address = '{$address}'. Expected length of the address <= 128.");
        }

        $this->address = $address;

        return $this;
    }

    /**
     * [* Опционально]
     * Название страны Покупателя (при использовании кириллицы использовать кодировку UTF-8) (в стандартном шаблоне в настоящее время не используется).
     *
     * @param string $country
     * @return $this
     * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 64 символов.
     */
    public function setCountry($country)
    {
        if (strlen($country) > 64)
        {
            throw new BuilderIncorrectValueException("Wrong: country = '{$country}'. Expected length of the country <= 64.");
        }

        $this->country = $country;

        return $this;
    }

    /**
     * [* Опционально]
     * Код штата/региона.
     *
     * @param string $state
     * @return $this
     * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 3 символов.
     */
    public function setState($state)
    {
        if (strlen($state) > 3)
        {
            throw new BuilderIncorrectValueException("Wrong: state = '{$state}'. Expected length of the state <= 3.");
        }

        $this->state = $state;

        return $this;
    }

    /**
     * [* Опционально]
     * Город (при использовании кириллицы использовать кодировку UTF-8) (в стандартном шаблоне в настоящее время не используется).
     *
     * @param string $city
     * @return $this
     * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 64 символов.
     */
    public function setCity($city)
    {
        if (strlen($city) > 64)
        {
            throw new BuilderIncorrectValueException("Wrong: city = '{$city}'. Expected length of the city <= 64.");
        }

        $this->city = $city;

        return $this;
    }

    /**
     * [* Опционально]
     * Почтовый индекс.
     *
     * @param string $zip
     * @return $this
     * @throws \Tmconsulting\Uniteller\Exception\BuilderIncorrectValueException Исключение генерируется в том случае, если длина значения параметра > 64 символов.
     */
    public function setZip($zip)
    {
        if (strlen($zip) > 64)
        {
            throw new BuilderIncorrectValueException("Wrong: zip = '{$zip}'. Expected length of the  zip <= 64.");
        }

        $this->zip = $zip;

        return $this;
    }

    /* Getters */

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
    public function getShopIdp()
    {
        return $this->shopIdp;

        return $this;
    }

    /**
     * Возвращает номер заказа в системе расчётов интернет-магазина, соответствующий
     * данному платежу. Может быть любой непустой строкой максимальной
     * длиной 127 символов, не может содержать только пробелы.
     *
     * Значение Order_IDP должно быть уникальным для всех оплаченных
     * заказов (заказов, по которым успешно прошла блокировка средств) в
     * рамках одного магазина (одной точки продажи). Пока по заказу не
     * проведена блокировка средств (авторизация), допускается несколько
     * запросов с одинаковым Order_IDP (например, несколько попыток
     * оплаты одного и того же заказа). При использовании электронных валют
     * номер заказа должен быть уникальным для каждого запроса на оплату.
     *
     * @return string
     */
    public function getOrderIdp()
    {
        return $this->orderIdp;

        return $this;
    }

    /**
     * Возвращает сумму покупки в валюте, оговоренной в договоре с банком-эквайером.
     * В качестве десятичного разделителя используется точка,
     * не более 2 знаков после разделителя. Например, 12.34.
     *
     * @return float|string
     */
    public function getSubtotalP()
    {
        return $this->subtotalP;

        return $this;
    }

    /**
     * Возвращает подпись, гарантирующую неизменность критичных данных оплаты (суммы, Order_IDP).
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * Возвращает URL страницы, на которую должен вернуться Покупатель
     * после успешного осуществления платежа в системе Client.
     *
     * @return string
     */
    public function getUrlReturnOk()
    {
        return $this->urlReturnOk;
    }

    /**
     * Возвращает URL страницы, на которую должен вернуться Покупатель
     * после неуспешного осуществления платежа в системе.
     *
     * @return string
     */
    public function getUrlReturnNo()
    {
        return $this->urlReturnNo;
    }

    /**
     * Возвращает валюту платежа. Параметр обязателен для точек продажи, работающих c
     * валютой, отличной от российского рубля. Для оплат в российских рублях
     * параметр необязательный.
     *
     * Возвращаемое значение соответствует значению перечисления {@see \Tmconsulting\Uniteller\Enums\CurrencyTypes}.
     *
     * @return integer
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * [* Опционально]
     * Адрес электронной почты.
     *
     * Параметры Email, Phone, переданные в запросе на оплату от сайта Мерчанта, автоматически
     * подставляются в соответствующие поля (скрытые) формы оплаты и не могут быть изменены
     * Покупателем (поведение устанавливается в Личном кабинете Uniteller на странице свойств Точки
     * продажи в настройках шаблона страницы оплаты). Если эти поля от Мерчанта не переданы, то
     * соответствующие им поля видны на странице оплаты и доступны для редактирования.
     *
     * Если процесс покупки и форма оплаты на сайте Мерчанта предусматривают заполнение
     * Покупателем поля Email, в целях повышения эффективности противодействия мошенническим
     * операциям рекомендуется передавать этот параметр в запросе на оплату. Не допускается
     * использовать один и тот же e-mail-адрес во всех запросах. Если алгоритм работы клиента не
     * предполагает передачу параметра Email, рекомендуется дополнительно согласовать с Uniteller
     * включение мерчанта в специальную группу правил фрод-мониторинга.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * [* Опционально]
     * Время жизни формы оплаты в секундах, начиная с момента её показа.
     * Должно быть целым положительным числом. Если Покупатель
     * использует форму дольше указанного времени, то форма оплаты будет
     * считаться устаревшей, и платёж не будет принят. Покупателю в этом
     * случае будет предложено вернуться на сайт Мерчанта для повторного
     * выполнения заказа.
     *
     * Значение параметра рекомендуется устанавливать не более 300 сек.
     *
     * @return integer
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * [* Опционально]
     * Время жизни (в секундах) заказа на оплату банковской картой, начиная с
     * момента первого вывода формы оплаты.
     *
     * Должно быть целым положительным числом. Если Покупатель пытается
     * оплатить заказ после истечения периода, указанного в OrderLifetime, то
     * платёж не будет принят. Покупателю в этом случае будет показано
     * сообщение: «Данный заказ не может быть оплачен. Заказ устарел.
     * Обратитесь к мерчанту».
     *
     * @return integer
     */
    public function getOrderLifetime()
    {
        return $this->orderLifetime;
    }


    /**
     * [* Опционально]
     * Идентификатор Покупателя, используемый некоторыми интернет-магазинами.
     *
     * @return string
     */
    public function getCustomerIdp()
    {
        return $this->customerIdp;
    }

    /**
     * [* Опционально]
     * Идентификатор зарегистрированной карты.
     *
     * @return string
     */
    public function getCardIdp()
    {
        return $this->cardIdp;
    }

    /**
     * [* Опционально]
     * Тип платежа. Произвольная строка длиной до десяти символов включительно.
     * В подавляющем большинстве схем подключения интернет-магазинов этот параметр не используется.
     *
     * @return string
     */
    public function getPtCode()
    {
        return $this->ptCode;
    }

    /**
     * [* Опционально]
     * Платёжная система кредитной карты.
     *
     * Возвращаемое значение соответствует значению перечисления {@see \Tmconsulting\Uniteller\Enums\MeanTypes}.
     *
     * @return integer
     */
    public function getMeanType()
    {
        return $this->meanType;
    }

    /**
     * [* Опционально]
     * Тип электронной валюты.
     *
     * Возвращаемое значение соответствует значению перечисления {@see \Tmconsulting\Uniteller\Enums\EMoneyTypes}.
     *
     * @return integer
     */
    public function getEMoneyType()
    {
        return $this->eMoneyType;
    }

    /**
     * [* Опционально]
     * Срок жизни заказа оплаты в электронной платёжной системе в часах (от 1 до 1080 часов).
     * Значение параметра BillLifetime учитывается только для QIWI-платежей.
     * Если BillLifetime не передаётся, то для QIWI-платежа срок жизни заказа на
     * оплату устанавливается по умолчанию — 72 часа.
     *
     * @return integer
     */
    public function getBillLifetime()
    {
        return $this->billLifetime;
    }

    /**
     * [* Опционально]
     * Признак преавторизации платежа.
     * При использовании в запросе должен принимать значение “1”.
     *
     * @return bool
     */
    public function isPreAuth()
    {
        return $this->preAuth;
    }

    /**
     * Возвращает признак того, что платёж является «родительским» для последующих
     * рекуррентных платежей. Может принимать значение “1”.
     *
     * Примечание: обязателен для рекуррентных платежей при работе с
     * банком-эквайером ВТБ.
     *
     * @return bool
     */
    public function isIsRecurrentStart()
    {
        return $this->IsRecurrentStart;
    }

    /**
     * [* Опционально]
     * Список дополнительных полей, передаваемых в уведомлении об изменении статуса заказа.
     * Строка, не более 29 символов. Поля должны быть разделены пробелами.
     *
     * Возможные значения: AcquirerID, ApprovalCode, BillNumber, Card_IDP, CardNumber, Customer_IDP, ECI, EMoneyType, PaymentType, Total.
     *
     * @return array
     */
    public function getCallbackFields()
    {
        return $this->callbackFields;
    }

    /**
     * [* Опционально]
     * Запрашиваемый формат уведомления о статусе оплаты.
     * Eсли параметр имеет значение "json", то уведомление направляется
     * в json-формате. Во всех остальных случаях уведомление направляется в виде POST-запроса.
     *
     * @return string
     */
    public function getCallbackFormat()
    {
        return $this->callbackFormat;
    }

    /**
     * [* Опционально]
     * Код языка интерфейса платёжной страницы. Может быть en или ru.
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * [* Опционально]
     * Комментарий к платежу (при использовании кириллицы использовать кодировку UTF-8).
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * [* Опционально]
     * Имя Покупателя, переданное с сайта Мерчанта (при использовании кириллицы использовать кодировку UTF-8).
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * [* Опционально]
     * Фамилия Покупателя, переданная с сайта Мерчанта (при использовании кириллицы использовать кодировку UTF-8).
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * [* Опционально]
     * Отчество (при использовании кириллицы использовать кодировку UTF-8).
     *
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * [* Опционально]
     * Телефон (при использовании кириллицы использовать кодировку UTF-8).
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
    * [* Опционально]
    * Верифицированный мерчантом номер телефона.
    * Если передаётся, то значение Phone устанавливается равным PhoneVerified.
    * (при использовании кириллицы использовать кодировку UTF-8)
    *
    * @return string
    */
    public function getPhoneVerified()
    {
        return $this->phoneVerified;
    }

    /**
     * [* Опционально]
     * Адрес (при использовании кириллицы использовать кодировку UTF-8) (в стандартном шаблоне в настоящее время не используется).
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * [* Опционально]
     * Название страны Покупателя (при использовании кириллицы использовать кодировку UTF-8) (в стандартном шаблоне в настоящее время не используется).
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * [* Опционально]
     * Код штата/региона.
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * [* Опционально]
     * Город (при использовании кириллицы использовать кодировку UTF-8) (в стандартном шаблоне в настоящее время не используется).
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * [* Опционально]
     * Почтовый индекс.
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'Shop_IDP'         => $this->getShopIdp(),
            'Order_IDP'        => $this->getOrderIdp(),
            'Subtotal_P'       => $this->getSubtotalP(),
            'Signature'        => $this->getSignature(),
            'URL_RETURN_OK'    => $this->getUrlReturnOk(),
            'URL_RETURN_NO'    => $this->getUrlReturnNo(),
            'Currency'         => $this->getCurrency(),
            'Email'            => $this->getEmail(),
            'Lifetime'         => $this->getLifetime(),
            'OrderLifetime'    => $this->getOrderLifetime(),
            'Customer_IDP'     => $this->getCustomerIdp(),
            'Card_IDP'         => $this->getCardIdp(),
            'PT_Code'          => $this->getPtCode(),
            'MeanType'         => $this->getMeanType(),
            'EMoneyType'       => $this->getEMoneyType(),
            'BillLifetime'     => $this->getBillLifetime(),
            'Preauth'          => $this->isPreAuth(),
            'IsRecurrentStart' => $this->isIsRecurrentStart(),
            'CallbackFields'   => $this->getCallbackFields(),
            'CallbackFormat'   => $this->getCallbackFormat(),
            'Language'         => $this->getLanguage(),
            'Comment'          => $this->getComment(),
            'FirstName'        => $this->getFirstName(),
            'LastName'         => $this->getLastName(),
            'MiddleName'       => $this->getMiddleName(),
            'Phone'            => $this->getPhone(),
            'PhoneVerified'    => $this->getPhoneVerified(),
            'Address'          => $this->getAddress(),
            'Country'          => $this->getCountry(),
            'State'            => $this->getState(),
            'City'             => $this->getCity(),
            'Zip'              => $this->getZip(),
        ];
    }
}