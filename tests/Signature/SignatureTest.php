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

namespace Rusproj\Uniteller\Tests\Signature;

use Rusproj\Uniteller\Tests\TestCase;
use Rusproj\Uniteller\Signature\SignatureHandler;
use Rusproj\Uniteller\Tests\Payment\FiscaliationPaymentBuilderTest;
use Rusproj\Uniteller\Payment\PaymentBuilder;
use Rusproj\Uniteller\Enum\CurrencyTypes;
use Rusproj\Uniteller\Callback\CallbackBuilder;
use Rusproj\Uniteller\Tests\PaymentConfirm\PreauthConfirmBuilderTest;
use Rusproj\Uniteller\Tests\PaymentApi\ApiCheckBuilderTest;
use Rusproj\Uniteller\Tests\PaymentApi\ApiPayBuilderTest;

class SignatureTest extends TestCase
{

    public function testSignatureHandlerForFiscaliationPaymentBuilder()
    {
        $_signatureHandler = new SignatureHandler();
        $_keys = $_signatureHandler->sign(FiscaliationPaymentBuilderTest::createFiscaliationPaymentBuilderTestInstance(), 'Some passwd');

        $this->assertTrue(is_array($_keys));
        $this->assertArrayHasKey('Receipt', $_keys);
        $this->assertEquals('eyJjdXN0b21lciI6eyJwaG9uZSI6Iis3MTIzNDU2Nzg5MCIsImVtYWlsIjoidGVzdEB0ZXN0LnR0IiwiaWQiOjEyMzQ1LCJuYW1lIjoiQ2xpZW50IiwiaW5uIjoiMTIzNDU2Nzg5MDEyIn0sImNhc2hpZXIiOnsibmFtZSI6IkNhc2hpZXIiLCJpbm4iOiIxMjM0NTY3ODkwMTIifSwidGF4bW9kZSI6MCwibGluZXMiOlt7Im5hbWUiOiJQcm9kdWN0IE5hbWUiLCJwcmljZSI6IjUwLjA0IiwicXR5IjoiNSIsInN1bSI6IjEyMi40IiwidmF0IjoxMjAsInBheWF0dHIiOjUsImxpbmVhdHRyIjoxMiwicHJvZHVjdCI6eyJrdCI6IlJVIiwiZXhjIjoi0JDQutGG0LjQtyIsImNvYyI6ItCa0L7QtCDRgtC+0LLQsNGA0LAiLCJuY2QiOiIxMjM0NTYifSwiYWdlbnQiOnsiYWdlbnRhdHRyIjoiQUdFTlRfQVRUUiIsImFnZW50cGhvbmUiOiIrNDU2Nzg5MTMyMCIsImFjY29wcGhvbmUiOiIrMTIzNDY1Nzg5MCIsIm9wcGhvbmUiOiJPUF9IT01FIiwib3BuYW1lIjoiT1BfTkFNRSIsIm9waW5uIjoiMTIzNDU2Nzg5MDEiLCJvcGFkZHJlc3MiOiJTb21ld2hlcmUiLCJvcGVyYXRpb24iOiJBYmNkIiwic3VwcGxpZXJuYW1lIjoiU1VQX05BTUUiLCJzdXBwbGllcmlubiI6IjA5ODc2NTQzMjEwOSIsInN1cHBsaWVycGhvbmUiOiIrNjc4OTA0MzE2NSJ9fSx7Im5hbWUiOiJQcm9kdWN0IE5hbWUiLCJwcmljZSI6IjUwLjA0IiwicXR5IjoiNSIsInN1bSI6IjEyMi40IiwidmF0IjoxMjAsInBheWF0dHIiOjUsImxpbmVhdHRyIjoxMiwicHJvZHVjdCI6eyJrdCI6IlJVIiwiZXhjIjoi0JDQutGG0LjQtyIsImNvYyI6ItCa0L7QtCDRgtC+0LLQsNGA0LAiLCJuY2QiOiIxMjM0NTYifSwiYWdlbnQiOnsiYWdlbnRhdHRyIjoiQUdFTlRfQVRUUiIsImFnZW50cGhvbmUiOiIrNDU2Nzg5MTMyMCIsImFjY29wcGhvbmUiOiIrMTIzNDY1Nzg5MCIsIm9wcGhvbmUiOiJPUF9IT01FIiwib3BuYW1lIjoiT1BfTkFNRSIsIm9waW5uIjoiMTIzNDU2Nzg5MDEiLCJvcGFkZHJlc3MiOiJTb21ld2hlcmUiLCJvcGVyYXRpb24iOiJBYmNkIiwic3VwcGxpZXJuYW1lIjoiU1VQX05BTUUiLCJzdXBwbGllcmlubiI6IjA5ODc2NTQzMjEwOSIsInN1cHBsaWVycGhvbmUiOiIrNjc4OTA0MzE2NSJ9fV0sIm9wdGlvbmFsIjp7InZhbCI6IlNvbWUgbWVyY2hhbnQgZGF0YSJ9LCJwYXJhbXMiOnsicGxhY2UiOiJJVkEifSwicGF5bWVudHMiOlt7ImtpbmQiOjEsInR5cGUiOjQsImlkIjoiMDAzNTQ2NCIsImFtb3VudCI6IjE1Mi42NSJ9XSwidG90YWwiOiI5OC4zMiJ9', $_keys['Receipt']);

        $this->assertArrayHasKey('ReceiptSignature', $_keys);
        $this->assertEquals('9E9BEAC5318A56D011C3F66BC8E05B0CF94325A2B2B360678948F069766F8633', $_keys['ReceiptSignature']);

        $this->assertArrayHasKey('Shop_IDP', $_keys);
        $this->assertEquals('012345-67890', $_keys['Shop_IDP']);

        $this->assertArrayHasKey('Order_IDP', $_keys);
        $this->assertEquals(12345, $_keys['Order_IDP']);

        $this->assertArrayHasKey('Subtotal_P', $_keys);
        $this->assertEquals(100.30, $_keys['Subtotal_P']);

        $this->assertArrayHasKey('Signature', $_keys);
        $this->assertEquals('7F7D0EB7F1CBA8485AF1EC4FF7B1CA2C', $_keys['Signature']);

        $this->assertArrayHasKey('URL_RETURN_OK', $_keys);
        $this->assertEquals('http://mysite.com/success', $_keys['URL_RETURN_OK']);

        $this->assertArrayHasKey('URL_RETURN_NO', $_keys);
        $this->assertEquals('http://mysite.com/error', $_keys['URL_RETURN_NO']);

        $this->assertArrayHasKey('Currency', $_keys);
        $this->assertEquals('RUB', $_keys['Currency']);

        $this->assertArrayHasKey('IsRecurrentStart', $_keys);
        $this->assertEquals('', $_keys['IsRecurrentStart']);
    }

