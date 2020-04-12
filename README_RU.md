# Uniteller PHP SDK
  

<p align="center">
    <img src="https://www.uniteller.ru//local/templates/index/img/base/logo.svg" width="220">
</p>
  
  
  


## Описание
Полностью переработанный форк [tmconsulting/uniteller-php-sdk ](https://packagist.org/packages/tmconsulting/uniteller-php-sdk).  

PHP (5.5+) SDK для интеграции с интернет-эквайрингом от Uniteller (не официальная).

## Соответствие техническим порядкам
* ТП Интернет-экваринг v. 1.41 rev. 2 (реализовано частично)
* Платежи с фискализацией v. 2.1.10 rev. 1-1 (реализовано частично) (<b>* Основной документ</b>)

## Реализовано (в скобках указан раздел *официальной документации)
* [3.2] Форма оплаты с фискализацией (версия 2.0)
* [3.10] Преавторизация с печатью чека аванса с использованием
платёжной формы
* [3.19] callback (проверка сигнатуры)
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

#### Неполный пример
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

### Построители параметров запросов
Для формирования параметров запросов необходимо использовать следующие построители из пространства имён `\Rusproj\Uniteller\Payment\`:
* `PaymentBuilder` - общий построитель параметров запросов для оплаты;
* `FiscaliationPaymentBuilder` - построитель параметров запросов для оплаты с фискализацией.

#### Неполный пример использования
```php
<?php
use Rusproj\Uniteller\Payment\PaymentBuilder;
use Rusproj\Uniteller\Payment\FiscaliationPaymentBuilder;
use Rusproj\Uniteller\Enum\CurrencyTypes;

$_paymentBuilder = (new PaymentBuilder())
            ->setCallbackFields(['BillNumber', 'Total'])
            ->setCurrency(CurrencyTypes::RUB)
            ->setCustomerIdp('1234-5678')
            ->setOrderIdp('Заказ-123')
            ->setShopIdp($_client->getShopId()) // Данные о магазине берем из клиента (пока так)
            ->setSubtotalP($_receipt->getTotal())
            ->setUrlReturnOk('https://rusproj.space/success')
            ->setUrlReturnNo('https://rusproj.space/error');

// ИЛИ

$_fiscalPaymentBuilder = (new FiscaliationPaymentBuilder())
            ->setCallbackFields(['BillNumber', 'Total'])
            ->setCurrency(CurrencyTypes::RUB)
            ->setCustomerIdp('1234-5678')
            ->setOrderIdp('Заказ-123')
            ->setShopIdp($_client->getShopId()) // Данные о магазине берем из клиента (пока так)
            ->setSubtotalP($_receipt->getTotal())
            ->setUrlReturnOk('https://rusproj.space/success')
            ->setUrlReturnNo('https://rusproj.space/error')
            ->setReceipt($_receipt); // Отличается от {@see PaymentBuilder} только этим
```

### Генераторы ссылок
Для генерации ссылок (адресов к которым будут генерироваться запросы) необходимо создать и зарегистрировать в клиенте соответствующий генератор из пространства имён `\Rusproj\Uniteller\Payment\`:
* `PaymentLinkCreatorWithFiscalization_V2` - форма оплаты с фискализацией (версия 2.0);
* `PreauthPaymentLinkCreator` - преавторизация с печатью чека аванса с использованием
платёжной формы;

### Переход к оплате
```php

// [3.2] Форма оплаты с фискализацией (версия 2.0)
$_client
    ->registerPaymentLinkCreator(new PaymentLinkCreatorWithFiscalization_V2());
    ->createPymentLink($_fiscalPaymentBuilder); // ->go() или getUri()


// [3.10] Преавторизация с печатью чека аванса с использованием платёжной формы

$_paymentBuilder->usePreAuth(); // Обязательный признак преавторизации
$_client
    ->registerPaymentLinkCreator(new PreauthPaymentLinkCreator())
    ->createPymentLink($_paymentBuilder); // ->go() или getUri()
```

### Callback

Проверка сигнатуры при приёме данных от шлюза.

```php
<?php
if (! $_client->verifyCallbackRequest(['all_parameters_from_post_with_signature'])) {
    return 'invalid_signature';
}
```

## Как реализовать остальное
В большинстве случаев достаточно реализовать класс, реализующий `\Rusproj\Uniteller\Payment\PaymentLinkCreatorInterface`.
Смотрите примеры реализации в соответствующих классах.

## TODO

* В readme.md добавить https://poser.pugx.org бейджи.

## Тесты

`vendor/bin/phpunit`

## Лицензия

MIT.
