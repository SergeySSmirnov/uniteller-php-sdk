# Uniteller PHP SDK
  

<p align="center">
    <img src="https://www.uniteller.ru//local/templates/index/img/base/logo.svg" width="220">
</p>
  
  
  


## Описание
Полностью переработанный форк [tmconsulting/uniteller-php-sdk ](https://packagist.org/packages/tmconsulting/uniteller-php-sdk).    
PHP (5.5+) SDK для интеграции с интернет-эквайрингом от Uniteller (не официальная).    
  
<b>Важно! Текущая версия не совместима с 0.2.*.</b>    
<br />
<b>Важно! На данный момент реализована поддержка только API v. 2.</b>

## Соответствие техническим порядкам
* ТП Интернет-экваринг v. 1.41 rev. 2
* Платежи с фискализацией v. 2.1.10 rev. 1-1

## Что реализовано
В квадратных скобках указан раздел из [Платежи с фискализацией v. 2.1.10 rev. 1-1].
* [3.2] Форма оплаты с фискализацией (версия 2.0)
* [3.10] Преавторизация с печатью чека аванса с использованием
* [3.13.2] Подтверждение платежа с преавторизацией
платёжной формы
* [3.19] Уведомление об изменении статуса заказа - callback (проверка сигнатуры)
*
*
* 
* обработчик ошибок, кидает эксепшены даже на строку `ERROR: %s` в теле ответа на запрос
* единство статусов.

## Установка
Чтобы установить пакет, достаточно подключить его в проект, как зависимость:

`composer require rusproj/uniteller-php-sdk`

## Использование

### Установка учетных данных 

```php
<?php
use Rusproj\Uniteller\Client;
 
$_client = (new Client())
                ->setShopId('you_shop_id')
                ->setPassword('you_password')
                ->setBaseUri('https://wpay.uniteller.ru');
```

### Создание чека (Receipt)
В большинстве операций необходимо сформировать чек.  

Для этого создайте экземпляр класса `\Rusproj\Uniteller\FiscalCheck\Receipt` и заполните все необходимые поля. Все необязательные поля помечены как `[*Опционально]`, однако для некоторых видов операций обязательно наличие тех или иных данных.  

Для формирования тех или иных данных чека вы можете использовать дополнительные классы из пространства имён `\Rusproj\Uniteller\FiscalCheck\`:
* `AdditionalProductInfo` - дополнительные сведения о продукте;
* `Agent` - информация об агенте;
* `Cashier` - информация о кассире;
* `Customer` - информация о плательщике;
* `Payment` - информация об оплате дополнительными платежными средствами;
* `ProductLine` - информация о товаре в фискальном чеке (одна позиция).  

Все константы, которые могут быть использованы для установки значений доступны в пространстве имён `\Rusproj\Uniteller\Enum\`.

#### Пример
```php
<?php
use Rusproj\Uniteller\FiscalCheck\Customer;
use Rusproj\Uniteller\FiscalCheck\PaymentInfo;
use Rusproj\Uniteller\FiscalCheck\ProductLine;
use Rusproj\Uniteller\FiscalCheck\Receipt;

use Rusproj\Uniteller\Enum\PaymentInstrumentTypes;
use Rusproj\Uniteller\Enum\MeansPaymentTypes;
use Rusproj\Uniteller\Enum\CalculationSubjectTypes;
use Rusproj\Uniteller\Enum\CalculationMethodTypes;
use Rusproj\Uniteller\Enum\VatRateTypes;
use Rusproj\Uniteller\Enum\TaxModeTypes;

$_customer = (new Customer())
                ->setId('1');
                ->setEmail('sergeyssmirnov@mail.ru');
                ->setPhone('+7920343....');

$_payments = [
            (new PaymentInfo())
                ->setAmount(15000)
                ->setKind(PaymentInstrumentTypes::BANK_CARD)
                ->setType(MeansPaymentTypes::AMPT_4)
];

$_lines = [
            (new ProductLine())
                ->setLineattr(CalculationSubjectTypes::CALC_SUBJECT_4)
                ->setName('Какой-то товар')
                ->setPayattr(CalculationMethodTypes::CALC_METHOD_4)
                ->setPrice(5000)
                ->setQty(3)
                ->setSum(15000)
                ->setVat(VatRateTypes::VAT_20_120)
];
            
$_receipt = (new Receipt())
            ->setCustomer($_customer)
            ->setLines($_lines)
            ->setPayments($_payments)
            ->setTaxmode(TaxModeTypes::TAX_0)
            ->setTotal(15000);
```

### Переход к оплате [3.2] Форма оплаты с фискализацией (версия 2.0)
```php

use Rusproj\Uniteller\Enum\CurrencyTypes;
use Rusproj\Uniteller\Payment\FiscaliationPaymentBuilder;

$_fiscalPaymentBuilder = (new FiscaliationPaymentBuilder())
            ->setCallbackFields(['BillNumber', 'Total'])
            ->setCurrency(CurrencyTypes::RUB)
            ->setCustomerIdp('1234-5678')
            ->setOrderIdp('Заказ-123')
            ->setShopIdp($_client->getShopId()) // Данные о магазине берём из клиента (пока так)
            ->setSubtotalP($_receipt->getTotal())
            ->setUrlReturnOk('https://rusproj.space/success')
            ->setUrlReturnNo('https://rusproj.space/error')
            ->setReceipt($_receipt); // Отличается от {@see PaymentBuilder} только этим

$_client
    ->createPymentLink($_fiscalPaymentBuilder); // ->go() или getUri()
```

### Переход к оплате [3.4] Оплата через API (версия 2.0)
```php

use Rusproj\Uniteller\PaymentApi\ApiBuilder;

$_apiBuilder = (new ApiBuilder())
    ->setShopID($_client->getShopId()) // Данные о магазине берём из клиента (пока так)
    ->setOrderID('Заказ-123/1')
    ->setSubtotal(0);

$_client
    ->

```

### Переход к оплате [3.10] Преавторизация с печатью чека аванса с использованием платёжной формы
```php

use Rusproj\Uniteller\Enum\CurrencyTypes;
use Rusproj\Uniteller\Payment\PaymentBuilder;
use Rusproj\Uniteller\Payment\PreauthPaymentLinkCreator

$_paymentBuilder = (new PaymentBuilder())
            ->setCallbackFields(['BillNumber', 'Total'])
            ->setCurrency(CurrencyTypes::RUB)
            ->setCustomerIdp('1234-5678')
            ->setOrderIdp('Заказ-123')
            ->setShopIdp($_client->getShopId()) // Данные о магазине берём из клиента (пока так)
            ->setSubtotalP($_receipt->getTotal())
            ->setUrlReturnOk('https://rusproj.space/success')
            ->setUrlReturnNo('https://rusproj.space/error');
            
$_paymentBuilder->usePreAuth(); // Обязательный признак преавторизации
$_client
    ->setLinkCreator(new PreauthPaymentLinkCreator()) // Указываем другой URI для преавторизации
    ->createPaymentLink($_paymentBuilder); // ->go() или getUri()
```

### [3.13.2] Подтверждение платежа с преавторизацией (версия 2.0)
```php

use Rusproj\Uniteller\PaymentConfirm\PreauthConfirmBuilder; 

$_preauthConfirmBuilder = (new PreauthConfirmBuilder())
    ->setReceipt($_receipt)
    ->setShopID($_client->getShopId()) // Данные о магазине берём из клиента (пока так)
    ->setOrderID('Заказ-123')
    ->setSubtotal($_receipt->getTotal());

// Могут быть сгенерированы исключения \Rusproj\Uniteller\Exception\UnitellerException
try {
    $_queryResult = $_client->confirmPreauthPayment($_preauthConfirmBuilder);
} catch (UnitellerException $_exc) { 
    
}
```

### [3.19] Уведомление об изменении статуса заказа
```php

$_verificationResult = $_client->verifyCallbackRequest($_POST);
if ($_verificationResult === false) {
    die('Params not valid!!!');
}
```

## Как реализовать остальное
Смотрите примеры реализации в соответствующих классах.
Дополнительные возможности в большинстве случаев создаются "по аналогии".

## TODO

* В readme.md добавить https://poser.pugx.org бейджи.
* Реализовать то, что ещё не сделано в соответствии с техническими регламентами.

## Тесты

`vendor/bin/phpunit`

## Лицензия

MIT.