    public function testSignatureHandlerForPaymentBuilder()
    {
        $_builder = new PaymentBuilder();
        $_builder
            ->setCurrency(CurrencyTypes::RUB)
            ->setOrderIdp('FOO')
            ->setShopIdp('ACME')
            ->setSubtotalP('100')
            ->setLifetime('300')
            ->setCustomerIdp('short_shop_string')
            ->setUrlReturnOk('http://mysite.com/success')
            ->setUrlReturnNo('http://mysite.com/error');

        $_signatureHandler = new SignatureHandler();
        $_keys = $_signatureHandler->sign($_builder, 'LONG-PWD');

        $this->assertTrue(is_array($_keys));

        $this->assertArrayHasKey('Signature', $_keys);
        $this->assertEquals('3D1D6F830384886A81AD672F66392B03', $_keys['Signature']);

        $this->assertArrayHasKey('Shop_IDP', $_keys);
        $this->assertEquals('ACME', $_keys['Shop_IDP']);

        $this->assertArrayHasKey('Customer_IDP', $_keys);
        $this->assertEquals('short_shop_string', $_keys['Customer_IDP']);

        $this->assertArrayHasKey('Order_IDP', $_keys);
        $this->assertEquals('FOO', $_keys['Order_IDP']);

        $this->assertArrayHasKey('Subtotal_P', $_keys);
        $this->assertEquals(100, $_keys['Subtotal_P']);

        $this->assertArrayHasKey('Lifetime', $_keys);
        $this->assertEquals(300, $_keys['Lifetime']);

        $this->assertArrayHasKey('URL_RETURN_OK', $_keys);
        $this->assertEquals('http://mysite.com/success', $_keys['URL_RETURN_OK']);

        $this->assertArrayHasKey('URL_RETURN_NO', $_keys);
        $this->assertEquals('http://mysite.com/error', $_keys['URL_RETURN_NO']);

        $this->assertArrayHasKey('Currency', $_keys);
        $this->assertEquals('RUB', $_keys['Currency']);

        $this->assertArrayHasKey('IsRecurrentStart', $_keys);
        $this->assertEquals('', $_keys['IsRecurrentStart']);
    }

    public function testSimpleCallbackSignatureValidation()
    {
        $_fields = [
            'Signature' => '3F728AA479E50F5B10EE6C20258BFF88',
            'Order_ID' => 'FOO',
            'Status' => 'paid'
        ];

        $_validSignatures = [
            'Signature' => $_fields['Signature']
        ];

        $_builder = new CallbackBuilder($_fields);

        $_signatureHandler = new SignatureHandler();
        $_verificationresult = $_signatureHandler->verify($_builder, 'LONG-PWD', $_validSignatures);

        $this->assertTrue($_verificationresult);
    }

    public function testSimpleCallbackSignatureValidationWithAdditionalFields()
    {
        $_fields = [
            'AcquirerID'   => 'fOO',
            'ApprovalCode' => 'BaR',
            'BillNumber'   => 'baz',
            'Signature' => '1F4E3B63AE408D0BE1E33965E6697236',
            'Order_ID' => 'FOO',
            'Status' => 'paid'
        ];

        $_validSignatures = [
            'Signature' => $_fields['Signature']
        ];

        $_builder = new CallbackBuilder($_fields);

        $_signatureHandler = new SignatureHandler();
        $_verificationresult = $_signatureHandler->verify($_builder, 'LONG-PWD', $_validSignatures);

        $this->assertTrue($_verificationresult);
    }

    public function testCallbackSignatureCreation()
    {
        $_fields = [
            'AcquirerID' => 'fOO',
            'ApprovalCode' => 'BaR',
            'BillNumber' => 'baz',
            'Order_ID' => 'FOO',
            'Status' => 'paid',
            'Signature' => '1F4E3B63AE408D0BE1E33965E6697236',
            'Receipt' => 'eyJjdXN0b21lciI6eyJwaG9uZSI6Iis3MTIzNDU2Nzg5MCIsImVtYWlsIjoidGVzdEB0ZXN0LnR0IiwiaWQiOjEyMzQ1LCJuYW1lIjoiQ2xpZW50IiwiaW5uIjoiMTIzNDU2Nzg5MDEyIn0sImNhc2hpZXIiOnsibmFtZSI6IkNhc2hpZXIiLCJpbm4iOiIxMjM0NTY3ODkwMTIifSwidGF4bW9kZSI6MCwibGluZXMiOlt7Im5hbWUiOiJQcm9kdWN0IE5hbWUiLCJwcmljZSI6IjUwLjA0IiwicXR5IjoiNSIsInN1bSI6IjEyMi40IiwidmF0IjoxMjAsInBheWF0dHIiOjUsImxpbmVhdHRyIjoxMiwicHJvZHVjdCI6eyJrdCI6IlJVIiwiZXhjIjoi0JDQutGG0LjQtyIsImNvYyI6ItCa0L7QtCDRgtC+0LLQsNGA0LAiLCJuY2QiOiIxMjM0NTYifSwiYWdlbnQiOnsiYWdlbnRhdHRyIjoiQUdFTlRfQVRUUiIsImFnZW50cGhvbmUiOiIrNDU2Nzg5MTMyMCIsImFjY29wcGhvbmUiOiIrMTIzNDY1Nzg5MCIsIm9wcGhvbmUiOiJPUF9IT01FIiwib3BuYW1lIjoiT1BfTkFNRSIsIm9waW5uIjoiMTIzNDU2Nzg5MDEiLCJvcGFkZHJlc3MiOiJTb21ld2hlcmUiLCJvcGVyYXRpb24iOiJBYmNkIiwic3VwcGxpZXJuYW1lIjoiU1VQX05BTUUiLCJzdXBwbGllcmlubiI6IjA5ODc2NTQzMjEwOSIsInN1cHBsaWVycGhvbmUiOiIrNjc4OTA0MzE2NSJ9fSx7Im5hbWUiOiJQcm9kdWN0IE5hbWUiLCJwcmljZSI6IjUwLjA0IiwicXR5IjoiNSIsInN1bSI6IjEyMi40IiwidmF0IjoxMjAsInBheWF0dHIiOjUsImxpbmVhdHRyIjoxMiwicHJvZHVjdCI6eyJrdCI6IlJVIiwiZXhjIjoi0JDQutGG0LjQtyIsImNvYyI6ItCa0L7QtCDRgtC+0LLQsNGA0LAiLCJuY2QiOiIxMjM0NTYifSwiYWdlbnQiOnsiYWdlbnRhdHRyIjoiQUdFTlRfQVRUUiIsImFnZW50cGhvbmUiOiIrNDU2Nzg5MTMyMCIsImFjY29wcGhvbmUiOiIrMTIzNDY1Nzg5MCIsIm9wcGhvbmUiOiJPUF9IT01FIiwib3BuYW1lIjoiT1BfTkFNRSIsIm9waW5uIjoiMTIzNDU2Nzg5MDEiLCJvcGFkZHJlc3MiOiJTb21ld2hlcmUiLCJvcGVyYXRpb24iOiJBYmNkIiwic3VwcGxpZXJuYW1lIjoiU1VQX05BTUUiLCJzdXBwbGllcmlubiI6IjA5ODc2NTQzMjEwOSIsInN1cHBsaWVycGhvbmUiOiIrNjc4OTA0MzE2NSJ9fV0sIm9wdGlvbmFsIjp7InZhbCI6IlNvbWUgbWVyY2hhbnQgZGF0YSJ9LCJwYXJhbXMiOnsicGxhY2UiOiJJVkEifSwicGF5bWVudHMiOlt7ImtpbmQiOjEsInR5cGUiOjQsImlkIjoiMDAzNTQ2NCIsImFtb3VudCI6IjE1Mi42NSJ9XSwidG90YWwiOiI5OC4zMiJ9',
            'ReceiptSignature' => '8F9B20567189C1323BEF24F3E5BB886C3231459EE16F20595A16627C1316D2C0'
        ];

        $_validSignatures = [
            'Signature' => $_fields['Signature'],
            'ReceiptSignature' => $_fields['ReceiptSignature']
        ];

        $_builder = new CallbackBuilder($_fields);

        $_signatureHandler = new SignatureHandler();
        $_verificationresult = $_signatureHandler->verify($_builder, 'LONG-PWD', $_validSignatures);

        $this->assertTrue($_verificationresult);
    }

    public function testSignatureHandlerForPreauthConfirmBuilder()
    {
        $_signatureHandler = new SignatureHandler();
        $_keys = $_signatureHandler->sign(PreauthConfirmBuilderTest::createPreauthConfirmBuilderTestInstance(), 'Some passwd');

        $this->assertArrayHasKey('Signature', $_keys);
        $this->assertEquals('52DE3A0BE2A4C4F72F09B200593616C0', $_keys['Signature']);

        $this->assertEquals('eyJjdXN0b21lciI6eyJwaG9uZSI6Iis3MTIzNDU2Nzg5MCIsImVtYWlsIjoidGVzdEB0ZXN0LnR0IiwiaWQiOjEyMzQ1LCJuYW1lIjoiQ2xpZW50IiwiaW5uIjoiMTIzNDU2Nzg5MDEyIn0sImNhc2hpZXIiOnsibmFtZSI6IkNhc2hpZXIiLCJpbm4iOiIxMjM0NTY3ODkwMTIifSwidGF4bW9kZSI6MCwibGluZXMiOlt7Im5hbWUiOiJQcm9kdWN0IE5hbWUiLCJwcmljZSI6IjUwLjA0IiwicXR5IjoiNSIsInN1bSI6IjEyMi40IiwidmF0IjoxMjAsInBheWF0dHIiOjUsImxpbmVhdHRyIjoxMiwicHJvZHVjdCI6eyJrdCI6IlJVIiwiZXhjIjoi0JDQutGG0LjQtyIsImNvYyI6ItCa0L7QtCDRgtC+0LLQsNGA0LAiLCJuY2QiOiIxMjM0NTYifSwiYWdlbnQiOnsiYWdlbnRhdHRyIjoiQUdFTlRfQVRUUiIsImFnZW50cGhvbmUiOiIrNDU2Nzg5MTMyMCIsImFjY29wcGhvbmUiOiIrMTIzNDY1Nzg5MCIsIm9wcGhvbmUiOiJPUF9IT01FIiwib3BuYW1lIjoiT1BfTkFNRSIsIm9waW5uIjoiMTIzNDU2Nzg5MDEiLCJvcGFkZHJlc3MiOiJTb21ld2hlcmUiLCJvcGVyYXRpb24iOiJBYmNkIiwic3VwcGxpZXJuYW1lIjoiU1VQX05BTUUiLCJzdXBwbGllcmlubiI6IjA5ODc2NTQzMjEwOSIsInN1cHBsaWVycGhvbmUiOiIrNjc4OTA0MzE2NSJ9fSx7Im5hbWUiOiJQcm9kdWN0IE5hbWUiLCJwcmljZSI6IjUwLjA0IiwicXR5IjoiNSIsInN1bSI6IjEyMi40IiwidmF0IjoxMjAsInBheWF0dHIiOjUsImxpbmVhdHRyIjoxMiwicHJvZHVjdCI6eyJrdCI6IlJVIiwiZXhjIjoi0JDQutGG0LjQtyIsImNvYyI6ItCa0L7QtCDRgtC+0LLQsNGA0LAiLCJuY2QiOiIxMjM0NTYifSwiYWdlbnQiOnsiYWdlbnRhdHRyIjoiQUdFTlRfQVRUUiIsImFnZW50cGhvbmUiOiIrNDU2Nzg5MTMyMCIsImFjY29wcGhvbmUiOiIrMTIzNDY1Nzg5MCIsIm9wcGhvbmUiOiJPUF9IT01FIiwib3BuYW1lIjoiT1BfTkFNRSIsIm9waW5uIjoiMTIzNDU2Nzg5MDEiLCJvcGFkZHJlc3MiOiJTb21ld2hlcmUiLCJvcGVyYXRpb24iOiJBYmNkIiwic3VwcGxpZXJuYW1lIjoiU1VQX05BTUUiLCJzdXBwbGllcmlubiI6IjA5ODc2NTQzMjEwOSIsInN1cHBsaWVycGhvbmUiOiIrNjc4OTA0MzE2NSJ9fV0sIm9wdGlvbmFsIjp7InZhbCI6IlNvbWUgbWVyY2hhbnQgZGF0YSJ9LCJwYXJhbXMiOnsicGxhY2UiOiJJVkEifSwicGF5bWVudHMiOlt7ImtpbmQiOjEsInR5cGUiOjQsImlkIjoiMDAzNTQ2NCIsImFtb3VudCI6IjE1Mi42NSJ9XSwidG90YWwiOiI5OC4zMiJ9', $_keys['Receipt']);
        $this->assertEquals('7D76010357DB8BCF2171999316F905B6F8A203BC45D5EB3B61CF3AFC02C5FF23', $_keys['ReceiptSignature']);
    }

    public function testSignatureHandlerForApiCheckBuilder()
    {
        $_signatureHandler = new SignatureHandler();
        $_keys = $_signatureHandler->sign(ApiCheckBuilderTest::createBuilderTestInstance(), 'Some passwd');

        $this->assertTrue(is_array($_keys));
        $this->assertEquals(3, count($_keys));

        $this->assertArrayHasKey('Signature', $_keys);
        $this->assertEquals('551221BC54D5E1DAF12983AF3F34E11F', $_keys['Signature']);

        $this->assertArrayHasKey('ShopID', $_keys);
        $this->assertEquals('012345-67890', $_keys['ShopID']);

        $this->assertArrayHasKey('OrderID', $_keys);
        $this->assertEquals('12345', $_keys['OrderID']);
    }

    public function testSignatureHandlerForApiPayBuilder()
    {
        $_signatureHandler = new SignatureHandler();
        $_keys = $_signatureHandler->sign(ApiPayBuilderTest::createBuilderTestInstance(), 'Some passwd');

        $this->assertTrue(is_array($_keys));
        $this->assertEquals(6, count($_keys));

        $this->assertArrayHasKey('Signature', $_keys);
        $this->assertEquals('E54A0377B6B2CB343E809E24E51D60DE', $_keys['Signature']);

        $this->assertArrayHasKey('PaymentAttemptID', $_keys);
        $this->assertEquals('1234567890QAZ', $_keys['PaymentAttemptID']);

        $this->assertArrayHasKey('Subtotal', $_keys);
        $this->assertEquals(12.95, $_keys['Subtotal']);

        $this->assertArrayHasKey('ShopID', $_keys);
        $this->assertEquals('012345-67890', $_keys['ShopID']);

        $this->assertArrayHasKey('Receipt', $_keys);
        $this->assertEquals('eyJjdXN0b21lciI6eyJwaG9uZSI6Iis3MTIzNDU2Nzg5MCIsImVtYWlsIjoidGVzdEB0ZXN0LnR0IiwiaWQiOjEyMzQ1LCJuYW1lIjoiQ2xpZW50IiwiaW5uIjoiMTIzNDU2Nzg5MDEyIn0sImNhc2hpZXIiOnsibmFtZSI6IkNhc2hpZXIiLCJpbm4iOiIxMjM0NTY3ODkwMTIifSwidGF4bW9kZSI6MCwibGluZXMiOlt7Im5hbWUiOiJQcm9kdWN0IE5hbWUiLCJwcmljZSI6IjUwLjA0IiwicXR5IjoiNSIsInN1bSI6IjEyMi40IiwidmF0IjoxMjAsInBheWF0dHIiOjUsImxpbmVhdHRyIjoxMiwicHJvZHVjdCI6eyJrdCI6IlJVIiwiZXhjIjoi0JDQutGG0LjQtyIsImNvYyI6ItCa0L7QtCDRgtC+0LLQsNGA0LAiLCJuY2QiOiIxMjM0NTYifSwiYWdlbnQiOnsiYWdlbnRhdHRyIjoiQUdFTlRfQVRUUiIsImFnZW50cGhvbmUiOiIrNDU2Nzg5MTMyMCIsImFjY29wcGhvbmUiOiIrMTIzNDY1Nzg5MCIsIm9wcGhvbmUiOiJPUF9IT01FIiwib3BuYW1lIjoiT1BfTkFNRSIsIm9waW5uIjoiMTIzNDU2Nzg5MDEiLCJvcGFkZHJlc3MiOiJTb21ld2hlcmUiLCJvcGVyYXRpb24iOiJBYmNkIiwic3VwcGxpZXJuYW1lIjoiU1VQX05BTUUiLCJzdXBwbGllcmlubiI6IjA5ODc2NTQzMjEwOSIsInN1cHBsaWVycGhvbmUiOiIrNjc4OTA0MzE2NSJ9fSx7Im5hbWUiOiJQcm9kdWN0IE5hbWUiLCJwcmljZSI6IjUwLjA0IiwicXR5IjoiNSIsInN1bSI6IjEyMi40IiwidmF0IjoxMjAsInBheWF0dHIiOjUsImxpbmVhdHRyIjoxMiwicHJvZHVjdCI6eyJrdCI6IlJVIiwiZXhjIjoi0JDQutGG0LjQtyIsImNvYyI6ItCa0L7QtCDRgtC+0LLQsNGA0LAiLCJuY2QiOiIxMjM0NTYifSwiYWdlbnQiOnsiYWdlbnRhdHRyIjoiQUdFTlRfQVRUUiIsImFnZW50cGhvbmUiOiIrNDU2Nzg5MTMyMCIsImFjY29wcGhvbmUiOiIrMTIzNDY1Nzg5MCIsIm9wcGhvbmUiOiJPUF9IT01FIiwib3BuYW1lIjoiT1BfTkFNRSIsIm9waW5uIjoiMTIzNDU2Nzg5MDEiLCJvcGFkZHJlc3MiOiJTb21ld2hlcmUiLCJvcGVyYXRpb24iOiJBYmNkIiwic3VwcGxpZXJuYW1lIjoiU1VQX05BTUUiLCJzdXBwbGllcmlubiI6IjA5ODc2NTQzMjEwOSIsInN1cHBsaWVycGhvbmUiOiIrNjc4OTA0MzE2NSJ9fV0sIm9wdGlvbmFsIjp7InZhbCI6IlNvbWUgbWVyY2hhbnQgZGF0YSJ9LCJwYXJhbXMiOnsicGxhY2UiOiJJVkEifSwicGF5bWVudHMiOlt7ImtpbmQiOjEsInR5cGUiOjQsImlkIjoiMDAzNTQ2NCIsImFtb3VudCI6IjE1Mi42NSJ9XSwidG90YWwiOiI5OC4zMiJ9', $_keys['Receipt']);

        $this->assertArrayHasKey('ReceiptSignature', $_keys);
        $this->assertEquals('11A10E9B4D2CE17C9F90FBD5F84205D5A67F597A7C9B71BB27EA43AE97547D99', $_keys['ReceiptSignature']);
    }

}
